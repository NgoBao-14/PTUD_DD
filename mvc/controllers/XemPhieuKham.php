<?php
class XemPhieuKham extends Controller
{
  
    function SayHi()
    {
        if (!isset($_SESSION['idbn'])) {
            header("Location: /PTUD_DD/Login"); 
            exit;
        }

        $MaBN = $_SESSION['idbn'];
        $khachhang = $this->model("mXemPhieuKham");
        $MaPK = isset($_POST["MaPK"]) ? $_POST["MaPK"] : "";
        $NgayTao = isset($_POST["NgayTao"]) ? $_POST["NgayTao"] : "";    
        if (isset($MaBN)){
            $page='XemPhieuKham';
            $view='layoutBN';
        }else{
            $page='Login';
            $view='layoutLogin';
        }
        $phieuKham = $khachhang->GetPK($MaBN);
        $chiTietPhieuKham = ($MaPK != "") ? $khachhang->getCTPK($MaPK) : [];
        $this->view($view, [
            "Page" => $page,
            "PK" => $phieuKham,
            "CTPK" => $chiTietPhieuKham,

        ]);
    }

}


?>