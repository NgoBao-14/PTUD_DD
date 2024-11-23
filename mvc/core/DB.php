<?php

class DB{
    //đừng thay đổi gì hết
    public $con;
    protected $servername = "localhost";
    protected $username = "domdom";
    protected $password = "1234";
    protected $dbname = "domdom";

    function __construct(){
        $this->con = mysqli_connect($this->servername, $this->username, $this->password);
        mysqli_select_db($this->con, $this->dbname);
        mysqli_query($this->con, "SET NAMES 'utf8'");
    }
}

?>