<?php
/**
 * 当前时间
 * @param string $format
 * @return false|string
 */
function getNowAsString($format = 'Y-m-d H:i:s')
{
    return date($format, time());
}

/**
 * 加密
 * @param $str
 * @param string $salt
 * @return string
 */
function saltMd5($str, $salt = 'bbs')
{
    return md5($str . $salt);
}

function avatar($url)
{
    return empty($url) ? C('DEFAULT.avatar') : $url;
}