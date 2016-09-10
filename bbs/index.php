<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/8/13 0013
 * Time: 11:19
 */
if (version_compare(PHP_VERSION, '5.3.0', '<')) die('require PHP > 5.3.0 !');
define('APP_DEBUG', true);
define('APP_PATH', './Application/');
define('BUILD_DIR_SECURE', false);
require '../ThinkPHP/ThinkPHP.php';