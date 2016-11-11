<?php
include_once './config.php';

class Items {

    protected $pic;
    protected $name;
    protected $price;
    protected $description;

    const AVAILABLE_TYPES = array(
        "image/jpeg",
        "image/jpg",
        "image/png",
    );
    const IMG_SIZE = 2 * 1024 * 1024;
    const UPLOAD_DIR = 'photos';

    public function validate() {
        $name=  filter_input(INPUT_POST, 'name');
        $price=  filter_input(INPUT_POST, 'price');
        $description=  filter_input(INPUT_POST, 'description');
        $file = $_FILES['photo'];
        if (empty($_FILES['photo']) && empty($name) && empty($price) && empty($description)) {
            return FALSE;
        } else if (!in_array($file['type'], self::AVAILABLE_TYPES)) {
            return FALSE;
        } else if ($file['size'] > self::IMG_SIZE) {
            return false;
        }
        return TRUE;
    }

    public function upload() {
        $name=  filter_input(INPUT_POST, 'name');
        $price=  filter_input(INPUT_POST, 'price');
        $description=  filter_input(INPUT_POST, 'description');
        $file = $_FILES['img'];
        $file_name_parts = explode(".", $file['name']);
        $file_extention = array_pop($file_name_parts);
        $file_base_name = implode("", $file_name_parts);
        $file_name = md5($file_base_name . rand(1, getrandmax()));
        $file_name .= '.' . $file_extention;
        $this->pic = self::UPLOAD_DIR . '/' . $file_name;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        if (move_uploaded_file($file['tmp_name'], $this->pic)){
            return $this->pic;
            return $this->name;
            return $this->price;
            return $this->description;
            
        }
        
    }

    public function addToDB() {
        if ($this->data) {
            $query = "INSERT INTO catalogs (name,description,price,img) VALUES";
            $query.="('{$this->name}','{$this->price}', '{$this->description}', '{$this->pic}')";
            $result = $mysqli->query($query);
        }
    }
}



$vi = new Items();
if ($vi->validate()) {
    $pu->upload()->addToDB();
}

