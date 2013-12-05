<?php
class CreateThumbProcessor extends modProcessor{
    public function process(){
        $out = null;
        $modelPath = $this->modx->getOption('phpthumbon.core_path',array(), $this->modx->getOption('core_path').'components/phpthumbon/model/');
        $this->modx->addPackage("ThumbImages", $modelPath);
        $q = $this->modx->getObject("ThumbImages", 'isend=0');
        if(!empty($q) && $q instanceof ThumbImages){
            if (!$this->modx->loadClass('phpthumb',$this->modx->getOption('core_path').'model/phpthumb/',true,true)) {
                //Не могу загрузить класс
                $out = $this->modx->error->failure('Could not load phpthumb class');
                $this->modx->log(modX::LOG_LEVEL_ERROR,'[phpthumbon] Could not load phpthumb class');
            }else{

                $phpThumb = new phpthumb();
                $phpThumb->setSourceFilename($q->image);
                $config = $this->modx->fromJSON($q->config);
                foreach($config as $item=>$value){
                    $phpThumb->setParameter($item,$value);
                }

                if ($phpThumb->GenerateThumbnail()){
                    $phpThumb->RenderToFile($q->cache_image);
                    $q->set('isend', 1);
                    $q->save();
                    $this->modx->error->total = 1;
                    $out = $this->modx->error->success('Create', $q->toArray());
                }else{
                    //Не могу создать картинку
                    $out = $this->modx->error->failure('Could not generate thumbnail from '.$q->image);
                    $this->modx->log(modX::LOG_LEVEL_ERROR,'[phpthumbon] Could not generate thumbnail from '.$q->image);
                }
            }
        }else{
            $out = $this->modx->error->success('The queue is empty');
        }
        return $out;
    }
}
return 'CreateThumbProcessor';