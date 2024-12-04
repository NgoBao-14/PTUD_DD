<?php
class mRegister extends DB{
    public function DK($username, $password, $phanquyen) {
        // Câu lệnh SQL chèn dữ liệu vào bảng taikhoan
        $str = "INSERT INTO taikhoan VALUES(null, '$username', '$password', '5')";
        
        $result = [
            'success' => false,  // Mặc định là thất bại
            'last_id' => null    // Mặc định chưa có ID
        ];
    
        // Thực hiện truy vấn
        if (mysqli_query($this->con, $str)) {
            // Nếu chèn thành công, lấy last_id
            $result['success'] = true;
            $result['last_id'] = mysqli_insert_id($this->con);
        }
    
        // Trả về kết quả dưới dạng JSON
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