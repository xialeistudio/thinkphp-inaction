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
			'username' => 'admin',
			'password' => '111111',
			'repassword' => '111111'
		);
		if (!$user->create($data))
		{
			echo $user->getError();
			exit;
		}
		echo 'ok';
	}
}