<?php
namespace app\main\controllers\front
{

    use app\main\models\ModelTag;
    use app\main\src\PhotoDefaultController;
    use core\application\Autoload;
    use core\application\Core;
    use core\application\Go;
    use core\application\Header;
    use core\data\SimpleJSON;
    use core\system\File;

    class Photos extends PhotoDefaultController
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function byTag()
        {
            if(!Core::checkRequiredGetVars('tag'))
                Go::to404();

            $m = new ModelTag();

            if(!$m->isAccessibleFor($_GET['tag'], $this->username))
            {
                trace("not accessible...");
                Go::to404();
            }

            $files = $m->retrieveImageList($_GET['tag']);

            Autoload::addScript('https://dependencies.arnaud-nicolas.fr/?need=Request,M4Tween');
            Autoload::addComponent('PhotoWall');

            $this->setTitle('Photos - '.$_GET['tag'].' - arnaud-nicolas.fr');
            $this->addContent('secondTitle', ucfirst($_GET['tag']));

            $this->addContent('images_json', SimpleJSON::encode($files));
        }

        public function byTagAndPath()
        {
            if(!Core::checkRequiredGetVars('tag', 'file'))
                Go::to404();

            $m = new ModelTag();

            if(!$m->isAccessibleFor($_GET['tag'], $this->username))
            {
                trace("not accessible...");
                Go::to404();
            }

            $file = $m->getImage($_GET['tag'], Core::$url);

            if(!$file)
                Go::to404();

            Header::contentType($file['mime']);
            echo $file['content'];
            Core::endApplication();
        }
    }
}