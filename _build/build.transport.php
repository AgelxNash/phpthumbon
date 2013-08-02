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
 * @date 02.08.2013
 * @version 1.0.
 *
 */
/**
 * @package phpThumbOn
 * @subpackage build
 */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

/* set package defines */
define('PKG_NAME','phpThumbOn');
define('PKG_NAME_LOWER',strtolower(PKG_NAME));
define('PKG_VERSION','1.0.0');
define('PKG_RELEASE','pl');

/* override with your own defines here (see build.config.sample.php) */
require_once dirname(__FILE__) . '/build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
require_once dirname(__FILE__). '/includes/functions.php';

$modx= new modX();
$root = dirname(dirname(__FILE__)).'/';
$assets = MODX_ASSETS_PATH.'components/'.PKG_NAME_LOWER.'/';
$sources= array (
    'root' => $root,
    'build' => $root .'_build/',
    'resolvers' => $root . '_build/resolvers/',
    'data' => $root . '_build/data/',
    'properties' => $root . '_build/properties/',
    'events' => $root . '_build/data/events/',
    'source_core' => $root.'core/components/'.PKG_NAME_LOWER,
    'source_assets' => $root.'assets/components/'.PKG_NAME_LOWER,
    'plugins' => $root.'core/components/'.PKG_NAME_LOWER.'/elements/plugins/',
    'snippets' => $root.'core/components/'.PKG_NAME_LOWER.'/elements/snippets/',
    'lexicon' => $root.'core/components/'.PKG_NAME_LOWER.'/lexicon/',
    'docs' => $root.'core/components/'.PKG_NAME_LOWER.'/docs/',
);
unset($root);

$modx->initialize('mgr');
echo '<pre>';
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME,PKG_VERSION,PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER,false,true,'{core_path}components/'.PKG_NAME_LOWER.'/');

/* package snippets */
$snippets = include $sources['data'].'transport.snippets.php';
if (!is_array($snippets)) { $modx->log(modX::LOG_LEVEL_FATAL,'Adding snippets failed.'); }
$attr = array(
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => 'name',
);
$i = 1;
foreach ($snippets as $snippet) {
    $vehicle = $builder->createVehicle($snippet,$attr);
    if ($i == count($snippets)) {
        $vehicle->resolve('file',array(
            'source' => $sources['source_core'],
            'target' => "return MODX_CORE_PATH . 'components/';",
        ));
        $vehicle->resolve('file',array(
            'source' => $sources['source_assets'],
            'target' => "return MODX_ASSETS_PATH . 'components/';",
        ));
    }
    $builder->putVehicle($vehicle);
    $i++;
}
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($snippets).' Snippets.'); flush();

/* load system settings */
$settings = include_once $sources['data'].'transport.settings.php';
if (!is_array($settings)) $modx->log(modX::LOG_LEVEL_FATAL,'No settings returned.');
$attributes= array(
    xPDOTransport::UNIQUE_KEY => 'key',
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => false,
);
foreach ($settings as $setting) {
    $vehicle = $builder->createVehicle($setting,$attributes);
    $builder->putVehicle($vehicle);
}
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($settings).' System Settings.'); flush();
unset($settings,$setting,$attributes);

/* now pack in the license file, readme and setup options */
$builder->setPackageAttributes(array(
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
));

$builder->pack();

$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

$modx->log(modX::LOG_LEVEL_INFO,"\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");

exit ();