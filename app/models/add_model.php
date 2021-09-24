<?php

class Add_model{
    public $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Category check
     */
    public function categoryCheck(string $userid,string $category_name): bool
    {
        try {
            $this->db->query("SELECT * FROM categories WHERE category_name = :category_name AND created_by = :userid");
            $this->db->bind('userid'       ,$userid);
            $this->db->bind('category_name',strtolower(trim($category_name)));
            
            if($this->db->singleResult()){
                return true;
            }
            else{
                return false;
            }
        }
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * Add Category
     */
    public function addCategory(string $userid,array $data): bool
    {
        try {
            // check category
            $isExist = $this->categoryCheck($userid,$data['category_name']);

            if(!$isExist){    
                $this->db->query("INSERT INTO categories(category_name,created_by) VALUES(:category_name,:userid)");
                $this->db->bind('userid'       ,$userid);
                $this->db->bind('category_name',strtolower(trim($data['category_name'])));
                return $this->db->execute();
            }
            else{
                Utility::response(400,"'".$data['category_name']."' is exist");
            }
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * Add Testimony
     */
    public function addTestimony(string $userid,array $data): bool
    {
        try {
            $this->db->query("INSERT INTO testimonies(img,img_type,created_by) VALUES(:img,:img_type,:user_id)");
            
            $img_testi = fopen($data['tmp_name'], 'rb');
            $this->db->bind('user_id' ,$userid);
            $this->db->bind('img'     ,$img_testi,PDO::PARAM_LOB);
            $this->db->bind('img_type',$data['img_type']);
            
            return $this->db->execute();
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * Add Banner
     */
    public function addBanner(string $userid,array $data): bool
    {
        try {
            $this->db->query("INSERT INTO banners(img_desktop,img_desktop_type,img_mobile,img_mobile_type,created_by) VALUES(:desktop,:type_banner_desktop,:mobile,:type_banner_mobile,:user_id)");

            $img_desktop = fopen($data['tmp_banner_desktop'], 'rb');
            $img_mobile  = fopen($data['tmp_banner_mobile'] , 'rb');
            $this->db->bind('user_id',            $userid);
            $this->db->bind('desktop',            $img_desktop,PDO::PARAM_LOB);
            $this->db->bind('mobile' ,            $img_mobile ,PDO::PARAM_LOB);
            $this->db->bind('type_banner_desktop',$data['type_banner_desktop']);
            $this->db->bind('type_banner_mobile' ,$data['type_banner_mobile']);
            
            return $this->db->execute();
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * IS PRODUCT EXIST?
     */
    public function isProductExist(string $userid,string $searchBy,array $data): array
    {
        try {
            $this->db->query("SELECT * FROM products WHERE $searchBy=:searchVal AND created_by=:user_id");
            $this->db->bind('user_id',$userid);
            
            if($searchBy === 'name'){
                $searchVal = $data['product_name'];
                $this->db->bind('searchVal',strtolower($searchVal));
            }
            if($searchBy === 'id'){
                $searchVal = $data['product_id'];
                $this->db->bind('searchVal',strtolower($searchVal));
            }

            if($this->db->singleResult()){
                return [
                    'status' => true,
                    'data'   => $this->db->singleResult(),
                ];
            }
            else{
                return [
                    'status' => false,
                    'data'   => 'notfound',
                ];
            }
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * Add Product
     */
    public function addProduct(string $userid,array $data): bool
    {
        try {
            $this->db->query("INSERT INTO products(name,price,kategori,keyword,img,img_type,deskripsi,linktp,linksp,linklz,linkwa,created_by) VALUES(:name,:price,:kategori,:keyword,:img,:img_type,:deskripsi,:linktp,:linksp,:linklz,:linkwa,:user_id)");

            $product_img = fopen($data['tmp_product_img'], 'rb');
            $this->db->bind('user_id'  ,$userid);
            $this->db->bind('name'     ,trim($data['product_name']));
            $this->db->bind('price'    ,$data['price']);
            $this->db->bind('kategori' ,trim(strtolower($data['kategori'])));
            $this->db->bind('keyword'  ,trim(strtolower($data['keyword'])));
            $this->db->bind('img'      ,$product_img,PDO::PARAM_LOB);
            $this->db->bind('img_type' ,$data['type_product_img']);
            $this->db->bind('deskripsi',trim($data['deskripsi']));
            $this->db->bind('linktp'   ,trim($data['linktp']));
            $this->db->bind('linksp'   ,trim($data['linksp']));
            $this->db->bind('linklz'   ,trim($data['linklz']));
            $this->db->bind('linkwa'   ,trim($data['linkwa']));
            
            return $this->db->execute();
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

}

?>