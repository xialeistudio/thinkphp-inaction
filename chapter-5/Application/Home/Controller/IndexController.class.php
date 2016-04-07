<?php
namespace Home\Controller;

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
}