<?php

class User_model{
    public $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * get user by
     */
    public function getUser(string $searchBy,string $searchVal): array
    {
        try {
            if($searchBy == 'user_id'){
                $this->db->query("SELECT username AS old_username,password AS old_password FROM users WHERE user_id = :searchVal");
            }
            if($searchBy == 'email'){
                $this->db->query("SELECT email FROM users WHERE email = :searchVal");
            }
            if($searchBy == 'username'){
                $this->db->query("SELECT * FROM users WHERE username = :searchVal");
            }
    
            $this->db->bind("searchVal",$searchVal);
            $result = $this->db->singleResult();

            if ($result == false) {    
                return [
                    'status'=> false,
                    'data'  => 'notfound'
                ];
            } 
            else {    
                return [
                    'status'=> true,
                    'data'  => $result
                ];
            }
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());   
        }
    }

    /**
     * add user
     */
    public function addUser(array $data): bool
    {
        try {
            $this->db->query("INSERT INTO users(user_id,email,username,password,api_key) VALUES(:user_id,:email,:username,:password,:api_key)");

            $this->db->bind('user_id' ,$data['id']);
            $this->db->bind('email'   ,$data['email']);
            $this->db->bind('username',$data['username']);
            $this->db->bind('password',$data['password']);
            $this->db->bind('api_key' ,$data['api_key']);

            if($this->db->execute()){
                // create sosmed
                if($this->createSosmed($data['id'])){
                    // create countdown
                    if($this->createCountdown($data['id'])){
                        // create visitors
                        return $this->createVisitors($data['id']);
                    }
                }
            }
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * email verification
     */
    public function emailVerification(string $api_key): bool
    {
        try {
            $this->db->query("UPDATE users SET is_validated='yes' WHERE api_key=:api_key");
            $this->db->bind('api_key',$api_key);
            $this->db->execute();
            return $this->db->rowCount();
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * CREATE SOSMED
     */
    public function createSosmed(string $user_id): bool
    {
        try {
            $this->db->query("INSERT INTO link_sosmed(created_by) VALUES(:user_id)");
            $this->db->bind('user_id',$user_id);
            return $this->db->execute();
        } 
        catch (Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * CREATE COUNTDOWN
     */
    public function createCountdown(string $user_id): bool
    {
        try {
            $this->db->query("INSERT INTO countdown(created_by) VALUES(:user_id)");
            $this->db->bind('user_id',$user_id);
            return $this->db->execute();
        } 
        catch (Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * CREATE VISITORS
     */
    public function createVisitors(string $user_id): bool
    {
        try {
            $this->db->query("INSERT INTO visitors(created_by) VALUES(:user_id)");
            $this->db->bind('user_id',$user_id);
            return $this->db->execute();
        } 
        catch (Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * edit user
     */
    public function editUser(array $data): bool
    {
        try {
            $this->db->query("UPDATE users SET username=:username,password=:password WHERE user_id=:user_id");

            $this->db->bind('user_id',$data['user_id']);
            $this->db->bind('username',$data['username']);
            $this->db->bind('password',$data['password']);
            return $this->db->execute();
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * delete token
     */
    public function deleteToken(string $user_id): bool
    {
        try {
            $this->db->query("UPDATE users SET token = NULL WHERE user_id=:user_id");
            $this->db->bind('user_id',$user_id);
            return $this->db->execute();
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * delete account
     */
    public function deleteUser(string $user_id): bool
    {
        try {
            $this->db->query("DELETE FROM users WHERE user_id=:user_id");
            $this->db->bind('user_id',$user_id);
            return $this->db->execute();
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

}

?>