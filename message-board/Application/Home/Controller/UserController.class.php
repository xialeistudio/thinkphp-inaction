<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/7/11 0011
 * Time: 10:41
 */
namespace Home\Controller;

use Think\Controller;
use Think\Model;

/**
 * 用户控制器
 * Class UserController
 * @package Home\Controller
 */
class UserController extends Controller
{
	/**
	 * 注册表单
	 */
	public function register()
	{
		$this->display();
	}

	/**
	 * 注册处理
	 */
	public function do_register()
	{
		$username = I('username');
		$password = I('password');
		$repassword = I('repassword');
		if (empty($username))
		{
			$this->error('用户名不能为空');
		}
		if (empty($password))
		{
			$this->error('密码不能为空');
		}
		if ($password != $repassword)
		{
			$this->error('确认密码错误');
		}
		//检测用户是否已注册
		$model = new Model('User');
		$user = $model->where(array('username' => $username))->find();
		if (!empty($user))
		{
			$this->error('用户名已存在');
		}
		$data = array(
			'username' => $username,
			'password' => md5($password),
			'created_at' => time()
		);
		if (!($model->create($data) && $model->add()))
		{
			$this->error('注册失败！' . $model->getDbError());
		}
		$this->success('注册成功，请登录', U('login'));
	}

	/**
	 * 用户登录
	 */
	public function login()
	{
		$this->display();
	}

	/**
	 * 登录处理
	 */
	public function do_login()
	{
		$username = I('username');
		$password = I('password');
		$model = new Model('User');
		$user = $model->where(array('username' => $username))->find();
		if (empty($user) || $user['password'] != md5($password))
		{
			$this->error('账号或密码错误');
		}
		//写入session
		session('user.userId', $user['user_id']);
		session('user.username', $user['username']);
		//跳转首页
		$this->redirect('Index/index');
	}

	/**
	 * 退出登录
	 */
	public function logout()
	{
		if (!session('user.userId'))
		{
			$this->error('请登录');
		}
		session_destroy();
		$this->success('退出登录成功', U('Index/index'));
	}
}