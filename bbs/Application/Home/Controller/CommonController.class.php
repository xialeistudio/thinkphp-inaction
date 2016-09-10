<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/10 0010
 * Time: 17:03
 */

namespace Home\Controller;


use Think\Controller;
use Think\Verify;

class CommonController extends Controller
{
    public function capture()
    {
        $verify = new Verify();
        $verify->entry();
    }
}