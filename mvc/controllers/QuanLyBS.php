<?php
class QuanLyBS extends Controller {
    function DSBS() {
        $ql = $this->model("mQLBS");
        $bacsi = json_decode($ql->GetAllBS(), true);

        $this->view("layoutQLyBS", [
            "Page" => "qlbs",
            "BacSi" => $bacsi
        ]);
    }

    function CTBS() {
        if (isset($_POST["btnCTBS"])) {
            $MaNV = $_POST["ctbs"];

            if (!empty($MaNV)) {
                $ql = $this->model("mQLBS");
                $chitietBS = json_decode($ql->Get1BS($MaNV), true);

                if ($chitietBS) {
                    $this->view("layoutQLyBS", [
                        "Page" => "qlchitietbs",
                        "CTBS" => $chitietBS
                    ]);
                } else {
                    $this->view("layoutQLyBS", [
                        "Page" => "qlchitietbs",
                        "Error" => "Không tìm thấy thông tin bác sĩ với mã đã nhập."
                    ]);
                }
            } else {
                $this->view("layoutQLyBS", [
                    "Page" => "qlchitietbs",
                    "Error" => "Mã nhân viên không hợp lệ."
                ]);
            }
        } else {
            $this->view("layoutQLyBS", [
                "Page" => "qlchitietbs",
                "Error" => "Yêu cầu không hợp lệ."
            ]);
        }
    }


    function SuaBS() {
        if (isset($_POST["btnSuaBS"])) {
            $MaNV = $_POST["MaNV"];
            $HovaTenNV = $_POST["HovaTenNV"];
            $NgaySinh = $_POST["NgaySinh"];
            $GioiTinh = $_POST["GioiTinh"];
            $SoDT = $_POST["SoDT"];
            $EmailNV = $_POST["EmailNV"];
            $MaKhoa = $_POST["MaKhoa"];

            $ql = $this->model("mQLBS");

            // Kiểm tra số điện thoại và email
            if ($ql->CheckExistingPhoneNumber($SoDT, $MaNV)) {
                $this->view("layoutQLyBS", [
                    "Page" => "qlchitietbs",
                    "Error" => "Số điện thoại đã tồn tại trong hệ thống.",
                    "CTBS" => $ql->Get1BS($MaNV)
                ]);
                return;
            }

            if ($ql->CheckExistingEmail($EmailNV, $MaNV)) {
                $this->view("layoutQLyBS", [
                    "Page" => "qlchitietbs",
                    "Error" => "Email đã tồn tại trong hệ thống.",
                    "CTBS" => $ql->Get1BS($MaNV)
                ]);
                return;
            }

            $result = $ql->UpdateBS($MaNV, $HovaTenNV, $NgaySinh, $GioiTinh, $SoDT, $EmailNV, $MaKhoa);

            if ($result) {
                header("Location: ./DSBS");
            } else {
                $this->view("layoutQLyBS", [
                    "Page" => "qlchitietbs",
                    "Error" => "Không thể cập nhật thông tin bác sĩ.",
                    "CTBS" => $ql->Get1BS($MaNV)
                ]);
            }
        } else {
            $this->view("layoutQLyBS", [
                "Page" => "qlchitietbs",
                "Error" => "Yêu cầu không hợp lệ."
            ]);
        }
    }

    function XoaBS() {
        if (isset($_POST["btnXoaBS"])) {
            $MaNV = $_POST["MaNV"];

            $ql = $this->model("mQLBS");
            $result = $ql->DeleteBS($MaNV);

            if ($result) {
                header("Location: ./DSBS");
            } else {
                $this->view("layoutQLyBS", [
                    "Page" => "qlbs",
                    "Error" => "Không thể xóa bác sĩ."
                ]);
            }
        } else {
            $this->view("layoutQLyBS", [
                "Page" => "qlbs",
                "Error" => "Yêu cầu không hợp lệ."
            ]);
        }
    }

    function ThemBS() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $HovaTenNV = $_POST['HovaTenNV'];
            $NgaySinh = $_POST['NgaySinh'];
            $GioiTinh = $_POST['GioiTinh'];
            $SoDT = $_POST['SoDT'];
            $EmailNV = $_POST['EmailNV'];
            $MaKhoa = $_POST['MaKhoa'];

            // Kiểm tra dữ liệu đầu vào
            if (!preg_match("/^[a-zA-ZÀ-ỹ\s]+$/u", $HovaTenNV)) {
                $this->view("layoutQLyBS", [
                    "Page" => "thembacsi",
                    "Error" => "Họ tên không được chứa ký tự đặc biệt và số."
                ]);
                return;
            }

            if (!preg_match("/^[0-9]+$/", $SoDT)) {
                $this->view("layoutQLyBS", [
                    "Page" => "thembacsi",
                    "Error" => "Số điện thoại chỉ được chứa số."
                ]);
                return;
            }

            $ql = $this->model("mQLBS");
            
            $result = $ql->AddBS($HovaTenNV, $NgaySinh, $GioiTinh, $SoDT, $EmailNV, $MaKhoa);

