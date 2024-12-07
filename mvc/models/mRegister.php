<?php
class mRegister extends DB{
    public function usernameExists($username) {
        $str = "SELECT COUNT(*) as count FROM taikhoan WHERE username = '$username'";
        $result = mysqli_query($this->con, $str);
        $row = mysqli_fetch_assoc($result);
        return $row['count'] > 0;
    }
    
    public function DK($username, $password, $phanquyen) {
        if ($this->usernameExists($username)) {
            return json_encode([
                'success' => false,
                'message' => 'Số điện thoại đã tồn tại hoặc đã được sử dụng!'
            ]);
        }
        $str = "INSERT INTO taikhoan VALUES(null, '$username', '$password', '5')";
        $result = [
            'success' => false,
            'last_id' => null,
            'message' => 'Đăng ký thất bại'
        ];
        if (mysqli_query($this->con, $str)) {
            $result['success'] = true;
            $result['last_id'] = mysqli_insert_id($this->con);
            $result['message'] = 'Đăng ký thành công';
        }
        return json_encode($result);
    }

    public function GetSDT($id){
        $str = "select username from taikhoan where ID='$id'";
        $rows = mysqli_query($this->con, $str);
        $mang = array();
        while($row = mysqli_fetch_array($rows)){
            $mang[] = $row;
        }
        return json_encode($mang);
    }

    public function TaoHS($hoten, $gioitinh, $ngaysinh, $sdt, $diachi, $email, $bhyt, $mapk, $id){
        $str = "INSERT INTO benhnhan VALUES(null, '$hoten', '$gioitinh', '$ngaysinh', '$sdt', '$diachi', '$email', '$bhyt', '0', $id)";
        $result = false;
        if(mysqli_query($this->con, $str)){
            $result = true;
        }
        return json_encode($result);
    }
}
?>