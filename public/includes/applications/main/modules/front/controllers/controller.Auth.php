<?php

namespace app\main\controllers\front
{

    use app\main\src\authentication\PhotoAuthHandler;
    use app\main\src\PhotoDefaultController;
    use core\application\Configuration;
    use core\application\DefaultController;
    use core\application\Go;
    use core\application\Header;
    use core\tools\form\Form;

    class Auth extends DefaultController
    {
        public function __construct()
        {
            PhotoAuthHandler::getInstance();
        }

        public function login()
        {
            if(PhotoAuthHandler::is(PhotoAuthHandler::USER))
            {
                PhotoDefaultController::goToDefaultTag();
            }

            $form = new Form('login');

            if($form->isValid())
            {
                $values = $form->getValues();

                if(PhotoAuthHandler::getInstance()->login($values['username'], $values['password']))
                {
                    PhotoDefaultController::goToDefaultTag();
                }
                else
                {
                    mail('arno06@gmail.com', 'Photos - login incorrect', 'Tentative de connexion : '.print_r($values, true));
                    trace("nop");
                }

            }
            else
            {
                $error = $form->getError();

                if(!empty(trim($error)))
                {
                    mail('arno06@gmail.com', 'Photos - login incorrect', 'Tentative de connexion : '.$error);
                    $this->addContent("error", $error);
                }
            }

            $this->setTitle("Photos - arnaud-nicolas.fr");
            $this->addForm('login', $form);
        }

        public function logout()
        {
            PhotoAuthHandler::getInstance()->logout();
            Header::location(Configuration::$server_url.'hi');
        }
    }
}