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
    'LAYOUT_ON' => true,
    'DEFAULT' => array(
        'avatar' => 'http://localhost/thinkphp-inaction/bbs/upload/2016-09-19/57dfa8dcf2b41.jpg'
    )
);
return array_merge($config, $db);