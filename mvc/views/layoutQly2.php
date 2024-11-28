<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Work Schedule Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="../public/css/main.css">
    <style>
        .schedule-grid {
            display: flex;
            border: 1px solid #dee2e6;
            border-radius: 15px;
            overflow: hidden;
            background: white;
            height: 600px; /* Đặt chiều cao cố định cho lưới */
        }

        .schedule-day {
            flex: 1;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #dee2e6;
            min-width: 0; /* Cho phép co lại khi cần thiết */
        }

        .schedule-day:last-child {
            border-right: none;
        }

        .schedule-header {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            border-bottom: 1px solid #dee2e6;
        }

        .schedule-shifts {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .shift {
            height: 300px; /* Fixed height for all shift sections */
            min-height: 300px;
            display: flex;
            flex-direction: column;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .shift:last-child {
            border-bottom: none;
        }

        .time-slot {
            padding: 10px;
            background-color: #f8f9fa;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .doctor-list {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
        }

        .doctor-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        .doctor-item:last-child {
            border-bottom: none;
        }

        .add-doctor-btn {
            width: 100%;
            text-align: left;
            padding: 8px;
            border: 1px dashed #dee2e6;
            background: none;
            color: #0d6efd;
            border-radius: 4px;
            margin-top: 8px;
        }

        .add-doctor-btn:hover {
            background-color: #f8f9fa;
        }

        body {
            background-color: #f0f0f0;
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .delete-btn {
            color: #dc3545;
            background: none;
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .delete-btn:hover {
            background-color: #fee2e2;
        }

        .past-week {
            opacity: 0.6;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <?php include "blocks/header.php" ?>
    <div class="main-container">
        <?php require_once "./mvc/views/pages/".$data["Page"].".php" ?>
    </div>
<?php require_once "./mvc/views/blocks/footer.php" ?>
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa bác sĩ này không?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" onclick="deleteDoctor()">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addDoctorModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm bác sĩ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input
                        type="text"
                        class="form-control mb-3"
                        id="doctorSearch"
                        placeholder="Tìm kiếm bác sĩ..."
                    />
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Chọn</th>
                                <th>Tên</th>
                                <th>Khoa</th>
                                <th>Chuyên môn</th>
                            </tr>
                        </thead>
                        <tbody id="doctorTableBody">
                            <!-- Doctor rows will be dynamically added here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" onclick="addSelectedDoctors()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

