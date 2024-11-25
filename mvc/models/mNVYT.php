<?php
class mNVYT extends DB
{
    public function GetHD()
    {
        $str = 'select * 
                from hoadon as h 
                join chitiethoadon as hd on h.MaHD = hd.MaHD 
                join benhnhan as b on h.MaBN=b.MaBN 
                join phuongthucthanhtoan as t on h.MaPTTT = t.MaPTTT
                order by h.MaHD desc';
        $tblNVYT = mysqli_query($this->con, $str);
        return $tblNVYT;
    }
    public function getCTHD($MaHD)
    {
        $str = 'SELECT *
                FROM hoadon AS h
                JOIN chitiethoadon AS hd ON h.MaHD = hd.MaHD
                JOIN benhnhan AS b ON h.MaBN = b.MaBN
                WHERE h.MaHD = '.$MaHD.'
                ORDER BY h.MaHD DESC';
        $tblCTHD = mysqli_query($this->con, $str);
        return $tblCTHD;
    }
}



?>