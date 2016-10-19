<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/19
 * Time: 17:27
 */

namespace Admin\Controller;


use Common\Model\PostViewModel;

class PostController extends BaseController
{
    public function index()
    {
        $modelPost = new PostViewModel();
        list($postList, $page, $postCount) = $modelPost->getList(0);
        $this->assign('postList', $postList);
        $this->assign('page', $page);
        $this->assign('postCount', $postCount);
        $this->display();
    }
}