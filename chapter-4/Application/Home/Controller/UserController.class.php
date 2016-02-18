<?php
/**
 * Project: thinkphp-inaction
 * User: xialeistudio<1065890063@qq.com>
 * Date: 2016-02-18
 */
namespace Home\Controller;

use Think\Controller;

class UserController extends Controller
{
	public function _empty($name)
	{
		$this->view($name);
	}

	private function view($name)
	{
		echo 'name:'.$name;
	}
}