<?php
class MBacsi extends DB
{
    // Thêm lịch làm việc với MaNV từ session
    public function themLichLamViec($maNV, $ngayLamViec, $caLamViec)
    {
        $stmt = $this->con->prepare("INSERT INTO LichLamViec (MaNV, NgayLamViec, CaLamViec, TrangThai) VALUES (?, ?, ?, 'chưa duyệt')");
        $stmt->bind_param("iss", $maNV, $ngayLamViec, $caLamViec);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Kiểm tra lịch làm việc đã tồn tại hay chưa
    public function kiemTraLichDaTonTai($maNV, $ngayLamViec, $caLamViec)
    {
        $stmt = $this->con->prepare("SELECT COUNT(*) FROM LichLamViec WHERE MaNV = ? AND NgayLamViec = ? AND CaLamViec = ?");
        $stmt->bind_param("iss", $maNV, $ngayLamViec, $caLamViec);
        $stmt->execute();
        $count = 0;
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        return $count > 0; // Trả về true nếu đã tồn tại
    }

    // Kiểm tra số lượng bác sĩ đã đăng ký trong ca làm việc
    public function kiemTraSoLuongCaLamViec($ngayLamViec, $caLamViec)
    {
        $stmt = $this->con->prepare("SELECT COUNT(*) FROM LichLamViec WHERE NgayLamViec = ? AND CaLamViec = ?");
        $stmt->bind_param("ss", $ngayLamViec, $caLamViec);
        $stmt->execute();
        $count = 0;
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        return $count;
    }
    
    public function XemLichLamViec($maNV)
    {
        $stmt = $this->con->prepare("SELECT NgayLamViec, CaLamViec FROM lichlamviec WHERE MaNV = ?");
        $stmt->bind_param("i", $maNV);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }

    //NhatCuong; Usecase: Xem danh sách khám bệnh; Hàm truy vấn for input-radio:Sáng
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

    //NhatCuong; Usecase: Xem danh sách khám bệnh; Hàm truy vấn for input-radio:Chiều
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

    //NhatCuong; Usecase: Xem danh sách khám bệnh; Hàm truy vấn for input-radio:Tất cả
    public function GetDanhSachKhamAll()
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
}
