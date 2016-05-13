<?php
namespace Home\Controller;

use Home\Model\PostModel;
use Home\Model\PostViewModel;
use Home\Model\UserModel;
use Think\Controller;
use Think\Model;

class IndexController extends Controller
{
    public function index()
    {
        //变量
        $val = 'name';
        //一维数组
        $array1 = [
            'name' => 'admin'
        ];
        //多维数组
        $array2 = [
            ['name' => 'admin'],
            ['name' => 'admin2'],
        ];
        //对象
        $obj = new \stdClass();
        $obj->name = 'admin';
        //模板赋值
        $this->assign('val', $val);
        $this->assign('array1', $array1);
        $this->assign('array2', $array2);
        $this->assign('obj', $obj);
        $this->display();
    }

    public function view1()
    {
        $this->display();
    }

    public function view2()
    {
        $this->assign('name', 'test');
        $this->assign('now', time());
        $this->display();
    }
}