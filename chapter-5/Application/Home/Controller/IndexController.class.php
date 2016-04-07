<?php
namespace Home\Controller;

use Home\Model\PostModel;
use Home\Model\PostViewModel;
use Home\Model\UserModel;
use Think\Controller;
use Think\Model;

class IndexController extends Controller
{
	public function index()
	{
		$user = new UserModel();
		$data = array(
			'username' => 'zhangsan',
			'password' => '111111',
			'repassword' => '111111'
		);
		if (!$user->create($data))
		{
			echo $user->getError();
			exit;
		}
		else
		{
			$id = $user->add();
			print_r($user->find($id));
		}
	}

	public function update()
	{
		$user = new UserModel();
		$data = array(
			'id' => 6,
			'username' => 'zhangsan',
			'password' => '222222',
		);
		if (!$user->create($data))
		{
			echo $user->getError();
			exit;
		}
		else
		{
			$user->save();
			print_r($user->find(6));
		}
	}

	public function posts()
	{
		$m = new PostViewModel();
		$data = $m->select();
		print_r($data);
	}

	public function posts2()
	{
		$m = new UserModel();
		$data = $m->relation('extra')->find();
		print_r($data);
	}

	public function posts3()
	{
		$m = new PostModel();
		$data = $m->relation('author')->find();
		print_r($data);
	}

	public function posts4()
	{
		$m = new UserModel();
		$data = $m->relation('posts')->find();
		print_r($data);
	}
}