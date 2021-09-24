<?php

class BaseController{
    // view
    public function view($url,$data){
        require_once 'app/views/'.$url.'.php';
    }
    // models
    public function model($file){
        require_once 'app/models/'.$file.'.php';
        return new $file;
    }
}

?>