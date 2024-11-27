<?php
class Bacsi extends Controller
{
    // Hàm mặc định khi vào trang bác sĩ
    function SayHi()
    {
        $this->view("layoutBacsi", [
            "Page"
        ]);
    }

    function DangKyLichLamViec()
    {
        $this->view("layoutBacsi", [
            "Page" => "dangkylichlamviec"
        ]);
    }

    function XemLichLamViec()
    {
        $this->view("layoutBacsi", [
            "Page" => "xemlichlamviec"
        ]);
    }

    function XemDanhSachKham()
    {
        $this->view("layoutBacsi", [
            "Page" => "xemdanhsachkham"
        ]);
    }

    function XemThongTinBenhNhan()
    {
        $this->view("layoutBacsi", [
            "Page" => "xemthongtinbenhnhan"
        ]);
    }

    function XemLichSuKhamBenh()
    {
        $this->view("layoutBacsi", [
            "Page" => "xemlichsukhambenh"
        ]);
    }
}
