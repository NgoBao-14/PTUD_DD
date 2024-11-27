<?php
$dt = json_decode($data["CTPK"], true);
foreach ($dt as $data):
echo'<div class="container my-5" id="container">
        <div class="card" id="card">
                                <form action="/PTUD_DD/QuanLy/TTBN" method="POST">
                                <input type="hidden" name="back" value="' . $data['MaBN'] . '">
                                <input type="submit" name="nutBack" value="Back">
                                
                        </form>
            <div class="card-header text-center py-3" id="card-header">
                <h4 class="mb-0">PHIẾU KHÁM BỆNH</h4>
            </div>
            <div class="card-body" id="card-body">
                <div class="row mb-4" id="row">
                    <div class="col-md-6" id="col-left">
                        <h5 class="section-title" id="patient-info-title">Thông tin bệnh nhân</h5>
                        <div class="info-row row" id="info-row">
                            <div class="col-sm-4 info-label">Họ và Tên:</div>
                            <div class="col-sm-8">' . ($data['HovaTen']) . '</div>
                        </div>
                        <div class="info-row row" id="info-row">
                            <div class="col-sm-4 info-label">Ngày sinh:</div>
                            <div class="col-sm-8">' . ($data['NgaySinh']) . '</div>
                        </div>
                        <div class="info-row row" id="info-row">
                            <div class="col-sm-4 info-label">Giới tính:</div>
                            <div class="col-sm-8">' . ($data['GioiTinh']) . '</div>
                        </div>
                        <div class="info-row row" id="info-row">
                            <div class="col-sm-4 info-label">Địa chỉ:</div>
                            <div class="col-sm-8">' . ($data['DiaChi']) . '</div>
                        </div>
                        <div class="info-row row" id="info-row">
                            <div class="col-sm-4 info-label">Số điện thoại:</div>
                            <div class="col-sm-8">' . ($data['SoDT']) . '</div>
                        </div>
                    </div>
                    <div class="col-md-6" id="col-right">
                        <h5 class="section-title" id="exam-info-title">Thông tin khám bệnh</h5>
                        <div class="info-row row" id="info-row">
                            <div class="col-sm-4 info-label">Mã phiếu khám:</div>
                            <div class="col-sm-8">' . ($data['MaPK']) . '</div>
                        </div>
                        <div class="info-row row" id="info-row">
                            <div class="col-sm-4 info-label">ID bệnh nhân:</div>
                            <div class="col-sm-8">' . ($data['MaBN']) . '</div>
                        </div>
                        <div class="info-row row" id="info-row">
                            <div class="col-sm-4 info-label">BHYT:</div>
                            <div class="col-sm-8">' . ($data['BHYT']) . '</div>
                        </div>
                        <div class="info-row row" id="info-row">
                            <div class="col-sm-4 info-label">Ngày khám:</div>
                            <div class="col-sm-8">' . ($data['NgayTaoPhieuKham']) . '</div>
                        </div>
                        <div class="info-row row" id="info-row">
                            <div class="col-sm-4 info-label">Bác sĩ:</div>
                            <div class="col-sm-8">' . ($data['BacSiPhuTrach']) . '</div>
                        </div>
                    </div>
                </div>

                <h5 class="section-title" id="exam-results-title">Kết quả khám</h5>
                <div class="info-row row" id="info-row">
                    <div class="col-sm-3 info-label">Triệu chứng:</div>
                    <div class="col-sm-9">' . ($data['KetQua']) . '</div>
                </div>
                <div class="info-row row" id="info-row">
                    <div class="col-sm-3 info-label">Chỉ số cơ thể:</div>
                    <div class="col-sm-9">Nhiệt độ: 37,7°C ; Nhịp tim: 72 ; Huyết áp: 130mmHg</div>
                </div>
                <div class="info-row row" id="info-row">
                    <div class="col-sm-3 info-label">Kết quả cận lâm sàng:</div>
                    <div class="col-sm-9">' . ($data['KetQua']) . '</div>
                </div>
                <div class="info-row row" id="info-row">
                    <div class="col-sm-3 info-label">Chuẩn đoán:</div>
                    <div class="col-sm-9">' . ($data['KetQua']) . '</div>
                </div>

                <h5 class="section-title mt-4" id="prescription-title">Đơn thuốc và Lời dặn</h5>
                <div class="info-row row" id="info-row">
                    <div class="col-sm-3 info-label">Đơn thuốc:</div>
                    <div class="col-sm-9">' . ($data['DonThuoc']) . '</div>
                </div>
                <div class="info-row row" id="info-row">
                    <div class="col-sm-3 info-label">Lời dặn:</div>
                    <div class="col-sm-9">' . ($data['LoiDan']) . '</div>
                </div>
            </div>
        </div>
    </div>';
endforeach;
?>