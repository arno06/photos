<?php
namespace app\main\src
{

    use app\main\src\authentication\PhotoAuthHandler;
    use core\application\Application;
    use core\application\Configuration;
    use core\application\DefaultController;
    use core\application\Header;

    class PhotoDefaultController extends DefaultController
    {

        protected $access;

        protected $username;

        public function __construct()
        {
            /** @var PhotoAuthHandler $authHandler */
            $authHandler = Application::getInstance()->authenticationHandler;
            if(!$authHandler::is($authHandler::USER))
                Header::location(Configuration::$server_url.'hi');

            /** @var array $data*/
            $this->username = $authHandler::$data['username'];
        }

        static public function goToDefaultTag()
        {
            /** @var PhotoAuthHandler $authHandler */
            $authHandler = Application::getInstance()->authenticationHandler;
            /** @var array $data */
            $data = $authHandler::$data;
            Header::location(Configuration::$server_url.'t/'.$data['default']);
        }
    }
}