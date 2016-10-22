<?php
namespace Home\Controller;

use Common\Model\BoardModel;
use Common\Model\BoardViewModel;
use Common\Model\BoardWithAdminModel;
use Common\Model\PostViewModel;
use Common\Model\UserModel;
use Think\Controller;
use Think\Image;
use Think\Upload;

class IndexController extends Controller
{
    public function index()
    {
        //版块列表
        $boards = (new BoardModel())->all(1);
        //最新帖子
        $list = (new PostViewModel())->latest(5);
        //最新成员
        $users = (new UserModel())->latest();
        $this->assign('boards', $boards);
        $this->assign('posts', $list);
        $this->assign('users', $users);
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