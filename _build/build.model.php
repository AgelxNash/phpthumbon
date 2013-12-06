<?php
require 'build.config.php';

/* define sources */
$root = dirname(dirname(dirname(__FILE__))).'/';
$sources = array(
    'root' => $root,
    'build' => $root . PKG_NAME_LOWER . '/_build/',
    'source_core' => $root.'core/components/'.PKG_NAME_LOWER,
    'model' => $root.'core/components/'.PKG_NAME_LOWER.'/model/',
    'xml' => $root . PKG_NAME_LOWER . '/_build/schema/'.PKG_NAME_LOWER.'.mysql.schema.xml',
);
unset($root);

require MODX_CORE_PATH . 'model/modx/modx.class.php';
require $sources['build'] . '/includes/functions.php';

$modx= new modX();
$modx->initialize('mgr');
$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');
$modx->loadClass('transport.modPackageBuilder', '', false, true);

/** @var xPDOManager $manager */
$manager = $modx->getManager();
/** @var xPDOGenerator $generator */
$generator = $manager->getGenerator();

// Remove old model
rrmdir($sources['model'] . PKG_NAME_LOWER . '/mysql');

// Generate a new one
$generator->parseSchema($sources['xml'], $sources['model']);

$modx->log(modX::LOG_LEVEL_INFO, 'Model generated.');