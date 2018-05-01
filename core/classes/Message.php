<?php
class Newsletter
{
    public $db;
    public $id;
    public $title;
    public $content;
    public $dateSent;
    public $isDeleted;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    public function signNewsletter($email, $name)
    {
        $param = [$email, $name];
        $sql = "INSERT INTO newsletter (email, name) VALUES (?,?)";
        return $this->db->_query($sql,$param);
    }
}
