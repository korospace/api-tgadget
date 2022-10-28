<?php

class Get extends BaseController{     
    
    public string $user_id;

    public function __construct()
    {
        Utility::reqMethodCheck('GET');
        $this->user_id = Utility::apiKeyCheck()['user_id'];
    }

    /**
     * Get Socialmedia
     */
    public function socialMedia(): void
    {
        $this->model('get_model')->getSocialMedia($this->user_id);
    }
    
    /**
     * Get Countdown
     */
    public function countDown(): void
    {
        $this->model('get_model')->getCountDown($this->user_id);
    }

    /**
     * Get Categories
     */
    public function categories(): void
    {
        $this->model('get_model')->getCategories($this->user_id);
    }

    /**
     * Get Keywords
     */
    public function keywords(): void
    {
        $this->model('get_model')->getKeywords($this->user_id);
    }

    /**
     * Get Testimonies
     */
    public function testimonies(): void
    {
        $this->model('get_model')->getTestimonies($this->user_id);
    }

    /**
     * Get Banners
     */
    public function banners(): void
    {
        $this->model('get_model')->getBanners($this->user_id);
    }

    /**
     * Get Statistics
     */
    public function statistics(): void
    {
        $this->model('get_model')->getStatistics($this->user_id);
    }

    /**
     * Get Products
     */
    public function products(): void
    {
        $dataFilter = [
            'user_id' => $this->user_id
        ];

        // query param check
        foreach ($_GET as $key => $value) {
            if(!in_array($key,["url","id","limit","offset","kategori","keyword"])){
                Utility::response(400,"invalid parameter '$key'");
            }
            if(strlen($value) == 0){
                Utility::response(400,"parameter '$key' is empty");
            }
        }

        if(isset($_GET['limit'])){
            if (!isset($_GET['offset'])) {
                Utility::response(400,"missing parameter offset");
            }

            $dataFilter['limit']  = $_GET['limit'];
            $dataFilter['offset'] = $_GET['offset'];
            
            if(isset($_GET['filterBy'])){
                if (!isset($_GET['filterVal'])) {
                    Utility::response(400,"missing parameter 'filterVal'!");
                }
                if(!in_array($_GET['filterBy'],["kategori","keyword"])){
                    Utility::response(400,"undifined filterBy ".$_GET['filterBy']."!");
                }

                $dataFilter['filterBy']  = $_GET['filterBy'];
                $dataFilter['filterVal'] = $_GET['filterVal'];
            }
            
            $this->model('get_model')->getProducts($dataFilter);
        }
        else if(isset($_GET['id'])){
            $dataFilter['id']  = $_GET['id'];
            $this->model('get_model')->getProducts($dataFilter);
        }
        else if(isset($_GET['kategori'])){
            $dataFilter['kategori']  = $_GET['kategori'];
            $this->model('get_model')->getProducts($dataFilter);
        }
        else if(isset($_GET['keyword'])){
            $dataFilter['keyword']  = $_GET['keyword'];
            $this->model('get_model')->getProducts($dataFilter);
        }
        else{
            $this->model('get_model')->getProducts($dataFilter);
        }   
    }
}

?>