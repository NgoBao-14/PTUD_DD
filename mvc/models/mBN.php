<?php
class mBN extends DB
{
    public function get1BN($mabn){
        $str = "select * from benhnhan where MaBN='$mabn'";
        $rows = mysqli_query($this->con, $str);
        
        $mang = array();
        while($row = mysqli_fetch_array($rows)){
            $mang[] = $row;
        }
        return json_encode($mang);
    }
    public function UpdateBN($mabn, $hoten, $gioitinh, $ngaysinh, $diachi, $email, $bhyt){
        $str = "UPDATE benhnhan SET HovaTen='$hoten', GioiTinh='$gioitinh', NgaySinh='$ngaysinh', 
                DiaChi='$diachi', Email='$email', BHYT='$bhyt' WHERE MaBN = $mabn";
        $result = mysqli_query($this->con, $str);
        return json_encode(array("success" => $result));
    }

    public function getDKXN($ngayxn, $ketqua, $loaixn, $mabn){
        $str = "INSERT INTO xetnghiem VALUES(null, '$ngayxn', '$ketqua', '$loaixn', '$mabn')";
        $result = false;
        if(mysqli_query($this->con, $str)){
            $result = true;
        }
        return json_encode($result);
    }
}
?>