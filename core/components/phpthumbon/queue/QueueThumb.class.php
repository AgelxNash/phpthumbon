<?php
class QueueThumb {
    public static function add(phpThumbOn $ThumbOn, modX $modx){
        $from = $ThumbOn->getOption('input');
        $to = $ThumbOn->getOption('_cacheFileName');
        $options = $ThumbOn->getOption('_options', array('f'=>$ThumbOn::DEFAULT_EXT));
        $noImage = $ThumbOn->getOption('noimage');

        switch($ThumbOn->getOption('queue')){
            case 2:{ //Отправляем в очередь и сжимаем картику noimage
                $path = $ThumbOn->getOption('assetsPath', MODX_BASE_PATH.'/assets/')."/components/phpthumbon/cache/";
                $tmp = md5(serialize($options)).".".$options['f'];
                $ThumbOn->makeDir($path);
                if(file_exists($path.$tmp)){
                    copy($path.$tmp, $to);
                }else{
                    if($to = $ThumbOn->loadResizer($noImage, $to)){
                        copy($to, $path.$tmp);
                    }
                }
                $modx->addPackage("ThumbImages", $ThumbOn->getOption('modelPath'));
                $modx->newObject("ThumbImages", array(
                    'image' => $from,
                    'cache_image' => $to,
                    'config' => $modx->toJSON($options),
                    'isend' => ($from == $noImage)
                ))->save();
                break;
            }
            case 1:
            default:{
             //Отправляем в очередь и сразу отдаем картинку noimage
                if(!file_exists($to)){
                    $to = copy($noImage, $to);
                }
                $modx->newObject("ThumbImages", array(
                    'image' => $from,
                    'cache_image' => $to,
                    'config' => $modx->toJSON($options),
                    'isend' => 0
                ));
                break;
            }
        }
        return $to;
    }
} 