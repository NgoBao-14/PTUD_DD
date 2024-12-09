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
    <title>Danh sách khám bệnh</title>
    <link rel="stylesheet" href="/ptud_dd/public/css/main.css">
    <style>
            body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f0f0;
    }
    .layout {
        display: flex;
        width: 100%;
        max-width: 1400px;
        margin: 80px auto 0;
        gap: 20px;
    }
    .sidebar {
        width: 250px;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .main-content {
        flex-grow: 1;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
        color: #333;
        margin-bottom: 20px;
        font-size: 18px;
    }
    .function-list {
        list-style-type: none;
        padding: 0;
    }
    .function-list li {
        margin-bottom: 10px;
    }
    .function-list a {
        text-decoration: none;
        color: #333;
        display: block;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: background-color 0.3s;
    }
    .function-list a:hover, .function-list a.active {
        background-color: #f0f0f0;
    }
    h1 {
        color: #333;
        margin-bottom: 20px;
    }
    .filters {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .radio-group {
        display: flex;
        gap: 20px;
    }
    .radio-group label {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .date-picker {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .date-picker input {
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .no-data {
        text-align: center;
        padding: 40px;
        background-color: #f9f9f9;
        border-radius: 8px;
    }
    .no-data p:first-child {
        font-weight: bold;
        margin-bottom: 10px;
    }
    .no-data p:last-child {
        color: #666;
    }
    .patient-list {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .patient-list th, .patient-list td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    .patient-list th {
        background-color: #f2f2f2;
    }
    .patient-list tr:hover {
        background-color: #f1f1f1;
    }
    .patient-list .highlight {
        color: blue;
        text-decoration: underline;
    }
    .patient-list .selected {
        background-color: #cce5ff;
    }
    .btn-submit {
        display: inline-block;
        padding: 10px 20px;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
    }
    .btn-submit:hover {
        background-color: #0056b3;
    }
    </style>
</head>
<body>
    <?php require_once "./mvc/views/blocks/header.php" ?>

    <div class="layout">
        <div class="sidebar">
            <h2>DANH SÁCH CHỨC NĂNG</h2>
            <ul class="function-list">
                <li><a href="/ptud_dd/Bacsi/DangKyLichLamViec">Đăng ký lịch làm việc</a></li>
                <li><a href="/ptud_dd/Bacsi/XemLichLamViec">Xem lịch làm việc</a></li>
                <li><a href="/ptud_dd/Bacsi/XemDanhSachKham" class="active">Xem danh sách khám</a></li>
                <li><a href="/ptud_dd/Bacsi/XemThongTinBenhNhan">Xem thông tin bệnh nhân</a></li>
                <li><a href="/ptud_dd/Bacsi/XemLichSuKhamBenh">Xem lịch sử khám bệnh</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h1>Danh sách khám bệnh</h1>
            <div id="appointment-list-container">
                <?php require_once "./mvc/views/pages/".$data["Page"].".php" ?>
            </div>
        </div>
    </div>

    <?php require_once "./mvc/views/blocks/footer.php" ?>

    <script>
        function selectRow(row) {
            var rows = document.querySelectorAll('.patient-list tr');
            rows.forEach(function(r) {
                r.classList.remove('selected');
            });
            row.classList.add('selected');
        }

        function submitForm() {
            var selectedRow = document.querySelector('.patient-list tr.selected');
            if (selectedRow) {
                var maLK = selectedRow.getAttribute('data-malk');
                window.location.href = '/ptud_dd/Bacsi/Lapphieu?maLK=' + maLK;
            } else {
                alert('Vui lòng chọn một bệnh nhân trước khi lập phiếu khám.');
            }
        }

        function filterAppointments() {
            var shift = document.querySelector('input[name="shift"]:checked').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/ptud_dd/Bacsi/GetDanhSach', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('appointment-list-container').innerHTML = xhr.responseText;
                }
            };
            xhr.send('shift=' + shift);
        }
    </script>
</body>
</html>