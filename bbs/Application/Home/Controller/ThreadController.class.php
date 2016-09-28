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
use Common\Model\ReplyModel;
use Common\Model\ReplyViewModel;
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
        try {
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
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 查看帖子
     * @param $id
     */
    public function view($id)
    {
        $postViewModel = new PostViewModel();
        $data = $postViewModel->view($id);
        $this->assign('thread', $data);
        list($replies, $replyCount) = (new ReplyViewModel())->getList($id);
        $this->assign('replies', $replies);
        $this->assign('replyCount', $replyCount);
        $this->display();
    }

    public function reply($id)
    {
        $this->checkLogin();
        $postViewModel = new PostViewModel();
        $data = $postViewModel->view($id);
        if (empty($data)) {
            $this->error('帖子不存在');
        }
        $this->assign('thread', $data);
        $this->display();
    }

    public function doReply()
    {
        $this->checkLogin();
        try {
            $data = array(
                'postId' => I('postId'),
                'content' => I('content'),
                'userId' => $this->user['userId']
            );
            $model = new ReplyModel();
            if (!$model->create($data)) {
                $this->error($model->getError());
            }
            if (!$model->add()) {
                $this->error('回复失败');
            }
            $this->redirect('thread/view?id=' . $data['postId']);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}