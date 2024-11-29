<?php
class mLogin extends DB
{
    public function GetND($user, $pass){
        $str = "SELECT tk.ID, tk.username, tk.password, tk.MaPQ, bn.SoDT, bn.MaBN, bn.HovaTen, pq.TenPQ, 'benhnhan' AS role 
            FROM taikhoan tk 
            JOIN benhnhan bn ON tk.ID = bn.ID 
            JOIN phanquyen pq ON tk.MaPQ = pq.MaPQ
            WHERE bn.SoDT = '$user' AND tk.password = '$pass'
            UNION
            SELECT tk.ID, tk.username, tk.password, tk.MaPQ, ql.SoDT, ql.MaQL, ql.HovaTen, pq.TenPQ, 'quanly' AS role 
            FROM taikhoan tk 
            JOIN quanly ql ON tk.ID = ql.ID 
            JOIN phanquyen pq ON tk.MaPQ = pq.MaPQ
            WHERE ql.SoDT = '$user' AND tk.password = '$pass'
            UNION
            SELECT tk.ID, tk.username, tk.password, tk.MaPQ, nv.SoDT, nv.MaNV, nv.HovaTen, pq.TenPQ, 'nhanvien' AS role 
            FROM taikhoan tk 
            JOIN nhanvien nv ON tk.ID = nv.ID 
            JOIN phanquyen pq ON tk.MaPQ = pq.MaPQ
            WHERE nv.SoDT = '$user' AND tk.password = '$pass'";
        $tblND = mysqli_query($this->con, $str);
        return $tblND;
    }
}
?>