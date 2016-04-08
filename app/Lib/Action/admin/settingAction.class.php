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
class settingAction extends backendAction {
    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('setting');
    }
    public function index() {
        $act=$this->_request('act','trim');
        if($act=='domain_auth'){
            $auth_data=$this->check_domain(true);
            $result=array(
                'msg'=>$auth_data['msg'],
                'sdate'=>$auth_data['sdate'],
                'edate'=>$auth_data['edate'],
            );
            print_r(json_encode($result));exit();
        }
        $type = $this->_get('type', 'trim', 'index');
        if($type=='auth_info'){
            $this->assign('auth_data',$this->check_domain());
        }
        $this->display($type);
    }
    public function user() {
        $this->display();
    }
    public function follow() {
        $this->display();
    }
    public function cps(){
        $this->display();
    }    
    public function edit() {            
        $setting = $this->_post('setting', ',');                
        $this->_mod->update($setting);         		
        $this->success(L('operation_success'));
    }
    public function ajax_mail_test() {
        $email = $this->_get('email', 'trim');
        !$email && $this->ajaxReturn(0);
        $mailer = mailer::get_instance();
        if ($mailer->send($email, L('send_test_email_subject'), L('send_test_email_body'))) {
            $this->ajaxReturn(1);
        } else {
            $this->ajaxReturn(0);
        }
    }
}