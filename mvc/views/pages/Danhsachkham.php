<div class="filters">
    <div class="radio-group">
        <label>
            <input type="radio" name="shift" value="morning" <?php echo isset($_POST['shift']) && $_POST['shift'] == 'morning' ? 'checked' : ''; ?> onchange="filterAppointments()">
            Sáng
        </label>
        <label>
            <input type="radio" name="shift" value="afternoon" <?php echo isset($_POST['shift']) && $_POST['shift'] == 'afternoon' ? 'checked' : ''; ?> onchange="filterAppointments()">
            Chiều
        </label>
        <label>
            <input type="radio" name="shift" value="all" <?php echo !isset($_POST['shift']) || $_POST['shift'] == 'all' ? 'checked' : ''; ?> onchange="filterAppointments()">
            Tất cả
        </label>
    </div>
    <div class="date-picker">
        <span>Ngày hiện tại: </span>
        <input type="date" value="<?php echo date('Y-m-d'); ?>" readonly>
    </div>
</div>

<table class="patient-list">
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên Bệnh nhân</th>
            <th>Ngày sinh</th>
            <th>Số điện thoại</th>
            <th>Giờ khám</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $danhSach = json_decode($data["DanhSachKham"], true);
        if (!empty($danhSach)) {
            foreach ($danhSach as $index => $benhnhan) {
                echo "<tr onclick='selectRow(this)' data-malk='{$benhnhan['MaLK']}'>";
                echo "<td>" . ($index + 1) . "</td>";
                echo "<td>{$benhnhan['HovaTen']}</td>";
                echo "<td>{$benhnhan['NgaySinh']}</td>";
                echo "<td>{$benhnhan['SoDT']}</td>";
                echo "<td>{$benhnhan['GioKham']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Không có dữ liệu</td></tr>";
        }
        ?>
    </tbody>
</table>

<button onclick="submitForm()" class="btn-submit">Lập phiếu khám</button>