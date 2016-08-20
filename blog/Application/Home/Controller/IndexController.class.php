<?php
namespace Home\Controller;

use Common\Model\ArticleCategoryViewModel;
use Think\Controller;
use Think\Model;
use Think\Page;

class IndexController extends Controller
{
	public function index()
	{
		//文章分页
		$condition = array(
			'status' => 1
		);
		$model = new ArticleCategoryViewModel();
		$count = $model->where($condition)->count();
		$page = new Page($count, 10);
		$list = $model->where($condition)->order('sort DESC,articleId DESC')->limit($page->firstRow . ',' . $page->listRows)->select();
		$this->assign('list', $list);
		$this->assign('page', $page->show());
		$this->display();
	}

	public function category($id)
	{
		$model = new Model('Category');
		$category = $model->find($id);
		if (empty($category))
		{
			$this->error('分类不存在');
		}
		$condition = array(
			'status' => 1,
			'categoryId' => $id
		);
		$model = new ArticleCategoryViewModel();
		$count = $model->where($condition)->count();
		$page = new Page($count, 10);
		$list = $model->where($condition)->order('sort DESC,articleId DESC')->limit($page->firstRow . ',' . $page->listRows)->select();
		$this->assign('list', $list);
		$this->assign('category', $category);
		$this->assign('page', $page->show());
		$this->display();
	}

	public function article($id)
	{
		$model = new ArticleCategoryViewModel();
		$article = $model->where(array('articleId' => $id))->find();
		if (empty($article))
		{
			$this->error('文章不存在');
		}
		$isHits = S('article-view-' . $id . '-' . get_client_ip());
		if (!$isHits)
		{
			$model->where(array('articleId' => $id))->setInc('hits');
			S('article-view-' . $id . '-' . get_client_ip(), 1, 600);
			$article['hits']++;
		}
		//评论
		$commentModel = new Model('Comment');
		$comments = $commentModel->where(array('articleId' => $id))->limit(30)->order('commentId DESC')->select();
		$this->assign('article', $article);
		$this->assign('comments', $comments);
		$this->display();
	}

	public function comment($id)
	{
		$model = new Model('Article');
		$article = $model->find(array('articleId' => $id));
		if (empty($article))
		{
			$this->error('文章不存在');
		}
		$key = get_client_ip() . '-view-article-' . $id;
		$cache = S($key);
		if (!empty($cache))
		{
			$this->error('评论间隔必须大于1分钟');
		}
		$nickname = I('nickname');
		$content = I('content');
		if (empty($nickname))
		{
			$this->error('昵称不能为空');
		}
		if (empty($content))
		{
			$this->error('评论内容不能为空');
		}
		$data = array(
			'nickname' => $nickname,
			'content' => $content,
			'createdAt' => time(),
			'createdIp' => get_client_ip(),
			'articleId' => $id
		);
		$commentModel = new Model('Comment');
		if (!$commentModel->data($data)->add())
		{
			$this->error('评论失败');
		}
		S($key, 1, 60);
		$data['createdAt'] = date('m-d H:i', $data['createdAt']);
		$this->ajaxReturn($data);
	}
}