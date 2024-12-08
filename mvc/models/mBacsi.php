<?php
class MBacsi extends DB
{
    // Thêm lịch làm việc
    public function themLichLamViec($maNV, $ngayLamViec, $caLamViec)
    {
        $str = "INSERT INTO LichLamViec (MaNV, NgayLamViec, CaLamViec, TrangThai) 
                VALUES ('$maNV', '$ngayLamViec', '$caLamViec', 'chưa duyệt')";
        return mysqli_query($this->con, $str);
    }

    // Kiểm tra lịch làm việc đã tồn tại
    public function kiemTraLichDaTonTai($maNV, $ngayLamViec, $caLamViec)
    {
        $str = "SELECT COUNT(*) as count 
                FROM LichLamViec 
                WHERE MaNV = '$maNV' AND NgayLamViec = '$ngayLamViec' AND CaLamViec = '$caLamViec'";
        $result = mysqli_query($this->con, $str);
        $row = mysqli_fetch_assoc($result);
        return $row['count'] > 0;
    }

    // Kiểm tra số lượng bác sĩ đã đăng ký trong ca làm việc
    public function kiemTraSoLuongCaLamViec($ngayLamViec, $caLamViec)
    {
        $str = "SELECT COUNT(*) as count 
                FROM LichLamViec 
                WHERE NgayLamViec = '$ngayLamViec' AND CaLamViec = '$caLamViec'";
        $result = mysqli_query($this->con, $str);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }

    // Xem lịch làm việc của bác sĩ
    public function XemLichLamViec($maNV)
    {
        $str = "SELECT NgayLamViec, CaLamViec 
                FROM LichLamViec 
                WHERE MaNV = '$maNV'";
        $result = mysqli_query($this->con, $str);
        $mang = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    //NhatCuong; Usecase: Xem danh sách khám bệnh1/3; Hàm truy vấn for input-radio:Sáng 
    public function GetDanhSachKhamSang()
    {
        $str = 'SELECT 
                    lk.MaLK, 
                    bn.HovaTen, 
                    bn.NgaySinh, 
                    bn.SoDT,
                    lk.NgayKham
                FROM 
                    lichkham2 lk
                JOIN 
                    benhnhan bn ON lk.MaBN = bn.MaBN
                WHERE 
                    DATE(lk.NgayKham) = CURDATE()
                    AND HOUR(lk.NgayKham) < 12
                ORDER BY 
                    lk.NgayKham ASC';
        $rows = mysqli_query($this->con, $str);
        $mang = array();
        while ($row = mysqli_fetch_array($rows))
        {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    //NhatCuong; Usecase: Xem danh sách khám bệnh2/3; Hàm truy vấn for input-radio:Chiều
    public function GetDanhSachKhamChieu()
    {
        $str = 'SELECT 
                    lk.MaLK, 
                    bn.HovaTen, 
                    bn.NgaySinh, 
                    bn.SoDT,
                    lk.NgayKham
                FROM 
                    lichkham2 lk
                JOIN 
                    benhnhan bn ON lk.MaBN = bn.MaBN
                WHERE 
                    DATE(lk.NgayKham) = CURDATE()
                    AND HOUR(lk.NgayKham) >= 12
                ORDER BY 
                    lk.NgayKham ASC';
        $rows = mysqli_query($this->con, $str);
        $mang = array();
        while ($row = mysqli_fetch_array($rows))
        {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    //NhatCuong; Usecase: Xem danh sách khám bệnh3/3; Hàm truy vấn for input-radio:Tất cả
    public function GetDanhSachKhamAll()
    {
        $str = 'SELECT 
                    lk.MaLK, 
                    bn.HovaTen, 
                    bn.NgaySinh, 
                    bn.SoDT,
                    lk.NgayKham
                FROM 
                    lichkham lk
                JOIN 
                    benhnhan bn ON lk.MaBN = bn.MaBN
                WHERE 
                    DATE(lk.NgayKham) = CURDATE()
                ORDER BY 
                    lk.NgayKham ASC';
        $rows = mysqli_query($this->con, $str);
        $mang = array();
        while ($row = mysqli_fetch_array($rows))
        {
            $mang[] = $row;
        }
        return json_encode($mang);
    }
    //NhatCuong; Usecase 1/3: Xem lịch sử khám bệnh, phiếu khám
    public function GetPhieuKhamBenhNhan($maBN)
    {
        $str = "SELECT 
                pk2.NgayTao,
                nv.HoVaTenNV AS BacSi,
                pk2.TrieuChung,
                pk2.ChuanDoan,
                pk2.KetQua,
                pk2.LoiDan,
                pk2.NgayTaiKham
            FROM 
                PhieuKham2 pk2
            JOIN 
                NhanVien nv ON pk2.MaNV = nv.MaNV
            WHERE 
                pk2.MaBN = '$maBN'
            ORDER BY 
                pk2.NgayTao";
        $result = mysqli_query($this->con, $str);
        $mang = array();
        while ($row = mysqli_fetch_array($result))
        {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    //NhatCuong; Usecase 2/3: Xem lịch sử khám bệnh, thông tin bệnh nhân
    public function GetThongTinBenhNhan($maBN)
    {
        $str = "SELECT MaBN, HovaTen, NgaySinh, GioiTinh, BHYT, DiaChi, SoDT
            FROM benhnhan
            WHERE MaBN = '$maBN'";
        $result = mysqli_query($this->con, $str);
        $row = mysqli_fetch_assoc($result);
        return json_encode($row);
    }

    //NhatCuong; Usecase 2/3: Xem lịch sử khám bệnh //count (phieukham)
    public function GetSoLanKhamBenh($maBN)
    {
        $str = "SELECT COUNT(*) as SoLanKham
            FROM PhieuKham2
            WHERE MaBN = '$maBN'";
        $result = mysqli_query($this->con, $str);
        $row = mysqli_fetch_assoc($result);
        return $row['SoLanKham'];
    }
}

