<?php

class Add extends BaseController{

    public $validator;
    public string $user_id;

    public function __construct()
    {
        Utility::reqMethodCheck('POST');
        $this->user_id   = Utility::sessionCheck()['user_id'];
        $this->validator = new Rakit\Validation\Validator([
            // custom message
            'required' => ':attribute is required',
            'min'      => ':attribute min :min char',
            'max'      => ':attribute max :max char',
        ]);;
    }
    
    /**
     * Add Category
     */
    public function category(): void
    {
        $validation = $this->validator->make($_POST, [
            'category_name' => 'required|max:20',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            Utility::response(400,$validation->errors()->firstOfAll());
        }

        $dbResponse    = $this->model("add_model")->addCategory($this->user_id,$_POST);

        if($dbResponse === true){
            Utility::response(201,"add category is success!");
        }
    }

    /**
     * Add Testimony
     */
    public function testimony(): void
    {
        $validation = $this->validator->make($_FILES, [
            'img_testi' => 'required|uploaded_file:0,200K,webp,png,jpeg',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            Utility::response(400,$validation->errors()->firstOfAll());
        }
        
        $data['tmp_name'] = $_FILES['img_testi']['tmp_name'];
        $data['img_type'] = $_FILES['img_testi']['type'];
        
        $dbResponse    = $this->model("add_model")->addTestimony($this->user_id,$data);

        if($dbResponse === true){
            Utility::response(201,"add category is success");
        }
    }

    /**
     * Add Banner
     */
    public function banner(): void
    {   
        $validation = $this->validator->make($_FILES, [
            'banner_desktop' => 'required|uploaded_file:0,200K,webp,png,jpeg',
            'banner_mobile'  => 'required|uploaded_file:0,200K,webp,png,jpeg',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            Utility::response(400,$validation->errors()->firstOfAll());
        }

        // get tmp_name
        foreach ($_FILES as $key1 => $values) {
            foreach ($values as $value) {
                $data["tmp_".$key1]  = $values['tmp_name'];
                $data["type_".$key1] = $values['type'];
            }
        }

        $dbResponse    = $this->model("add_model")->addBanner($this->user_id,$data);
        
        if($dbResponse === true){
            Utility::response(201,"add banner is success");
        }
    }

    /**
     * Add Product
     */
    public function product(): void
    {
        $validation = $this->validator->make($_POST + $_FILES, [
            'product_name' => 'required|max:250',
            'price'        => 'required|numeric|max:11',
            'kategori'     => 'required|max:20',
            'keyword'      => 'required|max:200',
            'deskripsi'    => 'required|max:1000',
            'linktp'       => 'required|max:200',
            'linksp'       => 'required|max:200',
            'linklz'       => 'required|max:200',
            'linkwa'       => 'required|max:200',
            'product_img'  => 'required|uploaded_file:0,200K,webp,png,jpeg',

        ]);
        
        $validation->validate();

        if ($validation->fails()) {
            Utility::response(400,$validation->errors()->firstOfAll());
        }
        
        $isExist        = [];
        $nameCheck      = $this->model("add_model")->isProductExist($this->user_id,'name',$_POST);
        $categoryCheck  = $this->model("add_model")->categoryCheck($this->user_id,$_POST['kategori']);

        if($nameCheck['status'] == true){
            $isExist['product_name'] = "Product name is exist";
        }
        if(!$categoryCheck){
            $isExist['kategori']     = "kategori not found";
        }
        if(!empty($isExist)){
            Utility::response(400,$isExist);
        }

        // get tmp file
        $_POST['tmp_product_img']  = $_FILES['product_img']['tmp_name'];
        $_POST['type_product_img'] = $_FILES['product_img']['type'];
        
        $dbResponse    = $this->model("add_model")->addProduct($this->user_id,$_POST);

        if($dbResponse === true){
            Utility::response(201,"add product is success");
        }
    }
}

?>