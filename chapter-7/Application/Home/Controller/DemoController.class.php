<?php
/**
 * User: xialei
 * Date: 2016/6/27 0027
 * Time: 15:16
 */
namespace Home\Controller;

use Think\Controller;

class DemoController extends Controller
{
	public function index()
	{
		$projects = array(
			array(
				'name' => 'PHP',
				'members' => array(
					array(
						'id' => 1,
						'name' => 'Jim'
					),
					array(
						'id' => 2,
						'name' => 'Tom'
					)
				),
			),
			array(
				'name' => 'Java',
				'members' => array(
					array(
						'id' => 3,
						'name' => 'White'
					),
					array(
						'id' => 4,
						'name' => 'Black'
					)
				)
			)
		);
		$age = 18;
		$this->assign('projects', $projects);
		$this->assign('age', $age);
		$this->display();
	}
}