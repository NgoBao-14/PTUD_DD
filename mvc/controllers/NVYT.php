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
}
?>