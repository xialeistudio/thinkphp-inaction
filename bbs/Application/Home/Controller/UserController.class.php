<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/10 0010
 * Time: 16:17
 */
namespace Home\Controller;

use Common\Model\PostModel;
use Common\Model\PostViewModel;
use Common\Model\ReplyModel;
use Common\Model\ReplyViewModel;
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

    /**
     * 用户帖子列表
     */
    public function posts()
    {
        $this->checkLogin();
        $model = new PostViewModel();
        list($list, $page, $count) = $model->getList($this->user['userId']);
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('count', $count);
        $this->display();
    }

    /**
     * 编辑帖子
     */
    public function postEdit()
    {
        $this->checkLogin();
        $id = I('id');
        $model = new PostModel();
        $post = $model->find($id);
        if (empty($post)) {
            $this->error('帖子不存在');
        }
        if ($post['userId'] != $this->user['userId']) {
            $this->error('你无权编辑');
        }
        $callback = I('callback');
        if (!empty($callback)) {
            session('threadUpdateCallback', $callback);
        }
        $this->assign('post', $post);
        $this->display();
    }

    /**
     * 处理帖子编辑
     */
    public function postDoPost()
    {
        $this->checkLogin();
        try {
            $id = I('id');
            $title = I('title');
            $content = I('content');
            $data = array(
                'title' => $title,
                'content' => $content
            );
            $model = new PostModel();
            if ($model->where(array('postId' => $id))->save($data) === false) {
                throw new Exception('编辑失败');
            }
            $callback = session('threadUpdateCallback');
            if (empty($callback)) {
                $callback = U('posts');
            }
            session('threadUpdateCallback', null);
            $this->success('编辑成功', $callback);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 删除帖子
     */
    public function postDelete()
    {
        $this->checkLogin();
        $id = I('id');
        $model = new PostModel();
        $post = $model->find($id);
        if (empty($post)) {
            $this->error('帖子不存在');
        }
        if ($post['userId'] != $this->user['userId']) {
            $this->error('你无权删除');
        }

        $result = $model->delete($id);
        if ($result === false) {
            $this->error('删除失败');
        } else {
            $callback = I('callback');
            if (empty($callback)) {
                $callback = U('posts');
            }
            $this->success('删除成功', $callback);
        }
    }

    /**
     * 用户回复列表
     */
    public function replies()
    {
        $this->checkLogin();
        $model = new ReplyViewModel();
        list($list, $page, $count) = $model->getList(0, $this->user['userId']);
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('count', $count);
        $this->display();
    }

    /**
     * 删除回复
     */
    public function replyDelete()
    {
        $this->checkLogin();
        $id = I('id');
        $model = new ReplyModel();
        $post = $model->find($id);
        if (empty($post)) {
            $this->error('回复不存在');
        }
        if ($post['userId'] != $this->user['userId']) {
            $this->error('你无权删除');
        }
        $result = $model->delete($id);
        if ($result === false) {
            $this->error('删除失败');
        } else {
            $callback = I('callback');
            if (empty($callback)) {
                $callback = U('replies');
            }
            $this->success('删除成功', $callback);
        }
    }
}