<?php
class mQLNVYT extends DB {
    public function GetStaffCount() {
        $str = "SELECT COUNT(*) as count FROM nhanvien
                WHERE ChucVu = 'Nhân viên y tế' AND TrangThaiLamViec = 'Đang làm việc'";
        $result = $this->con->query($str);
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    public function GetAllNVYT($search = '') {
        $str = "SELECT nv.MaNV, nv.HovaTen, nv.NgaySinh, nv.GioiTinh, nv.SoDT, nv.EmailNV
                FROM nhanvien nv
                WHERE nv.TrangThaiLamViec = 'Đang làm việc'
                AND nv.ChucVu = 'Nhân viên y tế'
                AND (nv.MaNV LIKE ? OR nv.HovaTen LIKE ?)
                ORDER BY nv.MaNV DESC";
        $search = "%$search%";
        $stmt = $this->con->prepare($str);
        $stmt->bind_param("ss", $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
    }

    public function Get1NVYT($MaNV) {
        $str = "SELECT nv.MaNV, nv.HovaTen, nv.NgaySinh, nv.GioiTinh, nv.SoDT, nv.EmailNV
                FROM nhanvien nv
                JOIN nhanvienyte nvyt ON nv.MaNV = nvyt.MaNV
                WHERE nv.MaNV = ? AND nv.ChucVu = 'Nhân viên y tế'";
        $stmt = $this->con->prepare($str);
        $stmt->bind_param("i", $MaNV);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        return json_encode($data);
    }
    

    public function UpdateNVYT($MaNV, $NgaySinh, $GioiTinh, $EmailNV) {
        $this->con->begin_transaction();
        try {
            $str = "UPDATE nhanvien SET NgaySinh = ?, GioiTinh = ?, EmailNV = ? WHERE MaNV = ?";
            $stmt = $this->con->prepare($str);
            $stmt->bind_param("sssi", $NgaySinh, $GioiTinh, $EmailNV, $MaNV);
            $stmt->execute();

            $this->con->commit();
            return true;
        } catch (Exception $e) {
            $this->con->rollback();
            return false;
        }
    }
    public function DeleteNVYT($MaNV) {
        $str = "UPDATE nhanvien SET TrangThaiLamViec = 'Nghỉ làm' 
                WHERE MaNV = ? AND ChucVu = 'Nhân viên y tế'";
        $stmt = $this->con->prepare($str);
        $stmt->bind_param("i", $MaNV);
        $result = $stmt->execute();
        return json_encode(['success' => $result]);
    }

    public function AddNVYT($HovaTen, $NgaySinh, $GioiTinh, $SoDT, $EmailNV) {
        $this->con->begin_transaction();
        try {
            // Check for existing phone number and email
            if ($this->CheckExistingPhoneNumber($SoDT)) {
                return "Số điện thoại đã tồn tại";
            }
            if ($this->CheckExistingEmail($EmailNV)) {
                return "Email đã tồn tại";
            }

            // Generate new MaNV
            $MaNV = $this->GenerateNewMaNV();

            // Insert into nhanvien table
            $str1 = "INSERT INTO nhanvien (MaNV, HovaTen, NgaySinh, GioiTinh, SoDT, EmailNV, ChucVu, TrangThaiLamViec, ID) 
                     VALUES (?, ?, ?, ?, ?, ?, 'Nhân viên y tế', 'Đang làm việc', 0)";
            $stmt1 = $this->con->prepare($str1);
            $stmt1->bind_param("isssss", $MaNV, $HovaTen, $NgaySinh, $GioiTinh, $SoDT, $EmailNV);
            $stmt1->execute();

            // Insert into nhanvienyte table
            $this->con->query("SET FOREIGN_KEY_CHECKS = 0");
            $str2 = "INSERT INTO nhanvienyte (MaNV) VALUES (?)";
            $stmt2 = $this->con->prepare($str2);
            $stmt2->bind_param("i", $MaNV);
            $stmt2->execute();

            $this->con->commit();
            return true;
        } catch (Exception $e) {
            $this->con->rollback();
            return "Lỗi: " . $e->getMessage();
        }
    }
    
    public function CheckExistingPhoneNumber($SoDT) {
        $str = "SELECT COUNT(*) as count FROM nhanvien WHERE SoDT = ?";
        $stmt = $this->con->prepare($str);
        $stmt->bind_param("s", $SoDT);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
    
    public function CheckExistingEmail($EmailNV) {
        $str = "SELECT COUNT(*) as count FROM nhanvien WHERE EmailNV = ?";
        $stmt = $this->con->prepare($str);
        $stmt->bind_param("s", $EmailNV);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
    
    private function GenerateNewMaNV() {
        $str = "SELECT MAX(MaNV) as max_id FROM nhanvien";
        $result = $this->con->query($str);
        $row = $result->fetch_assoc();
        return ($row['max_id'] ?? 0) + 1;
    }
    
    private function GenerateNewID() {
        $str = "SELECT MAX(ID) as max_id FROM taikhoan";
        $result = $this->con->query($str);
        $row = $result->fetch_assoc();
        return ($row['max_id'] ?? 0) + 1;
    }
    
    private function GenerateUsername($HovaTen) {
        $name_parts = explode(' ', $HovaTen);
        $last_name = end($name_parts);
        $first_letter = mb_strtolower(mb_substr($HovaTen, 0, 1, 'UTF-8'), 'UTF-8');
        $username = $first_letter . mb_strtolower($last_name, 'UTF-8');
    
        $i = 1;
        $original_username = $username;
        while ($this->CheckExistingUsername($username)) {
            $username = $original_username . $i;
            $i++;
        }
    
        return $username;
    }
    
    private function CheckExistingUsername($username) {
        $str = "SELECT COUNT(*) as count FROM taikhoan WHERE username = ?";
        $stmt = $this->con->prepare($str);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
    
    
}
?>
