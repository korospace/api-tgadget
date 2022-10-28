<?php

use Rakit\Validation\Validator;

class User extends BaseController{

    /**
     * REGISTER
     */
    public function register(): void
    {
        Utility::reqMethodCheck('POST');
        
        $validator  = new Validator;
        $validation = $validator->validate($_POST, [
            'email'    => 'required|email|max:50',
            'username' => 'required|min:8|max:20',
            'password' => 'required|min:8|max:20',
        ]);

        if ($validation->fails()) {
            Utility::response(400,$validation->errors()->firstOfAll());
        }

        // if user is exist
        $isExist    = [];
        $emailCheck = $this->model("user_model")->getUser('email',   $_POST['email']);
        $nameCheck  = $this->model("user_model")->getUser('username',$_POST['username']);

        if($emailCheck['status'] == true){
            $isExist['email']    = "email is exist";
        }
        if($nameCheck['status']  == true){
            $isExist['username'] = "username is exist";
        }
        if(!empty($isExist)){
            Utility::response(400,$isExist);
        }

        // add user
        $data = [
            'id'       => Utility::generateOTP(6),
            'api_key'  => uniqid(),
            'email'    => trim($_POST['email']),
            'username' => trim($_POST['username']),
            'password' => hash('sha256', trim($_POST['password'])),
        ];
        
        $dbResponse = $this->model("user_model")->addUser($data);
        
        if($dbResponse == true){
            $sendEmail = Utility::sendEmail($data['email'],$data['api_key']);

            if ($sendEmail == true) {
                Utility::response(201,"user register is success, please check your email!");
            } 
            else {
                Utility::response(500,$sendEmail);
            }
        }
    }

    /**
     * EMAIL Verification
     */
    public function verification(?string $api_key = 'xx'): void
    {
        Utility::reqMethodCheck('GET');
        $dbResponse = $this->model("user_model")->emailVerification($api_key);
        
        if($dbResponse == true) {
            $this->view('Success/index','');
        }
        else{
            $this->view('Failed/index','');
        }
    }

    /**
     * LOGIN
     */
    public function login(): void
    {
        Utility::reqMethodCheck('POST');
        // if parameter not set 
        (!isset($_POST['username'])) ? Utility::response(400,"missing parameter 'username'") : '';
        (!isset($_POST['password'])) ? Utility::response(400,"missing parameter 'password'") : '';

        $user_data = $this->model("user_model")->getUser('username',trim($_POST['username']));
        
        // if username is not exist
        if($user_data['status'] == false){
            Utility::response(401,"username is not exist");
        }

        // password validation
        $password  = hash('sha256', trim($_POST['password']));
        if($password === $user_data['data']['password']){

            $isVerify = $user_data['data']['is_validated'];
            $user_id  = $user_data['data']['user_id'];
            $api_key  = $user_data['data']['api_key'];

            if ($isVerify == 'yes') {
                Utility::createNewToken($user_id,$api_key);
            } 
            else {
                Utility::response(401,"email not verified");
            }            
        }
        else{
            Utility::response(401,"wrong password!");
        }
    }

    /**
     * SESSION
     */
    public function session(): void
    {
        Utility::reqMethodCheck('GET');
        $jwtDecoded = Utility::sessionCheck();
        
        Utility::response(200,[
            'user_id'   => $jwtDecoded['user_id'],
            'token_age' => $jwtDecoded['expired']-time()
        ]);
    }

    /**
     * EDIT USER
     */
    public function edit()
    {
        Utility::reqMethodCheck('PUT');
        Utility::_methodParser('_PUT');
        global $_PUT;

        $validator  = new Validator;
        $validation = $validator->make($_PUT, [
            'new_username' => 'required|min:8|max:20',
            'new_password' => 'required|min:8|max:20',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            Utility::response(400,$validation->errors()->firstOfAll());
        }
        
        $jwtDecoded   = Utility::sessionCheck();
        $user_data    = $this->model('user_model')->getUser('user_id',$jwtDecoded['user_id']);
        $new_username = trim($_PUT['new_username']);
        $new_password = hash('sha256', trim($_PUT['new_password'])); 

        // is username exist
        if($new_username !== $user_data['data']['old_username']){
            $nameIsExist = $this->model('user_model')->getUser('username',$new_username);
            
            if($nameIsExist['status']  == true){
                Utility::response(400,['new_username' => "username is exist"]);
            }
        }

        $data = [
            'user_id'  => $jwtDecoded['user_id'],
            'username' => $new_username,
            'password' => $new_password,
        ];

        $dbResponse  = $this->model("user_model")->editUser($data);

        if($dbResponse == true){
            Utility::response(201,"edit user is success");
        }
    }

    /**
     * LOGOUT
     */
    public function logout(): void
    {
        Utility::reqMethodCheck('DELETE');
        $user_id    = Utility::sessionCheck()['user_id'];
        $dbResponse = $this->model("user_model")->deleteToken($user_id);
        
        if($dbResponse){
            Utility::response(202,"logout success");
        } 
    }

    /**
     * DELETE
     */
    public function delete(): void
    {
        Utility::reqMethodCheck('DELETE');
        $user_id    = Utility::sessionCheck()['user_id'];
        $dbResponse = $this->model("user_model")->deleteUser($user_id);
        
        if($dbResponse){
            Utility::response(202,"delete account success");
        } 
    }
}