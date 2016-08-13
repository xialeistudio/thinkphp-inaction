<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/8/13 0013
 * Time: 14:17
 */
/**
 * 安全加密
 * @param $password
 * @param string $salt
 * @return string
 */
function saltEncrypt($password, $salt = 'thinkphp-inaction')
{
	return md5($password . $salt);
}