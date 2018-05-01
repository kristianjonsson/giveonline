<?php
class User
{
    // User info
    public $db;
    public $id;
    public $username;
    public $password;
    public $email;
    public $isDeleted;
    public $isSuspended;
    public $roleId;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }
    
    public function isAdmin($id)
    {
        $params = [$id];
        $sql = "SELECT id FROM users WHERE id = ? AND roleId = 1";
        return $this->db->_fetch_array($sql, $params);
    }
    public function createUser($username, $password, $email, $roleId)
    {
        $params = [$username, $password, $email, $roleId];
        $sql = "INSERT INTO users (username, password, email, roleId) VALUES (?,?,?,?)";
        return $this->db->_query($sql, $params);
    }

    public function getAllUsers()
    {
        $sql = "SELECT * from user WHERE isDeleted = 0";
        return $this->db->_fetch_array($sql);
    }

    public function getUser($id)
    {
        $params = array($id);
        $sql = "SELECT * from user WHERE id = ?";
        return $this->db->_fetch_array($sql, $params);
    }

    public function deleteUser()
    {
        $params = array($id);
        $sql = "UPDATE user SET isDeleted WHERE id = ?";
        return $this->db->_query($sql, $params);
    }

    public function suspendUser()
    {
        $params = array($id);
        $sql = "UPDATE user SET isSuspended WHERE id = ?";
        return $this->db->_query($sql, $params);
    }
}
