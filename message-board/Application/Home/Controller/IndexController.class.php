<?php
namespace Home\Controller;

use Home\Model\MessageViewModel;
use Think\Controller;
use Think\Model;
use Think\Page;

class IndexController extends Controller
{
    /**
     * 检测登录
     */
    private function checkLogin()
    {
        if (!session('user.userId')) {
            $this->error('请登录', U('User/login'));
        }
    }

    /**
     * 留言列表
     */
    public function index()
    {
        $model = new MessageViewModel();
        $count = $model->count();

        $page = new Page($count, 1);
        $show = $page->show();
        $list = $model->order('message_id desc')->limit($page->firstRow . ',' . $page->listRows)->select();

        $this->assign('page', $show);
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * 发表留言
     */
    public function post()
    {
        $this->display();
    }

    /**
     * 留言处理
     */
    public function do_post()
    {
        $this->checkLogin();
        $content = I('content');
        if (empty($content)) {
            $this->error('留言内容不能为空');
        }
        if (mb_strlen($content, 'utf-8') > 100) {
            $this->error('留言内容最多100字');
        }

        $model = new Model('Message');
        $userId = session('user.userId');
        $data = array(
            'content' => $content,
            'created_at' => time(),
            'user_id' => $userId
        );
        if (!($model->create($data) && $model->add())) {
            $this->error('留言失败');
        }
        $this->success('留言成功', U('Index/index'));
    }

    public function delete()
    {
        $id = I('id');
        if (empty($id)) {
            $this->error('缺少参数');
        }
        $this->checkLogin();
        $model = new Model('Message');
        if (!$model->where(array('message_id' => $id, 'user_id' => session('user.userId')))->delete()) {
            $this->error('删除失败');
        }
        $this->success('删除成功', U('index'));
    }
}