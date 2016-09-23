<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/23 0023
 * Time: 16:29
 */

namespace Home\Controller;


use Common\Model\BoardModel;
use Think\Exception;

class BoardController extends CommonController
{
    public function index($id)
    {
        try {
            $model = new BoardModel();
            $board = $model->view($id, 1);
            $this->assign('board', $board);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}