<?php
class QuanLy extends Controller {
    function SayHi()
    {
        $this->view("layoutQL", [
            "Page"
        ]);
    }

    function TTBN() {
        $ql = $this->model("mQuanLy");
        $benhnhan = null;
        $phieukham = [];
        $found = false;
        if(isset($_POST['nutBack'])) {
            $maBN = $_POST['back'];
            $benhnhan = json_decode($ql->Get1BN($maBN), true);
        
            if($benhnhan && !empty($benhnhan)) {
                $phieukham = json_decode($ql->GetPK($maBN), true);
                $found = true;
            }
        }
        else if(isset($_POST['btnsearch'])) {
            $maBN = $_POST['txtsearch'];
            $benhnhan = json_decode($ql->Get1BN($maBN), true);
        
            if($benhnhan && !empty($benhnhan)) {
                $phieukham = json_decode($ql->GetPK($maBN), true);
                $found = true;
            }
        }

        $this->view("layoutQLy", [
            "Page" => "qlpk",
            "QuanLy" => json_encode([
                "BNhan" => $benhnhan,
                "PhieuKham" => $phieukham,
                "Found" => $found
            ])
        ]);
    }

    function CTPK() {
        if (isset($_POST["btnCTPK"])) {
            $MaPK = $_POST["ctpk"];
            $ql = $this->model("mQuanLy");
            $this->view("layoutQLy", [
                "Page" => "qlchitietpk",
                "CTPK" => $ql->GetCTPK($MaPK)
            ]);
        }
    }
    function LLV($date = null) {
        $ql = $this->model("mQuanLy");

        if(isset($_POST['btnDKL'])) {
            $MaNV=$_POST['MaNVien'];
            $NgayLamViec=$_POST['NgayLamViec'];
            $CaLamViec=$_POST['cl'];
            $result = $ql->AddLLV($MaNV, $NgayLamViec, $CaLamViec);
        }
        if(isset($_POST['MaNV'])) {
            $maNV = $_POST['MaNV'];
            $result = $ql->DelLLV($maNV);
            
            if($result) {
                $_SESSION['message'] = "Xóa ca làm việc thành công!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Xóa ca làm việc thất bại!";
                $_SESSION['message_type'] = "error";
            }
            header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
        }

        if (!$date) {
            $date = date('Y-m-d');
        }
    
        $khoa = $ql->GetDanhSachKhoa();
        
        $maKhoa = '';
        if (isset($_POST['khoaSelect']) && $_POST['khoaSelect'] != '') {
            $maKhoa = $_POST['khoaSelect'];
        }
    
        // Lấy lịch làm việc theo khoa nếu có, nếu không lấy tất cả bác sĩ
        if ($maKhoa != '') {
            $listBacSi = $ql->GetLichLamViecTheoKhoa($maKhoa);
        } else {
            $listBacSi = $ql->GetBSLLV();
        }
    
        // Gửi dữ liệu tới view
        $this->view("layoutQly2", [
            "Page" => "qlllv",
            "LLV" => $listBacSi,
            "Khoa" => $khoa,
            "SelectedDate" => $date,
            "SelectedKhoa" => $maKhoa,
            "BS" => $ql->GetDSBS()
        ]);
    }
    
    function ThongKe() {
        $ql = $this->model("mQuanLy");
    
        // Lấy dữ liệu tổng tiền theo tháng
        $thongKeTheoThang = $ql->GetThongKeTheoThang();
    
        // Truyền dữ liệu vào view
        $this->view("layoutQLy3", [
            "Page" => "thongke",
            "ThongKe" => $thongKeTheoThang  // Dữ liệu được truyền vào view
        ]);
    }
    
    
    }
?>

