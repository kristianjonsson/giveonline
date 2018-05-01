<?php
class Newsletter
{
    public $db;
    public $id;
    public $email;
    public $name;
    public $isDeleted;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    public function signNewsletter($email, $name)
    {
        $param = [$this->email, $this->name];
        $sql = "INSERT INTO newsletter (email, name) VALUES (?,?)";
        return $this->db->_query($sql,$param);
    }
}
