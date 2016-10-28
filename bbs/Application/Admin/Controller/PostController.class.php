<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/19
 * Time: 17:27
 */

namespace Admin\Controller;


use Common\Model\BoardModel;
use Common\Model\PostModel;
use Common\Model\PostViewModel;
use Think\Exception;

class PostController extends BaseController
{
    public function index()
    {
        $bid = I('bid', 0);
        $modelPost = new PostViewModel();
        list($postList, $page, $postCount) = $modelPost->getList(0, $bid);
        if ($bid > 0) {
            $board = (new BoardModel())->find($bid);
            $this->assign('board', $board);
        }
        $this->assign('postList', $postList);
        $this->assign('page', $page);
        $this->assign('postCount', $postCount);
        $this->display();
    }

    public function delete()
    {
        $id = I('id');
        $model = new PostModel();

        $result = $model->delete($id);
        if ($result === false) {
            $this->error('删除失败');
        } else {
            $this->success('删除成功');
        }
    }

    public function edit()
    {
        $id = I('id');
        $model = new PostModel();
        $post = $model->find($id);
        if (empty($post)) {
            $this->error('帖子不存在');
        }
        $this->assign('post', $post);
        $this->display();
    }

    public function doPost()
    {
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
            $this->success('编辑成功', U('post/index'));
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}