<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/8/18 0018
 * Time: 16:57
 */
namespace Admin\Controller;

use Think\Model;
use Think\Page;

class CommentController extends BaseController
{
	public function index()
	{
		$model = new Model('Comment');
		$count = $model->count();
		$page = new Page($count, 30);
		$list = $model->order('commentId DESC')->limit($page->firstRow . ',' . $page->listRows)->select();
		$this->assign('list', $list);
		$this->assign('page', $page->show());
		$this->display();
	}

	public function delete($id)
	{
		$model = new Model('Comment');
		$data = $model->find($id);
		if (empty($data))
		{
			$this->error('评论不存在');
		}
		if (!$model->delete($id))
		{
			$this->error('删除失败');
		}
		else
		{
			$this->success('删除成功');
		}
	}
}