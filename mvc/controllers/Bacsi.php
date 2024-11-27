<?php
class Bacsi extends Controller
{
    function DangKyLichLamViec()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maBS = $_POST['MaBS']; // Mã bác sĩ
            $schedule = $_POST['schedule']; // Dữ liệu lịch làm việc
            $dateRange = $_POST['dateRange']; // Khoảng thời gian của tuần được chọn

            $model = $this->model("MBacsi");
            $success = [];
            $failed = [];

            // Chuyển khoảng thời gian thành ngày bắt đầu và kết thúc
            list($startDate, $endDate) = explode(" - ", $dateRange);
            $startDate = DateTime::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
            $endDate = DateTime::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');

            // Tính ngày làm việc cho tuần được chọn
            $daysMap = ['mon' => 0, 'tue' => 1, 'wed' => 2, 'thu' => 3, 'fri' => 4, 'sat' => 5, 'sun' => 6];
            $monday = new DateTime($startDate);

            foreach ($schedule as $day => $shifts) {
                foreach ($shifts as $shift) {
                    // Tính ngày làm việc dựa vào thứ
                    $ngayLamViec = $monday->modify("+{$daysMap[$day]} days")->format('Y-m-d');

                    // Kiểm tra xem lịch đã tồn tại chưa
                    if ($model->kiemTraLichDaTonTai($maBS, $ngayLamViec, $shift)) {
                        $failed[] = "Ngày $ngayLamViec ($shift) đã được đăng ký.";
                    } else {
                        // Thêm lịch làm việc
                        if ($model->themLichLamViec($maBS, $ngayLamViec, $shift)) {
                            $success[] = "Ngày $ngayLamViec ($shift) đã được đăng ký thành công.";
                        } else {
                            $failed[] = "Có lỗi xảy ra khi đăng ký ngày $ngayLamViec ($shift).";
                        }
                    }
                }
                $monday = new DateTime($startDate); // Reset lại thứ 2
            }

            // Trả về giao diện với thông báo chi tiết
            $this->view("layoutBacsi", [
                "Page" => "dangkylichlamviec",
                "Message" => [
                    "success" => $success,
                    "failed" => $failed
                ]
            ]);
        } else {
            $this->view("layoutBacsi", [
                "Page" => "dangkylichlamviec"
            ]);
        }
    }
    function XemLichLamViec()
    {
        $this->view("layoutBacsi", [
            "Page" => "xemlichlamviec"
        ]);
    }

    function XemDanhSachKham()
    {
        $this->view("layoutBacsi", [
            "Page"
        ]);
    }

    function XemThongTinBenhNhan()
    {
        $this->view("layoutBacsi", [
            "Page"
        ]);
    }

    function XemLichSuKhamBenh()
    {
        $this->view("layoutBacsi", [
            "Page"
        ]);
    }
}
