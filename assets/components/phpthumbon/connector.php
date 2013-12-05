<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
define('MODX_REQP', false);
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('phpthumbon.core_path',array(), $modx->getOption('core_path').'components/phpthumbon/');
$modx->addPackage("ThumbImages", $corePath."model/");

$path = $modx->getOption('phpthumbon.processors_path', array(), $modx->getOption('core_path').'components/phpthumbon/processors/');

$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));