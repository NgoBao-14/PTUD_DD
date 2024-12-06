<?php
     if($_SESSION["role"] != 2){
         echo "<script>alert('Bạn không có quyền truy cập')</script>";
         header("refresh: 0; url='/PTUD_DD'");
     }
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ Bác Sĩ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/nvyt.css">
    <link rel="stylesheet" href="./public/css/main.css">
    <link rel="stylesheet" href="../public/css/nvyt.css">
    <link rel="stylesheet" href="../public/css/main.css">
</head>

<body class="bg-light">

    <!-- header -->
    <?php include "blocks/header.php" ?>

    <div class="container mt-5 mb-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-3">DANH SÁCH CHỨC NĂNG</h6>
                        <div class="d-grid gap-2">
                            <a href="DangKyLichLamViec" class="btn btn-light text-start sidebar-link">Đăng ký lịch làm việc</a>
                            <a href="XemLichLamViec" class="btn btn-light text-start sidebar-link">Xem lịch làm việc</a>
                            <a href="Bacsi/XemDanhSachKham" class="btn btn-light text-start sidebar-link">Xem danh sách khám</a>
                            <a href="XemThongTinBenhNhan" class="btn btn-light text-start sidebar-link">Xem thông tin bệnh nhân</a>
                            <a href="XemLichSuKhamBenh" class="btn btn-light text-start sidebar-link">Xem lịch sử khám bệnh</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body" id="mainContent">
                        <?php
                        if (isset($data["Page"])) {
                            require_once "./mvc/views/pages/" . $data["Page"] . ".php";
                        } else {
                            echo "<h5 class='text-center text-muted'>Vui lòng chọn một chức năng</h5>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- footer -->
    <?php include "blocks/footer.php" ?>
</body>

</html>