<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/19 0019
 * Time: 14:57
 */

namespace Admin\Controller;

use Think\Image;
use Think\Upload;

/**
 * Class IndexController
 * @package Admin\Controller
 */
class IndexController extends BaseController
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        $this->display();
    }

    /**
     * 上传图片
     * @param int $size 宽度
     */
    public function upload($size = 200)
    {
        $upload = new Upload();// 实例化上传类
        $upload->maxSize = 1024 * 1024 * 2;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = __DIR__ . '/../../../upload/'; // 设置附件上传根目录
        $upload->savePath = ''; // 设置附件上传（子）目录
        // 上传文件
        $info = $upload->upload();
        if (!$info) {
            $this->ajaxReturn(array(
                'error' => $upload->getError()
            ));
        } else {
            $path = $upload->rootPath . $info['file']['savepath'] . $info['file']['savename'];
            $image = new Image();
            $image->open($path);
            $image->thumb($size, $size, Image::IMAGE_THUMB_CENTER)->save($path);
            $this->ajaxReturn(array(
                'url' => U('/', '', false, true) . 'upload/' . $info['file']['savepath'] . $info['file']['savename']
            ));
        }
    }
}