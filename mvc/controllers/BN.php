<?php
class BN extends Controller{
    // function SayHi(){
    //     // $mabn = $_SESSION['idbn'];
    //     //Models
    //     // $bn = $this->model("mBN");
    //     //Views
    //     $this->view("layoutBN",[
    //         "Page"
    //     ]);
    // }
    
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
    // function TTBN(){
    //     $mabn = $_SESSION['idbn'];
    //     //Models
    //     $bn = $this->model("mBN");

    //     $this->view("layoutBN",[
    //         "Page"=>"thongtinbn",
    //         "TT"=>$bn->get1BN($mabn)
    //     ]);
    // }
    function LK(){
        //Models
        // $bn = $this->model("mBN");
        //Views
        $this->view("layoutBN",[
            "Page"=>"lichkhambn"
        ]);
    }
    function UDTT(){
        if(isset($_POST["btnUDTT"])){
            // Call models
            $udbn = $this->model("mBN");
            $mabn = $_SESSION['idbn'];
            // Call Views
            if(isset($_POST["btn-updatebn"])){
                $mabn = $_SESSION['idbn'];
                $hoten = $_POST["hoten"];
                $gioitinh = $_POST["gioitinh"];
                $ngaysinh = $_POST["ngaysinh"];
                $diachi = $_POST["diachi"];
                $email = $_POST["email"];
                $bhyt = $_POST["bhyt"];
                $this->view("layoutBN",[
                    "Page"=>"udthongtinbn",
                    "UD"=>$udbn->UpdateBN($mabn, $hoten, $gioitinh, $ngaysinh, $diachi, $email, $bhyt)
                ]);
            }
            $this->view("layoutBN",[
                "Page"=>"udthongtinbn",
                "UD"=>$udbn->get1BN($mabn)
            ]);
            
        }
    }
}
?>