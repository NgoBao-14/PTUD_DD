<?php
$dt = json_decode($data["LLV"], true);
$K = json_decode($data["Khoa"], true);
date_default_timezone_set('Asia/Ho_Chi_Minh');
$homnay = date('Y-m-d');
$week = date('w'); // Lấy thứ hiện tại (0 = Chủ nhật)
$ngaydautuan = date('Y-m-d', strtotime("-" . (0 + $week) . " days"));
$ngaycuoituan = date('Y-m-d', strtotime("+" . (6 - $week) . " days"));

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


        <div class="mb-4 d-flex gap-3 align-items-center">
            <button class="btn btn-outline-secondary" id="prevWeek">Tuần trước</button>
            <span class="fw-bold" id="currentWeek">Hiện tại: ' . $homnay . '</span>
            <button class="btn btn-outline-secondary" id="nextWeek">Tuần sau</button>
        </div>

        <!-- Schedule Grid -->
        <div class="schedule-grid mb-4">
            <!-- Schedule content will be dynamically generated here -->
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
                        if ($data['NgayLamViec'] === $day && $data['CaLamViec'] === 'Sáng') {
                        echo $data['HovaTenNV'] . ' 
                        <button class="delete-btn" data-bs-toggle="modal" 
                        data-bs-target="#deleteConfirmModal" onclick="setDoctorToDelete('.$data["MaNV"].')">
                        <i class="bi bi-person-dash"></i>
                        </button>' . '<br>';
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
                        if ($data['NgayLamViec'] === $day && $data['CaLamViec'] === 'Chiều') {
                        echo $data['HovaTenNV'] . ' 
                        <button class="delete-btn" data-bs-toggle="modal" 
                        data-bs-target="#deleteConfirmModal" onclick="setDoctorToDelete(' . $data["MaNV"] . ')">
                        <i class="bi bi-person-dash"></i>
                        </button>' . '<br>';
                        }
                    }
                    echo '</td>';
                }

                echo '</tr>';

        echo '  </tbody>
            </table>
        </div>';

?>

<!-- Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa bác sĩ này không?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form method="POST" action="./LLV">
                    <!-- Input ẩn để truyền MaNV -->
                    <input type="hidden" name="MaNV" id="maNVToDelete" />
                    <button type="submit" class="btn btn-danger">Xóa</button>
                    <?php
                    echo $data["MaNV"];
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let doctorToDelete = null;
    function setDoctorToDelete(MaNV) {
        document.getElementById('maNVToDelete').value = MaNV;
    }
    document.getElementById('deleteButton').addEventListener('click', function () {
        const maNV = document.getElementById('maNVToDelete').value;
        if (maNV) {
            alert('Đã xóa bác sĩ với MaNV: ' + maNV);
        }
        $('#deleteConfirmModal').modal('hide');
    });
</script>
