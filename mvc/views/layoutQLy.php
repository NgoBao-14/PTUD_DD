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
    <title>Lịch làm việc - Đom Đóm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./public/css/main.css">
    <link rel="stylesheet" href="./public/css/QLPK.css">
    <link rel="stylesheet" href="../public/css/main.css">
    <link rel="stylesheet" href="../public/css/QLPK.css">
    <style>
        
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
    margin-bottom: 1rem;
}
.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}
.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0b5ed7;
}
.btn-custom-search {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: #ffffff;
    font-weight: bold;
    border-radius: 5px;
    transition: background-color 0.3s, border-color 0.3s;
    font-size: 0.7rem;
    width: 7%;
}

.btn-custom-search:hover {
    background-color: #0b5ed7;
    border-color: #0b5ed7;
    color: #ffffff;
}
body {
    background-color: #f0f2f5;
}

#card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: none;
}

#card-header {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

.section-title {
    background-color: #e9ecef;
    padding: 10px;
    margin-bottom: 15px;
    font-weight: bold;
    border-left: 5px solid #007bff;
}

#row {
    margin-bottom: 1rem;
}

#col-left, #col-right {
    padding: 10px;
}

#info-row {
    border-bottom: 1px solid #dee2e6;
    padding: 8px 0;
}

.info-label {
    font-weight: 600;
    color: #495057;
}

#signature-row {
    margin-top: 30px;
}

#patient-sign, #doctor-sign {
    padding: 20px;
    text-align: center;
}

@media print {
    body {
        background-color: white;
    }

    #card {
        box-shadow: none;
    }
}

    </style>
</head>
<body>
<?php include "blocks/header.php" ?>
<div class="main">
        <div class="container mt-4">
            <!-- <div class="row mb-3">
                <div class="col mt-2">
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" name="txtsearch" placeholder="Nhập ID bệnh nhân" aria-label="Search">
                    <button class="btn btn-custom-search" type="submit" name="btnsearch">Tìm kiếm</button>
                </form>
                </div>
            </div> -->
            <?php require_once "./mvc/views/pages/".$data["Page"].".php" ?>
            </div>
    </div>
    <?php require_once "./mvc/views/blocks/footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>