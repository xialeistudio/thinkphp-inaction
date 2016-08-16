<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/8/16 0016
 * Time: 14:40
 */
namespace Admin\Controller;

use Org\Net\Http;
use Think\Model;
use Think\Page;

class LinkController extends BaseController
{
	public function index()
	{
		$model = new Model('Link');
		$count = $model->count();
		$page = new Page($count);
		$show = $page->show();
		$list = $model->order('linkId DESC')->limit($page->firstRow . ',' . $page->listRows)->select();
		$this->assign('list', $list);
		$this->assign('page', $show);
		$this->display();
	}


	public function add()
	{
		if (IS_POST)
		{
			$model = new Model('Link');
			$name = I('name');
			$link = I('link');
			$status = I('status', 1);
			$sort = I('sort', 0);
			if (empty($name))
			{
				$this->error('网站名称不能为空');
			}
			if (empty($link))
			{
				$this->error('网站链接不能为空');
			}
			$data = array(
				'name' => $name,
				'link' => $link,
				'status' => $status,
				'sort' => $sort
			);
			if (!$model->data($data)->add())
			{
				$this->error('添加失败');
			}
			else
			{
				$this->success('添加成功', U('admin/link/index'));
			}
		}
		else
		{
			$this->display('post');
		}
	}

	public function delete($id)
	{
		if (M('Link')->delete($id) !== false)
		{
			$this->success('删除成功');
		}
		else
		{
			$this->error('删除失败');
		}
	}

	public function edit($id)
	{
		$model = new Model('Link');
		$data = $model->find($id);
		if (empty($data))
		{
			$this->error('链接不存在');
		}
		if (IS_POST)
		{
			$name = I('name');
			$link = I('link');
			$status = I('status', 1);
			$sort = I('sort', 0);
			if (empty($name))
			{
				$this->error('网站名称不能为空');
			}
			if (empty($link))
			{
				$this->error('网站链接不能为空');
			}
			$data = array(
				'name' => $name,
				'link' => $link,
				'status' => $status,
				'sort' => $sort
			);
			if (false === $model->where(array('linkId' => $id))->save($data))
			{
				$this->error('编辑失败');
			}
			else
			{
				$this->success('编辑成功', U('admin/link/index'));
			}
		}
		else
		{
			$this->assign('data', $data);
			$this->display('post');
		}
	}


}