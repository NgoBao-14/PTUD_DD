<?php
class mNVYT extends DB
{
    public function GetTotalInvoices() {
        $str = 'SELECT COUNT(*) as total FROM hoadon';
        $result = mysqli_query($this->con, $str);
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    public function GetHD($offset, $limit)
    {
        $str = "select * 
                from hoadon as h 
                join chitiethoadon as hd on h.MaHD = hd.MaHD 
                join benhnhan as b on h.MaBN=b.MaBN 
                join phuongthucthanhtoan as t on h.MaPTTT = t.MaPTTT
                order by h.MaHD desc
                LIMIT $offset, $limit";
        $rows = mysqli_query($this->con, $str);
        $mang = array();
        while ($row = mysqli_fetch_array($rows))
        {
            $mang[] = $row;
        }
        return json_encode($mang);
    }
    public function GetHDTheoLoc($offset, $limit,$loc)
    {
        $str = "select * 
                from hoadon as h 
                join chitiethoadon as hd on h.MaHD = hd.MaHD 
                join benhnhan as b on h.MaBN=b.MaBN 
                join phuongthucthanhtoan as t on h.MaPTTT = t.MaPTTT
                WHERE h.TrangThai = $loc
                order by h.MaHD desc
                LIMIT $offset, $limit";
        $rows = mysqli_query($this->con, $str);
        $mang = array();
        while ($row = mysqli_fetch_array($rows))
        {
            $mang[] = $row;
        }
        return json_encode($mang);
    }
    public function getCTHD($MaHD)
    {
        $str = 'SELECT *
                FROM hoadon AS h
                JOIN chitiethoadon AS hd ON h.MaHD = hd.MaHD
                JOIN benhnhan AS b ON h.MaBN = b.MaBN
                WHERE h.MaHD = '.$MaHD.'
                ORDER BY h.MaHD DESC';
        $rows = mysqli_query($this->con, $str);
        $mang = array();
        while ($row = mysqli_fetch_array($rows))
        {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    public function getPTTT()
    {
        $str = 'SELECT * 
                FROM phuongthucthanhtoan 
                WHERE MaPTTT > 0';
        $rows = mysqli_query($this->con, $str);
        $mang = array();
        while ($row = mysqli_fetch_array($rows))
        {
            $mang[] = $row;
        }
        return json_encode($mang);
    }
    public function setPTTT($MaHD,$PT)
    {
        $str = 'UPDATE hoadon SET MaPTTT = '.$PT.' WHERE MaHD = '.$MaHD.'';
        $tblPTTT = mysqli_query($this->con, $str);
        return $tblPTTT;
    }
    public function setTrangThai($MaHD,$TT)
    {
        $str = 'UPDATE hoadon SET TrangThai = '.$TT.' WHERE MaHD = '.$MaHD.'';
        $tblTT = mysqli_query($this->con, $str);
        return $tblTT;
    }
}



?>