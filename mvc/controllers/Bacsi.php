<?php
class Bacsi extends Controller
{
    // Hàm mặc định khi vào trang bác sĩ
    function SayHi()
    {
        $this->view("layoutBacsi", [
            "Page"
        ]);
    }

    function DangKyLichLamViec()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maNV = $_SESSION['MaNV'] ?? rand(1, 100); // Mã nhân viên (bác sĩ đăng nhập)
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

                    // Kiểm tra số lượng bác sĩ đã đăng ký trong ca làm việc
                    $soLuong = $model->kiemTraSoLuongCaLamViec($ngayLamViec, $shift);
                    if ($soLuong >= 10) {
                        $ngayLamViec = date('d/m/Y', strtotime($ngayLamViec));
                        $failed[] = "Ngày $ngayLamViec ($shift) đã đạt giới hạn số lượng bác sĩ.";
                        continue;
                    }

                    // Kiểm tra xem lịch đã tồn tại chưa
                    if ($model->kiemTraLichDaTonTai($maNV, $ngayLamViec, $shift)) {
                        $ngayLamViec = date('d/m/Y', strtotime($ngayLamViec));
                        $failed[] = "Ngày $ngayLamViec ($shift) đã được đăng ký.";
                    } else {
                        // Thêm lịch làm việc
                        if ($model->themLichLamViec($maNV, $ngayLamViec, $shift)) {
                            $ngayLamViec = date('d/m/Y', strtotime($ngayLamViec));
                            $success[] = "Ngày $ngayLamViec ($shift) đã được đăng ký thành công.";
                        } else {
                            $ngayLamViec = date('d/m/Y', strtotime($ngayLamViec));
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
        $model = $this->model("MBacsi");
        $maNV = $_SESSION['MaNV'] ?? 1;
        $lichLamViec = $model->XemLichLamViec($maNV);

        $this->view("layoutBacsi", [
            "Page" => "xemlichlamviec",
            "LichLamViec" => $lichLamViec
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
