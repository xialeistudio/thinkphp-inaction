<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/19 0019
 * Time: 15:54
 */

namespace Admin\Controller;

use Common\Model\BoardModel;
use Think\Exception;


/**
 * 版块管理
 * Class BoardController
 * @package Admin\Controller
 */
class BoardController extends BaseController
{
    public function index()
    {
        $model = new BoardModel();
        $list = $model->all();
        $this->assign('list', $list);
        $this->assign('pageTitle', '版块列表');
        $this->display();
    }

    /**
     * 添加版块
     */
    public function create()
    {
        try {
            $model = new BoardModel();
            if (IS_POST) {
                $model->post($_POST);
                $this->redirect('index');
            } else {
                $this->assign('pageTitle', '添加版块');
                $this->display('post');
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 编辑版块
     * @param $id
     */
    public function update($id)
    {
        try {
            $model = new BoardModel();
            $board = $model->find($id);
            if (empty($board)) {
                throw new Exception('版块不存在');
            }
            if (IS_POST) {
                $model->post($_POST, $id);
                $this->redirect('index');
            } else {
                $this->assign('board', $board);
                $this->assign('pageTitle', '编辑版块');
                $this->display('post');
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 删除版块
     * @param $id
     */
    public function delete($id)
    {
        try {
            $model = new BoardModel();
            if ($model->delete($id) === false) {
                throw new Exception('删除失败');
            }
            $this->redirect('index');
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}