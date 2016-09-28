<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/28 0028
 * Time: 11:37
 */

namespace Common\Model;


use Think\Model;

class ReplyModel extends Model
{
    public $pk = 'replyId';
    public $_validate = array(
        array('content', 'require', '回复内容不能为空'),
        array('userId', 'require', '帖子内容不能为空'),
        array('postId', 'require', '版块不能为空'),
    );

    public $_auto = array(
        array('createdAt', 'getNowAsString', self::MODEL_INSERT, 'function'),
    );
}