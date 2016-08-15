<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/8/13 0013
 * Time: 17:28
 */
namespace Admin\Controller;

use Think\Model;

class CategoryController extends BaseController
{
	public function index()
	{
		$model = new Model('Category');
		$list = $model->select();
		$this->assign('list', $list);
		$this->display();
	}

	public function add()
	{
		if (IS_POST)
		{
			$model = new Model('Category');
			$name = I('name');
			$isNav = I('isNav', 1);
			$sort = I('sort', 0);
			if (empty($name))
			{
				$this->error('请输入分类名称');
			}
			$isExists = $model->where(array('name' => $name))->find();
			if (!empty($isExists))
			{
				$this->error('分类已存在');
			}
			$data = array(
				'name' => $name,
				'isNav' => $isNav,
				'sort' => $sort
			);
			if (!$model->data($data)->add())
			{
				$this->error('添加失败');
			}
			$this->success('添加成功', U('admin/category/index'));
		}
		else
		{
			$this->display('post');
		}
	}

	public function edit($id)
	{
		$model = new Model('Category');
		$data = $model->find($id);
		if (empty($data))
		{
			$this->error('分类不存在', 'admin/category/index');
		}
		if (IS_POST)
		{
			$name = I('name');
			$isNav = I('isNav', 1);
			$sort = I('sort', 0);
			if (empty($name))
			{
				$this->error('请输入分类名称');
			}
			$data = array(
				'name' => $name,
				'isNav' => $isNav,
				'sort' => $sort
			);
			if (false === $model->where(array('categoryId' => $id))->save($data))
			{
				$this->error('编辑失败');
			}
			$this->success('编辑成功', U('admin/category/index'));
		}
		else
		{
			$this->assign('data', $data);
			$this->display('post');
		}
	}

	public function delete($id)
	{
		$model = new Model('Category');
		$category = $model->find($id);
		if (empty($category))
		{
			$this->error('分类不存在');
		}
		if ($category['total'] > 0)
		{
			$this->error('该分类下有文章，不可删除');
		}
		if (!$model->delete($id))
		{
			$this->error('删除失败');
		}
		$this->success('删除成功',U('admin/category/index'));
	}
}