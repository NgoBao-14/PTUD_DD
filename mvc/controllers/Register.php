<?php
class Register extends Controller{
    public $DKModel;

    public function __construct(){
        $this->DKModel = $this->model("mRegister");
    }
    
    public function SayHi(){
        $this->view("layoutRegister",[]);
    }
    public function BNDK(){
        if(isset($_POST["btn-dk"])){
            $username = $_POST["txtuser"];
            $password = $_POST["password"];
            $phanquyen = $_POST["hiddenphanquyen"];
            $password2 = $_POST['password2'];
            if ($password !== $password2) {
            echo "<script>alert('Mật khẩu và mật khẩu nhập lại không khớp!')</script>";
            exit;
            }
            $password = md5($password);

            $kq = $this->DKModel->DK($username, $password, $phanquyen);

            $result = json_decode($kq, true);
            if ($result['success']) {
                $_SESSION['last_id'] = $result['last_id'];
            }
            $this->view("layoutRegister",[
                "result"=>$kq
            ]);
        }
    }
    public function BNHS(){
        $id = $_SESSION['last_id'];
        $kq = $this->DKModel->GetSDT($id);
        
        $this->view("layoutTaoHS",[
            "SDT"=>$kq
        ]);
    }
    public function XNHS(){
        if(isset($_POST['btn-xn'])){
            $id = $_POST["last_id"];
            $hoten = $_POST["ten"];
            $gioitinh = $_POST["gt"];
            $ngaysinh = $_POST["ns"];
            $sdt = $_POST["sdt"];
            $diachi = $_POST["diachi"];
            $email = $_POST["email"];
            $bhyt = $_POST["bhyt"];
            $mapk = $_POST["maphieukham"];
            $hs = $this->DKModel->TaoHS($hoten, $gioitinh, $ngaysinh, $sdt, $diachi, $email, $bhyt, $mapk, $id);
            $result = json_decode($hs, true);
            $this->view("layoutTaoHS",[
                "result"=>$hs
            ]);
        }
    }
}
?>