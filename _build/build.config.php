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

define('MODX_BASE_PATH', dirname(dirname(dirname(__FILE__))).'/');
define('MODX_CORE_PATH', MODX_BASE_PATH . 'core/');
define('MODX_MANAGER_PATH', MODX_BASE_PATH . 'manager/');
define('MODX_CONNECTORS_PATH', MODX_BASE_PATH . 'connectors/');
define('MODX_ASSETS_PATH', MODX_BASE_PATH . 'assets/');

/* define urls */
define('MODX_BASE_URL', '/');
define('MODX_CORE_URL', MODX_BASE_URL . 'core/');
define('MODX_MANAGER_URL', MODX_BASE_URL . 'manager/');
define('MODX_CONNECTORS_URL', MODX_BASE_URL . 'connectors/');
define('MODX_ASSETS_URL', MODX_BASE_URL . 'assets/');

/* define package */
define('PKG_NAME','phpThumbOn');
define('PKG_NAME_LOWER',strtolower(PKG_NAME));

define('PKG_VERSION', '1.3.1');
define('PKG_RELEASE','pl');
