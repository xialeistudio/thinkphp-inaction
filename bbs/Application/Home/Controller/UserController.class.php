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

class UserController extends CommonController
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
                $callback = session('callback');
                $this->success('登录成功', empty($callback) ? U('/') : $callback);
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

    /**
     * 用户主页
     */
    public function home()
    {
        $this->checkLogin();
        $model = new UserModel();
        if (IS_POST) {
            $avatar = I('avatar');
            $nickname = I('nickname');
            $password = I('password');
            if (!$model->create()) {
                $this->error($model->getError());
            }
            $data = [
                'avatar' => $avatar,
                'nickname' => $nickname
            ];
            if (!empty($password)) {
                $data['password'] = $password;
            }
            if ($model->where(array('userId' => $this->user['userId']))->save() === false) {
                $this->error('编辑失败');
            }
            $this->success('编辑成功');
        } else {
            $user = $model->find($this->user['userId']);
            $this->assign('user', $user);
            $this->display();
        }
    }
}