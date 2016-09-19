<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/19 0019
 * Time: 14:54
 */

namespace Common\Model;


use Admin\Controller\BaseController;
use Think\Exception;
use Think\Model;

/**
 * 管理员Model
 * Class AdminModel
 * @package Common\Model
 */
class AdminModel extends Model
{
    /**
     * 管理员登录
     * @param $username
     * @param $password
     * @return mixed
     * @throws Exception
     */
    public function login($username, $password)
    {
        $user = $this->where(array('username' => $username))->find();
        if (empty($user) || $user['password'] != saltMd5($password)) {
            throw new Exception('用户名或密码错误');
        }
        session(BaseController::SESSION_KEY, $user);
        return $user;
    }
}