<?php

class Delete extends BaseController{

    public string $user_id;
    public string $target_id;

    public function __construct()
    {
        Utility::reqMethodCheck('DELETE');
        $this->user_id   = Utility::sessionCheck()['user_id'];
        $this->target_id = (!isset($_GET['id'])) ? Utility::response(400,"missing parameter 'id'") : $_GET['id'];
    }
    
    /**
     * Delete Category
     */
    public function category(): void
    {
        $this->model("delete_model")->deleteCategory($this->target_id,$this->user_id);
    }

    /**
     * Delete Testimony
     */
    public function testimony(): void
    {
        $this->model("delete_model")->deleteTesti($this->target_id,$this->user_id);
    }

    /**
     * Delete Banner
     */
    public function banner(): void
    {
        $this->model("delete_model")->deleteBanner($this->target_id,$this->user_id);
    }

    /**
     * Delete Product
     */
    public function product(): void
    {
        $this->model("delete_model")->deleteProduct($this->target_id,$this->user_id);
    }
}

?>