<?php

use Firebase\JWT\JWT;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception as mailerException;

// pass mailer
// vhvknqqbpxdkknxa

class Utility{

    /**
     * request method check
     */
    static public function reqMethodCheck(string $method): void
    {
        if($_SERVER['REQUEST_METHOD'] !== $method){
            self::response(400,"invalid method '".$_SERVER['REQUEST_METHOD']."'");
        }
    }

    /**
     * JSON Output
     */
    static public function response(int $status,$data): string
    {
        $success = ($status >= 200 && $status < 300) ? true : false;
        $varData = ($status == 200) ? 'data' : 'message';
        
        $jsonOutput['success'] = $success;
        $jsonOutput[$varData]  = $data;
        
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code($status);
        echo json_encode($jsonOutput);
        die;
    }

    /**
     * TOKEN SESSION 
     */
    static public function sessionCheck(): array
    {
        if(!isset($_SERVER['HTTP_TOKEN']) || !isset($_SERVER['HTTP_API_KEY'])){
            self::response(401,"Unauthorized");
        }
        else{
            try {
                $db  = new Database;
                $db->query("SELECT * FROM users WHERE api_key=:api_key AND token=:token");
                $db->bind("api_key",$_SERVER['HTTP_API_KEY']);
                $db->bind("token",  $_SERVER['HTTP_TOKEN']);
                $result = $db->singleResult();
                
                if($result){
                    return self::tokenExpired($_SERVER['HTTP_TOKEN'],$_SERVER['HTTP_API_KEY']);
                }else{
                    self::response(401,"Unauthorized");
                }
            } 
            catch(Exception $err) {
                self::response(500,[
                    "error" => $err->getMessage(),
                    "location" => $err->getTraceAsString()
                ]);
            }
        }
    }

    /**
     * Create New Token
     */
    static public function createNewToken(string $user_id,string $api_key): void
    {
        $payload = array(
            "user_id" => $user_id,
            "api_key" => $api_key,
            "expired" => time()+3600
        );

        // token generator
        $jwt = JWT::encode($payload, $api_key);
        
        // update user token at database
        try {
            $db  = new Database;
            $db->query("UPDATE users SET token=:token WHERE user_id=:user_id");
            $db->bind("user_id",$user_id);
            $db->bind("token"  ,$jwt);
            if($db->execute()){
                self::response(200,[
                    'user_id'    => $user_id,
                    'api_key'    => $api_key,
                    'token'      => $jwt
                ]);
            }
        } 
        catch(Exception $err) {
            self::response(500,[
                "error" => $err->getMessage(),
                "location" => $err->getTraceAsString()
            ]);
        }
    }

    /**
     * TOKEN EXPIRED 
     */
    static public function tokenExpired(string $token,string $api_key): array
    {
        try{
            $decoded = JWT::decode($token, $api_key, array('HS256'));
            $decoded = (array)$decoded;
    
            if(time() < $decoded['expired']){
                return $decoded;
            }
            else{
                try {
                    $db  = new Database;
                    $db->query("UPDATE users SET token = NULL WHERE user_id=:user_id");
                    $db->bind("user_id",$decoded['user_id']);
                    if($db->execute()){
                        self::response(401,"expired token");
                    }
                } 
                catch(Exception $err) {
                    self::response(500,[
                        "error" => $err->getMessage(),
                        "location" => $err->getTraceAsString()
                    ]);
                }
            }
        }
        catch(Exception $err) {
            self::response(401,"invalid token");
        }
    }

    /**
     * API KEY CHECK 
     */
    static public function apiKeyCheck(): array
    {
        (!isset($_SERVER['HTTP_API_KEY'])) ? self::response(401,"Unauthorized") : '';

        $db = new Database;
        $db->query("SELECT * FROM users WHERE api_key = :api_key");
        $db->bind("api_key",$_SERVER['HTTP_API_KEY']);
        $result = $db->singleResult();
        
        if(!$result){
            self::response(401,"Unauthorized");
        }
        else{
            return $result;
        }
    }
    
    /**
     * Generate OTP.
     */
    static public function generateOTP(int $n): string
    {
        $generator = "135792468";      
        $result    = "";
      
        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }
      
