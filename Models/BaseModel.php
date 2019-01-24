<?php

include_once(getcwd() . 'classes/Database.php');

abstract class BaseModel {
    protected $db;

    function __construct(){
        $this->$db = new Database();
    }
}

?>