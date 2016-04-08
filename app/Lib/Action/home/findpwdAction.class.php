<?php 
/**
* ZhePHP 值得买模式的海淘网站程序
* ====================================================================
* 版权所有 杭州言商网络有限公司，并保留所有权利。
* 网站地址: http://www.zhiphp.com
* 交流论坛: http://bbs.pinphp.com
* --------------------------------------------------------------------
* 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
* 使用；不允许对程序代码以任何形式任何目的的再发布。
* ====================================================================
* Author: brivio <brivio@qq.com>
* 授权技术支持: 1142503300@qq.com
*/
class findpwdAction extends frontendAction {
    public function index() {
        if (IS_POST) {
            $captcha = $this->_post('captcha', 'trim');
            session('captcha') != md5($captcha) && $this->error(L('captcha_failed'));
            $tpl_data = array();
            $tpl_data['username'] = $username = $this->_post('username','trim');
            $user = M('user')->where(array('username'=>$username))->find();
            !$user && $this->error(L('user_not_exists'));
            $time = time();
            $activation = md5($user['reg_time'] . substr($user['password'], 10) . $time);
            $url_args = array(
                'm'=>'findpwd',
                'a'=>'reset',
                'username'=>$user['username'],
                'activation'=>$activation,
                't'=>$time
            );
            $tpl_data['reset_url'] = __SITEROOT__.'/index.php?'.http_build_query($url_args);
            $mail_body = D('message_tpl')->get_mail_info('findpwd', $tpl_data);
            $this->_mail_queue($user['email'], L('findpwd'), $mail_body);
            $this->success(L('findpwd_mail_sended'));
        } else {
            $this->_config_seo();
            $this->display();
        }
    }
    public function reset() {
        $username = $this->_get('username', 'trim');
        $activation = $this->_get('activation', 'trim');
        $t = $this->_get('t', 'intval');
        if (!$username || !$activation || !$t) {
            $this->redirect('index/index');
        }
        $time = time();
        ($time - $t) > 3600 && $this->error(L('findpwd_link_expired'), U('findpwd/index'));
        $user = M('user')->field('id,reg_time,password')->where(array('username'=>$username))->find();
        !$user && $this->error(L('username').L('not_exist'), U('index/index'));
        if ($activation != md5($user['reg_time'] . substr($user['password'], 10) . $t)) {
            $this->error(L('findpwd_link_error'), U('index/index'));
        }
        if (IS_POST) {
            $captcha = $this->_post('captcha', 'trim');
            session('captcha') != md5($captcha) && $this->error(L('captcha_failed'));
            $password   = $this->_post('password','trim');
            $repassword = $this->_post('repassword','trim');
            !$password && $this->error(L('no_new_password'));
            $password != $repassword && $this->error(L('inconsistent_password'));
            $passlen = strlen($password);
            if ($passlen < 6 || $passlen > 20) {
                $this->error('password_length_error');
            }
            $passport = $this->_user_server();
            $result = $passport->edit($user['id'], '', array('password'=>$password), true);
            if (!$result) {
                $this->error($passport->get_error());
            }
            $this->success(L('reset_password_success'), U('user/login'));
        } else {
            $this->_config_seo();
            $this->display();
        }
    }
}