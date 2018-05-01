<?php
/*
* DB Configuration with credentials
* Should be ignored from any Git services
*/
class dbConf extends db {
function __construct() {
  $this->dbhost = "localhost";
  $this->dbuser = "root";
  $this->dbpassword = "";
  $this->dbname = "giveonline";
  $db = parent::_connect();
  }
}
