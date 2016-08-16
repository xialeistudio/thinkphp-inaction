<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Image;
use Think\Model;
use Think\Upload;

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
		if (!in_array(ACTION_NAME, $this->publicActions) && session('admin.adminId') === null)
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
			session('admin.adminId', $admin['adminId']);
			session('admin.loginAt', $admin['loginAt']);
			session('admin.loginIp', $admin['loginIp']);
			//更新登录时间
			$data = array('loginAt' => time(), 'loginIp' => get_client_ip());
			$model->where(array('adminId' => $admin['adminId']))->save($data);
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

	public function profile()
	{
		if (IS_POST)
		{
			$password = I('password');
			$repassword = I('repassword');
			if (!empty($password) && $password != $repassword)
			{
				$this->error('确认密码不一致');
			}
			$data = array('password' => saltEncrypt($password));
			$model = new Model('Admin');
			$result = $model->where(array('adminId' => session('admin.adminId')))->save($data);
			if ($result === false)
			{
				$this->error('修改失败');
			}
			else
			{
				$this->success('修改成功');
			}
		}
		else
		{
			$this->display();
		}
	}

	public function upload()
	{
		$upload = new Upload();// 实例化上传类
		$upload->maxSize = 1024 * 1024 * 2;// 设置附件上传大小
		$upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath = __DIR__ . '/../../../upload/'; // 设置附件上传根目录
		$upload->savePath = ''; // 设置附件上传（子）目录
		// 上传文件
		$info = $upload->upload();
		if (!$info)
		{
			$this->ajaxReturn(array(
				'error' => $upload->getError()
			));
		}
		else
		{
			$path = $upload->rootPath . $info['file']['savepath'] . $info['file']['savename'];
			$image = new Image();
			$image->open($path);
			$image->thumb(200, 200, Image::IMAGE_THUMB_CENTER)->save($path);
			$this->ajaxReturn(array(
				'url' => U('/', '', false, true) . 'upload/' . $info['file']['savepath'] . $info['file']['savename']
			));
		}
	}
}