            if ($result === true) {
                header("Location: ./DSBS");
                $this->view("layoutQLyBS", [
                    "Page" => "qlbs",
                    "Message" => "Thêm bác sĩ mới thành công."
                    

                ]);
            } else {
                $this->view("layoutQLyBS", [
                    "Page" => "thembacsi",
                    "Error" => $result
                ]);
            }
        } else {
            $this->view("layoutQLyBS", [
                "Page" => "thembacsi"
            ]);
        }
    }
    function DSNVYT() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $ql = $this->model("mQLNVYT");
        $nhanvien = $ql->GetAllNVYT($search);

        $this->view("layoutQLyBS", [
            "Page" => "qlnvyt",
            "NhanVien" => $nhanvien
        ]);
    }

    function CTNVYT() {
        if (isset($_POST["btnCTNVYT"])) {
            $MaNV = $_POST["ctnv"];

            if (!empty($MaNV)) {
                $ql = $this->model("mQLNVYT");
                $chitietNV = $ql->Get1NVYT($MaNV);

                if ($chitietNV) {
                    $this->view("layoutQLyBS", [
                        "Page" => "qlchitietnvyt",
                        "CTNV" => $chitietNV
                    ]);
                } else {
                    $this->view("layoutQLyBS", [
                        "Page" => "qlchitietnvyt",
                        "Error" => "Không tìm thấy thông tin nhân viên với mã đã nhập."
                    ]);
                }
            } else {
                $this->view("layoutQLyBS", [
                    "Page" => "qlchitietnvyt",
                    "Error" => "Mã nhân viên không hợp lệ."
                ]);
            }
        }
    }

    function SuaNVYT() {
        if (isset($_POST["btnSuaNVYT"])) {
            $MaNV = $_POST["MaNV"];
            $HovaTenNV = $_POST["HovaTenNV"];
            $NgaySinh = $_POST["NgaySinh"];
            $GioiTinh = $_POST["GioiTinh"];
            $SoDT = $_POST["SoDT"];
            $EmailNV = $_POST["EmailNV"];

            $ql = $this->model("mQLNVYT");

            // Kiểm tra số điện thoại và email
            if ($ql->CheckExistingPhoneNumber($SoDT, $MaNV)) {
                $this->view("layoutQLyBS", [
                    "Page" => "qlchitietnvyt",
                    "Error" => "Số điện thoại đã tồn tại trong hệ thống.",
                    "CTNV" => $ql->Get1NVYT($MaNV)
                ]);
                return;
            }

            if ($ql->CheckExistingEmail($EmailNV, $MaNV)) {
                $this->view("layoutQLyBS", [
                    "Page" => "qlchitietnvyt",
                    "Error" => "Email đã tồn tại trong hệ thống.",
                    "CTNV" => $ql->Get1NVYT($MaNV)
                ]);
                return;
            }

            $result = json_decode($ql->UpdateNVYT($MaNV, $HovaTenNV, $NgaySinh, $GioiTinh, $SoDT, $EmailNV), true);

            if ($result['success']) {
                header("Location: ./DSNVYT");
            } else {
                $this->view("layoutQLyBS", [
                    "Page" => "qlchitietnvyt",
                    "Error" => "Không thể cập nhật thông tin nhân viên.",
                    "CTNV" => $ql->Get1NVYT($MaNV)
                ]);
            }
        }
    }

    function XoaNVYT() {
        if (isset($_POST["btnXoaNVYT"])) {
            $MaNV = $_POST["MaNV"];

            $ql = $this->model("mQLNVYT");
            $result = json_decode($ql->DeleteNVYT($MaNV), true);

            if ($result['success']) {
                header("Location: ./DSNVYT");
            } else {
                $this->view("layoutQLyBS", [
                    "Page" => "qlnvyt",
                    "Error" => "Không thể xóa nhân viên."
                ]);
            }
        }
    }

    function ThemNVYT() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $HovaTenNV = $_POST['HovaTenNV'];
            $NgaySinh = $_POST['NgaySinh'];
            $GioiTinh = $_POST['GioiTinh'];
            $SoDT = $_POST['SoDT'];
            $EmailNV = $_POST['EmailNV'];

            // Kiểm tra dữ liệu đầu vào
            if (!preg_match("/^[a-zA-ZÀ-ỹ\s]+$/u", $HovaTenNV)) {
                $this->view("layoutQLyBS", [
                    "Page" => "themnvyt",
                    "Error" => "Họ tên không được chứa ký tự đặc biệt và số."
                ]);
                return;
            }

            if (!preg_match("/^[0-9]+$/", $SoDT)) {
                $this->view("layoutQLyBS", [
                    "Page" => "themnvyt",
                    "Error" => "Số điện thoại chỉ được chứa số."
                ]);
                return;
            }

            $ql = $this->model("mQLNVYT");
            
            $result = json_decode($ql->AddNVYT($HovaTenNV, $NgaySinh, $GioiTinh, $SoDT, $EmailNV), true);

            if ($result['success']) {
                header("Location: ./DSNVYT");
            } else {
                $this->view("layoutQLyBS", [
                    "Page" => "themnvyt",
                    "Error" => $result['message']
                ]);
            }
        } else {
            $this->view("layoutQLyBS", [
                "Page" => "themnvyt"
            ]);
        }
    }
}
?>