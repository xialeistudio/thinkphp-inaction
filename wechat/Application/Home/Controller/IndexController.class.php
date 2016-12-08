<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    const REGISTER_STEP_USERNAME = 1;
    const REGISTER_STEP_PASSWORD = 2;

    const LOGIN_STEP_USERNAME = 3;
    const LOGIN_STEP_PASSWORD = 4;

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
        session_id($data['FromUserName']);
        session_start();
        if ($data['MsgType'] == 'text') {
            return $this->_handleText($data);
        }
        if ($data['MsgType'] == 'image') {
            return $this->_handleImage($data);
        }
        if ($data['MsgType'] == 'event') {
            return $this->_handleEvent($data);
        }
        return array('你好', 'text');
    }

    /**
     * 处理文本信息
     * @param array $data
     * @return array
     */
    private function _handleText(array $data)
    {
        $step = session('step');
        //全局操作
        if ($data['Content'] == '0') {
            session('step', null);
            session('login', null);
            session_destroy();
            return array('重置成功', 'text');
        }
        //未登录，且未选择操作
        if (empty($step) && !session('login')) {
            //未选择操作
            if ($data['Content'] == '1') {
                session('step', self::REGISTER_STEP_USERNAME);
                return array('请输入您的账号', 'text');
            }
            if ($data['Content'] == '2') {
                session('step', self::LOGIN_STEP_USERNAME);
                return array('请输入您的账号', 'text');
            }
        }
        //已登录
        if (session('login')) {
            //查看个人信息
            if ($data['Content'] == '1') {
                return array(
                    join("\n", array(
                        '您的账号:' . session('username'),
                        '您的密码:' . session('password')
                    )),
                    'text');
            }
            //退出登录
            if ($data['Content'] == '2') {
                session('login', null);
                return array('您已成功退出登录', 'text');
            }
        }
        //用户注册输入用户名
        if ($step == self::REGISTER_STEP_USERNAME) {
            session('username', $data['Content']);
            session('step', self::REGISTER_STEP_PASSWORD);
            return array('请输入您的密码', 'text');
        }
        //用户注册输入密码
        if ($step == self::REGISTER_STEP_PASSWORD) {
            session('password', $data['Content']);
            session('step', null);
            return array('注册成功', 'text');
        }
        //用户登录输入账号
        if ($step == self::LOGIN_STEP_USERNAME) {
            if (session('username') != $data['Content']) {
                return array('账号不匹配', 'text');
            }
            session('step', self::LOGIN_STEP_PASSWORD);
            return array('请输入密码', 'text');
        }
        //用户登录输入密码
        if ($step == self::LOGIN_STEP_PASSWORD) {
            if (session('password') != $data['Content']) {
                return array('密码错误', 'text');
            }
            session('login', 1);
            session('step', null);
            return array(join("\n", array(
                '登录成功！您可以进行以下操作',
                '1.个人信息',
                '2.退出登录'
            )), 'text');
        }
        return array(
            join("\n", array(
                '不存在的操作!您可以进行以下操作',
                '1.注册账号',
                '2.登录账号'
            )),
            'text'
        );
    }

    private function _handleImage(array $data)
    {
        return array("您上传的图片链接：${data['PicUrl']}", 'text');
    }

    private function _handleEvent(array $data)
    {
        if ($data['Event'] == 'subscribe') {
            return array(
                join("\n", array(
                    '欢迎关注!您可以进行以下操作',
                    '1.注册账号',
                    '2.登录账号'
                )),
                'text'
            );
        }
        return array('你好', 'text');
    }

    /**
     * 读取AccessToken
     */
    private function _getAccessToken()
    {
        $cacheKey = C('WECHAT.APPID') . 'accessToken';
        $data = S($cacheKey);
        if (!empty($data)) {
            return $data;
        }
        require __DIR__ . '/../../../../Vendor/Requests.php';
        $url = 'https://api.weixin.qq.com/cgi-bin/token?';
        $params = array(
            'grant_type' => 'client_credential',
            'appid' => C('WECHAT.APPID'),
            'secret' => C('WECHAT.SECRET')
        );

        $resp = \Requests::get($url . http_build_query($params));
        if ($resp->status_code != 200) {
            return null;
        }
        $data = json_decode($resp->body, true);

        S($cacheKey, $data['access_token'], 7000);
        return $data['access_token'];
    }
}