<?php
namespace Home\Controller;

use Common\Model\BoardModel;
use Common\Model\BoardViewModel;
use Common\Model\BoardWithAdminModel;
use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        //版块列表
        $boards = (new BoardModel())->all(1);
        $this->assign('boards', $boards);
        $this->display();
    }
}