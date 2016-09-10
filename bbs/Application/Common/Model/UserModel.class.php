<?php
namespace Common\Model;

use Think\Exception;
use Think\Model;

/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/10 0010
 * Time: 16:03
 */
class UserModel extends Model
{
    protected $_validate = array(
        array('username', 'require', '用户名不能为空', self::MUST_VALIDATE, null, self::MODEL_INSERT),//注册时必须填写用户名
        array('username', null, '用户名已存在', self::MUST_VALIDATE, 'unique', self::MODEL_INSERT),//注册时检测用户名是否被使用
        array('repassword', 'password', '确认密码不一致', self::EXISTS_VALIDATE, 'confirm'),
        array('nickname', 'require', '昵称不能为空'),
        array('nickname', null, '昵称已存在', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH)
    );

    protected $_auto = array(
        array('password', 'saltMd5', self::MODEL_BOTH, 'function'),
        array('createdAt', 'getNowAsString', self::MODEL_INSERT, 'function'),
        array('createdIp', 'getIp', self::MODEL_INSERT, 'callback')
    );

    /**
     * 获取地址数字
     * @return mixed
     */
    public function getIp()
    {
        return get_client_ip(1, true);
    }

    /**
     * 注册
     * @param array $data
     * @throws Exception
     */
    public function register(array $data)
    {
        $model = new UserModel();
        if (!$model->create($data)) {
            throw new  Exception($model->getError());
        }
        if (!$model->add()) {
            throw new Exception('注册时间');
        }
    }

    /**
     * 登录
     * @param $username
     * @param $password
     * @return mixed
     * @throws Exception
     */
    public function login($username, $password)
    {
        $model = new UserModel();
        $user = $model->find(array('username' => $username));
        if (empty($user) || $user['password'] != saltMd5($password)) {
            throw new Exception('用户名或密码错误');
        }
        session('user', $user);
        return $user;
    }
}