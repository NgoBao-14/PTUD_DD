<?php
class mQLBS extends DB {
    public function GetAllBS() {
        $str = "SELECT bs.MaNV, nv.HovaTenNV, nv.NgaySinh, nv.GioiTinh, nv.SoDT, nv.EmailNV, ck.TenKhoa
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
        $str = "SELECT bs.MaNV, nv.HovaTenNV, nv.NgaySinh, nv.GioiTinh, nv.SoDT, nv.EmailNV, ck.TenKhoa, ck.MaKhoa
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

    public function UpdateBS($MaNV, $HovaTenNV, $NgaySinh, $GioiTinh, $SoDT, $EmailNV, $MaKhoa) {
        $this->con->begin_transaction();
        try {
            $str1 = "UPDATE nhanvien SET HovaTenNV = ?, NgaySinh = ?, GioiTinh = ?, SoDT = ?, EmailNV = ? WHERE MaNV = ?";
            $stmt1 = $this->con->prepare($str1);
            $stmt1->bind_param("sssssi", $HovaTenNV, $NgaySinh, $GioiTinh, $SoDT, $EmailNV, $MaNV);
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

    public function AddBS($HovaTenNV, $NgaySinh, $GioiTinh, $SoDT, $EmailNV, $MaKhoa) {
        $this->con->begin_transaction();
        try {
            // Check for existing phone number and email
            if ($this->CheckExistingPhoneNumber($SoDT)) {
                return "Số điện thoại đã tồn tại";
            }
            if ($this->CheckExistingEmail($EmailNV)) {
                return "Email đã tồn tại";
            }

            // Generate new IDs
            $MaNV = $this->GenerateNewMaNV();
            $ID = $this->GenerateNewID();
            $MaLLV = $this->GenerateNewMaLLV();

            // Insert into nhanvien table
            $str1 = "INSERT INTO nhanvien (MaNV, HovaTenNV, NgaySinh, GioiTinh, SoDT, EmailNV, ChucVu, TrangThaiLamViec, ID, MaLLV) 
                     VALUES (?, ?, ?, ?, ?, ?, 'Bác sĩ', 'Đang làm việc', ?, ?)";
            $stmt1 = $this->con->prepare($str1);
            $stmt1->bind_param("isssssii", $MaNV, $HovaTenNV, $NgaySinh, $GioiTinh, $SoDT, $EmailNV, $ID, $MaLLV);
            $stmt1->execute();

            // Insert into bacsi table
            $str2 = "INSERT INTO bacsi (MaNV, MaKhoa) VALUES (?, ?)";
            $stmt2 = $this->con->prepare($str2);
            $stmt2->bind_param("ii", $MaNV, $MaKhoa);
            $stmt2->execute();

            // Insert into taikhoan table
            $username = $this->GenerateUsername($HovaTenNV);
            $password = password_hash($SoDT, PASSWORD_DEFAULT); // Using phone number as initial password
            $str3 = "INSERT INTO taikhoan (ID, username, password, phanquyen) VALUES (?, ?, ?, 'Bác sĩ')";
            $stmt3 = $this->con->prepare($str3);
            $stmt3->bind_param("iss", $ID, $username, $password);
            $stmt3->execute();

            // Insert into lichlamviec table
            $str4 = "INSERT INTO lichlamviec (MaLLV, NgayLamViec, TrangThai, GhiChu, CaLamViec) 
                     VALUES (?, NOW(), 'Chưa phân công', '', '')";
            $stmt4 = $this->con->prepare($str4);
            $stmt4->bind_param("i", $MaLLV);
            $stmt4->execute();

            $this->con->commit();
            return true;
        } catch (Exception $e) {
            $this->con->rollback();
            return "Lỗi: " . $e->getMessage();
        }
    }

    private function GenerateNewMaNV() {
        $str = "SELECT MAX(MaNV) as max_id FROM nhanvien";
        $result = $this->con->query($str);
        $row = $result->fetch_assoc();
        return $row['max_id'] + 1;
    }

    private function GenerateNewID() {
        $str = "SELECT MAX(ID) as max_id FROM taikhoan";
        $result = $this->con->query($str);
        $row = $result->fetch_assoc();
        return $row['max_id'] + 1;
    }

    private function GenerateNewMaLLV() {
        $str = "SELECT MAX(MaLLV) as max_id FROM lichlamviec";
        $result = $this->con->query($str);
        $row = $result->fetch_assoc();
        return $row['max_id'] + 1;
    }

    private function GenerateUsername($HovaTenNV) {
        $name_parts = explode(' ', $HovaTenNV);
        $last_name = end($name_parts);
        $first_letter = strtolower(substr($HovaTenNV, 0, 1));
        $username = $first_letter . strtolower($last_name);

        // Check if username exists and append number if necessary
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

    public function CheckExistingPhoneNumber($SoDT, $MaNV = null) {
        $str = "SELECT COUNT(*) as count FROM nhanvien WHERE SoDT = ? AND MaNV != ?";
        $stmt = $this->con->prepare($str);
        $stmt->bind_param("si", $SoDT, $MaNV);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    public function CheckExistingEmail($EmailNV, $MaNV = null) {
        $str = "SELECT COUNT(*) as count FROM nhanvien WHERE EmailNV = ? AND MaNV != ?";
        $stmt = $this->con->prepare($str);
        $stmt->bind_param("si", $EmailNV, $MaNV);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
}
?>

