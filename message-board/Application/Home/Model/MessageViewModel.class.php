<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/7/11 0011
 * Time: 11:07
 */

namespace Home\Model;


use Think\Model\ViewModel;

class MessageViewModel extends ViewModel
{
    public $viewFields = array(
        'Message' => array('message_id', 'content', 'created_at'),
        'User' => array('user_id', 'username', '_on' => 'User.user_id=Message.user_id')
    );
}