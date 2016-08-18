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

function array2xml($data, $rootNodeName = 'data', $xml = null)
{
	// turn off compatibility mode as simple xml throws a wobbly if you don't.
	if (ini_get('zend.ze1_compatibility_mode') == 1)
	{
		ini_set('zend.ze1_compatibility_mode', 0);
	}
	if ($xml == null)
	{
		/** @var \SimpleXMLElement $xml */
		$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
	}
	// loop through the data passed in.
	foreach ($data as $key => $value)
	{
		// no numeric keys in our xml please!
		if (is_numeric($key))
		{
			// make string key...
			$key = "unknownNode_" . (string)$key;
		}
		// replace anything not alpha numeric
		$key = preg_replace('/[^a-z]/i', '', $key);
		// if there is another array found recrusively call this function
		if (is_array($value))
		{
			$node = $xml->addChild($key);
			// recrusive call.
			array2xml($value, $rootNodeName, $node);
		}
		else
		{
			// add single node.
			$value = htmlentities($value);
			$xml->addChild($key, $value);
		}
	}
	// pass back as string. or simple xml object if you want!
	return $xml->asXML();
}

/**
 * 获取分类
 * @param int $isNav
 * @return mixed
 */
function getCategory($isNav = -1)
{
	$map = array();
	if ($isNav > -1)
	{
		$map['isNav'] = $isNav;
	}
	$model = new \Think\Model('Category');
	return $model->where($map)->order('sort DESC')->select();
}

function getLinks()
{
	return M('Link')->where(array('status' => 1))->order('linkId DESC')->select();
}