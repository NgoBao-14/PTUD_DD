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
        $result = $this->con->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
    }

    public function Get1BS($MaNV) {
        $str = "SELECT bs.MaNV, nv.HovaTen, nv.NgaySinh, nv.GioiTinh, nv.SoDT, nv.EmailNV, ck.TenKhoa, ck.MaKhoa
                FROM bacsi bs
                JOIN nhanvien nv ON bs.MaNV = nv.MaNV
                JOIN chuyenkhoa ck ON bs.MaKhoa = ck.MaKhoa
                WHERE bs.MaNV = $MaNV";
        $result = $this->con->query($str);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return json_encode($data);
    }

    public function UpdateBS($MaNV, $NgaySinh, $GioiTinh, $EmailNV, $MaKhoa) {
        $str1 = "UPDATE nhanvien SET NgaySinh = '$NgaySinh', GioiTinh = '$GioiTinh', EmailNV = '$EmailNV' WHERE MaNV = $MaNV";
        $str2 = "UPDATE bacsi SET MaKhoa = $MaKhoa WHERE MaNV = $MaNV";
        
        $result1 = mysqli_query($this->con, $str1);
        $result2 = mysqli_query($this->con, $str2);
        
        return $result1 && $result2;
    }

    public function DeleteBS($MaNV) {
        $str = "UPDATE nhanvien SET TrangThaiLamViec = 'Nghỉ làm', ID=null WHERE MaNV = $MaNV";
        $result = mysqli_query($this->con, $str);
        return $result;
    }

    public function GetAllChuyenKhoa() {
        $str = "SELECT MaKhoa, TenKhoa FROM chuyenkhoa ORDER BY TenKhoa ASC";
        $result = $this->con->query($str);
        return $result;
    }

    public function AddBS($HovaTen, $NgaySinh, $GioiTinh, $SoDT, $EmailNV, $MaKhoa) {
        // Kiểm tra số điện thoại và email trùng lặp
        if ($this->CheckExistingPhoneNumber($SoDT)) {
            return "Số điện thoại đã tồn tại trong hệ thống.";
        }
        if ($this->CheckExistingEmail($EmailNV)) {
            return "Email đã tồn tại trong hệ thống.";
        }

        // Tạo tài khoản mới
        $username = $SoDT;
        $password = md5('123456');
        $str1 = "INSERT INTO taikhoan (username, password, MaPQ) VALUES ('$username', '$password', 2)";
        $result1 = mysqli_query($this->con, $str1);
        if (!$result1) {
            return "Lỗi khi tạo tài khoản: " . mysqli_error($this->con);
        }
        $newAccountId = mysqli_insert_id($this->con);

        // Thêm vào bảng nhanvien
        $str2 = "INSERT INTO nhanvien (HovaTen, NgaySinh, GioiTinh, SoDT, EmailNV, ChucVu, TrangThaiLamViec, ID) 
                 VALUES ('$HovaTen', '$NgaySinh', '$GioiTinh', '$SoDT', '$EmailNV', 'Bác sĩ', 'Đang làm việc', $newAccountId)";
        $result2 = mysqli_query($this->con, $str2);
        if (!$result2) {
            return "Lỗi khi thêm nhân viên: " . mysqli_error($this->con);
        }
        $MaNV = mysqli_insert_id($this->con);

        // Thêm vào bảng bacsi
        $str3 = "INSERT INTO bacsi (MaNV, MaKhoa) VALUES ($MaNV, $MaKhoa)";
        $result3 = mysqli_query($this->con, $str3);
        if (!$result3) {
            return "Lỗi khi thêm bác sĩ: " . mysqli_error($this->con);
        }

        return true;
    }

    public function CheckExistingPhoneNumber($SoDT) {
        $str = "SELECT COUNT(*) as count FROM nhanvien WHERE SoDT = '$SoDT'";
        $result = $this->con->query($str);
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    public function CheckExistingEmail($EmailNV) {
        $str = "SELECT COUNT(*) as count FROM nhanvien WHERE EmailNV = '$EmailNV'";
        $result = $this->con->query($str);
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
}
?>
