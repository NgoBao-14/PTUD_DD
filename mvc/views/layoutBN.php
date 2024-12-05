<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./public/css/main.css">
    <link rel="stylesheet" href="../public/css/main.css">
    <link rel="stylesheet" href="./public/css/khachhang.css">
    <link rel="stylesheet" href="../public/css/khachhang.css">
    <style>
        body {
            background-color: #e9ecef;
        }

        .container {
            margin-bottom: 50px;
        }

        
        .sidebar a:hover {
            color: #0d6efd;
            font-weight: bold;
        }
        li{
            list-style-type: none;
        }
        .main-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 20px;
        }


        .profile-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-header .avatar {
            font-size: 3rem;
            color: #6c757d;
            margin-right: 15px;
        }
        .profile-header h5 {
            margin: 0;
        }

        .info-section {
            
        }

        .profile-section {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            border-left: 4px solid #0d6efd;
        }
        .profile-section p {
            margin: 0;
            font-weight: bold;
        }
        .profile-section div {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        .edit-button {
            text-align: right;
            margin-top: 20px;
        }
        .btn a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php require "./mvc/views/blocks/header.php";?>
    <div class="container mt-5">
        <div class="row">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 sidebar">
                        <ul>
                            <li><a href="/PTUD_DD/LichKham">Lịch khám</a></li>
                            <li ><a href="/PTUD_DD/ThanhToan">Thanh toán</a></li>
                            <li><a href="/PTUD_DD/BN/TTBN">Hồ sơ cá nhân</a></li>
                            <li ><a href="/PTUD_DD/XemPhieuKham">Hồ sơ phiếu khám</a></li>
                            <li><a href="">Tài khoản</a></li>
                            <li><a href="Home.php">Đăng xuất</a></li>
                        </ul>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                        <?php
                            if(isset($data["Page"])){
                                require_once "./mvc/views/pages/".$data["Page"].".php";
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require "./mvc/views/blocks/footer.php";?>
</body>
</html>