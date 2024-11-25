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
                "CTHD" => $nvyt->getCTHD($MaHD)
            ]);
        }
            
        
    }
}
?>