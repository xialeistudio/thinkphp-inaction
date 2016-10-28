<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/28
 * Time: 16:53
 */

namespace Admin\Controller;

use Common\Model\PostModel;
use Common\Model\ReplyModel;
use Common\Model\ReplyViewModel;

/**
 * 回复列表
 * Class ReplyController
 * @package Admin\Controller
 */
class ReplyController extends BaseController
{
    public function index()
    {
        $pid = I('pid', 0);
        $modelPost = new ReplyViewModel();
        list($list, $page, $postCount) = $modelPost->getList($pid, 0);
        if ($pid > 0) {
            $post = (new PostModel())->find($pid);
            $this->assign('post', $post);
        }
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('postCount', $postCount);
        $this->display();
    }

    public function delete()
    {

        $id = I('id');
        $model = new ReplyModel();
        $post = $model->find($id);
        if (empty($post)) {
            $this->error('回复不存在');
        }

        $result = $model->delete($id);
        if ($result === false) {
            $this->error('删除失败');
        } else {
            $this->success('删除成功');
        }
    }
}