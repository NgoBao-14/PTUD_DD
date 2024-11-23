<?php
echo '<h1>Danh Sách Hóa Đơn</h1>
<table>
    <thead>
        <tr>
            <th style="text-align: center;">STT</th>
            <th style="text-align: center;">Mã hóa đơn</th>
            <th style="text-align: center;">Tên Bệnh Nhân</th>
            <th style="text-align: center;">Ngày tạo</th>
            <th style="text-align: center;">Thành tiền</th>
            <th style="text-align: center;">Trạng thái</th>
            <th style="text-align: center;">Dịch vụ</th>
            <th style="text-align: center;">Thanh toán</th>
            <th style="text_align: center"></th>
        </tr>
    </thead>
    <tbody>';
$dem = 1;
while($r = mysqli_fetch_array($data["HD"])){  
    echo '<tr>
                <td data-label="STT">'.$dem.'</td>
                <td data-label="Order ID">'.$r["MaHD"].'</td>
                <td data-label="Customer" style="text-align: left;">'.$r["HovaTen"].'</td>
                <td data-label="Date">'.$r["NgayLapHoaDon"].'</td>
                <td data-label="Total">'.$r["TongTien"].'</td>
                <td data-label="Status"><span
                        class="status status-'.$r["TrangThai"].'">'.$r["TrangThai"].'</span>
                <td data-label="DV" style="text-align: left;">'.$r["DichVu"].'</td>
                <td data-label="MT" style="text-align: left;">'.$r["TenPTTT"].'
                    
                </td>
                <td><a href="index.php?chitiethoadon='.$r["MaHD"].'">Xem</a></td>
                </td>
            </tr>';
            $dem++;
}
echo '</tbody>
                                </table>';
?>