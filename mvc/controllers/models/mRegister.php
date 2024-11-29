<?php
class mRegister extends DB{
    public function DK($username, $password, $phanquyen){
        $str = "INSERT INTO taikhoan VALUES(null, '$username', '$password', '$phanquyen')";
        $result = false;
        if(mysqli_query($this->con, $str)){
            $result = true;
        }

        return json_encode($result);

        // if ($tblTK) {
        //     $last_id = mysqli_insert_id($con);
        // } else {
        //     $last_id = false;
        // }
        // return $last_id;
    }
}
?>