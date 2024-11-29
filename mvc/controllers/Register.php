<?php
class Register extends Controller{
    public $DKModel;

    public function __construct(){
        $this->DKModel = $this->model("mRegister");
    }
    
    public function SayHi(){
        //Models
        
        //Views
        $this->view("layoutRegister",[]);
    }
    public function BNDK(){
        if(isset($_POST["btn-dk"])){
            $username = $_POST["txtuser"];
            $password = $_POST["password"];
            $phanquyen = $_POST["hiddenphanquyen"];
            $password2 = $_REQUEST['password2'];
            if ($password !== $password2) {
            echo "<script>alert('Mật khẩu và mật khẩu nhập lại không khớp!')</script>";
            exit;
            }
            $password = md5($password);

            $kq = $this->DKModel->DK($username, $password, $phanquyen);

            $this->view("layoutRegister",[
                "result"=>$kq
            ]);
        }
    }
}
?>