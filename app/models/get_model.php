<?php

class Get_model{
    public $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }

    /** 
     * Get Socialmedia
    */
    public function getSocialMedia(string $user_id): void
    {
        try{
            $this->db->query("SELECT * FROM link_sosmed WHERE created_by = :user_id");
            $this->db->bind("user_id",$user_id);
            
            if(!$this->db->singleResult()){
                Utility::response(404,"data not found!. please, update your social media link");
            }
            else{
                Utility::response(200,$this->db->singleResult());
            }
        }
        catch(Exception $err){
            Utility::response(500,$err->getMessage());
        }
    }

    /** 
     * Get Countdown
    */
    public function getCountDown(string $user_id): void
    {
        try{
            $this->db->query("SELECT * FROM countdown WHERE created_by = :user_id");
            $this->db->bind("user_id",$user_id);
            $result = $this->db->singleResult();
            
            if(!$result){
                Utility::response(404,"data not found!. please, update your countdown data");
            }
            else{
                foreach ($result as $key => $res) {
                    if($key == "poster"){
                        $result[$key] = "data:".$result['poster_type'].";base64, ".base64_encode($res);
                    }
                }

                Utility::response(200,$result);
            }
        }
        catch(Exception $err){
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * Get Categories
     */
    public function getCategories(string $user_id): void
    {
        try{
            $this->db->query("SELECT * FROM categories WHERE created_by = :user_id ORDER BY id DESC");
            $this->db->bind("user_id",$user_id);
            
            if(!$this->db->multiResult()){
                Utility::response(404,"data not found!. please, insert your categories");
            }
            else{
                Utility::response(200,$this->db->multiResult());
            }
        }
        catch(Exception $err){
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * Get Keywords
     */
    public function getKeywords(string $user_id): void
    {
        try{
            $this->db->query("SELECT DISTINCT keyword FROM products WHERE created_by = :user_id");
            $this->db->bind("user_id",$user_id);
            
            if(!$this->db->multiResult()){
                Utility::response(404,"data not found!. please, insert your products");
            }
            else{
                Utility::response(200,$this->db->multiResult());
            }
        }
        catch(Exception $err){
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * Get Testimonies
     */
    public function getTestimonies(string $user_id): void
    {
        try{
            $this->db->query("SELECT * FROM testimonies WHERE created_by = :user_id ORDER BY id DESC");
            $this->db->bind("user_id",$user_id);
            $arrays = $this->db->multiResult();
            $result = [];

            if(!$arrays){
                Utility::response(404,"data not found!. please, insert your testimonies");
            }
            else{
                foreach ($arrays as $array) {
                    foreach ($array as $key => $value) {
                        if($key === 'img'){
                            $array[$key] = "data:".$array['img_type'].";base64, ".base64_encode($value);
                            $result[]    = $array; 
                        }
                        
                    }
                }

                Utility::response(200,$result);
            }
        }
        catch(Exception $err){
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * Get Banners
     */
    public function getBanners(string $user_id): void
    {
        try{
            $this->db->query("SELECT * FROM banners WHERE created_by = :user_id ORDER BY id DESC");
            $this->db->bind("user_id",$user_id);
            $arrays = $this->db->multiResult();
            $result = [];

            if(!$arrays){
                Utility::response(404,"data not found! please, insert your banners");
            }
            else{
                foreach ($arrays as $array) {
                    foreach ($array as $key => $r) {
                        if($key == "img_desktop"){
                            $array[$key] = "data:".$array['img_desktop_type'].";base64, ".base64_encode($r);
                        }
                        if($key == "img_mobile"){
                            $array[$key] = "data:".$array['img_mobile_type'].";base64, ".base64_encode($r);
                            $result[]    = $array;
                        }
                    }
                }
                
                Utility::response(200,$result);
            }
        }
        catch(Exception $err){
            Utility::response(500,$err->getMessage());
        }
    }

    /** 
     * Get Statistics
    */
    public function getStatistics(string $user_id): void
    {
        try{
            // select visitor's value
            $this->db->query("SELECT ourwebsite,tokopedia,shopee,lazada,whatsapp FROM visitors WHERE created_by=:user_id");
            $this->db->bind("user_id",$user_id);
            $result = $this->db->singleResult();
            
            // select total product
            $this->db->query("SELECT count(*) AS all_product FROM products WHERE created_by=:user_id");
            $this->db->bind("user_id",$user_id);
            $result['all_product'] = $this->db->singleResult()['all_product'];

            Utility::response(200,$result);
        }
        catch(Exception $err){
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * PRODUCTS
     */
    public function getProducts(array $dataFilter): void
    {
        try{
            if (isset($dataFilter['limit'])) {
                if (isset($dataFilter['filterBy'])) {
                    $filterBy  = $dataFilter['filterBy'];
                    $filterVal = $dataFilter['filterVal'];

                    if ($filterBy == 'keyword') {
                        $this->db->query("SELECT * FROM products WHERE $filterBy LIKE :filterVal AND created_by = :user_id ORDER BY id DESC LIMIT :offset,:limitt");
                        $this->db->bind("filterVal","%$filterVal%");
                    } else {
                        $this->db->query("SELECT * FROM products WHERE $filterBy = :filterVal AND created_by = :user_id ORDER BY id DESC LIMIT :offset,:limitt");
                        $this->db->bind("filterVal",$filterVal);
                    }
                }
                else{
                    $this->db->query("SELECT * FROM products WHERE created_by = :user_id ORDER BY id DESC LIMIT :offset,:limitt");
                }

                $this->db->bind("user_id",$dataFilter['user_id']);
                $this->db->bind("offset" ,(int)$dataFilter['offset']);
                $this->db->bind("limitt" ,(int)$dataFilter['limit']);
            }
            if (!isset($dataFilter['limit'])){
                if(isset($dataFilter['id'])){
                    $this->db->query("SELECT * FROM products WHERE id = :id AND created_by = :user_id");
                    $this->db->bind("id",$dataFilter['id']);
                }
                else{
                    if(isset($dataFilter['kategori'])){
                        $this->db->query("SELECT * FROM products WHERE kategori = :kategori AND created_by = :user_id ORDER BY id DESC");
                        $this->db->bind("kategori",$dataFilter['kategori']);
                    }
                    else{
                        if(isset($dataFilter['keyword'])){
                            $keyword = $dataFilter['keyword'];

                            $this->db->query("SELECT * FROM products WHERE keyword LIKE :keyword AND created_by = :user_id ORDER BY id DESC");
                            $this->db->bind("keyword","%$keyword%");
                        }
                        else{
                            $this->db->query("SELECT * FROM products WHERE created_by = :user_id ORDER BY id DESC");
                        }
                    }
                }

                $this->db->bind("user_id",$dataFilter['user_id']);
            }
    
            $arrays = $this->db->multiResult();
            $result = [];

            if(!$arrays){
                Utility::response(404,"product not found!");
            }
            else{
                foreach ($arrays as $array) {
                    foreach ($array as $key => $r) {
                        if($key == "img"){
                            $array[$key] = "data:".$array['img_type'].";base64, ".base64_encode($r);
                            $result[]    = $array;
                        }
                    }
                }
                
                Utility::response(200,$result);
            }
        }
        catch(Exception $err){
            Utility::response(500,$err->getMessage());
        }
    }

}

?>