<?php
class QuanLy extends Controller {
    // ... (other methods remain unchanged)

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
    
        // Lấy ngày hiện tại nếu không có ngày được truyền
        if (!$date) {
            $date = date('Y-m-d');
        }
    
        // Lấy danh sách khoa
        $khoa = $ql->GetDanhSachKhoa();
        
        // Kiểm tra xem có khoa được chọn hay không qua POST
        $maKhoa = '';
        if (isset($_POST['khoaSelect']) && $_POST['khoaSelect'] != '') {
            $maKhoa = $_POST['khoaSelect'];
        }
    
        // Xử lý xóa bác sĩ nếu có yêu cầu
        if (isset($_POST['deleteDoctor'])) {
            $maNV = $_POST['deleteDoctor'];
            
            $ql->DeleteDoctor($maNV);
            
            // Sau khi xóa, tải lại danh sách bác sĩ
            if ($maKhoa != '') {
                $listBacSi = $ql->GetLichLamViecTheoKhoa($maKhoa);
            } else {
                $listBacSi = $ql->GetBSLLV();
            }

            $this->view("layoutQly2", [
                "Page" => "qlllv",
                "LLV" => $listBacSi,
                "Khoa" => $khoa,
                "SelectedDate" => $date,
                "SelectedKhoa" => $maKhoa
            ]);
            return; // Dừng lại sau khi xóa và tải lại
        }
    
        // Lấy lịch làm việc theo khoa nếu có, nếu không lấy tất cả bác sĩ
        if ($maKhoa != '') {
            $listBacSi = $ql->GetLichLamViecTheoKhoa($maKhoa);
        } else {
            $listBacSi = $ql->GetBSLLV();
        }
    
        $this->view("layoutQly2", [
            "Page" => "qlllv",
            "LLV" => $listBacSi,
            "Khoa" => $khoa,
            "SelectedDate" => $date,
            "SelectedKhoa" => $maKhoa
        ]);
    }
    
    
    
    }
?>

