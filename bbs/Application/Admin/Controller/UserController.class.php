<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/19 0019
 * Time: 15:21
 */

namespace Admin\Controller;

use Common\Model\UserModel;
use Think\Exception;
use Think\Page;

/**
 * 用户管理
 * Class UserController
 * @package Admin\Controller
 */
class UserController extends BaseController
{
    /**
     * 首页
     */
    public function index()
    {
        $model = new UserModel();
        $count = $model->count();
        $page = new Page($count, 30);
        $list = $model->limit($page->firstRow . ',' . $page->listRows)->order('userId DESC')->select();
        $this->assign('pageTitle', '用户列表');
        $this->assign('page', $page->show());
        $this->assign('list', $list);
        $this->assign('count', $count);
        $this->display();
    }

    /**
     * 编辑资料
     * @param $id
     */
    public function update($id)
    {
        try {
            $model = new UserModel();
            $user = $model->find($id);
            unset($user['password']);
            if (empty($user)) {
                throw new Exception('用户不存在');
            }
            if (IS_POST) {
                $data = $_POST;
                $unsets = array('userId', 'username', 'createdAt', 'createdIp', 'postCount');
                if (empty($data['password'])) {
                    $unsets[] = 'password';
                } else {
                    $data['password'] = saltMd5($data['password']);
                }
                foreach ($unsets as $unset) {
                    unset($data[$unset]);
                }
                $result = $model->where(array('userId' => $id))->save($data);
                if ($result === false) {
                    throw new Exception('编辑失败');
                }
                $this->redirect('/admin/user');
            } else {
                $this->assign('user', $user);
                $this->assign('pageTitle', '编辑用户');
                $this->display();
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 删除用户
     * @param $id
     */
    public function delete($id)
    {
        try {
            $model = new UserModel();
            if ($model->delete($id) === false) {
                throw new Exception('删除失败');
            }
            $this->redirect('/admin/user');
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}