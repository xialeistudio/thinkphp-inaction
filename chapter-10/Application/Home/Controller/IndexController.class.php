<?php
namespace Home\Controller;

use Think\Controller;
use Think\Image;
use Think\Page;
use Think\Upload;
use Think\Verify;

class IndexController extends Controller
{
    public function index()
    {
        $model = M('User');
        $count = $model->count();
        $page = new Page($count, 30);
        $show = $page->show();
        $list = $model->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }

    public function insert()
    {
        $model = M('User');
        for ($i = 0; $i < 100; $i++) {
            $data = array(
                'username' => 'zhangshan' . $i,
                'password' => md5(microtime(true)),
                'created_at' => time(),
                'updated_at' => time()
            );

            $model->create($data);
            echo $model->add($data) ? 1 : 0, '<br/>';
        }
        echo 'ok';
    }

    public function upload()
    {
        $this->display();
    }

    public function upload_do()
    {
        $upload = new Upload();// 实例化上传类
        $upload->maxSize = 1024 * 1024 * 2;// 2M
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = './Uploads/'; // 设置附件上传根目录
        $upload->savePath = ''; // 设置附件上传子目录
        // 上传文件 
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功
            $baseURL = 'Uploads/' . $info['file']['savepath'] . $info['file']['savename'];
            echo $baseURL;
        }
    }

    public function verify()
    {
        $verify = new Verify();
        $verify->entry();
    }

    public function login()
    {
        $this->display();
    }

    public function login_do()
    {
        //检测验证码
        $code = I('code');
        $verify = new Verify();
        if ($verify->check($code)) {
            $this->success('验证成功');
        } else {
            $this->error('验证码错误');
        }
    }

    public function imginfo()
    {
        $path = './Public/images/demo.jpg';
        $image = new Image(Image::IMAGE_GD, $path);
        dump([
            'width' => $image->width(),
            'height' => $image->height(),
            'mime' => $image->mime(),
            'type' => $image->type()
        ]);
    }

    public function crop()
    {
        $path = './Public/images/demo.jpg';
        $image = new Image(Image::IMAGE_GD, $path);
        $image->crop(200, 200)->save('./Public/images/demo-crop-200x200.jpg');
    }

    public function thumb()
    {
        $path = './Public/images/demo.jpg';
        $image = new Image(Image::IMAGE_GD, $path);
        $image->thumb(200, 200)->save('./Public/images/demo-thumb-200x200.jpg');
    }

    public function water()
    {
        $path = './Public/images/demo.jpg';
        $water = './Public/images/logo.png';
        $image = new Image(Image::IMAGE_GD, $path);
        $image->water($water)->save('./Public/images/demo-water.jpg');
    }
}