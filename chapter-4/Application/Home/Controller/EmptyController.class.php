<?php
/**
 * Project: thinkphp-inaction
 * User: xialeistudio<1065890063@qq.com>
 * Date: 2016-02-18
 */
namespace Home\Controller;

use Think\Controller;

class EmptyController extends Controller
{
	public function index()
	{
		$name = CONTROLLER_NAME;
		$this->view($name);
	}

	private function view($name)
	{
		echo 'name:' . $name;
	}
}