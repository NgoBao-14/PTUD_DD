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
                AND (nv.MaNV LIKE '%$search%' OR nv.HovaTen LIKE '%$search%')
                ORDER BY nv.MaNV DESC";
        $result = $this->con->query($str);
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
                WHERE nv.MaNV = $MaNV AND nv.ChucVu = 'Nhân viên y tế'";
        $result = $this->con->query($str);
        $data = $result->fetch_assoc();
        return json_encode($data);
    }

    public function UpdateNVYT($MaNV, $NgaySinh, $GioiTinh, $EmailNV) {
        $str = "UPDATE nhanvien 
                SET NgaySinh = '$NgaySinh', GioiTinh = '$GioiTinh', EmailNV = '$EmailNV'
                WHERE MaNV = $MaNV";
        $result = mysqli_query($this->con, $str);
        return $result;
    }

    public function DeleteNVYT($MaNV) {
        $str = "UPDATE nhanvien 
                SET TrangThaiLamViec = 'Nghỉ làm', ID=null
                WHERE MaNV = $MaNV AND ChucVu = 'Nhân viên y tế'";
        $result = mysqli_query($this->con, $str);
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

            $username = $SoDT;
            $password = md5('123456'); // Using MD5 for password hashing
            $str1 = "INSERT INTO taikhoan (username, password, MaPQ) VALUES (?, ?, 3)";
            $stmt1 = $this->con->prepare($str1);
            $stmt1->bind_param("ss", $username, $password);
            $stmt1->execute();
    
            // Get the auto-generated ID
            $newAccountId = $this->con->insert_id;
            // Insert into nhanvien table
            $str1 = "INSERT INTO nhanvien (MaNV, HovaTen, NgaySinh, GioiTinh, SoDT, EmailNV, ChucVu, TrangThaiLamViec, ID) 
                     VALUES (?, ?, ?, ?, ?, ?, 'Nhân viên y tế', 'Đang làm việc', ?)";
            $stmt1 = $this->con->prepare($str1);
            $stmt1->bind_param("isssssi", $MaNV, $HovaTen, $NgaySinh, $GioiTinh, $SoDT, $EmailNV,$newAccountId );
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
    
    
    
}
?>
