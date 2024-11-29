<div class="container">
    <h2 class="mb-4">Xem lịch làm việc</h2>

    <?php if (!empty($data['LichLamViec'])): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center;">Ngày làm việc</th>
                    <th style="text-align: center;">Ca làm việc</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['LichLamViec'] as $lich): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($lich['NgayLamViec'])) ?></td>
                        <td><?= htmlspecialchars($lich['CaLamViec']) ?></td>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">
            Không có lịch làm việc nào.
        </div>
    <?php endif; ?>
</div>
