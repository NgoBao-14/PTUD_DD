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
}



?>