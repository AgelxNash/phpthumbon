<?php
class ThumbImages extends xPDOSimpleObject {
    public function save($cacheFlag= null) {
        if(!$this->checkDuplicate()){
            $out = parent::save($cacheFlag);
        }else{
            $this->xpdo->log(xPDO::LOG_LEVEL_INFO, '[ThumbImages] Duplicate records for '.$this->get('image').' with config '.$this->config);
            $out = false;
        }
        return $out;
    }
    private function checkDuplicate(){
        $flag = false;
        $q = $this->xpdo->newQuery(__CLASS__, array(
            'image'=>$this->get('image'),
            'cache_image'=>$this->get('cache_image'),
            'config'=>$this->config
        ));
        if($total = $this->xpdo->getCount(__CLASS__, $q)){
            $flag = true;
            if($total == 1){
                $obj = $this->xpdo->getObject(__CLASS__, $q);
                if($obj->get('id') == $this->get('id')){
                    $flag = false;
                }
            }
        }
        return $flag;
    }
}