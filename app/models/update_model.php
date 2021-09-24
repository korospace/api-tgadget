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
     * STATISTIK - current value
     */
    public function currentValue(string $column1,string $table,string $column2,string $value,string $user_id)
    : array
    {
        try {
            $this->db->query("SELECT $column1 FROM $table WHERE $column2 = :value AND created_by = :user_id");
            $this->db->bind('user_id',$user_id);
            $this->db->bind('value',$value);
            return $this->db->singleResult();
        } 
        catch (Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * STATISTIK - update
     */
    public function updateStatistic(?string $atribut = null,?string $id = null,string $user_id): void
    {
        // .. column viewers in table products
        if($id != null && $atribut != null){
            try {
                $this->db->query("UPDATE products SET $atribut=$atribut+1 WHERE id=:id AND created_by=:user_id");
                $this->db->bind('id',     $id);
                $this->db->bind('user_id',$user_id);
                $this->db->execute();

                if($this->db->rowCount()){
                    Utility::response(201,[
                        'table'  => 'products',
                        'column' => $atribut,
                        'current_value' => $this->currentValue($atribut,'products','id',$id,$user_id)[$atribut]
                    ]);
                }
                else{
                    Utility::response(404,"'$atribut' with product id '$id' not found !");
                }
            } 
            catch (Exception $err) {
                Utility::response(500,$err->getMessage());
            }
        }
        // .. column viewers in table products
        if($id != null){
            try {
                $this->db->query("UPDATE products SET viewers = viewers+1 WHERE id=:id AND created_by=:user_id");
                $this->db->bind('id',$id);
                $this->db->bind('user_id',$user_id);
                $this->db->execute();

                if($this->db->rowCount()){
                    Utility::response(201,[
                        'table'  => 'products',
                        'column' => 'viewers',
                        'current_value' => $this->currentValue("viewers",'products','id',$id,$user_id)["viewers"]
                    ]);
                }
                else{
                    Utility::response(404,"product with id '$id' not found !");
                }
            } 
            catch (Exception $err) {
                Utility::response(500,$err->getMessage());
            }
        }
        // .. table visitors
        if($atribut != null){
            try {
                $this->db->query("UPDATE visitors SET $atribut = $atribut+1 WHERE created_by=:user_id");
                $this->db->bind('user_id',$user_id);
                
                if($this->db->execute()){
                    Utility::response(201,[
                        'table'  => 'visitors',
                        'column' => $atribut,
                        'current_value' => $this->currentValue($atribut,'visitors','created_by',$user_id,$user_id)[$atribut]
                    ]);
                }
                else{
                    Utility::response(404,"atribut with name '$atribut' not found !");
                }
            } 
            catch (Exception $err) {
                Utility::response(500,$err->getMessage());
            }
        }
    }

}

?>