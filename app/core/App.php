<?php

class App{
    public $controller;
    public $method;
    public $params  = [];
    
    public function __construct()
    {
        $url = $this->getUrl();

        // set controller
        if(isset($url[0])){
            if(file_exists('app/controllers/'.$url[0].'.php')){
                require_once 'app/controllers/'.$url[0].'.php';
                $this->controller = new $url[0]();
                unset($url[0]);
            }
            else{
                Utility::response(404,"controller '$url[0]' not found");
            }
        }
        else{
            Utility::response(202,["message" => "Wellcome to T-GADGETID API","documentation" => "https://github.com/korospace/t-gadgetapi"]);
        }
        
        // set method
        if(isset($url[1])){
            if(method_exists($this->controller,$url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }
            else{
                Utility::response(404,"method '$url[1]' not found");
            }
        }
        else{
            Utility::response(404,"method is missing");
        }

        if(!empty($url)){
            $this->params = array_values($url);
        }

        call_user_func_array([$this->controller,$this->method],$this->params);
    }

    public function getUrl()
    {
        if(isset($_GET['url'])){
            $url = $_GET['url'];
            $url = rtrim($url,'/');
            $url = explode('/',$url);

            return $url;
        }
    }

}

?>