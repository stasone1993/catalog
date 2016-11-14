<?php

include_once './config.php';

class Items {

    protected $pic;
    protected $name;
    protected $price;
    protected $description;
    protected $db;

    const AVAILABLE_TYPES = array(
        "image/jpeg",
        "image/jpg",
        "image/png",
    );
    const IMG_SIZE = 2 * 1024 * 1024;
    const UPLOAD_DIR = 'photos';

    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'catalogs');
    }

    public function validate() {
        $name = filter_input(INPUT_POST, 'name');
        $price = filter_input(INPUT_POST, 'price');
        $description = filter_input(INPUT_POST, 'description');
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
        $name = filter_input(INPUT_POST, 'name');
        $price = filter_input(INPUT_POST, 'price');
        $description = filter_input(INPUT_POST, 'description');
        $file = $_FILES['photo'];
        $file_name_parts = explode(".", $file['name']);
        $file_extention = array_pop($file_name_parts);
        $file_base_name = implode("", $file_name_parts);
        $file_name = md5($file_base_name . rand(1, getrandmax()));
        $file_name .= '.' . $file_extention;
        $path = self::UPLOAD_DIR . '/' . $file_name;
        move_uploaded_file($file['tmp_name'], $path);
        if (!empty($name) && !empty($description) && !empty($price) && !empty($path)) {
            $query = "INSERT INTO shops (name, description, price, img) VALUES('$name','$description','$price','$path')";
            if ($this->db->query($query)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function Show() {
        $query = "SELECT * FROM shops";
        $items = '';
        if ($this->db->query($query)) {
            foreach ($this->db->query($query) as $row) {
                $items[] = array(
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'description' => $row['deswcription'],
                    'img' => $row['img'],
                );
                header('Content-Type: application/json');
                echo json_encode($items);
            }
        } else {
            return false;
        }
    }

}

$additems = new Items();
if ($additems->validate()) {
    $additems->upload();
    return true;
}
var_dump($additems->Show());