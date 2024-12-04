<?php
class BN extends Controller{
    public $HSModel;

    public function __construct(){
        $this->HSModel = $this->model("mBN");
    }
    
    function SayHi(){
        $mabn = $_SESSION['idbn'];
        //Models
        $bn = $this->model("mBN");
        //Views
        $this->view("layoutBN",[
            "Page"=>"thongtinbn",
            "TT"=>$bn->get1BN($mabn)
        ]);
    }
    function LK(){
        //Models
        // $bn = $this->model("mBN");
        //Views
        $this->view("layoutBN",[
            "Page"=>"lichkhambn"
        ]);
    }
    function UDTT(){
        $udbn = $this->model("mBN");
        if(isset($_POST["btnUDTT"])){
            // Call models
            $udbn = $this->model("mBN");
            $mabn = $_SESSION['idbn'];
            // Call Views
            
            $this->view("layoutBN",[
                "Page"=>"udthongtinbn",
                "UD"=>$udbn->get1BN($mabn)
            ]);
            
        }
        if (isset($_POST["btn-updatebn"])) {
            $mabn = $_SESSION["idbn"]; // Mã bệnh nhân từ session
            $tenbn = $_POST["hovaten"];
            $gioitinh = $_POST["gt"];
            $ngaysinh = $_POST["ngaysinh"];
            $diachi = $_POST["diachi"];
            $email = $_POST["email"];
            $bhyt = $_POST["bhyt"];
    
            // Gọi model để cập nhật thông tin
            $result = $udbn->UpdateBN($mabn, $tenbn, $gioitinh, $ngaysinh, $diachi, $email, $bhyt);
    
            // Nếu cập nhật thành công, cập nhật session tên mới
            if ($result) {
                $_SESSION["ten"] = $tenbn; // Cập nhật tên mới vào session
            }
    
            // Truyền kết quả vào View
            $this->view("layoutBN", [
                "Page" => "udthongtinbn",
                "UD"=>$udbn->get1BN($mabn),
                "XL" => $result // Truyền kết quả cập nhật
            ]);
        }
    }
}
?>