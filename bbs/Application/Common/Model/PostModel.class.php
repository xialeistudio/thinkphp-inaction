<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/23 0023
 * Time: 16:46
 */

namespace Common\Model;


use Think\Model;

class PostModel extends Model
{
    public $_validate = array(
        array('title', 'require', '帖子标题'),
        array('content', 'require', '帖子内容不能为空'),
        array('boardId', 'require', '版块不能为空'),
        array('userId', 'require', '用户ID不能为空')
    );
}