<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        echo '<pre>';
        echo "设置前：\n";
        $admin = C('ADMIN');
        print_r($admin);
        $newAdmin = array(
            array(
                'id' => 1,
                'username' => 'root',
                'password' => 'admin'
            )
        );
        C('ADMIN', $newAdmin);
        echo "覆盖模式设置后：\n";
        print_r(C('ADMIN'));
        $admin = array_merge($admin,$newAdmin);
        echo "合并模式设置后：\n";
        print_r($admin);
        echo '</pre>';

    }
}