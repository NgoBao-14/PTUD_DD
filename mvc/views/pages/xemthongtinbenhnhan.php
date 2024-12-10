<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .search-bar {
            margin-bottom: 20px;
            position: relative;
        }

        .search-bar input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .search-bar button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div id="container">
        <h2 class="mb-4">Xem thông tin bệnh nhân</h2>
        <form method="POST" class="search-bar">
            <input type="text" name="maBN" placeholder="Vui lòng nhập mã bệnh nhân hoặc mã BHYT" required>
            <button type="submit" name="search">Tìm kiếm</button>
        </form>
    </div>
    <div id="container">
        <?php
        if (isset($data["ThongTinBenhNhan"])) {
            $thongTinBenhNhan = json_decode($data["ThongTinBenhNhan"], true);
            $phieuKhamBenhNhan = json_decode($data["PhieuKhamBenhNhan"], true);
            $soLanKhamBenh = $data["SoLanKhamBenh"];

            if ($thongTinBenhNhan) {
        ?>
                <div class="patient-info">
                    <h3>Bệnh nhân</h3>
                    <div class="info-grid">
                        <div class="info-item"><span class="info-label">Mã bệnh nhân:</span> <?php echo $thongTinBenhNhan['MaBN']; ?></div>
                        <div class="info-item"><span class="info-label">BHYT:</span> <?php echo $thongTinBenhNhan['BHYT']; ?></div>
                        <div class="info-item"><span class="info-label">Họ và Tên:</span> <?php echo $thongTinBenhNhan['HovaTen']; ?></div>
                        <div class="info-item"><span class="info-label">Địa chỉ:</span> <?php echo $thongTinBenhNhan['DiaChi']; ?></div>
                        <div class="info-item"><span class="info-label">Ngày sinh:</span> <?php echo date('d-m-Y', strtotime($thongTinBenhNhan['NgaySinh'])); ?></div>
                        <div class="info-item"><span class="info-label">Số điện thoại:</span> <?php echo $thongTinBenhNhan['SoDT']; ?></div>
                        <div class="info-item"><span class="info-label">Giới tính:</span> <?php echo $thongTinBenhNhan['GioiTinh']; ?></div>
                    </div>
                </div>

                <div class="medical-history">
                    <h3>Các lần khám bệnh</h3>
                    <p><span class="info-label">Số lần khám bệnh:</span> <?php echo $soLanKhamBenh; ?></p>
                    <?php
                    if ($phieuKhamBenhNhan) {
                        foreach ($phieuKhamBenhNhan as $index => $phieu) {
                    ?>
                            <div class="visit-details">
                                <h4>Kết quả khám bệnh lần <?php echo $index + 1; ?>:</h4>
                                <div class="info-grid">
                                    <div class="info-item"><span class="info-label">Ngày khám:</span> <?php echo date('d/m/Y', strtotime($phieu['NgayTao'])); ?></div>
                                    <div class="info-item"><span class="info-label">Bác sĩ:</span> <?php echo $phieu['BacSi']; ?></div>
                                    <div class="info-item"><span class="info-label">Triệu chứng:</span> <?php echo $phieu['TrieuChung']; ?></div>
                                    <div class="info-item"><span class="info-label">Kết quả:</span> <?php echo $phieu['KetQua']; ?></div>
                                    <div class="info-item"><span class="info-label">Chuẩn đoán ban đầu:</span> <?php echo $phieu['ChuanDoan']; ?></div>
                                    <div class="info-item"><span class="info-label">Lời dặn:</span> <?php echo $phieu['LoiDan']; ?></div>
                                    <div class="info-item"><span class="info-label">Ngày tái khám:</span> <?php echo $phieu['NgayTaiKham'] ? date('d/m/Y', strtotime($phieu['NgayTaiKham'])) : 'Không'; ?></div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p>Bệnh nhân chưa có lần khám bệnh nào.</p>";
                    }
                    ?>
                </div>
        <?php
            } else {
                echo "<p>Không tìm thấy bệnh nhân với thông tin đã nhập.</p>";
            }
        } else {
            echo "<p>Vui lòng nhập thông tin tìm kiếm để xem lịch sử khám bệnh.</p>";
        }
        ?>


    </div>
</body>

</html>