<?php
/**
 * Created by PhpStorm.
 * User: xialei
 * Date: 2016/4/7 0007
 * Time: 15:08
 */
namespace Home\Model;

use Think\Model\ViewModel;

class PostViewModel extends ViewModel
{
	public $viewFields = array(
		'Post' => array('post_id', 'title', 'content', 'created_at', 'updated_at'),
		'User' => array('username' => 'author', '_on' => 'Post.user_id=User.id')
	);
}