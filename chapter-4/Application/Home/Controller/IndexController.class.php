<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
	public function index()
	{
		$this->redirect('login', 'role=admin', 3, '请登录');
	}

	public function bind($id = 1)
	{
		echo U('Blog/view', array('id' => 1), 'shtml');
	}

	public function login()
	{
		if (IS_POST)
		{
			echo '当前为POST请求方法，需要处理登录逻辑';
		}
		else if (IS_GET)
		{
			echo '当前为空GET请求方法，需要显示登录页面';
		}
		else
		{
			echo '非法请求';
		}
	}
}