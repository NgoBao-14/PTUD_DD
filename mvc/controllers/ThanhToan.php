<?php
class ThanhToan extends Controller
{
   

    function SayHi()

    {   
        if (!isset($_SESSION['idbn'])) {
            header("Location: /PTUD_DD/Login"); 
            exit;
        }

        $MaBN = $_SESSION['idbn'];
        $khachhang = $this->model("mThanhToan");
        $MaLK = isset($_POST["MaLK"]) ? $_POST["MaLK"] : "";
        $NgayKham = isset($_POST["NgayKham"]) ? $_POST["NgayKham"] : "";
        $GioKham = isset($_POST["GioKham"]) ? $_POST["GioKham"] : "";

        if (isset($MaBN)){
            $page='ThanhToan';
            $view='layoutBN';
        }else{
            $page='Login';
            $view='layoutLogin';
        }
       
        $lichKham = $khachhang->GetLK($MaBN);
        $chiTietLichKham = ($MaLK != "") ? $khachhang->getCTLK($MaLK) : [];
        $this->view($view, [
            "Page" =>  $page,
            "LK" => $lichKham,
            "CTLK" => $chiTietLichKham,
            
        ]);
    }

}


?>