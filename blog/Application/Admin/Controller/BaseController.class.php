<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/8/13 0013
 * Time: 17:25
 */
namespace Admin\Controller;

use Think\Controller;

class BaseController extends Controller
{
	protected function _initialize()
	{
		if (session('admin.adminId') === null)
		{
			$this->error('请登录', U('admin/index/login'));
		}
		C('LAYOUT_NAME', 'admin');
	}
}