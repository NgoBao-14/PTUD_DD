<?php
class mQLBS extends DB {
    public function GetDoctorCount() {
        $str = "SELECT COUNT(*) as count FROM bacsi bs
                JOIN nhanvien nv ON bs.MaNV = nv.MaNV
                WHERE nv.TrangThaiLamViec = 'Đang làm việc'";
        $result = $this->con->query($str);
        $row = $result->fetch_assoc();
        return $row['count'];
    }
    public function GetAllBS() {
        $str = "SELECT bs.MaNV, nv.HovaTen, nv.NgaySinh, nv.GioiTinh, nv.SoDT, nv.EmailNV, ck.TenKhoa, ck.MaKhoa, nv.HinhAnh
            FROM bacsi bs
            JOIN nhanvien nv ON bs.MaNV = nv.MaNV
            JOIN chuyenkhoa ck ON bs.MaKhoa = ck.MaKhoa
            WHERE nv.TrangThaiLamViec = 'Đang làm việc'
            ORDER BY bs.MaNV DESC";
        $stmt = $this->con->prepare($str);
        $stmt->execute();
        $result = $stmt->get_result();
        $doctors = [];
        while ($row = $result->fetch_assoc()) {
            $doctors[] = $row;
        }
        return json_encode($doctors);
    }

    public function Get1BS($MaNV) {
        $str = "SELECT bs.MaNV, nv.HovaTen, nv.NgaySinh, nv.GioiTinh, nv.SoDT, nv.EmailNV, ck.TenKhoa, ck.MaKhoa
                FROM bacsi bs
                JOIN nhanvien nv ON bs.MaNV = nv.MaNV
                JOIN chuyenkhoa ck ON bs.MaKhoa = ck.MaKhoa
                WHERE bs.MaNV = ?";
        $stmt = $this->con->prepare($str);
        $stmt->bind_param("i", $MaNV);
        $stmt->execute();
        $result = $stmt->get_result();
        $doctor = $result->fetch_assoc();
        return json_encode($doctor);
    }

    public function UpdateBS($MaNV, $NgaySinh, $GioiTinh, $EmailNV, $MaKhoa) {
        $this->con->begin_transaction();
        try {
            $str1 = "UPDATE nhanvien SET NgaySinh = ?, GioiTinh = ?, EmailNV = ? WHERE MaNV = ?";
            $stmt1 = $this->con->prepare($str1);
            $stmt1->bind_param("sssi", $NgaySinh, $GioiTinh, $EmailNV, $MaNV);
            $stmt1->execute();

            $str2 = "UPDATE bacsi SET MaKhoa = ? WHERE MaNV = ?";
            $stmt2 = $this->con->prepare($str2);
            $stmt2->bind_param("ii", $MaKhoa, $MaNV);
            $stmt2->execute();

            $this->con->commit();
            return true;
        } catch (Exception $e) {
            $this->con->rollback();
            return false;
        }
    }
    public function DeleteBS($MaNV) {
        $str = "UPDATE nhanvien SET TrangThaiLamViec = 'Nghỉ làm' WHERE MaNV = ?";
        $stmt = $this->con->prepare($str);
        $stmt->bind_param("i", $MaNV);
        return $stmt->execute();
    }

    public function GetAllChuyenKhoa() {
        $str = "SELECT MaKhoa, TenKhoa FROM chuyenkhoa ORDER BY TenKhoa ASC";
        $stmt = $this->con->prepare($str);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function AddBS($HovaTen, $NgaySinh, $GioiTinh, $SoDT, $EmailNV, $MaKhoa) {
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
                     VALUES (?, ?, ?, ?, ?, ?, 'Bác sĩ', 'Đang làm việc', 0)";
            $stmt1 = $this->con->prepare($str1);
            $stmt1->bind_param("isssss", $MaNV, $HovaTen, $NgaySinh, $GioiTinh, $SoDT, $EmailNV);
            $stmt1->execute();

            // Insert into bacsi table
            $str2 = "INSERT INTO bacsi (MaNV, MaKhoa) VALUES (?, ?)";
            $stmt2 = $this->con->prepare($str2);
            $stmt2->bind_param("ii", $MaNV, $MaKhoa);
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
    
    // private function GenerateNewID() {
    //     $str = "SELECT MAX(ID) as max_id FROM taikhoan";
    //     $result = $this->con->query($str);
    //     $row = $result->fetch_assoc();
    //     return ($row['max_id'] ?? 0) + 1;
    // }
    
    // private function GenerateUsername($HovaTen) {
    //     $name_parts = explode(' ', $HovaTen);
    //     $last_name = end($name_parts);
    //     $first_letter = mb_strtolower(mb_substr($HovaTen, 0, 1, 'UTF-8'), 'UTF-8');
    //     $username = $first_letter . mb_strtolower($last_name, 'UTF-8');
    
    //     $i = 1;
    //     $original_username = $username;
    //     while ($this->CheckExistingUsername($username)) {
    //         $username = $original_username . $i;
    //         $i++;
    //     }
    
    //     return $username;
    // }
    
    // private function CheckExistingUsername($username) {
    //     $str = "SELECT COUNT(*) as count FROM taikhoan WHERE username = ?";
    //     $stmt = $this->con->prepare($str);
    //     $stmt->bind_param("s", $username);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     $row = $result->fetch_assoc();
    //     return $row['count'] > 0;
    // }
}
?>

