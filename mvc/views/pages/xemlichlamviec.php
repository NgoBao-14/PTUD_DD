<div class="container">
    <h2 class="mb-4">Xem lịch làm việc</h2>

    <!-- Week Navigation -->
    <div class="d-flex justify-content-between mb-4">
        <button id="prevWeek" class="btn btn-secondary">Tuần trước</button>
        <button id="currentWeek" class="btn btn-primary">Hiện tại</button>
        <button id="nextWeek" class="btn btn-secondary">Tuần sau</button>
    </div>

    <!-- Week Range Display -->
    <div id="weekRange" class="text-center fw-bold mb-4"></div>

    <!-- Work Schedule Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Thứ 2<br><span id="date-mon" class="text-muted small"></span></th>
                <th>Thứ 3<br><span id="date-tue" class="text-muted small"></span></th>
                <th>Thứ 4<br><span id="date-wed" class="text-muted small"></span></th>
                <th>Thứ 5<br><span id="date-thu" class="text-muted small"></span></th>
                <th>Thứ 6<br><span id="date-fri" class="text-muted small"></span></th>
                <th>Thứ 7<br><span id="date-sat" class="text-muted small"></span></th>
                <th>Chủ nhật<br><span id="date-sun" class="text-muted small"></span></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                foreach ($days as $day):
                ?>
                    <td>
                        <?php if (!empty($data['schedule'][$day])): ?>
                            <ul class="list-unstyled">
                                <?php foreach ($data['schedule'][$day] as $shift): ?>
                                    <li><?= ucfirst($shift) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <span class="text-muted">Không có ca làm việc</span>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
</div>

<script>
    function getMonday(d) {
        d = new Date(d);
        const day = d.getDay(),
            diff = d.getDate() - day + (day === 0 ? -6 : 1);
        return new Date(d.setDate(diff));
    }

    function formatDate(date) {
        return date.getDate().toString().padStart(2, '0') + '/' +
            (date.getMonth() + 1).toString().padStart(2, '0') + '/' +
            date.getFullYear();
    }

    function updateWeekRange(monday) {
        const sunday = new Date(monday);
        sunday.setDate(sunday.getDate() + 6);

        // Update week range display
        document.getElementById('weekRange').textContent =
            formatDate(monday) + ' - ' + formatDate(sunday);

        // Update dates for each column
        const days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        days.forEach((day, index) => {
            const date = new Date(monday);
            date.setDate(date.getDate() + index);

            // Update date labels
            document.getElementById(`date-${day}`).textContent = formatDate(date);
        });
    }

    // Get current Monday
    let currentMonday = getMonday(new Date());

    // Week Navigation
    document.getElementById('prevWeek').addEventListener('click', function() {
        currentMonday.setDate(currentMonday.getDate() - 7);
        updateWeekRange(currentMonday);
        // TODO: Load schedule for the updated week
    });

    document.getElementById('nextWeek').addEventListener('click', function() {
        currentMonday.setDate(currentMonday.getDate() + 7);
        updateWeekRange(currentMonday);
        // TODO: Load schedule for the updated week
    });

    document.getElementById('currentWeek').addEventListener('click', function() {
        currentMonday = getMonday(new Date());
        updateWeekRange(currentMonday);
        // TODO: Load schedule for the current week
    });

    // Initial interface update
    updateWeekRange(currentMonday);
</script>
