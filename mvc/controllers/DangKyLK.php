<?php
class DangKyLK extends Controller {
   

    public function SayHi() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }       
        $dangky = $this->model("mDangKyLK");
        $searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : ""; 
        
        if (!isset($_SESSION['idbn'])) {
            header("Location: /PTUD_DD/Login"); 
            exit;
        }
        $MaBN = $_SESSION['idbn'];
       
    
        $MaBS = isset($_POST["MaBS"]) ? $_POST["MaBS"] : "";
        if (isset($_POST["MaBS"]) && !empty($_POST["MaBS"])) {
            $_SESSION["MaBS"] = $_POST["MaBS"];
        } 
        $MaKhoa = isset($_POST["MaKhoa"]) ? $_POST["MaKhoa"] : "";
        $NgayKham = isset($_POST["NgayKham"]) ? $_POST["NgayKham"] : "";
        $GioKham = isset($_POST["GioKham"]) ? $_POST["GioKham"] : "";
        $Buoi = isset($_POST["Buoi"]) ? $_POST["Buoi"] : "";

        $message = "";
        $messageType = "";
    
        if (isset($_POST['check']) && $_POST['check'] === 'Đặt Lịch Khám') {
            if ($NgayKham == "" || $GioKham == "") {
                $message = "Vui lòng chọn đầy đủ cả ngày và giờ khám!";
                $messageType = "error";
            } elseif ($MaBS != "" && $NgayKham != "" && $GioKham != "") {
                $isDuplicated = json_decode($dangky->CheckTrungLich($MaBS, $NgayKham, $GioKham), true);
                if ($isDuplicated['exists']) {
                    $message = "Lịch khám đã bị trùng, vui lòng chọn giờ khác!";
                    $messageType = "error";
                } else {
                   
                    $dangky->InsertLichKham($MaBS, $NgayKham, $GioKham, $MaBN);
                    $message = "Đặt lịch khám thành công!";
                    $messageType = "success";
                }
            } else {
                $message = "Vui lòng chọn đầy đủ thông tin để đặt lịch khám!";
                $messageType = "error";
            }
        }
        
        if (!empty($searchTerm)) {
            $chuyenkhoa = $dangky->SearchChuyenKhoa($searchTerm);
        } else {
            $chuyenkhoa = $dangky->GetAllCK();
        }
      

      
        
        if (isset($MaBN)){
            $page='DangKyLK';
            $view='layoutDKLK';
        }else{
            $page='Login';
            $view='layoutLogin';
        }

        $bacsiList = ($MaKhoa != "") ? $dangky->GetBS($MaKhoa) : [];    
        $page = ($MaBS != "") ? 'ThongTinLK' : 'DangKyLK';

        $this->view($view, [
            "Page" => $page,
            "CK" => $chuyenkhoa,
            "BS" => $bacsiList,
            "Message" => $message,
            "MessageType" => $messageType,
        ]);
    }
}
?>
