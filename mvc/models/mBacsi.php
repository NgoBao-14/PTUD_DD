<?php
class MBacsi extends DB
{
    // Thêm lịch làm việc
    public function themLichLamViec($maBS, $ngayLamViec, $caLamViec)
    {
        $stmt = $this->con->prepare("INSERT INTO LichLamViec (MaLLV, NgayLamViec, CaLamViec, TrangThai) VALUES (?, ?, ?, 'chưa duyệt')");
        $stmt->bind_param("iss", $maBS, $ngayLamViec, $caLamViec);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Kiểm tra lịch làm việc đã tồn tại hay chưa
    public function kiemTraLichDaTonTai($maBS, $ngayLamViec, $caLamViec)
    {
        $stmt = $this->con->prepare("SELECT COUNT(*) FROM LichLamViec WHERE MaLLV = ? AND NgayLamViec = ? AND CaLamViec = ?");
        $stmt->bind_param("iss", $maBS, $ngayLamViec, $caLamViec);
        $stmt->execute();
        $count = 0;
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        return $count > 0; // Trả về true nếu đã tồn tại
    }
    
    
}
