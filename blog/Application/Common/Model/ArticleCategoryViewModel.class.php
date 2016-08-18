<?php
namespace Common\Model;

use Think\Model\ViewModel;

/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/8/16 0016
 * Time: 11:49
 */
class ArticleCategoryViewModel extends ViewModel
{
	public $viewFields = array(
		'Article' => array('articleId', 'title', 'description', 'image', 'hits', 'createdAt', 'updateAt', 'status', 'sort', 'content'),
		'Category' => array('categoryId', 'name', '_on' => 'Article.categoryId=Category.categoryId')
	);
}