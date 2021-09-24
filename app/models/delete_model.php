<?php

class Delete_model{
    public $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Delete Category
     */
    public function deleteCategory(string $id,string $user_id): void
    {
        try {
            $this->db->query("DELETE FROM categories WHERE id = :id AND created_by=:user_id");
            $this->db->bind('id',$id);
            $this->db->bind('user_id',$user_id);
            $this->db->execute();

            if($this->db->rowCount() > 0){
                Utility::response(201,"delete categoriy with id '$id' is success!");
            }
            else{
                Utility::response(404,"categoriy with id '$id' is not found");
            }
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * Delete Testimony
     */
    public function deleteTesti(string $id,string $user_id): void
    {
        try {
            $this->db->query("DELETE FROM testimonies WHERE id = :id AND created_by=:user_id");
            $this->db->bind('id',$id);
            $this->db->bind('user_id',$user_id);
            $this->db->execute();

            if($this->db->rowCount() > 0){
                Utility::response(201,"delete testimoni with id '$id' is success!");
            }
            else{
                Utility::response(404,"testimoni with id '$id' is not found");
            }
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * Delete Banner
     */
    public function deleteBanner(string $id,string $user_id): void
    {
        try {
            $this->db->query("DELETE FROM banners WHERE id = :id AND created_by=:user_id");
            $this->db->bind('id',$id);
            $this->db->bind('user_id',$user_id);
            $this->db->execute();

            if($this->db->rowCount() > 0){
                Utility::response(201,"delete banner with id '$id' is success!");
            }
            else{
                Utility::response(404,"banner with id '$id' is not found");
            }
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * Delete Product
     */
    public function deleteProduct(string $id,string $user_id): void
    {
        try {
            $this->db->query("DELETE FROM products WHERE id = :id AND created_by=:user_id");
            $this->db->bind('id',$id);
            $this->db->bind('user_id',$user_id);
            $this->db->execute();

            if($this->db->rowCount() > 0){
                Utility::response(201,"delete product with id '$id' is success!");
            }
            else{
                Utility::response(404,"product with id '$id' is not found");
            }
        } 
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }
}

?>