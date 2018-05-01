<?php
class Product
{
    public $db;
    public $id;
    public $name;
    public $number;
    public $zip;
    public $address;
    public $city;
    public $country;
    public $logo;
    public $userId;
    public $isDeleted;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    public function createRetailer($name, $number, $zip, $address, $city, $country, $logo, $userId)
    {
        $params = [$name, $number, $zip, $address, $city, $country, $logo, $userId];
        $sql = "INSERT INTO retailers VALUES (?,?,?,?,?,?,?,?)";
        return $this->db->_query($sql, $params);
    }

    public function getAllRetailers()
    {
        $sql = "SELECT * from retailers WHERE isDeleted = 0";
        return $this->db->_fetch_array($sql);
    }

    public function getRetailer($id)
    {
        $params = array($id);
        $sql = "SELECT * from retailer WHERE id = ?";
        return $this->db->_fetch_array($sql, $params);
    }

    public function deleteRetailer($id)
    {
        $params = array($id);
        $sql = "UPDATE retailers SET isDeleted WHERE id = ?";
        return $this->db->_query($sql, $params);
    }
}
