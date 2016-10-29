<?php
namespace app\main\models
{

    use core\data\SimpleJSON;
    use core\system\File;
    use core\system\Folder;

    class ModelTag
    {
        const CACHE_FILE = "../access.json";

        public function __construct()
        {
            try
            {
                $this->access = SimpleJSON::import(self::CACHE_FILE);
            }
            catch(\Exception $e)
            {
                trigger_error('Unable to load '.self::CACHE_FILE, E_USER_WARNING);
                return;
            }
        }

        public function exists($pTag)
        {
            return isset($this->access) && isset($this->access['tags']) && isset($this->access['tags'][$pTag]);
        }

        public function isAccessibleFor($pTag, $pUser)
        {
            if(!$this->exists($pTag))
                return false;

            $tags = $this->access['tags'];
            $groups = $this->access['groups'];
            $tag = $tags[$pTag];

            foreach($tag['groups'] as $group)
            {
                if(!isset($groups[$group]))
                    continue;
                if(in_array($pUser, $groups[$group]))
                    return true;
            }

            return false;
        }

        public function retrieveImageList($pTag)
        {
            if(!$this->exists($pTag))
                return false;

            $local_path = '../images/'.$pTag.'/';

            $remote_path = 't/'.$pTag.'/';

            $files = Folder::read('../images/'.$pTag.'/');

            $images = [];
            foreach($files as &$f)
            {
                $info = getimagesize($f['path']);
                if(!$info)
                    continue;
                $f['path'] = str_replace($local_path, $remote_path, $f['path']);
                $f['mime'] = $info['mime'];
                $f['attr'] = $info[3];
                $f['size'] = [$info[0], $info[1]];
                $images[] = $f;
            }

            return $images;
        }

        public function getImage($pTag, $pImage)
        {
            $local_path = '../images/'.$pTag.'/';
            $remote_path = 't/'.$pTag.'/';
            $pImage = str_replace($remote_path, $local_path, $pImage);

            $info = getimagesize($pImage);

            if(!file_exists($pImage)||!$info)
                return false;

            return ["content"=>file_get_contents($pImage), "mime"=>$info['mime']];
        }
    }
}