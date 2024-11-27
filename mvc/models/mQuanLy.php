<?php
class mQuanLy extends DB {

    // public function GetBN() {
    //     $str = 'SELECT * FROM benhnhan';
    //     $tblBNhan = mysqli_query($this->con, $str);
    //     $mang = array();
    //     while ($row = mysqli_fetch_assoc($tblBNhan)) {
    //         $mang[] = $row;
    //     }
    //     return json_encode($mang);
    // }

    public function Get1BN($MaBN) {
        $str = "SELECT * FROM benhnhan WHERE mabn = '$MaBN'";
        $tblBNhan = mysqli_query($this->con, $str);
        $mang = array();
        while ($row = mysqli_fetch_assoc($tblBNhan)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    public function GetPK($MaBN) {
        $str = "SELECT 
                    pk.MaPK AS MaPK,
                    pk.NgayTao AS NgayTaoPhieuKham,
                    nv.HovaTenNV AS BacSiPhuTrach,
                    pk.KetQua AS KetQua
                FROM 
                    phieukham pk
                JOIN 
                    bacsi bs ON pk.MaBS = bs.MaNV
                JOIN 
                    nhanvien nv ON bs.MaNV = nv.MaNV
                WHERE 
                    pk.MaBN = $MaBN";
        $tblPK = mysqli_query($this->con, $str);
        $mang = array();
        while ($row = mysqli_fetch_assoc($tblPK)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    public function GetCTPK($MaPK) {
        $str = "SELECT 
    pk.MaPK,
    pk.NgayTao AS NgayTaoPhieuKham,
    nv.HovaTenNV AS BacSiPhuTrach,
    pk.KetQua,
    GROUP_CONCAT(DISTINCT CONCAT(xn.LoaiXN, ': ', xn.KetQua) SEPARATOR '; ') AS KetQuaXetNghiem,
    GROUP_CONCAT(DISTINCT CONCAT(t.TenThuoc, ' - ', ct.LieuDung, ' - ', ct.CachDung) SEPARATOR '; ') AS DonThuoc,
    dt.MoTa AS LoiDan,
    bn.HovaTen,          -- Thêm thông tin họ tên bệnh nhân
    bn.NgaySinh,         -- Thêm ngày sinh bệnh nhân
    bn.DiaChi,           -- Thêm địa chỉ bệnh nhân
    bn.SoDT,
    bn.BHYT,
    bn.GioiTinh,
    bn.MaBN
    -- Thêm số điện thoại bệnh nhân
    FROM 
        phieukham pk
    LEFT JOIN 
        bacsi bs ON pk.MaBS = bs.MaNV
    LEFT JOIN 
        nhanvien nv ON bs.MaNV = nv.MaNV
    LEFT JOIN 
        xetnghiem xn ON pk.MaXN = xn.MaXN
    LEFT JOIN 
        donthuoc dt ON pk.MaDT = dt.MaDT
    LEFT JOIN 
        chitietdonthuoc ct ON dt.MaDT = ct.MaDT
    LEFT JOIN 
        thuoc t ON ct.MaThuoc = t.MaThuoc
    LEFT JOIN
        benhnhan bn ON pk.MaBN = bn.MaBN    -- Thêm LEFT JOIN với bảng bệnh nhân
    WHERE 
        pk.MaPK = '$MaPK'
    GROUP BY 
        pk.MaPK";
        
        $result = mysqli_query($this->con, $str);
        $mang = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $mang[] = $row;
        }
        return json_encode($mang);
    }
}

?>
