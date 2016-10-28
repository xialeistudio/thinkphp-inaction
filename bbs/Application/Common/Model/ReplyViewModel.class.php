<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/28 0028
 * Time: 11:46
 */

namespace Common\Model;


use Common\Lib\Page;
use Think\Model\ViewModel;

class ReplyViewModel extends ViewModel
{
    public $viewFields = array(
        'Reply' => array('replyId', 'createdAt' => 'replyAt', 'content'),
        'Post' => array('postId', 'title', '_on' => 'Post.postId=Reply.postId'),
        'User' => array('userId', 'avatar', 'nickname', 'score', 'postCount', '_on' => 'User.userId=Reply.userId'),
    );

    /**
     * 回复列表
     * @param int $postId
     * @param int $userId
     * @param int $size
     * @return array
     */
    public function getList($postId = 0, $userId = 0, $size = 10)
    {
        $condition = array();
        if ($postId > 0) {
            $condition['postId'] = $postId;
        }
        if ($userId > 0) {
            $condition['userId'] = $userId;
        }
        $count = $this->where($condition)->count();
        $page = new Page($count, $size);
        $list = $this->where($condition)->order('replyId ASC')->limit($page->firstRow . ',' . $page->listRows)->select();
        return [$list, $page->show(), $count];
    }
}