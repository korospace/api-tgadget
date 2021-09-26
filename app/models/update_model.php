<?php

class Update_model{
    public $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * SOCIALMEDIA - update
     */
    public function updateSocialmedia(string $userid,array $put): void
    {
        // var_dump($userid,$put);die;
        
        try {
            $this->db->query("UPDATE link_sosmed SET tokopedia = :tokopedia,shopee = :shopee,lazada = :lazada,whatsapp = :whatsapp,ourwebsite = :ourwebsite WHERE created_by=:id");
            $this->db->bind('id'        ,$userid);
            $this->db->bind('tokopedia' ,trim($put['link_tokopedia']));
            $this->db->bind('shopee'    ,trim($put['link_shopee']));
            $this->db->bind('lazada'    ,trim($put['link_lazada']));
            $this->db->bind('whatsapp'  ,trim($put['link_whatsapp']));
            $this->db->bind('ourwebsite',trim($put['link_ourwebsite']));
            $this->db->execute();

            if($this->db->rowCount() > 0){
                Utility::response(201,"update socialmedia is success");
            }
            else{
                Utility::response(201,"no data updated");
            }
        } 
        catch (Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * COUNTDOWN - update data
     */
    public function updateCountdown(string $userid,array $data): void
    {
        try {
            if(isset($data['tmp_poster'])){
                $this->db->query("UPDATE countdown SET day = :day,month = :month,year = :year,poster = :poster,poster_type = :type_poster WHERE created_by = :user_id");

                $tmp_poster = fopen($data['tmp_poster'], 'rb');
                $this->db->bind('poster'     ,$tmp_poster,PDO::PARAM_LOB);
                $this->db->bind('type_poster',trim($data['type_poster']));
            }
            else{
                $this->db->query("UPDATE countdown SET day = :day,month = :month,year = :year WHERE created_by = :user_id");
            }

            $this->db->bind('day'    ,$data['day']);
            $this->db->bind('month'  ,$data['month']);
            $this->db->bind('year'   ,$data['year']);
            $this->db->bind('user_id',$userid);

            $this->db->execute();

            if($this->db->rowCount() > 0){
                Utility::response(201,"update countdown is success");
            }
            else{
                Utility::response(201,"no data updated");
            }
        } 
        catch (Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * Update product 
     */
    public function updateProduct(string $userid,array $data): void
    {
        try {
            if(isset($data['tmp_product_img'])){
                $this->db->query("UPDATE products SET name=:name,price=:price,kategori=:kategori,keyword=:keyword,img=:img,img_type=:img_type,deskripsi=:deskripsi,linktp=:linktp,linksp=:linksp,linklz=:linklz,linkwa=:linkwa,stock=:stock WHERE id=:id AND created_by=:user_id");

                $tmp_product_img = fopen($data['tmp_product_img'], 'rb');
                $this->db->bind('img'     ,$tmp_product_img,PDO::PARAM_LOB);
                $this->db->bind('img_type',preg_replace('/\s+/', '', $data['type_product_img']));
            }
            else{
                $this->db->query("UPDATE products SET name=:name,price=:price,kategori=:kategori,keyword=:keyword,deskripsi=:deskripsi,linktp=:linktp,linksp=:linksp,linklz=:linklz,linkwa=:linkwa,stock=:stock WHERE id=:id AND created_by=:user_id");
            }

            $this->db->bind('user_id'  ,$userid);
            $this->db->bind('id'       ,$data['product_id']);
            $this->db->bind('name'     ,trim(strtolower($data['product_name'])));
            $this->db->bind('price'    ,$data['price']);
            $this->db->bind('kategori' ,trim(strtolower($data['kategori'])));
            $this->db->bind('keyword'  ,trim(strtolower($data['keyword'])));
            $this->db->bind('deskripsi',trim($data['deskripsi']));
            $this->db->bind('linktp'   ,trim($data['linktp']));
            $this->db->bind('linksp'   ,trim($data['linksp']));
            $this->db->bind('linklz'   ,trim($data['linklz']));
            $this->db->bind('linkwa'   ,trim($data['linkwa']));
            $this->db->bind('stock'    ,trim($data['stock']));

            $this->db->execute();
            if($this->db->rowCount() > 0){
                Utility::response(201,"update product with id ".$data['product_id']." is success!");
            }
            else{
                Utility::response(201,"no data updated for product with id ".$data['product_id']);
            }
        } 
        catch (Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * Update statistics
     */
    public function updateStatistic(string $userid,array $get): void
    {
        try {
            // update product viewers
            if (isset($get['productid']) && !isset($get['storename'])) {
                $productid   = $get['productid'];
                $successMsg  = "success update product viewers with id $productid";
                $failedMsg   = "product viewers with id $productid not found";
    
                $this->db->query("UPDATE products SET viewers=viewers+1 WHERE id=:productid AND created_by=:userid");
                $this->db->bind('productid',$productid);
            }
            // update visitors
            else if (isset($get['storename']) && !isset($get['productid'])) {
                $column      = $get['storename'];
                $successMsg  = "success update $column visitors";
    
                $this->db->query("UPDATE visitors SET $column=$column+1 WHERE created_by=:userid");
            }
            // update product link visitors
            else if (isset($get['productid']) && isset($get['storename'])) {
                $productid   = $get['productid'];
                $column      = $get['storename'];
                $successMsg  = "success update $column visitors with product id $productid";
                $failedMsg   = "$column visitors with product id $productid not found";
    
                $this->db->query("UPDATE products SET $column=$column+1 WHERE id=:productid AND created_by=:userid");
                $this->db->bind('productid',$productid);
            }
            else {
                Utility::response(404,"parameter not match");
            }
            
            $this->db->bind('userid',$userid);
            $this->db->execute();

            if($this->db->rowCount() > 0 ){
                Utility::response(201,$successMsg);
            }
            else {
                Utility::response(404,$failedMsg);
            }
        } 
        catch (Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

}

?>