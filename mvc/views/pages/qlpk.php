<?php
$dt = json_decode($data["QuanLy"], true);
$benhnhan = $dt["BNhan"];
$phieukham = $dt["PhieuKham"];
$found = $dt["Found"];
echo'<div class="row mb-3">
                <div class="col mt-2">
                <form class="d-flex" method="post">
                    <input class="form-control me-2" type="search" name="txtsearch" placeholder="Nhập ID bệnh nhân" aria-label="Search">
                    <button class="btn btn-custom-search" type="submit" name="btnsearch">Tìm kiếm</button>
                </form>
                </div>
            </div>';
// Kiểm tra xem có tìm thấy bệnh nhân không
// if (isset($_POST['btnsearch'])) {
    if ($found) {
        echo '
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin bệnh nhân</h5>';
        if (!empty($benhnhan)) {
            $bn = $benhnhan[0];
            echo '
                        <p><strong>ID:</strong> ' . $bn["MaBN"] . '</p>
                        <p><strong>Họ và Tên:</strong> ' . $bn["HovaTen"] . '</p>
                        <p><strong>Ngày sinh:</strong> ' . $bn["NgaySinh"] . '</p>
                        <p><strong>Giới tính:</strong> ' . $bn["GioiTinh"] . '</p>
                        <p><strong>BHYT:</strong> ' . $bn["BHYT"] . '</p>
                        <p><strong>Địa chỉ:</strong> ' . $bn["DiaChi"] . '</p>
                        <p><strong>Số điện thoại:</strong> ' . $bn["SoDT"] . '</p>';
        }
        echo '
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Danh sách phiếu khám</h5>';
        
        if (!empty($phieukham)) {
            echo '
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ngày khám</th>
                                    <th>Bác sĩ</th>
                                    <th>Chuẩn đoán</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>';
            
            $stt = 0;
            foreach ($phieukham as $r) {
                $stt++;
                echo '  
                <tr>
                    <td>' . $stt . '</td>
                    <td>' . $r["NgayTaoPhieuKham"] . '</td>
                    <td>' . $r["BacSiPhuTrach"] . '</td>
                    <td>' . $r["KetQua"] . '</td>
                    <td>
                        <form action="./CTPK" method="POST">
                            <input type="hidden" name="ctpk" value="' . $r["MaPK"] . '">
                            <button class="btn btn-sm btn-primary" type="submit" name="btnCTPK">Xem chi tiết</button>
                        </form>
                    </td>
                </tr>';
            }
            echo '
                            </tbody>
                        </table>';
        } else {
            echo '<p>Không có phiếu khám nào cho bệnh nhân này.</p>';
        }
        echo '
                    </div>
                </div>
            </div>
        </div>';
    } 
    else if(isset($_POST['btnsearch']))
    {
        echo '<div class="alert alert-info">Id không có thực</div>';
    }
    else {
        echo '<div class="alert alert-info">Vui lòng nhập id bệnh nhân</div>';
    }
// } else {
//     
// }
?>

