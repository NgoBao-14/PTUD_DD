<?php
class Login extends Controller{
    function SayHi(){
        if (isset($_POST['nut'])) {
            $user = $_POST['username'];
            $pass = md5($_POST['pass']);
            //model
            $p = $this->model("mLogin");
            $login = $p->GetND($user, $pass);
    
            if ($login && mysqli_num_rows($login) > 0) {
                while ($r = mysqli_fetch_assoc($login)) {
                    $_SESSION['role'] = $r['MaPQ'];
                    $_SESSION['id'] = $r['ID'];
                    $_SESSION['idbn'] = $r['MaBN'];
					$_SESSION['ten'] = $r['HovaTen'];
                    $_SESSION['idql'] = $r['MaQL'];
                    $_SESSION['idnv'] = $r['MaNV'];
                }
                echo "<script>alert('Đăng nhập thành công');</script>";
                header("refresh:0; url='index.php'");
                exit;
            } else {
                echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu');</script>";
                header("refresh:0; url='Login'");
                exit;
            }
            
        }
        //view
        $this->view("layoutLogin");
    }
}
?>