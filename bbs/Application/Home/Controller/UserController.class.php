<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/10 0010
 * Time: 16:17
 */
namespace Home\Controller;

use Common\Model\UserModel;
use Think\Controller;
use Think\Exception;

class UserController extends Controller
{
    /**
     * 注册
     */
    public function register()
    {
        try {
            if (IS_POST) {
                $user = new UserModel();
                $user->register($_POST);
                $this->success('注册成功');
            } else {
                $this->display();
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 登录
     */
    public function login()
    {
        try {
            if (IS_POST) {
                $user = new UserModel();
                $user->login(I('username'), I('password'));
                $this->success('登录成功', U('/'));
            } else {
                $this->display();
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        session('user', null);
        session_destroy();
        $this->redirect('/');
    }
}