<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/23 0023
 * Time: 16:29
 */

namespace Home\Controller;


use Common\Model\BoardModel;
use Common\Model\PostModel;
use Common\Model\PostViewModel;
use Think\Exception;

class BoardController extends CommonController
{
    public function index($id)
    {
        try {
            $model = new BoardModel();
            $modelPost = new PostViewModel();
            $board = $model->view($id, 1);
            $admins = $model->getAdmins($id);
            list($postList, $page, $postCount) = $modelPost->getList(0, $id);
            $this->assign('board', $board);
            $this->assign('admins', $admins);
            $this->assign('postList', $postList);
            $this->assign('page', $page);
            $this->assign('postCount', $postCount);
            $this->display();
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}