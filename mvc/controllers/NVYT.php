<?php

class NVYT extends Controller{

    // Must have SayHi()
    function SayHi(){
        // Call models
        $nvyt = $this->model("mNVYT");
        // Call Views
        $this->view("layoutNVYT",[
            "Page"=>"hoadon",
            "HD" => $nvyt->GetHD()
        ]);

    }
    function CTHD(){
        if(isset($_POST["btnCTHD"])){
            $MaHD = $_POST["cthd"];
            // Call models
            $nvyt = $this->model("mNVYT");
            // Call Views
            $this->view("layoutNVYT",[
                "Page"=>"chitiethoadon",
                "CTHD" => $nvyt->getCTHD($MaHD),
                "TT" => $nvyt->getPTTT(),
            ]);
        }   
        if(isset($_POST["nutXN"]))
        {
                    $TT = "'Completed'";
                    $id = $_POST["paymentOption"];
                    $MaHD = $_POST["MaHD"];
                    $nvyt = $this->model("mNVYT");
                    $rs = $nvyt->setPTTT($MaHD,$id);
                    $rs = $nvyt->setTrangThai($MaHD,$TT);
                    $this->view("layoutNVYT",[
                        "Page"=>"chitiethoadon",
                        "CTHD" => $nvyt->getCTHD($MaHD),
                        "TT" => $nvyt->getPTTT(),
                        "Result"=> $rs
                    ]);
        }
        if(isset($_POST["nutHuy"]))
        {
            $TT = "'Cancelled'";
            $MaHD = $_POST["MaHD"];
            $nvyt = $this->model("mNVYT");
            if($nvyt->setTrangThai($MaHD,$TT))
            {
                $rs = 3;
            }
            $this->view("layoutNVYT",[
                "Page"=>"chitiethoadon",
                "CTHD" => $nvyt->getCTHD($MaHD),
                "TT" => $nvyt->getPTTT(),
                "Result"=> $rs
            ]);
        }
            
        
    }
}
?>