        return $result;
    }
    
    /**
     * Nuimeric checker
     */
    static public function numChecker(string $data): bool
    {
        if ((bool)preg_match_all('/[A-Za-z,.\\/?><:;\'\"|!@#$%^&*()\-_\+={}\\[\\]`~]/',$data)) {
            return false;
        } 
        else {
            return true;
        }   
    }
    
    /**
     * Image checker
     */
    static public function imgChecker(array $files): void
    {
        // get param name
        foreach ($files as $key1 => $values) {
            $paramName = $key1;
        }
        
        $isImage = (bool)preg_match_all("/image/i",$files[$paramName]['type']);
        
        if (!$isImage) {
            self::response(401,[$paramName => $files[$paramName]['name']." is not image!"]);
        }
        if ($files[$paramName]['size'] > 204800) {
            self::response(400,[$paramName => "$paramName max size is 200kb"]);
        }
    }

    /**
     * EMAIL SENDER
     */
    static public function sendEmail(String $email,String $api_key): string
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                          
            $mail->Host       = 'smtp.gmail.com';
            $mail->Username   = 'yourmail@gmail.com';
            $mail->Password   = 'secret-pass';
            $mail->Port       = 465;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = 'ssl';
            $mail->setFrom('yourmail@gmail.com', 'your-username');
            $mail->addAddress($email);
            $mail->isHTML(true);

            $mail->Subject = 'email verification';
            $mail->Body    = "Click the link below to verify your account:<br><a href='https://t-gadgetapi.herokuapp.com/user/verification/$api_key'>https://t-gadgetapi.herokuapp.com/user/verification/$api_key</a>";

            if($mail->send()) {
                return true;
            } 
        } 
        catch (mailerException $e) {
            return $e->getMessage();
        }
    }

    /**
     * PARSING METHOD
     */
    static public function _methodParser(string $methodName): void
    {
        // global $_PUT;

        $putdata  = fopen("php://input", "r");
        $raw_data = '';

        while ($chunk = fread($putdata, 1024))
            $raw_data .= $chunk;

        fclose($putdata);

        $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

        if(empty($boundary)){
            parse_str($raw_data,$data);
            $GLOBALS[ $methodName ] = $data;
            return;
        }

        $parts = array_slice(explode($boundary, $raw_data), 1);
        $data  = array();

        foreach ($parts as $part) {
            if ($part == "--\r\n") break;

            $part = ltrim($part, "\r\n");
            list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);

            $raw_headers = explode("\r\n", $raw_headers);
            $headers = array();
            foreach ($raw_headers as $header) {
                list($name, $value) = explode(':', $header);
                $headers[strtolower($name)] = ltrim($value, ' ');
            }

            if (isset($headers['content-disposition'])) {
                $filename = null;
                $tmp_name = null;
                preg_match(
                    '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
                    $headers['content-disposition'],
                    $matches
                );
                
                if(count($matches) !== 0){
                    list(, $type, $name) = $matches;
                }

                if( isset($matches[4]) )
                {
                    if( isset( $_FILES[ $matches[ 2 ] ] ) )
                    {
                        continue;
                    }

                    $filename       = $matches[4];
                    $filename_parts = pathinfo( $filename );
                    $tmp_name       = tempnam( ini_get('upload_tmp_dir'), $filename_parts['filename']);

                    $_FILES[ $matches[ 2 ] ] = array(
                        'name'=>$filename,
                        'type'=>str_replace(' ', '', $value),
                        'tmp_name'=>$tmp_name,
                        'error'=>0,
                        'size'=>strlen( $body ),
                    );

                    file_put_contents($tmp_name, $body);
                }
                else
                {
                    $data[$name] = substr($body, 0, strlen($body) - 2);
                }
            }

        }
        $GLOBALS[ $methodName ] = $data;
        return;
    }

    /**
     * current time
     */
    // static public function currentTime(): string
    // {
    //     $now = new DateTime();
    //     $now->setTimezone(new DateTimeZone('Asia/Jakarta'));
    //     $now = (array)$now;
    //     return $now['date'];
    // }

    /**
     * range time in second
     */
    // static public function rangeTime(string $timeStart): int
    // {
    //     $start = strtotime($timeStart);
    //     $end   = strtotime(self::currentTime());
    //     $range = intval($end - $start);
    //     return $range;
    // }

}