<?php
/**
 * phpThumbOn
 * Создание превьюх картинок
 *
 * Copyright 2013 by Agel_Nash <Agel_Nash@xaker.ru>
 *
 * @category images
 * @license GNU General Public License (GPL), http://www.gnu.org/copyleft/gpl.html
 * @author Agel_Nash <Agel_Nash@xaker.ru>
 * @date 25.08.2013
 * @version 1.0.1
 * @package phpThumbOn
 *
 * I love chaining:-)
 */
class phpThumbOn {
    /** @var modX объект класса modX */
    protected $modx;

    /** @var phpThumb объект класса phpThumb */
    protected $_phpThumb = null;

    /** @var null информация об обрабатываемом файле */
    protected $_fileInfo = null;

    /** @var bool наличие ошибки */
    protected $_flag = true;

    /** @var array все настройки класса */
    protected $_config = array();

    /** @var array основные настройки класса */
    private $_cfg = array();

    /** @var array кеш со */
    private $_cacheDir = array();

    /** качество картинки по умолчанию */
    const DEFAULT_QUALITY = '96';

    /** тип файла по умолчанию */
    const DEFAULT_EXT = 'jpeg';

    /** @var array константа */
    private static $ALLOWED_EXT = array(
        'jpg'=>true,
        'jpeg'=>true,
        'png'=>true,
        'gif'=>true,
        'bmp'=>true
    );

    /**
     * Проверка резрешено ли создавать такие файлы
     *
     * @param string расширение файла
     * @return array константа ALLOWED_EXT
     */
    public static function ALLOWED_EXT($ext=null){
        if(isset($ext)){
            if(is_scalar($ext) && isset(self::$ALLOWED_EXT[$ext])){
                $out = self::$ALLOWED_EXT[$ext];
            } else{
                $out = false;
            }
        } else{
            $out = self::$_ALLOWED_EXT;
        }

        return $out;
    }

    /**
     * @param modX $modx
     * @param array $config
     * @access public
     */
    public function __construct(modX $modx, array $config = array()) {
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        $this->modx = &$modx;

        $corePath = $this->modx->getOption('phpthumbon.core_path',array(),$this->modx->getOption('core_path').'components/phpthumbon/');
        $assetsPath = $this->modx->getOption('assets_path');
        $assetsUrl = $this->modx->getOption('assets_url');
        $this->_cfg = $this->_config = array_merge(array(
            'input' => null,
            'options' => null,

            //путь к папке с компонента
            'corePath' => $corePath,

            //путь к папке с моделью
            'modelPath' => $corePath.'model/',

            //Папка assets относительно корня сервера
            'assetsPath' => $assetsPath,

            //папка assets относительно web-root директории
            'assetsUrl' => $assetsUrl,

            // Папка в которой будут храниться кешированные картинки
            'cacheDir' => $assetsPath.trim($this->modx->getOption('phpthumbon.cache_dir', $this->_config, 'cache_image'),'/'),

            // подпапка из assets, в которой будут храниться картинки и загрузка картинок в которую будет сопровождаться плагином отчистки кеша
            'imagesFolder' => trim($this->modx->getOption('phpthumbon.images_dir', $this->_config, 'images'),'/'),

            //качество картинки по умолчанию
            'quality' => $this->modx->getOption('phpthumbon.quality', $this->_config, self::DEFAULT_QUALITY),

            //Тип картинки по умолчанию
            'ext' => $this->modx->getOption('phpthumbon.ext', $this->_config, self::DEFAULT_EXT),

            //Права на только что созданный файл
            'new_file_permissions' => (int)$this->modx->getOption('new_file_permissions',$this->_config,'0664'),

            // картинки нет
            'noimage' => $this->modx->getOption('phpthumbon.noimage', $this->_config, trim($assetsUrl,'/').'/components/phpthumbon/noimage.jpg')
        ),$config);

        $this->_cfg['options'] = null;
        $this->_cfg['input'] = null;

        $this->_validateConfig();

        if (!$this->modx->loadClass('phpthumb',$this->modx->getOption('core_path').'model/phpthumb/',true,true)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[phpthumbon] Could not load phpthumb class');
            $this->_flag = false;
        }
        //$this->debugTime[__FUNCTION__][1] = microtime(true);
    }

