<?php
    if($_SESSION["role"] != 1){
        echo "<script>alert('Bạn không có quyền truy cập')</script>";
        header("refresh: 0; url='/PTUD_DD'");
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../public/css/main.css">
    <style>
        body {
    background-color: #f0f0f0;
}
.navbar {
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0,0,0,.08);
}
.navbar-brand {
    font-weight: bold;
    color: #0d6efd;
}
.nav-link {
    color: #495057;
}
.nav-link.active {
    font-weight: bold;
    color: #0d6efd;
}
.card {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border-radius: 0.5rem;
}
.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}
.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0b5ed7;
}
#chart {
    width: 100%;
    height: 300px;
    background-color: #f8f9fa;
}
    </style>
</head>
<body>
<?php include "blocks/header.php" ?>
    <div class="main">
        <div class="container mt-4 mb-3">
            <!-- <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Thống kê hóa đơn</h5>
                            <form id="statisticForm">
                                <div class="mb-3">
                                    <label for="statisticCriteria" class="form-label">Tiêu chí thống kê:</label>
                                    <select class="form-select" id="statisticCriteria">
                                        <option selected>Chọn tiêu chí thống kê</option>
                                        <option value="1">Thống kê theo dịch vụ</option>
                                        <option value="2">Thống kê theo thời gian</option>
                                    </select>
                                </div>
                                <div id="serviceOptions" class="mb-3 d-none">
                                    <label class="form-label">Chọn loại dịch vụ:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="serviceType" id="examination">
                                        <label class="form-check-label" for="examination">
                                            Khám bệnh
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="serviceType" id="testing">
                                        <label class="form-check-label" for="testing">
                                            Xét nghiệm
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="serviceType" id="treatment">
                                        <label class="form-check-label" for="treatment">
                                            Điều trị
                                        </label>
                                    </div>
                                </div>
                                <div id="timeOptions" class="mb-3 d-none">
                                    <label for="timePeriod" class="form-label">Chọn khoảng thời gian:</label>
                                    <select class="form-select mb-2" id="timePeriod">
                                        <option selected>Chọn khoảng thời gian</option>
                                        <option value="day">Theo ngày</option>
                                        <option value="week">Theo tuần</option>
                                        <option value="month">Theo tháng</option>
                                        <option value="year">Theo năm</option>
                                    </select>
                                    <div id="specificDateContainer" class="d-none">
                                        <label for="specificDate" class="form-label">Chọn ngày cụ thể:</label>
                                        <input type="date" class="form-control" id="specificDate">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100" id="submitButton" disabled>Xác nhận thống kê</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Biểu đồ thống kê</h5>
                            <canvas id="chartCanvas"></canvas>
                        </div>
                        <div class="card-footer text-end mt-2">
                            <button class="btn btn-primary">In báo cáo</button>
                        </div>
                    </div>
                </div>
            </div> -->
            <?php require_once "./mvc/views/pages/".$data["Page"].".php" ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>