<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Model;

/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/8/13 0013
 * Time: 11:29
 */

/**
 * 首页控制器
 * Class IndexController
 * @package Admin\Controller
 */
class IndexController extends Controller
{
	/**
	 * @var array 不需要登录的操作
	 */
	protected $publicActions = array(
		'login'
	);

	protected function _initialize()
	{
		if (!in_array(ACTION_NAME, $this->publicActions) && session('admin.adminid') === null)
		{
			$this->error('请登录', U('admin/index/login'));
		}
		C('LAYOUT_NAME', 'admin');
	}

	public function login()
	{
		if (IS_POST)
		{
			$model = new Model('Admin');
			$username = I('username');
			$password = I('password');
			$admin = $model->where(array('username' => $username, 'password' => saltEncrypt($password)))->find();
			if (empty($admin))
			{
				$this->error('账号或密码错误');
			}
			//登录成功
			session('admin.adminid', $admin['adminid']);
			session('admin.loginat', $admin['loginat']);
			session('admin.loginip', $admin['loginip']);
			//更新登录时间
			$model->where(array('adminid' => $admin['adminid']))->save(array('loginat' => time(), 'loginip' => get_client_ip()));
			$this->redirect('admin/index/index');
		}
		C('LAYOUT_NAME', 'simple');
		$this->display();
	}

	public function index()
	{
		$this->display();
	}

	public function logout()
	{
		session_destroy();
		$this->redirect('admin/index/login');
	}
}