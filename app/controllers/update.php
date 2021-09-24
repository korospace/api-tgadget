<?php

class Update extends BaseController{

    public $validator;
    public string $user_id;

    public function __construct()
    {
        Utility::reqMethodCheck('PUT');
        $this->user_id   = Utility::sessionCheck()['user_id'];
        $this->validator = new Rakit\Validation\Validator([
            // custom message
            'required' => ':attribute is required',
            'min'      => ':attribute min :min char',
            'max'      => ':attribute max :max char',
        ]);;
    }
    
    /**
     * Edit Socialmedia link
     */
    public function socialmedia(): void
    {
        Utility::_methodParser('_PUT');
        global $_PUT;

        $validation = $this->validator->make($_PUT, [
            'link_tokopedia'  => 'required|max:250',
            'link_shopee'     => 'required|max:250',
            'link_lazada'     => 'required|max:250',
            'link_whatsapp'   => 'required|max:250',
            'link_ourwebsite' => 'required|max:250',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            Utility::response(400,$validation->errors()->firstOfAll());
        }

        $this->model('update_model')->updateSocialmedia($this->user_id,$_PUT);
    }

    /**
     * Edit Countdown
     */
    public function countdown(): void
    {
        Utility::_methodParser('_PUT');
        global $_PUT;

        // var_dump($_FILES);die;
        $validation = $this->validator->validate($_PUT, [
            'day'  => 'required|min:2|max:2',
            'month'=> 'required|min:2|max:2',
            'year' => 'required|min:4|max:4',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            Utility::response(400,$validation->errors()->firstOfAll());
        }

        // check number 
        $validation = [];
        (!Utility::numChecker($_PUT['day']))  ? $validation['day']   = "must integer"  : '';
        (!Utility::numChecker($_PUT['month']))? $validation['month'] = "must integer"  : '';
        (!Utility::numChecker($_PUT['year'])) ? $validation['year']  = "must integer"  : '';
        (!empty($validation)) ? Utility::response(400,$validation) : '';
        
        // if user upload new poster
        if(isset($_FILES['poster'])){
            Utility::imgChecker($_FILES);
            $_PUT['tmp_poster']  = $_FILES['poster']['tmp_name'];
            $_PUT['type_poster'] = $_FILES['poster']['type'];
        }

        $this->model("update_model")->updateCountdown($this->user_id,$_PUT);
    }

    /**
     * Edit Product
     */
    public function product(): void
    {
        Utility::_methodParser('_PUT');
        global $_PUT;

        $validation = $this->validator->make($_PUT, [
            'product_id'   => 'required',
            'product_name' => 'required|max:250',
            'price'        => 'required|max:11',
            'kategori'     => 'required|max:20',
            'keyword'      => 'required|max:200',
            'deskripsi'    => 'required|max:1000',
            'linktp'       => 'required|max:200',
            'linksp'       => 'required|max:200',
            'linklz'       => 'required|max:200',
            'linkwa'       => 'required|max:200',
            'stock'        => 'required|max:1',
        ]);
        
        $validation->validate();

        if ($validation->fails()) {
            Utility::response(400,$validation->errors()->firstOfAll());
        }

        $validation = [];
        $idCheck        = $this->model("add_model")->isProductExist($this->user_id,'id',$_PUT);
        $categoryCheck  = $this->model("add_model")->categoryCheck($this->user_id,$_PUT['kategori']);
        
        // check product ID
        if ($idCheck['status'] == false) {
            Utility::response(404,'product with id '.$_PUT['product_id'].' is not found');
        }
        // check product name
        if ($_PUT['product_name'] != $idCheck['data']['name']) {
            $nameCheck  = $this->model("add_model")->isProductExist($this->user_id,'name',$_PUT);
            
            if (($nameCheck['status'] == true)) {
                $validation['product_name'] = "Product name is exist";
            }
        }
        if (!$categoryCheck) {
            $validation['kategori'] = "kategori not found";
        }
        
        (!Utility::numChecker($_PUT['price'])) ? $validation['price'] = "must integer" : '';
        (!in_array($_PUT['stock'],['1','0']))  ? $validation['stock'] = "must 1 or 0"  : '';
        (!empty($validation)) ? Utility::response(400,$validation) : '';

        if(isset($_FILES['product_img'])){
            Utility::imgChecker($_FILES);
            $_PUT['tmp_product_img']  = $_FILES['product_img']['tmp_name'];
            $_PUT['type_product_img'] = $_FILES['product_img']['type'];
        }

        (!empty($validation)) ? Utility::response(400,$validation) : '';

        $this->model("update_model")->updateProduct($this->user_id,$_PUT);
    }

    /**
     * STATISTIC
     * 
     * method   : PUT
     * endpoint : yourwebsite.com/update/statistics
     * 
     * authentication:
     *  - header= x-api
     * 
     */
    public function statistic(): void
    {
        $user_id = Utility::apiKeyCheck()['user_id'];
        Utility::_methodParser('_PUT');
        global $_PUT;

        if(isset($_PUT['id'])){
            if(strlen($_PUT['id']) == 0){
                Utility::response(400,"parameter 'id' is empty");
            }    
        }

        if(isset($_PUT['column'])){
            if(strlen($_PUT['column']) == 0){
                Utility::response(400,"parameter 'column' is empty");
            }
        }

        if(isset($_PUT['id']) || isset($_PUT['column'])){
            $id       = (isset($_PUT['id']))     ? $_PUT['id'] : null;
            $column   = (isset($_PUT['column'])) ? $_PUT['column'] : null;
            $this->model('update_model')->updateStatistic($column,$id,$user_id);
        }
        else{
            Utility::response(400,"missing parameter 'id' or 'column'!");
        }
    }
}

?>