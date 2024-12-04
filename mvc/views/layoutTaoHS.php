<?php
    if(isset($_SESSION["role"])){
        header("refresh: 0; url='/PTUD_DD'");
    }
?>

<?php
$genders = ['Nam', 'Nữ'];
if(isset($data["result"])){
    if($data["result"] == true){
        echo '<script>alert("Tạo hồ sơ thành công. Bạn có thể đăng nhập")</script>';
        header("refresh:0; url='/PTUD_DD/Login'");
    } else{
        echo '<script>alert("Tạo hồ sơ thất bại")</script>';
        header("refresh:0; url='/PTUD_DD/Register/BNHS'");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../public/css/main.css">
    <style>
        .model{
            margin: auto;
            width: 800px;
        }
        .container {
        max-width: 600px;
        margin: 50px auto;
        background-color: #fff;
        padding: 30px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        font-family: Arial, sans-serif;
        }
        
        /* Tiêu đề form */
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        
        /* Căn chỉnh nhãn */
        .container label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }
        .radio-group {
            display: flex;
            margin-top: 10px;
        }
        .gr-rdo {
            margin-right: 20px;
        }
        .rdo{
            margin-left: 5px;
        }
                
        /* Styling cho các input */
        .container input[type="text"],
        .container input[type="email"],
        .container input[type="date"],
        .container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        /* Đổi màu border khi input được focus */
        .container input[type="text"]:focus,
        .container input[type="email"]:focus,
        .container input[type="date"]:focus,
        .container select:focus {
            border-color: #007bff;
            outline: none;
        }
        
        /* Nút xác nhận */
        .container button {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .container button:hover {
            background-color: #0056b3;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
        
            .container h2 {
                font-size: 20px;
            }
        
            .container button {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
<?php include "blocks/header.php" ?>
<div class="model">
        <div class="container">
        <h2>Thông tin Hồ sơ </h2>
        <form action="/PTUD_DD/Register/XNHS" method="POST">
            <input type="hidden" name="last_id" value="<?php echo $_SESSION['last_id']; ?>">
            <div class="mb-3">
                <label for="name">Họ và tên:</label>
                <input type="text" class="form-control" name="ten" required>
            </div>
            <div class="mb-3">
                <label for="name">Số điện thoại:</label>
                <input type="tel" class="form-control" name="sdt" 
                value="<?php 
                $sdt = json_decode($data["SDT"],true);
                foreach($sdt as $r):
                    echo $r["username"];
                endforeach;
                ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label for="dob">Ngày sinh:</label>
                <input type="date" class="form-control" name="ns" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Giới tính *</label>
                <div class="radio-group">
                    <?php
                        
                        foreach ($genders as $gender) {
                            echo '<div class="gr-rdo">';
                            echo '<input type="radio" class="ipgt" name="gt" id="gender_' . $gender . '" value="' . $gender . '"  required>';
                            echo '<label class="rdo" for="gender_' . $gender . '">' . $gender . '</label>';
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="diachi">Địa chỉ:</label>
                <input type="text" class="form-control" name="diachi">
            </div>
            <div class="mb-3">
                <label for="bh">Bảo hiểm y tế:</label>
                <input type="text" class="form-control" name="bhyt">
                <input type="hidden" name="maphieukham" value="0">
            </div>
            <button type="submit" class="btn btn-primary w-100" name="btn-xn" id="btn-xn">Xác nhận</button>
        </form>
        </div>
</div>
</body>
</html>