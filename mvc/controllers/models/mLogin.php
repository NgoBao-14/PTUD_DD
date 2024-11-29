<?php
class mLogin extends DB
{
    public function GetND($user, $pass){
        $str = "SELECT tk.ID, tk.username, tk.password, tk.phanquyen, bn.SoDT, bn.MaBN, bn.HovaTen, 'benhnhan' AS role 
            FROM taikhoan tk 
            JOIN benhnhan bn ON tk.ID = bn.ID 
            WHERE bn.SoDT = '$user' AND tk.password = '$pass'
            UNION
            SELECT tk.ID, tk.username, tk.password, tk.phanquyen, ql.SoDT, ql.MaQL, ql.HovaTen, 'quanly' AS role 
            FROM taikhoan tk 
            JOIN quanly ql ON tk.ID = ql.ID 
            WHERE ql.SoDT = '$user' AND tk.password = '$pass'
            UNION
            SELECT tk.ID, tk.username, tk.password, tk.phanquyen, nv.SoDT, nv.MaNV, nv.HovaTenNV, 'nhanvien' AS role 
            FROM taikhoan tk 
            JOIN nhanvien nv ON tk.ID = nv.ID 
            WHERE nv.SoDT = '$user' AND tk.password = '$pass'";
        $tblND = mysqli_query($this->con, $str);
        return $tblND;
    }
}
?>