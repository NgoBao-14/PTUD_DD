<?php
 while($r = mysqli_fetch_array($data["CTHD"]))
 {
     echo '<form action="" method="post">
     <h1>Hóa đơn #'.$r["MaHD"].'</h1>
     <span class="status status-'.$r["TrangThai"].'">'.$r["TrangThai"].'</span>
     
     <div class="customer-info">
         <h2>Thông tin bệnh nhân</h2>
         <div class="info-grid">
             <div class="info-item"><div class="info-label">Họ và tên:</div><div>'.$r["HovaTen"].'</div></div>
             <div class="info-item"><div class="info-label">Email:</div><div>'.$r["Email"].'</div></div>
             <div class="info-item"><div class="info-label">Điện thoại:</div><div>'.$r["SoDT"].'</div></div>
             <div class="info-item"><div class="info-label">BHYT:</div><div>'.$r["BHYT"].'</div></div>
             <div class="info-item"><div class="info-label">Dịch vụ:</div><div>'.$r["DichVu"].'</div></div>
             <div class="info-item"><div class="info-label">Thời gian:</div><div>'.$r["NgayLapHoaDon"].'</div></div>
         </div>
     </div>';
 }





 echo '</table>
        <div id="momoAction" class="action-section"><div class="qr-code"></div></div>
        <div id="bankAction" class="action-section"><div class="qr-code"></div></div>
        <div id="visaAction" class="action-section">
            <table id="card-payment-details" class="action-button">
                <tr><td><label for="card-name">Tên trên thẻ</label></td><td><input type="text" id="card-name" name="card-name"></td></tr>
                <tr><td><label for="card-number">Số thẻ</label></td><td><input type="text" id="card-number" name="card-number"></td></tr>
                <tr><td><label for="expiry-date">Ngày hết hạn</label></td><td><input type="text" id="expiry-date" name="expiry-date" placeholder="MM/YY"></td></tr>
                <tr><td><label for="cvv">CVV</label></td><td><input type="number" id="cvv" name="cvv"></td></tr>
            </table>
        </div>
        <div id="cashAction" class="action-section"><a href="#" class="action-button">Xác nhận thanh toán tiền mặt</a></div>

        <!-- Nút xác nhận và hủy -->
        <input type="submit" class="nut1" name="nut" id="nut" value="Hủy hóa đơn">
        <input type="submit" class="nut2" name="nut" id="nut" value="Xác nhận hóa đơn">
    ';
?>