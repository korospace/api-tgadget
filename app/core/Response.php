<?php

class Response{

    /**
     * JSON Output
     */
    static public function jsonOutput($status,$dbResponse)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        
        if($status == 200){
            $response = $dbResponse;
        }
        else{
            $response['status']  = $status;
            $response['message'] = $dbResponse;
        }

        echo json_encode($response);
        die;
    }

    /**
     * dbRespon Check
     */
    static public function dbResponseCheck($dbResponse){
        if(!$dbResponse){
            return self::jsonOutput(404,"Data not found!");
        }
        else if(!is_array($dbResponse)){
            return self::jsonOutput(500,$dbResponse);
        }
        else{
            return self::jsonOutput(200,$dbResponse);
        }
    }
}