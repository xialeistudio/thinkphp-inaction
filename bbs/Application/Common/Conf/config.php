<?php
$db = require __DIR__ . '/db.php';
$config = array(
	'URL_CASE_INSENSITIVE' => false,
	'URL_MODEL' => 2,
	'URL_HTML_SUFFIX' => '',
	'site' => array(
		'name' => 'BBS'
	),
	'MODULE_ALLOW_LIST' => array('Home', 'Admin'),
	'DEFAULT_MODULE' => 'Home',
	'TMPL_PARSE_STRING' => array(
		'__PUBLIC__' => '/thinkphp-inaction/bbs/public',
	),
	'LAYOUT_ON' => true
);
return array_merge($config, $db);