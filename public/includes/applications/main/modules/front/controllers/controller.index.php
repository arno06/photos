<?php
namespace app\main\controllers\front
{
    use app\main\src\PhotoDefaultController;
    use core\application\Core;

    class index extends PhotoDefaultController
    {

        public function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
            self::goToDefaultTag();
        }

        public function newUser()
        {
            $username = !Core::checkRequiredGetVars('username')?"arno":$_GET["username"];

            $password = !Core::checkRequiredGetVars('password')?'photos::arnaud':$_GET["password"];

            $hash = password_hash($password, PASSWORD_DEFAULT, ['cost'=>12]);

            trace_r($username);
            trace_r($hash);
        }
    }
}
