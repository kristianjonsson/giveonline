<?php
class Auth{
    public $authUsername;
    public $authPassword;
    public $userId;
    public $loginHtml;
    public $roleId;
    public $errMessage;
    public $timeoutSec;
    private $db;
    
    // CONSTANTS
    const errInvalidUser = 1;
    const errInvalidSession = 2;
    const loggedIn = 1;

    public function __construct(){
        global $db;
        $this->db = $db;
        $this->errMessage = "";
        session_start();
        $this->authUsername = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
        $this->authPassword = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
        $this->action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
        $this->loginHtml = DOCROOT . "index.php";
        $this->timeoutSec = 1800;
    }
    
    public function authentificate(){
        if($this->action == "logout"){
            $this->logOut();
        }
        if($this->authUsername && $this->authPassword){
            $this->initUser();
        }
    }


    private function initUser(){
        $params = array($this->authUsername);
        $sqlSelectUsername = "SELECT id, password, roleId FROM users WHERE username = ?";
        if($row = $this->db->_fetch_array($sqlSelectUsername, $params)){
            if(password_verify($this->authPassword, $row[0]['password'])){
                $params = array( session_id(), $row[0]['id'], self::loggedIn, time());
                $sqlInsertUsersession = "INSERT INTO usersession (id, userId, loggedIn, lastAction) values (?, ?, ?, ?)";
                $this->db->_query($sqlInsertUsersession, $params);
                $this->userId = $row[0]['id'];
                $this->roleId = $row[0]['roleId'];
                $_SESSION["userId"] = $this->userId;
                $_SESSION["username"] = $this->authUsername;
                $_SESSION["roleId"] = $this->roleId;
                if($this->roleId && $this->authUsername){
                    header("location: /admin/index.php");
                } else {
                    header("location: inddex.php");
                }
            } else {
                // echo $this->loginForm(self::errInvalidUser);
                header("location: index.html");
                // exit();
            }
        } else {
            // echo $this->loginForm(self::errInvalidUser);
            header("location: index.html");
            // exit();
        }
        exit();
    }

    public function getSession(){
        $params = array(session_id());
        $sqlSession = "SELECT userId,lastAction FROM usersession WHERE id = ? AND loggedIn = 1";
        if($row = $this->db->_fetch_array($sqlSession, $params)){
            if($row[0]["lastAction"] > (time() - $this->timeoutSec)){
                $this->userId = $row[0]["userId"];
                $this->updateSession();
                return $this->userId;
            } else {
                $this->logOut();
            }
        } else {
            echo $this->loginForm();
            exit();
        }
    }

    public function updateSession(){
        $params = array(session_id());
        $sqlUpdateSession = "UPDATE usersession SET lastAction = UNIX_TIMESTAMP() WHERE id = ?";
        $this->db->_query($sqlUpdateSession, $params);

    }

    public function logOut(){
        $params = array(session_id());
        $strSessionUpdate = "UPDATE usersession set loggedIn = 0 WHERE id = ?";
        $this->db->_query($strSessionUpdate, $params);
        session_unset();
        session_destroy();
        session_start();
        session_regenerate_id();
        header("location: index.php");
    }
    


    // Login form output
    public function loginForm($errCode = 0){
        ob_start();
        include_once($this->loginHtml);
        $strBuffer = ob_get_clean();
        $strErrorMsg = self::getError($errCode);
        $strBuffer = str_replace("@ERRORMSG@", $strErrorMsg, $strBuffer);
        return $strBuffer;
        exit();
    }

    public function getError($int){
        switch($int){
            default:
                $errMessage = "";
                break;
            case self::errInvalidUser:
                $errMessage = "Wrong username or password";
                break;
            case self::errInvalidSession:
                $errMessage = "Session not set";
                break;
        }
        return $errMessage;
    }
}
?>
