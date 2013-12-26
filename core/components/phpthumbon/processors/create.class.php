<?php
class CreateThumbProcessor extends modProcessor{
    /** Значение по умолчанию для числа обрабатываемых за 1 раз заданий из очереди */
    public static $TotalQueue = 1;

    /** Максимальное значение числа обрабатываемых заданий из очереди за 1 раз */
    public static $MaxQueue = 10;

    protected $_data = null;
    protected $_cfg = array();

    public $total = null;

    public function initialize() {
        $flag = true;

        $componentPath = (string)$this->modx->getOption('phpthumbon.core_path', null, $this->modx->getOption('core_path').'components/phpthumbon/');
        $this->_cfg = array(
            'componentPath' => $componentPath,
            'modelPath' => $componentPath.'model/'
        );
        $this->modx->addPackage("phpthumbon", $this->_cfg['modelPath']);

        CreateThumbProcessor::$TotalQueue = $this->modx->getOption('phpthumbon.total_queue', array(), CreateThumbProcessor::$TotalQueue);

        $this->protectTotal();

        if(!isset($this->modx->phpThumbOn)){
            $this->properties = array(
                'phpthumbon.queue' => 0
            );
            $this->modx->phpThumbOn = $this->modx->getService("phpthumbon","phpThumbOn",$this->_cfg['modelPath'].'phpthumbon/', $this->getProperties());
        }
        if(!($flag = ($this->modx->phpThumbOn instanceof phpThumbOn))){
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[phpthumbon] Could not load phpThumbOn class');
            $this->modx->error->failure('Could not load phpThumbOn class');
            $this->modx->phpThumbOn = null;
            $flag = false;
        }else{
            $flag = $this->_getObject();
        }

        return $flag ? parent::initialize() : false;
    }

    public function process(){
        $out = array();
        $total = &$this->modx->error->total;
        $total = 0;
        do{
            $file = rtrim(MODX_BASE_PATH, '/').$this->modx->phpThumbOn->run($this->getProperties());
            $this->_data->set('cache_image', $file);
            $this->_data->set('isend', 1);
            $this->_data->save();
            $out[$this->_data->get('id')] = $this->_data->toArray();
            $total++;
        }while($total < $this->total && $this->_getObject());

        return $this->modx->error->success('Create', $out);
    }

    /**
     * DDoS protection :-)
     *
     */
    public function protectTotal($total = 0){
        $this->total = ($total>0 ? $total : (int)$this->getProperty('total', CreateThumbProcessor::$TotalQueue));
        if($this->total < 0 || $this->total > CreateThumbProcessor::$MaxQueue){
            $this->total = CreateThumbProcessor::$TotalQueue;
        }
        return $this->total;
    }

    protected function _getObject(){
        $this->_data = $flag = $this->modx->getObject("ThumbImages", 'isend=0');
        if(!empty($this->_data) && $this->_data instanceof ThumbImages){
            $this->setProperties(array(
                'input' => $this->_data->image,
                'options' => $this->modx->fromJSON($this->_data->config)
            ));
            if(file_exists($this->_data->cache_image)){
                if(!unlink($this->_data->cache_image)){
                    $this->modx->log(modX::LOG_LEVEL_INFO,'[phpthumbon] Failed to delete file '.$this->_data->cache_image);
                    $this->modx->error->failure('Failed to delete file '.$this->_data->cache_image);
                    $flag = false;
                }
            }
        }else{
            $this->modx->log(modX::LOG_LEVEL_INFO,'[phpthumbon] The queue is empty');
            $this->modx->error->success('The queue is empty');
            $flag = false;
        }
        return $flag;
    }
}
return 'CreateThumbProcessor';