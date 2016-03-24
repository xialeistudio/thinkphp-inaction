<?php
namespace Home\Model;

use Think\Model;

/**
 * Project: thinkphp-inaction
 * User: xialeistudio<1065890063@qq.com>
 * Date: 2016-03-24
 */
class UserModel extends Model
{
	private $denyUsernames = array(
		'admin',
		'administrator'
	);
	public $_validate = array(
		array('username', 'require', '用户名不能为空'),
		array('password', 'require', '密码不能为空', 1, '', 1),
		array('username', '', '用户名已存在', 0, 'unique', 1),
		array('password', '6,20', '密码长度必须在6-20', 0, 'length'),
		array('password', '/^\w{6,20}$/', '密码格式错误'),
		array('password', 'repassword', '确认密码错误', 0, 'confirm', 1),
		array('username', 'checkUsername', '用户名非法', 0, 'callback')
	);

	/**
	 * 检测用户名 如果在屏蔽注册的账号中，直接报错
	 * @param string $username
	 * @return bool
	 */
	public function checkUsername($username)
	{
		foreach ($this->denyUsernames as $u)
		{
			if (strpos($username, $u) !== false)
			{
				return false;
			}
		}
		return true;
	}

}