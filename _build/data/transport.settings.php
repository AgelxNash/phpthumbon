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
 *
 */
/**
 * @package phpThumbOn
 * @subpackage build
 */

$settings = array();

//Имя папки с картинками
$settings['phpthumbon.images_dir']= $modx->newObject('modSystemSetting');
$settings['phpthumbon.images_dir']->fromArray(array(
    'key' => 'phpthumbon.images_dir',
    'value' => 'images',
    'xtype' => 'textfield',
    'namespace' => 'phpthumbon',
    'area' => 'paths',
),'',true,true);

//Качество картинки по умолчанию
$settings['phpthumbon.quality']= $modx->newObject('modSystemSetting');
$settings['phpthumbon.quality']->fromArray(array(
    'key' => 'phpthumbon.quality',
    'value' => '96',
    'xtype' => 'textfield',
    'namespace' => 'phpthumbon',
    'area' => 'general',
),'',true,true);

//Имя папки кеша
$settings['phpthumbon.cache_dir']= $modx->newObject('modSystemSetting');
$settings['phpthumbon.cache_dir']->fromArray(array(
    'key' => 'phpthumbon.cache_dir',
    'value' => 'cache_image',
    'xtype' => 'textfield',
    'namespace' => 'phpthumbon',
    'area' => 'path',
),'',true,true);

//Тип картинки по умолчанию
$settings['phpthumbon.ext']= $modx->newObject('modSystemSetting');
$settings['phpthumbon.ext']->fromArray(array(
    'key' => 'phpthumbon.ext',
    'value' => 'jpeg',
    'xtype' => 'textfield',
    'namespace' => 'phpthumbon',
    'area' => 'general',
),'',true,true);

//Путь к картинки с изображением "картинка не существует"
$settings['phpthumbon.noimage']= $modx->newObject('modSystemSetting');
$settings['phpthumbon.noimage']->fromArray(array(
    'key' => 'phpthumbon.noimage',
    'value' => '{assets_path}components/phpthumbon/noimage.jpg',
    'xtype' => 'textfield',
    'namespace' => 'phpthumbon',
    'area' => 'path',
),'',true,true);

//Очередь
$settings['phpthumbon.queue']= $modx->newObject('modSystemSetting');
$settings['phpthumbon.queue']->fromArray(array(
    'key' => 'phpthumbon.queue',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'phpthumbon',
    'area' => 'general',
),'',true,true);

return $settings;