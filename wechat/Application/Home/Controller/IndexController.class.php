<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    //操作步骤定义
    const STEP_REGISTER_USERNAME = 1;
    const STEP_REGISTER_PASSWORD = 2;
    const STEP_LOGIN_USERNAME = 3;
    const STEP_LOGIN_PASSWORD = 4;
    const STEP_AVATAR_UPLOAD = 5;

    //游客操作
    const GUEST_ACTION_REGISTER = 1;
    const GUEST_ACTION_LOGIN = 2;
    //用户操作
    const USER_ACTION_INFO = 1;
    const USER_ACTION_AVATAR = 2;
    const USER_ACTION_LOGOUT = 3;
    //全局操作
    const GLOBAL_ACTION_RESET = 0;

    /**
     * 外部接口
     */
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
        session('[start]');
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
     * 是否游客
     * @return bool
     */
    private function _isGuest()
    {
        return session('login') === null;
    }

    private function _login()
    {
        session('login', 1);
    }

    private function _logout()
    {
        session('login', null);
    }

    /**
     * 当前操作步骤
     * @return int
     */
    private function _currentStep()
    {
        return session('step');
    }

    /**
     * 重置步骤
     */
    private function _resetStep()
    {
        session('step', null);
    }

    /**
     * 设置操作步骤
     * @param $step
     */
    private function _setStep($step)
    {
        session('step', $step);
    }

    /**
     * 重置会话
     */
    private function _resetSession()
    {
        session('[destroy]');
    }


    /**
     * 游客操作
     */
    private function _guestActions()
    {
        return array(
            '您当前的身份是【游客】',
            '您可以进行以下操作：',
            '1.注册账号',
            '2.登录账号',
            '帮助:任何情况下回复0重置会话状态'
        );
    }

    /**
     * 用户操作
     * @return array
     */
    private function _userActions()
    {
        return array(
            '您当前的身份是【登录用户】',
            '您可以进行以下操作',
            '1.个人信息',
            '2.上传头像',
            '3.退出登录',
            '帮助:任何情况下回复0重置会话状态'
        );
    }

    /**
     * 全局操作
     * @param array $data
     * @return array|bool
     */
    private function _handleGlobalAction(array $data)
    {
        if ($data['Content'] == self::GLOBAL_ACTION_RESET) {
            $this->_resetSession();
            return array(join("\n", $this->_guestActions()), 'text');
        }

        return false;
    }

    /**
     * 处理文本信息
     * @param array $data
     * @return array|bool
     */
    private function _handleText(array $data)
    {
        $result = $this->_handleGlobalAction($data);
        //如果返回非false，证明当前操作已经被处理完成
        if ($result !== false) {
            return $result;
        }
        //游客
        if ($this->_isGuest()) {
            //没有选择任何步骤
            if (!$this->_currentStep()) {
                if ($data['Content'] == self::GUEST_ACTION_REGISTER) {
                    $this->_setStep(self::STEP_REGISTER_USERNAME);
                    return array(
                        '【注册】请输入您的用户名',
                        'text'
                    );
                }
                if ($data['Content'] == self::GUEST_ACTION_LOGIN) {
                    $this->_setStep(self::STEP_LOGIN_USERNAME);
                    return array(
                        '【登录】请输入您的用户名',
                        'text'
                    );
                }
            }
            //注册->输入用户名
            if ($this->_currentStep() == self::STEP_REGISTER_USERNAME) {
                $this->_setStep(self::STEP_REGISTER_PASSWORD);
                session('username', $data['Content']);
                return array('【注册】请输入密码', 'text');
            }
            //注册->输入密码
            if ($this->_currentStep() == self::STEP_REGISTER_PASSWORD) {
                $this->_resetStep();
                session('password', $data['Content']);
                return array(join("\n", array_merge(array('【注册】注册成功'), $this->_guestActions())), 'text');
            }
            //登录->输入用户名
            if ($this->_currentStep() == self::STEP_LOGIN_USERNAME) {
                if ($data['Content'] != session('username')) {
                    return array(
                        join("\n", array(
                            "【登录】用户名错误",
                            "回复用户名继续操作",
                            "回复0重新开始会话"
                        )),
                        'text'
                    );
                }
                $this->_setStep(self::STEP_LOGIN_PASSWORD);
                return array('【登录】请输入密码', 'text');
            }
            //登录->输入密码
            if ($this->_currentStep() == self::STEP_LOGIN_PASSWORD) {
                if ($data['Content'] != session('password')) {
                    return array(
                        join("\n", array(
                            "【登录】密码错误",
                            "回复密码继续操作",
                            "回复0重新开始会话"
                        )),
                        'text'
                    );
                }

                $this->_login();
                $this->_resetStep();
                return array(join("\n", array_merge(array('【登录】登录成功'), $this->_userActions())), 'text');
            }
            return array(join("\n", $this->_guestActions()), 'text');
        } else {
            if (!$this->_currentStep()) {
                if ($data['Content'] == self::USER_ACTION_INFO) {
                    return array(
                        join("\n", array(
                            '用户名:' . session('username'),
                            '密码:' . session('password'),
                            '头像:' . (session('avatar') ? session('avatar') : '未设置')
                        )),
                        'text'
                    );
                }
                if ($data['Content'] == self::USER_ACTION_AVATAR) {
                    $this->_setStep(self::STEP_AVATAR_UPLOAD);
                    return array(
                        '【头像】请上传一张头像',
                        'text'
                    );
                }
                if ($data['Content'] == self::USER_ACTION_LOGOUT) {
                    $this->_login();
                    $this->_resetStep();
                    return array(join("\n", array_merge(array('退出登录成功'), $this->_guestActions())), 'text');
                }
            }
            if ($this->_currentStep() == self::USER_ACTION_AVATAR) {
                return array(
                    '【头像】操作有误!请上传图片头像',
                    'text'
                );
            }
            return array(join("\n", $this->_userActions()), 'text');
        }
    }

    /**
     * 处理图片消息
     * @param array $data
     * @return array
     */
    private function _handleImage(array $data)
    {
        if ($this->_currentStep() != self::STEP_AVATAR_UPLOAD) {
            $messages = array('操作有误');
            if ($this->_isGuest()) {
                $messages = array_merge($messages, $this->_guestActions());
            } else {
                $messages = array_merge($messages, $this->_userActions());
            }
            return array(join("\n", $messages), 'text');
        }

        session('avatar', $data['PicUrl']);
        return array(join("\n", array_merge(array('【头像】上传成功'), $this->_userActions())), 'text');
    }

    private function _handleEvent(array $data)
    {
        if ($data['Event'] == 'subscribe') {
            return array(join("\n", array_merge(array('欢迎关注！'), $this->_guestActions())), 'text');
        }
        return array('操作有误', 'text');
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