    /**
     * Проверка и исправление настроек по умолчанию
     *
     * @return bool были ли ошибки в конфигурации по умолчанию
     */
    private function _validateConfig(){
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        $flag = true;

        if(!empty($this->_config['input'])){
            $this->_config['input'] = preg_replace("#^/#","",$this->_config['input']);
            if (strpos($this->_config['input'], MODX_BASE_PATH) === false) {
                $this->_config['input'] = MODX_BASE_PATH . $this->_config['input'];
            }
        }
		
        if(!isset($this->_config['ext']) || !self::ALLOWED_EXT($this->_config['ext'])){
            $this->_config['ext'] = self::DEFAULT_EXT;
            $flag = false;
        }

        if(!isset($this->_config['quality']) || (int)$this->_config['quality']<=0){
            $this->_config['quality'] = self::DEFAULT_QUALITY;
            $flag = false;
        }
        //$this->debugTime[__FUNCTION__][1] = microtime(true);
        return $flag;
    }
    /**
     * Обновление настроек класса
     *
     * @param array $options настройки для перезагрузки
     * @access private
     * @return bool статус обновления конфигов
     */
    private function _setConfig($options = array()){
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        if($flag = (is_array($options) && array()!=$options)){
            $this->_config = array_merge($this->_cfg,$options);
            $this->_validateConfig();
        }
        //$this->debugTime[__FUNCTION__][1] = microtime(true);
        return $flag;
    }

    /**
     * Запуск процесса создания превьюхи
     *
     * @param array обновление конфигов без перезагрузки класса
     * @access public
     * @return string имя файла с превьюхой или пустая строка
     */
    public function run($options = array()){
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        $this->_setConfig($options);
        if($this->_flag){
            $this->_phpThumb = new phpthumb();

            $out = $this->relativeSrcPath()
                ->makeCacheDir()
                ->makeOptions()
                ->checkOptions()
                ->saveOptions()
                ->getCacheFileName()
                ->getThumb();
        }else{
            $out = '';
        }
        $this->flush();
        //$this->debugTime[__FUNCTION__][1] = microtime(true);
        return $out;
    }

    /**
     * Цепочка для проверки необходимых параметров
     *
     * @access public
     * @return $this
     */
    public function checkOptions(){
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        $this->checkExt()
            ->checkQuality()
            ->setImage();
        //$this->debugTime[__FUNCTION__][1] = microtime(true);
        return $this;
    }

    /**
     * Создаем папку в которой будут храниться превьюхи текущей картинки
     *
     * @access public
     * @return $this
     */
    public function makeCacheDir(){
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        $exists = false;
        $this->_config['_cachePath'] = $this->_config['cacheDir'].'/'.$this->_config['relativePath'];

        if($this->_flag){
            if($exists = isset($this->_cacheDir[$this->_config['_cachePath']])){
                $this->_flag = $this->_cacheDir[$this->_config['_cachePath']];
            }
        }
        if($this->_flag && !$exists){
            $this->modx->getService('fileHandler','modFileHandler');
            $dir = $this->modx->fileHandler->make($this->_config['_cachePath'], array(),'modDirectory');
            if(!is_object($dir) || !($dir instanceof modDirectory)) {
                $this->modx->log(modX::LOG_LEVEL_ERROR,'[phpthumbon] Could not get class modDirectory');
                $this->_cacheDir[$this->_config['_cachePath']] = $this->_flag = false;
            }
            if($this->_flag){
                if(is_dir($this->_config['_cachePath']) || $dir->create()){
                    $this->_cacheDir[$this->_config['_cachePath']] = true;
                }else{
                    $this->_cacheDir[$this->_config['_cachePath']] = $this->_flag = false;
                    $this->modx->log(modX::LOG_LEVEL_ERROR, "[phpthmbon] Could not create cache directory ".$this->_config['_cachePath']);
                }
            }
        }
        //$this->debugTime[__FUNCTION__][1] = microtime(true);
        return $this;
    }

