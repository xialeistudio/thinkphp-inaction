<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/12 0012
 * Time: 10:15
 */

namespace Admin\Controller;

use Common\Model\AdminModel;
use Think\Exception;

/**
 * Class AuthController
 * @package Admin\Controller
 */
class AuthController extends BaseController
{
    /**
     * 可以不登陆
     * @return bool
     */
    protected function loginRequired()
    {
        return false;
    }

    /**
     * 登录
     */
    public function login()
    {
        try {
            if (IS_POST) {
                $username = I('username');
                $password = I('password');
                $model = new AdminModel();
                $model->login($username, $password);
                $this->success('登录成功', U('/admin'));
            } else {
                C('LAYOUT_NAME', 'single');
                $this->assign('pageTitle', '登录');
                $this->display();
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function logout()
    {
        session(self::SESSION_KEY, null);
        session_destroy();
        $this->redirect('/admin/auth/login');
    }
}