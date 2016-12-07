<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        import('Home.Library.ThinkWechat');
        $wechat = new \ThinkWechat(C('WECHAT.TOKEN'));
        $data = $wechat->request();
        list($content, $type) = $this->_handle($data);
        $wechat->response($content, $type);
    }

    private function _handle(array $data)
    {
        if ($data['MsgType'] == 'text') {
            return $this->_handleText($data);
        }
        if ($data['MsgType'] == 'image') {
            return $this->_handleImage($data);
        }
        if ($data['MsgType'] == 'event') {
            return $this->_handleEvent($data);
        }
        return ['你好', 'text'];
    }

    private function _handleText(array $data)
    {
        return ["您发送的内容是:${data['Content']}", 'text'];
    }

    private function _handleImage(array $data)
    {
        return ["您上传的图片链接：${data['PicUrl']}", 'text'];
    }

    private function _handleEvent(array $data)
    {
        if ($data['Event'] == 'subscribe') {
            return ['欢迎关注', 'text'];
        }
        return ['你好', 'text'];
    }
}