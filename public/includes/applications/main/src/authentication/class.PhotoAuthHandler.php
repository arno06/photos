<?php
namespace app\main\src\authentication
{

    use core\application\Singleton;
    use core\data\SimpleJSON;

    class PhotoAuthHandler extends Singleton
    {
        const USERS_FILE = '../users.json';

        const USER      = "USER";

        const ADMIN     = "ADMIN";

        const DEVELOPER = "DEVELOPER";

        const INVITE    = "INVITE";

        const SESSION_VAR = 'photo_auth';

        /**
         * Données relatives à l'utilisateur connecté
         * @var array
         */
        static public $data;

        /**
         * Ensemble des permissions acceptées pour l'application
         * @var array
         */
        static public $permissions = array(
            self::INVITE    =>  0,
            self::USER		=>	1,
            self::ADMIN		=>	2,
            self::DEVELOPER	=>	4
        );

        public function __construct()
        {

            if(isset($_SESSION[self::SESSION_VAR]))
            {
                $users = SimpleJSON::import(self::USERS_FILE);

                list($username, $hash) = $_SESSION[self::SESSION_VAR];

                if(isset($users[$username]) && $hash === $users[$username]['hash'])
                {
                    $users[$username]['username'] = $username;
                    self::$data = $users[$username];
                    trace('Connected: '.$username);
                }
                else
                {
                    $this->logout();
                }
            }
        }

        public function login($pUsername, $pPassword)
        {
            $users = SimpleJSON::import(self::USERS_FILE);

            if(!$users[$pUsername])
                return false;

            $user = $users[$pUsername];
            if(!password_verify($pPassword, $user['hash']))
                return false;
            $_SESSION[self::SESSION_VAR] = array($pUsername, $user['hash']);
            $user['username'] = $pUsername;
            self::$data = $user;
            return true;
        }

        public function logout()
        {
            $_SESSION[self::SESSION_VAR] = [];
            unset($_SESSION[self::SESSION_VAR]);
        }


        static public function is($pLevel)
        {
            /** @var PhotoAuthHandler $i */
            $i = self::getInstance();

            if(!isset(self::$permissions[$pLevel]))
                return false;

            /** @var array $data */
            return $i::$data['permissions']&self::$permissions[$pLevel];
        }
    }
}