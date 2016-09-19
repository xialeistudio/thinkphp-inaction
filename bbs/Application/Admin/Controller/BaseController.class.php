<?php
namespace Admin\Controller;

use Think\Controller;

/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/12 0012
 * Time: 10:11
 */
class BaseController extends Controller
{
    const SESSION_KEY = 'admin_session';
    protected $admin = null;

    public function _initialize()
    {
        $this->admin = session(self::SESSION_KEY);
        if (static::loginRequired() && empty($this->admin)) {
            $this->error('请登录', U('admin/auth/login'));
        }
        C('LAYOUT_NAME', 'dashboard');
    }

    /**
     * 是否要求登录
     * @return bool
     */
    protected function loginRequired()
    {
        return true;
    }
}