<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/28 0028
 * Time: 10:23
 */

namespace Home\Controller;


use Common\Model\BoardModel;
use Common\Model\PostModel;
use Common\Model\PostViewModel;
use Think\Exception;

class ThreadController extends CommonController
{
    public function post($bid)
    {
        $this->checkLogin();
        $boardModel = new BoardModel();
        $board = $boardModel->view($bid, 1);
        $this->assign('board', $board);
        $this->display();
    }

    public function doPost()
    {
        $this->checkLogin();
        $title = I('title');
        $content = I('content');
        $boardId = I('boardId');

        $data = array(
            'title' => $title,
            'content' => $content,
            'boardId' => $boardId,
            'userId' => $this->user['userId']
        );
        $model = new PostModel();
        if (!$model->create($data)) {
            throw new Exception($model->getError());
        }
        if (!$model->add()) {
            throw new Exception('发帖失败');
        }
        $this->redirect('board/view?id=' . $model->getLastInsID());
    }

    public function view($id)
    {
        $postViewModel = new PostViewModel();
        $data = $postViewModel->find(array('postId' => $id));
        print_r($data);
    }
}