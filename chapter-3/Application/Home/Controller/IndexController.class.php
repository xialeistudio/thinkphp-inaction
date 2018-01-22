<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
	public function index()
	{
        print_r($_GET);
		echo $_GET['from'];
	}
}