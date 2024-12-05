<?php
class ThanhToan extends Controller
{
    public $MaBN = 1; 

    function SayHi()
    {
        $khachhang = $this->model("mThanhToan");
        $MaLK = isset($_POST["MaLK"]) ? $_POST["MaLK"] : "";
        $NgayKham = isset($_POST["NgayKham"]) ? $_POST["NgayKham"] : "";
        $GioKham = isset($_POST["GioKham"]) ? $_POST["GioKham"] : "";
       
        $lichKham = $khachhang->GetLK($this->MaBN);
        $chiTietLichKham = ($MaLK != "") ? $khachhang->getCTLK($MaLK) : [];
        $this->view("layoutBN", [
            "Page" => "ThanhToan",
            "LK" => $lichKham,
            "CTLK" => $chiTietLichKham,
            
        ]);
    }

}


?>