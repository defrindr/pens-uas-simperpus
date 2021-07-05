<?php

class User
{
    private $_user = [];
    private $db = [];

    public function __construct()
    {
        $this->_user = isset($_SESSION['user']) ? $_SESSION['user'] : [];
        $this->db = new Connection(App::$dbconfig);
        return $this;
    }

    public function login($user)
    {
        $new_user = (array) $user;
        $new_user["last_login"] = date("Y-m-d H:i:s");

        $this->db->update($new_user, "user", "id='$user->id'");

        $this->_user = $this->db->findOne([
            "where" => [
                "=",
                "id",
                $user->id,
            ],
        ], "user");
        $_SESSION['user'] = $this->_user;
    }

    public function logout()
    {
        $this->_user = [];
        unset($_SESSION['user']);
    }

    public function getUser()
    {

        return ($this->isLogin()) ? $this->_user : null;
    }

    public function isLogin()
    {
        if (self::$_user == []) {
            return false;
        }
        return true;
    }

    public function get($name)
    {
        return $this->_user->$name ?? null;
    }

}
