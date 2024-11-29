<?php
if(isset($data["result"])){
    if($data["result"] == true){
        echo '<script>alert("Đăng ký thành công")</script>';
    } else{
        echo '<script>alert("Đăng ký thất bại")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/main.css">
    <style>
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin: 50px auto;
            max-width: 1200px;
        }
        .login-image {
            width: 80%;
            background-image: url('./public/img/bannerlogin.jpg');
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            min-height: 400px;
        }
        .login-form-container {
            margin-left: 150px;
            width: 40%;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include "blocks/header.php" ?>
    <div class="container login-container">
        <div class="login-image">
            <a href="img/bannerlogin.jpg"></a>
        </div>

        <div class="login-form-container">
            <ul class="nav nav-tabs" id="login-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link " id="login-tab" href="Login" >Đăng nhập</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="register-tab" href="Register" >Đăng ký</a>
                </li>
            </ul>
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="login" role="tabpanel">
                    <form action="./Register/BNDK" method="POST">
                        <div class="mb-3">
                            <label for="txtuser" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" name="txtuser" id="txtuser" placeholder="Nhập username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu">
                            <input type="hidden" name="hiddenphanquyen" id="hiddenphanquyen" value="Bệnh Nhân">
                        </div>
                        <div class="mb-3">
                            <label for="password2" class="form-label">Nhập lại mật khẩu</label>
                            <input type="password" class="form-control" name="password2" id="password2" placeholder="Nhập lại mật khẩu" required>
                        </div>
                        <button type="submit" name="btn-dk" id="btn-dk" class="btn btn-primary w-100">Đăng ký</button>
                    </form>
                    <p class="mt-3 text-center">Đã có tài khoản? <a href="Login">Đăng nhập ngay</a></p>
                </div>
            </div>
        </div>
    </div>
    <?php include "blocks/footer.php" ?>
</body>
</html>