    /**
     * Проверяем имя и его существование.
     * Затем определяем папку в которую будут складываться превьюхи этого файла
     *
     * @access public
     * @return $this
     */
    public function relativeSrcPath(){
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        if(!(empty($this->_config['input']) || !is_scalar($this->_config['input']))
            && !preg_match("/^http(s)?:\/\/\w+/",$this->_config['input'])
            && file_exists($this->_config['input'])){
            $full_assets = $this->_config['assetsPath'];
            $assets = ltrim($this->_config['assetsUrl'],'/');
            $imgDir = $this->_config['imagesFolder'];
			
            $this->_config['relativePath'] = preg_replace("#^({$full_assets}|(/)?{$assets})(/)?{$imgDir}(/)?#", '', $this->_pathinfo('dirname'));
        }else{
            if($this->_flag = file_exists($this->_config['noimage'])){
                $this->_config['input'] = $this->_config['noimage'];
                $this->_config['relativePath'] = '';
            }else{
                $this->modx->log(modX::LOG_LEVEL_ERROR,'[phpthumbon] Input image path is empty');
            }
        }

        //$this->debugTime[__FUNCTION__][1] = microtime(true);
        return $this;
    }

    /**
     * Чтобы не дергать постоянно файл который обрабатываем
     *
     * @access private
     * @return string информация из pathinfo о обрабатываемом файле input
     */
    private function _pathinfo($name){
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        if(empty($this->_fileInfo)){
            $this->_fileInfo = pathinfo($this->_config['input']);
        }
        $out = is_scalar($name) && isset($this->_fileInfo[$name]) ? $this->_fileInfo[$name] : '';
        //$this->debugTime[__FUNCTION__][1] = microtime(true);
        return $out;
    }

    /**
     * Формируем массив параметров для phpThumb из параметра options у сниппета
     *
     * @access public
     * @return $this
     */
    public function makeOptions(){
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        if($this->_flag){
            $eoptions = is_array($this->_config['options']) ? $this->_config['options'] : explode('&',$this->_config['options']);
            $this->_config['_options'] = array();
            foreach ($eoptions as $opt) {
                $opt = explode('=',$opt);
                $key = str_replace('[]','',$opt[0]);
                if (!empty($key)) {
                    /* allow arrays of options */
                    if (isset($this->_config['_options'][$key])) {
                        if (is_string($this->_config['_options'][$key])) {
                            $this->_config['_options'][$key] = array($this->_config['_options'][$key]);
                        }
                        $this->_config['_options'][$key][] = $opt[1];
                    } else { /* otherwise pass in as string */
                        $this->_config['_options'][$key] = $opt[1];
                    }
                }
            }
        }
        //$this->debugTime[__FUNCTION__][1] = microtime(true);
        return $this;
    }

    /**
     * Если параметр с расширением файла не установлен
     *
     * @access public
     * @return $this
     */
    public function checkExt(){
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        if ($this->_flag && empty($this->_config['_options']['f'])){
            $ext = $this->_pathinfo('extension');
            $ext = strtolower($ext);
            $this->_config['_options']['f'] = self::ALLOWED_EXT($ext) ? $ext : $this->_config['ext'];
        }
        //$this->debugTime[__FUNCTION__][1] = microtime(true);
        return $this;
    }

    /**
     * Если качество картинки не установлено
     *
     * @access public
     * @return $this
     */
    public function checkQuality(){
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        if($this->_flag && empty($this->_config['_options']['q'])){
            $this->_config['_options']['q'] = $this->_config['quality'];
        }
        //$this->debugTime[__FUNCTION__][1] = microtime(true);
        return $this;
    }

    /**
     * Если вдруг передан параметр src - то игнорируем его, т.к. у нас единственный и основной должен быть input
     *
     * @access public
     * @return $this
     */
    public function setImage(){
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        if($this->_flag){
            if(!empty($this->_config['_options']['src'])){
                unset($this->_config['_options']['src']);
            }
            $this->_phpThumb->setSourceFilename($this->_config['input']); //картинка какую будем сжимать
        }
        //$this->debugTime[__FUNCTION__][1] = microtime(true);
        return $this;
    }

