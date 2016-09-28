<?php
namespace Home\Controller;

use Common\Model\BoardModel;
use Common\Model\BoardViewModel;
use Common\Model\BoardWithAdminModel;
use Common\Model\PostViewModel;
use Common\Model\UserModel;
use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        //版块列表
        $boards = (new BoardModel())->all(1);
        //最新帖子
        $list = (new PostViewModel())->latest(5);
        //最新成员
        $users = (new UserModel())->latest();
        $this->assign('boards', $boards);
        $this->assign('posts', $list);
        $this->assign('users', $users);
        $this->display();
    }
}