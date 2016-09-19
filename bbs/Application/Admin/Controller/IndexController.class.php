<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/19 0019
 * Time: 14:57
 */

namespace Admin\Controller;

/**
 * Class IndexController
 * @package Admin\Controller
 */
class IndexController extends BaseController
{
    public function index()
    {
        print_r($this->admin);
    }
}