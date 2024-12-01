<?php
$dt = json_decode($data["LLV"], true);
$K = json_decode($data["Khoa"], true);
$BS = json_decode($data["BS"], true);
if(isset($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['message_type'] == 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
        <?php 
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;
date_default_timezone_set('Asia/Ho_Chi_Minh');
$homnay = date('Y-m-d');
$week = date('w');
$ngaydautuan = date('Y-m-d', strtotime("-" . (0 + $week) . " days"));
$ngaycuoituan = date('Y-m-d', strtotime("+" . (6 - $week) . " days"));
$selectedKhoa = isset($_POST['khoaSelect']) ? $_POST['khoaSelect'] : '';

// Kiểm tra thay đổi tuần
if (isset($_POST['changeWeek'])) {
    if ($_POST['changeWeek'] === 'prev') {
        $ngaydautuan = date('Y-m-d', strtotime($ngaydautuan . " -7 days"));
    } elseif ($_POST['changeWeek'] === 'next') {
        $ngaydautuan = date('Y-m-d', strtotime($ngaydautuan . " +7 days"));
    }elseif ($_POST['changeWeek'] === 'current') {
        $week = date('w');
        $ngaydautuan = date('Y-m-d', strtotime("-" . (0 + $week) . " days"));
    }
}
if (isset($_POST['currentWeekStart'])) {
    $ngaydautuan = $_POST['currentWeekStart'];
} else {
    $week = date('w');
    $ngaydautuan = date('Y-m-d', strtotime("-" . (0 + $week) . " days"));
}
$t2 = date('d-m', strtotime($ngaydautuan . " +1 day")); 
$t3 = date('d-m', strtotime($ngaydautuan . " +2 days")); 
$t4 = date('d-m', strtotime($ngaydautuan . " +3 days")); 
$t5 = date('d-m', strtotime($ngaydautuan . " +4 days")); 
$t6 = date('d-m', strtotime($ngaydautuan . " +5 days")); 
$t7 = date('d-m', strtotime($ngaydautuan . " +6 days")); 
$t8 = date('d-m', strtotime($ngaydautuan . " +7 days")); 
$daysOfWeek = [];
for ($i = 1; $i < 7; $i++) {
    $daysOfWeek[] = date('Y-m-d', strtotime($ngaydautuan . " +{$i} days"));
}
echo '
        <form method="POST" action="./LLV">
        <div class="mb-4 d-flex align-items-center gap-3">
            <select class="form-select" style="width: auto" id="khoaSelect" name="khoaSelect" onchange="this.form.submit()">
            <option value="">Danh sách khoa</option>';    
            foreach ($K as $k) {
                $selected = (isset($_POST['khoaSelect']) && $_POST['khoaSelect'] == $k["MaKhoa"]) ? 'selected' : '';
                echo '<option value="' . $k["MaKhoa"] . '" ' . $selected . '>' . $k["TenKhoa"] . '</option>';
            }
echo'       </select>
        </div>
        </form>


    <form method="POST" action="">
    <input type="hidden" name="currentWeekStart" value="'.$ngaydautuan.'">
    <input type="hidden" name="khoaSelect" value="' . $selectedKhoa . '">
    <div class="mb-4 d-flex gap-3 align-items-center">
        <button class="btn btn-outline-secondary" type="submit" name="changeWeek" value="prev">Tuần trước</button>
        <span class="fw-bold" id="currentWeek">
        <button class="btn btn-outline-primary" type="submit" name="changeWeek" value="current">Hiện tại</button>
        </span>
        <button class="btn btn-outline-secondary" type="submit" name="changeWeek" value="next">Tuần sau</button> 
    </div>
    </form>
    <button class="btn btn-outline-secondary" type="submit" name="them" data-bs-toggle="modal" data-bs-target="#addDoctorModal">Thêm lịch</button>
        <div class="schedule-grid mb-4" id="schedule-container">
            <table class="schedule-table table table-bordered">
                <thead>
                    <tr class="bg-light">
                        <th>Ca</th>
                        <th>Thứ 2|' . $t2 . '</th>
                        <th>Thứ 3|' . $t3 . '</th>
                        <th>Thứ 4|' . $t4 . '</th>
                        <th>Thứ 5|' . $t5 . '</th>
                        <th>Thứ 6|' . $t6 . '</th>
                        <th>Thứ 7|' . $t7 . '</th>
                        <th>Chủ nhật|' . $t8 . '</th>
                    </tr>
                </thead>
                <tbody>';
                echo '<tr>';
                echo '<td>Ca Sáng</td>';

                foreach ($daysOfWeek as $day) {
                    echo '<td class="shift-cell">';
                    foreach ($dt as $data) {
                        if ($data['NgayLamViec'] === $day && $data['CaLamViec'] === 'Sáng' && $data['TrangThai'] === 'Đang làm') {
                        echo $data['HovaTenNV'] . ' 
                        <form method="POST" action="" style="display: inline;">
                        <input type="hidden" name="MaNV" value="' . $data['MaNV'] . '">
                        <button type="submit" class="delete-btn" onclick="return confirm(\'Bạn có chắc chắn muốn xóa bác sĩ này không?\')">
                        <i class="bi bi-person-dash"></i>
                        </button>
                        </form><br>';
                        }
                    }
                    echo '</td>';
                }
                echo '</tr>';
                echo '<tr>';
                echo '<td>Ca Chiều</td>';
                foreach ($daysOfWeek as $day) {
                    echo '<td class="shift-cell afternoon">';
                    $hasWork = false;
                    foreach ($dt as $data) {
                        if ($data['NgayLamViec'] === $day && $data['CaLamViec'] === 'Chiều' && $data['TrangThai'] === 'Đang làm') {
                            echo $data['HovaTenNV'] . ' 
                            <form method="POST" action="./LLV" style="display: inline;">
                            <input type="hidden" name="MaNV" value="' . $data['MaNV'] . '">
                            <button type="submit" class="delete-btn" onclick="return confirm(\'Bạn có chắc chắn muốn xóa bác sĩ này không?\')">
                            <i class="bi bi-person-dash"></i>
                            </button>
                            </form><br>';
                        }
                    }
                    echo '</td>';
                }
                
                echo '</tr>';

        echo '  </tbody>
            </table>
        </div>';


        // modal thêm lịch làm việc
        echo '
        <div class="modal fade" id="addDoctorModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm bác sĩ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Input tìm kiếm bác sĩ -->
                        <input
                            type="text"
                            class="form-control mb-3"
                            id="doctorSearch"
                            placeholder="Tìm kiếm bác sĩ..."
                        >
                        <table class="table mb-3">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>Tên</th>
                                    <th>Khoa</th>
                                </tr>
                            </thead>
                            <form action="" method="POST">
                            <tbody id="doctorTableBody">
                                <tr>';
                                foreach($BS as $data):
                    echo'           <td><input type="checkbox" class="doctor-checkbox" value="'.$data["MaNV"].'" name="MaNVien"></td>
                                    <td>' . $data["HovaTenNV"] . '</td>
                                    <td>' . $data["TenKhoa"] . '</td>
                                </tr>';
                                endforeach;
                    echo'        </tbody>
                        </table>
                        <!-- Chọn lịch -->
                        <div class="mb-3">
                            <label for="scheduleDate" class="form-label">Chọn lịch</label>
                            <input
                            type="date"
                            class="form-control"
                            id="NgayLamViec"
                            name="NgayLamViec"
                            required
                        >
                        </div>
        
                        <!-- Chọn ca -->
                        <div class="mb-3">
                            <label for="scheduleShift" class="form-label">Chọn ca</label>
                            <select class="form-select" id="scheduleShift" name="cl">';
                    echo'       <option value="">-- Chọn ca --</option>
                                <option value="Sáng" >Ca sáng</option>
                                <option value="Chiều"Cl>Ca chiều</option>
                            </select>';
                    echo' </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
<button type="submit" class="btn btn-primary" name="btnDKL">Xác nhận</button>                    </div>
                    </form>
                </div>
            </div>
        </div>';
        
?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll("button[name='changeWeek']");
    buttons.forEach(button => {
        button.addEventListener("click", function(e) {
            e.preventDefault();

            // Get the week change value
            const weekChange = button.value;

            // Get the current week start date
            let currentWeekStart = document.querySelector("input[name='currentWeekStart']").value;
            currentWeekStart = new Date(currentWeekStart);

            // Calculate the new week start date based on the button clicked
            if (weekChange === 'prev') {
                currentWeekStart.setDate(currentWeekStart.getDate() - 7);
            } else if (weekChange === 'next') {
                currentWeekStart.setDate(currentWeekStart.getDate() + 7);
            } else if (weekChange === 'current') {
                // Set to the current week's Sunday
                const today = new Date();
                currentWeekStart = new Date(today.setDate(today.getDate() - today.getDay()));
            }

            // Ensure the week always starts on Sunday
            currentWeekStart.setDate(currentWeekStart.getDate() - currentWeekStart.getDay());

            // Update the hidden input value for the server
            document.querySelector("input[name='currentWeekStart']").value = currentWeekStart.toISOString().split('T')[0];

            // Get the selected department code
            const khoaSelect = document.querySelector("select[name='khoaSelect']") ? document.querySelector("select[name='khoaSelect']").value : "";

            // Send request to update the work schedule
            updateSchedule({ changeWeek: weekChange, currentWeekStart: currentWeekStart.toISOString().split('T')[0], khoaSelect: khoaSelect });
        });
    });

    function updateSchedule(data) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", window.location.href, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const parser = new DOMParser();
                const responseDoc = parser.parseFromString(xhr.responseText, "text/html");
                const newSchedule = responseDoc.querySelector("#schedule-container");
                const container = document.querySelector("#schedule-container");
                if (newSchedule && container) {
                    container.innerHTML = newSchedule.innerHTML;
                }
            }
        };

        // Create parameter string for the request
        const params = Object.keys(data).map(key => `${key}=${encodeURIComponent(data[key])}`).join("&");
        xhr.send(params);
    }
});
</script>
