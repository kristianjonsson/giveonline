<?php
class Product
{
    public $id;
    public $title;
    public $content;
    public $image;
    public $price;
    public $isDeleted;
    public $arrFormElements;
    public $arrLabels;

    public function __construct()
    {
        global $db;
        $this->db = $db;
                // Friendly names labels
                $this->arrLabels = array(
                    "id" => "id",
                    "name" => "Product Name",
                    "description" => "Description"
                );
        $this->arrFormElements = array(
            "id" => array("hidden", FILTER_VALIDATE_INT, FALSE, 0),
            "name" => ["text", FILTER_SANITIZE_STRING, ""],
            "description" => ["text", FILTER_SANITIZE_STRING, ""]
        );
    }
    // THIS SAVES AND CREATES A PRODUCT
    public function save()
    {
        if ($this->id) {
            // Update
            $params = array($this->name, $this->description, $this->id);
            $sql = "UPDATE products SET name = ?, description = ? WHERE id = ?";
            $this->db->_query($sql, $params);
            return $this->id;
          } else {
            // Create
            $params = array($this->name, $this->description, $this->genderId);
            $sql = "INSERT INTO products(name, description) VALUES (?,?,?)";
            $this->db->_query($sql, $params);
            return $this->db->_getinsertid();
          }
    }

    public function getAllProducts()
    {
        $sql = "SELECT * from products WHERE isDeleted = 0";
        return $this->db->_fetch_array($sql);
    }

    public function getProduct($id)
    {
        $params = array($id);
        $sql = "SELECT * from products WHERE id = ?";
        $row = $this->db->_fetch_array($sql, $params);
        $row = call_user_func_array('array_merge', $row);

        $this->id = $row["id"];
        $this->name = $row["name"];
        $this->description = $row["description"];
        $this->image = $row["image"];
        $this->genderId = $row["genderId"];
    }

    public function getLatest($max)
    {
        $params = [$max];
        $sql = "SELECT name, image FROM products ORDER BY id DESC LIMIT ?";
        return $this->db->_fetch_array($sql, $params);
    }

    public function deleteProduct($id)
    {
        $params = array($id);
        $sql = "UPDATE products SET isDeleted WHERE id = ?";
        return $this->db->_query($sql, $params);
    }
    
    public function searchProduct($pattern)
    {
        $params = ["%" . $pattern . "%"];
        // $k = "'le'";
        // var_dump($params);
        $sql = "SELECT name,description,image from products
        WHERE name LIKE ?";
        return $this->db->_fetch_array($sql, $params);
    }
}