    /**
     * Все необходимые параметры для создания превьюхи определены. Поэтому передаем их в phpthumb
     *
     * @access public
     * @return $this
     */
    public function saveOptions(){
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        if($this->_flag){
            foreach($this->_config['_options'] as $item=>$value){
                $this->_phpThumb->setParameter($item,$value);
            }
        }
        //$this->debugTime[__FUNCTION__][1] = microtime(true);
        return $this;
    }

    /**
     * Определяем имя файла и проверяем его наличие в кеш-папке
     *
     * @access public
     * @return $this
     */
    public function getCacheFileName(){
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        if($this->_flag){
            $w = isset($this->_config['_options']['w']) ? $this->_config['_options']['w'] : 0;
            $h = isset($this->_config['_options']['h']) ? $this->_config['_options']['h'] : 0;

            //Уникальный суффикс в имени файла превьюхи
            //$suffix = '_'.$w.'x'.$h.'_'.substr(md5($this->modx->toJSON($this->_config['_options'])),0,3);
            $suffix = '_'.$w.'x'.$h.'_'.substr(md5(serialize($this->_config['_options'])),0,3);

            //папка в которой лежат превьюхи текущей картинки
            $this->_cache['_cacheFileDir'] = rtrim($this->_config['_cachePath'],'/').'/'.$this->_pathinfo('filename');

            //Для поиска других превьюх с этого же файла
            //glob("fullfolder_to_cache_image/filename_[0-9]*x[0-9]*_???.{jpeg,gif,bmp,jpg,png}",GLOB_BRACE)
            $this->_config['_globThumb'] = $this->_cache['_cacheFileDir']."_[0-9]*x[0-9]*_???.{jpeg,gif,bmp,jpg,png}";

            //Кеш файл превьюхи
            $this->_config['_cacheFileName'] = $this->_cache['_cacheFileDir'].$suffix.".".$this->_config['_options']['f'];
        }
        //$this->debugTime[__FUNCTION__][1] = microtime(true);
        return $this;
    }

    /**
     * Пытаемся создать превьюху
     *
     * @access public
     * @return string путь к превьюхе или пустая строка
     */
    public function getThumb(){
        //$this->debugTime[__FUNCTION__][0] = microtime(true);
        $new = false;
        if($this->_flag){
            $out = $this->_config['_cacheFileName'];
            //Если оригинальный файл был изменен
            if(file_exists($out) && filemtime($out) < filemtime($this->_config['input'])){
                unlink($out);
                //Удаляем другие превьюхи этого же файла
                $thumbFile = glob($this->_config['_globThumb'],GLOB_BRACE);
                foreach($thumbFile as $tf){
                    unlink($tf);
                }
            }
            if (!file_exists($out)){
                // Пробуем создать превьюху
                if ($this->_phpThumb->GenerateThumbnail()){
                    // Сохраняем превьюху в кеш-файл
                    $new = true;
                    $out = $this->_phpThumb->RenderToFile($out);
                }else{
                    $out = false;
                    $this->modx->log(modX::LOG_LEVEL_ERROR,'[phpthumbon] Could not generate thumbnail');
                }
            }

            // Отдаем имя превьюхи предварительно заменив абсолютный путь на относительный
            if($out){
                if($new){
                    chmod($this->_config['_cacheFileName'], octdec($this->_config['new_file_permissions']));
                }
                $out = str_replace($this->_config['assetsPath'], $this->_config['assetsUrl'], $this->_config['_cacheFileName']);
            }
        }else{
            $out = false;
        }

        if($out===false){
            $out = '';
        }
        //$this->debugTime[__FUNCTION__][1] = microtime(true);
        return $out;
    }

    /**
     * Сброс текущих настроек
     *
     * @access public
     * @return bool всегда true
     */
    public function flush(){
        $this->_flag = class_exists('phpthumb');
        $this->_config = array_merge(
            $this->_cfg,
            array('options'=>null,'input'=>null)
        );
        $this->_fileInfo = $this->_phpThumb = null;
        return true;
    }
}
