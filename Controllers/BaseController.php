<?php

abstract class BaseController {
    protected $model;
    protected $view;
    protected $values;

    public function __construct($file) {
        $this->view = $file;

        if (!file_exists($this->view)) {
            return "Error loading file ($file).";
        } 
    }
    public function render($arrayParam = array()) {

        if(count($arrayParam) > 0){
            extract($arrayParam);
        }
        
        require $this->view;
    }
    public function set($name, $value) {
        $this->values[$name] = $value;
    }
    public function get($name) {
        return $this->values[$name];
    }
}

?>