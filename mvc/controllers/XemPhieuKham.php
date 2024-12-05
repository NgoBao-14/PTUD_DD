<?php
class XemPhieuKham extends Controller
{
    public $MaBN = 1; 

    function SayHi()
    {
        $khachhang = $this->model("mXemPhieuKham");
        $MaPK = isset($_POST["MaPK"]) ? $_POST["MaPK"] : "";
        $NgayTao = isset($_POST["NgayTao"]) ? $_POST["NgayTao"] : "";    
        
        $phieuKham = $khachhang->GetPK($this->MaBN);
        $chiTietPhieuKham = ($MaPK != "") ? $khachhang->getCTPK($MaPK) : [];
        $this->view("layoutBN", [
            "Page" => "XemPhieuKham",
            "PK" => $phieuKham,
            "CTPK" => $chiTietPhieuKham,

        ]);
    }

}


?>