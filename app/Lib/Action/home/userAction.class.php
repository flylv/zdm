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
class userAction extends userbaseAction {
    public function _initialize() {   
        parent::_initialize();                
        $this->_config_seo(array('title'=>'会员中心'));
    }
    public function login() {
        $this->visitor->is_login && $this->redirect('user/index');
        $this->_config_seo(array('title'=>'会员登录'));             
        if (IS_POST) {
            $username = $this->_post('username', 'trim');
            $password = $this->_post('password', 'trim');
            $type = $this->_post('type', 'trim', 'reg');
            $captcha = $this->_post('captcha', 'trim');
            if (session('captcha') != md5($captcha)&&C('pin_captcha_status')){
                $this->error(L('captcha_failed'));
            }
            $remember = $this->_post('remember');
            if (empty($username)) {
                IS_AJAX && $this->ajaxReturn(0, L('please_input').L('password'));
                $this->error(L('please_input').L('username'));
            }
            if (empty($username)) {
                IS_AJAX && $this->ajaxReturn(0, L('please_input').L('password'));
                $this->error(L('please_input').L('password'));
            }
            $passport = $this->_user_server();
            $uid = $passport->auth($username, $password);
            if (!$uid) {
                IS_AJAX && $this->ajaxReturn(0, $passport->get_error());
                $this->error($passport->get_error());
            }
            $this->visitor->login($uid, $remember);
            $tag_arg = array('uid'=>$uid, 'uname'=>$username, 'action'=>'login');
            tag('login_end', $tag_arg);
            $synlogin = $passport->synlogin($uid);            
            if (IS_AJAX) {
                $this->ajaxReturn(1, L('login_successe').$synlogin);
            } else {
                $ret_url =urldecode($this->_post('ret_url'));
                $this->success(L('login_successe').$synlogin, $ret_url);
            }
        } else {
            if (!empty($_GET['synlogout'])) {
                $passport = $this->_user_server();
                $synlogout = $passport->synlogout();
            }
            if (IS_AJAX) {
                $resp = $this->fetch('dialog:login');
                $this->ajaxReturn(1, '', $resp);
            } else {
                $ret_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : __APP__;
                $this->assign('ret_url', $ret_url);
                $this->assign('synlogout', $synlogout);
                $this->display();
            }
        }
    }
    public function logout() {
        $this->visitor->logout();
        $passport = $this->_user_server();
        $synlogout = $passport->synlogout();
        $this->success(L('logout_successe').$synlogout, $this->_request('ret_url', 'urldecode',U('index/index')));
    }
    public function binding() {
        $user_bind_info = object_to_array(cookie('user_bind_info'));
        $this->assign('user_bind_info', $user_bind_info);        
        $this->_config_seo(array('title'=>'账户绑定'));
        $this->display();
    }
    public function register() {
        $this->visitor->is_login && $this->redirect('user/index');
        $this->_config_seo(array('title'=>'会员注册'));
        if (IS_POST) {
            $type = $this->_post('type', 'trim', 'reg');
            if ($type == 'reg') {
                $agreement = $this->_post('agreement');
                !$agreement && $this->error(L('agreement_failed'));
                $captcha = $this->_post('captcha', 'trim');
                if(session('captcha') != md5($captcha)&&C('pin_captcha_status')){
                    $this->error(L('captcha_failed'));
                }
            }
            $username = $this->_post('username', 'trim');
            $email = $this->_post('email','trim');
            $password = $this->_post('password', 'trim');
            $repassword = $this->_post('repassword', 'trim');
            if ($password != $repassword) {
                $this->error(L('inconsistent_password')); 
            }
            $gender = $this->_post('gender','intval', '0');
            $ipban_mod = D('ipban');
            $ipban_mod->clear(); 
            $is_ban = $ipban_mod->where("(type='name' AND name='".$username."') OR (type='email' AND name='".$email."')")->count();
            $is_ban && $this->error(L('register_ban'));
            $passport = $this->_user_server();
            $uid = $passport->register($username, $password, $email, $gender);
            !$uid && $this->error($passport->get_error());
            if (cookie('user_bind_info')) {
                $user_bind_info = object_to_array(cookie('user_bind_info'));                
                $oauth = new oauth($user_bind_info['type']);
                $bind_info = array(
                    'pin_uid' => $uid,
                    'keyid' => $user_bind_info['keyid'],
                    'bind_info' => $user_bind_info['bind_info'],
                );
                $oauth->bindByData($bind_info);
                $this->_save_avatar($uid, $user_bind_info['temp_avatar']);
                cookie('user_bind_info', NULL);
            }
            $tag_arg = array('uid'=>$uid, 'uname'=>$username, 'action'=>'register');
            tag('register_end', $tag_arg);
            $this->visitor->login($uid);
            $tag_arg = array('uid'=>$uid, 'uname'=>$username, 'action'=>'login');
            tag('login_end', $tag_arg);
            $synlogin = $passport->synlogin($uid);
            $this->success(L('register_successe').$synlogin, U('user/index'));
        } else {
            if (!C('pin_reg_status')) {
                $this->error(C('pin_reg_closed_reason'));
            }
            $this->display();
        }
    }
    private function _save_avatar($uid, $img) {
        $avatar_size = explode(',', C('pin_avatar_size'));
        $avatar_dir = C('pin_attach_path') . 'avatar/' . avatar_dir($uid);
        !is_dir($avatar_dir) && mkdir($avatar_dir,0777,true);
        $img = C('pin_attach_path') . 'avatar/temp/' . $img;
        foreach ($avatar_size as $size) {
            Image::thumb($img, $avatar_dir.md5($uid).'_'.$size.'.jpg', '', $size, $size, true);
        }
        @unlink($img);
    }
    public function msgtip() {
        $result = D('user_msgtip')->get_list($this->visitor->info['id']);
        $this->ajaxReturn(1, '', $result);
    }
    public function index() {
        $info = $this->visitor->get();            
        $this->assign('info', $info);        
        $this->assign('favs_list',D("post_favs")->relation(true)->where(array('uid'=>$this->uid))->order("id desc")->limit(4)->select());
        $this->assign('message_num',D("message")->relation(true)->where(array('to_id'=>$this->uid,'status'=>'0'))->count());
        $this->display(); 
    }
    public function profile(){
        if( IS_POST ){
            foreach ($_POST as $key=>$val) {
                $_POST[$key] = Input::deleteHtmlTags($val);
            }
            $data['gender'] = $this->_post('gender', 'intval');
            $data['province'] = $this->_post('province', 'trim');
            $data['city'] = $this->_post('city', 'trim');
            $data['tags'] = $this->_post('tags', 'trim');
            $data['intro'] = $this->_post('intro', 'trim');
            $birthday = $this->_post('birthday', 'trim');
            $birthday = explode('-', $birthday);
            $data['byear'] = $birthday[0];
            $data['bmonth'] = $birthday[1];
            $data['bday'] = $birthday[2];
            if (false !== D('user')->where(array('id'=>$this->visitor->info['id']))->save($data)) {
                $msg = array('status'=>1, 'info'=>L('edit_success'));
            }else{
                $msg = array('status'=>0, 'info'=>L('edit_failed'));
            }  
            $this->assign('msg', $msg);
            $this->success($msg['info']);
        }        
        $info = $this->visitor->get();            
        $this->assign('info', $info);
        $this->display();        
    } 
    public function upload_avatar() {
        if (!empty($_FILES['avatar']['name'])) {
            $avatar_size = explode(',', C('pin_avatar_size'));
            $uid = abs(intval($this->visitor->info['id']));
            $suid = sprintf("%09d", $uid);
            $dir1 = substr($suid, 0, 3);
            $dir2 = substr($suid, 3, 2);
            $dir3 = substr($suid, 5, 2);
            $avatar_dir = $dir1.'/'.$dir2.'/'.$dir3.'/';
            $suffix = '';
            foreach ($avatar_size as $size) {
                $suffix .= '_'.$size.',';
            }
            $result = $this->_upload($_FILES['avatar'], 'avatar/'.$avatar_dir, array(
                'width'=>C('pin_avatar_size'), 
                'height'=>C('pin_avatar_size'),
                'remove_origin'=>true, 
                'suffix'=>trim($suffix, ','),
                'ext' => 'jpg',
            ), md5($uid));
            if ($result['error']) {
                $this->ajaxReturn(0, $result['info']);
            } else {
                $data = __ROOT__.'/data/upload/avatar/'.$avatar_dir.md5($uid).'_'.$size.'.jpg?'.time();
                D('user')->where("id=".$this->uid)->save(array('avatar'=>$avatar_dir.md5($uid)));
                $this->ajaxReturn(1, L('upload_success'), $data);
            }
        } else {
            $this->ajaxReturn(0, L('illegal_parameters'));
        }
    }
    public function password() {
        if( IS_POST ){
            $oldpassword = $this->_post('oldpassword','trim');
            $password   = $this->_post('password','trim');
            $repassword = $this->_post('repassword','trim');
            !$password && $this->error(L('no_new_password'));
            $password != $repassword && $this->error(L('inconsistent_password'));
            $passlen = strlen($password);
            if ($passlen < 6 || $passlen > 20) {
                $this->error('password_length_error');
            }            
            $passport = $this->_user_server();
            $result = $passport->edit($this->visitor->info['id'], $oldpassword, array('password'=>$password));
            if ($result) {
                $msg = array('status'=>1, 'info'=>L('edit_password_success'));
            } else {
                $msg = array('status'=>0, 'info'=>$passport->get_error());
            }
            $this->success($msg['info']);
        }
        $this->display();
    }
    public function bind() {
        $bind_list = D('user_bind')->field('type')->where(array('uid'=>$this->visitor->info['id']))->select();
        $binds = array();
        if ($bind_list) {
            foreach ($bind_list as $val) {
                $binds[] = $val['type'];
            }
        }
        $oauth_list = $this->oauth_list;
        foreach ($oauth_list as $type => $_oauth) {
            $oauth_list[$type]['isbind'] = '0';
            if (in_array($type, $binds)) {
                $oauth_list[$type]['isbind'] = '1';
            }
        }
        $this->assign('oauth_list', $oauth_list);
        $this->display();
    }
    public function custom() {
        $cover = $this->visitor->get('cover');
        $this->assign('cover', $cover);
        $this->display();
    }
    public function cancle_cover() {
        $result = D('user')->where(array('id'=>$this->visitor->info['id']))->setField('cover', '');
        !$result && $this->ajaxReturn(0, L('illegal_parameters'));
        $this->ajaxReturn(1, L('edit_success'));
    }
    public function upload_cover() {
        if (!empty($_FILES['cover']['name'])) {
            $data_dir = date('ym/d');
            $file_name = md5($this->visitor->info['id']);
            $result = $this->_upload($_FILES['cover'], 'cover/'.$data_dir, array('width'=>'900', 'height'=>'330', 'remove_origin'=>true), $file_name);
            if ($result['error']) {
                $this->ajaxReturn(0, $result['info']);
            } else {
                $ext = array_pop(explode('.', $result['info'][0]['savename']));
                $cover = $data_dir.'/'.$file_name.'_thumb.'.$ext;
                $data = '<img src="./data/upload/cover/'.$data_dir.'/'.$file_name.'_thumb.'.$ext.'?'.time().'">';
                D('user')->where(array('id'=>$this->visitor->info['id']))->setField('cover', $cover);
                $this->ajaxReturn(1, L('upload_success'), $data);
            }
        } else {
            $this->ajaxReturn(0, L('illegal_parameters'));
        }
    }
    public function address() {
        $user_address_mod = D('user_address');
        $id = $this->_get('id', 'intval');
        $type = $this->_get('type', 'trim', 'edit');
        if ($id) {
            if ($type == 'del') {
                $user_address_mod->where(array('id'=>$id, 'uid'=>$this->visitor->info['id']))->delete();
                $msg = array('status'=>1, 'info'=>L('delete_success'));
                $this->assign('msg', $msg);
            } else {
                $info = $user_address_mod->find($id);
                $this->assign('info', $info);
            }
        }
        if (IS_POST) {
            $consignee = $this->_post('consignee', 'trim');
            $address = $this->_post('address', 'trim');
            $zip = $this->_post('zip', 'trim');
            $mobile = $this->_post('mobile', 'trim');
            $id = $this->_post('id', 'intval');
            if ($id) {
                $result = $user_address_mod->where(array('id'=>$id, 'uid'=>$this->visitor->info['id']))->save(array(
                    'consignee' => $consignee,
                    'address' => $address,
                    'zip' => $zip,
                    'mobile' => $mobile,
                ));
                if ($result) {
                    $msg = array('status'=>1, 'info'=>L('edit_success'));
                } else {
                    $msg = array('status'=>0, 'info'=>L('edit_failed'));
                }
            } else {
                $result = $user_address_mod->add(array(
                    'uid' => $this->visitor->info['id'],
                    'consignee' => $consignee,
                    'address' => $address,
                    'zip' => $zip,
                    'mobile' => $mobile,
                ));
                if ($result) {
                    $msg = array('status'=>1, 'info'=>L('add_address_success'));
                } else {
                    $msg = array('status'=>0, 'info'=>L('add_address_failed'));
                }
            }
            $this->assign('msg', $msg);
        }
        $address_list = $user_address_mod->where(array('uid'=>$this->visitor->info['id']))->select();
        $this->assign('address_list', $address_list);
        $this->display();
    }
    public function ajax_check() {
        $type = $this->_get('type', 'trim', 'email');
        $user_mod = D('user');
        switch ($type) {
            case 'email':
                $email = $this->_get('J_email', 'trim');
                $user_mod->email_exists($email) ? $this->ajaxReturn(0) : $this->ajaxReturn(1);
                break;
            case 'username':
                $username = $this->_get('J_username', 'trim');
                $user_mod->name_exists($username) ? $this->ajaxReturn(0) : $this->ajaxReturn(1);
                break;
        }
    }
    public function follow() {
        $uid = $this->_get('uid', 'intval');
        !$uid && $this->ajaxReturn(0, L('follow_invalid_user'));
        $uid == $this->visitor->info['id'] && $this->ajaxReturn(0, L('follow_self_not_allow'));
        $user_mod = D('user');
        if (!$user_mod->where(array('id'=>$uid))->count('id')) {
            $this->ajaxReturn(0, L('follow_invalid_user'));
        }
        $user_follow_mod = D('user_follow');
        $is_follow = $user_follow_mod->where(array('uid'=>$this->visitor->info['id'], 'follow_uid'=>$uid))->count();
        $is_follow && $this->ajaxReturn(0, L('user_is_followed'));
        $return = 1;
        $map = array('uid'=>$uid, 'follow_uid'=>$this->visitor->info['id']);
        $isfollow_me = $user_follow_mod->where($map)->count();
        $data = array('uid'=>$this->visitor->info['id'], 'follow_uid'=>$uid, 'add_time'=>time());
        if ($isfollow_me) {
            $data['mutually'] = 1; 
            $user_follow_mod->where($map)->setField('mutually', 1); 
            $return = 2;
        }
        $result = $user_follow_mod->add($data);
        !$result && $this->ajaxReturn(0, L('follow_user_failed'));
        $user_mod->where(array('id'=>$this->visitor->info['id']))->setInc('follows');
        $user_mod->where(array('id'=>$uid))->setInc('fans');
        D('user_msgtip')->add_tip($uid, 1);
        $this->ajaxReturn(1, L('follow_user_success'), $return);
    }
    public function unfollow() {
        $uid = $this->_get('uid', 'intval');
        !$uid && $this->ajaxReturn(0, L('unfollow_invalid_user'));
        $user_follow_mod = D('user_follow');
        if ($user_follow_mod->where(array('uid'=>$this->visitor->info['id'], 'follow_uid'=>$uid))->delete()) {
            $user_mod = D('user');
            $map = array('uid'=>$uid, 'follow_uid'=>$this->visitor->info['id']);
            $isfollow_me = $user_follow_mod->where($map)->count();
            if ($isfollow_me) {
                $user_follow_mod->where($map)->setField('mutually', 0); 
            }
            $user_mod->where(array('id'=>$this->visitor->info['id']))->setDec('follows');
            $user_mod->where(array('id'=>$uid))->setDec('fans');
            D('topic_index')->where(array('author_id'=>$uid, 'uid'=>$this->visitor->info['id']))->delete();
            $this->ajaxReturn(1, L('unfollow_user_success'));
        } else {
            $this->ajaxReturn(0, L('unfollow_user_failed'));
        }
    }
    public function delfans() {
        $uid = $this->_get('uid', 'intval');
        !$uid && $this->ajaxReturn(0, L('delete_invalid_fans'));
        $user_follow_mod = D('user_follow');
        if ($user_follow_mod->where(array('follow_uid'=>$this->visitor->info['id'], 'uid'=>$uid))->delete()) {
            $user_mod = D('user');
            $user_mod->where(array('id'=>$this->visitor->info['id']))->setDec('fans');
            D('user')->where(array('id'=>$uid))->setDec('follows');
            D('topic_index')->where(array('author_id'=>$this->visitor->info['id'], 'uid'=>$uid))->delete();
            $this->ajaxReturn(1, L('delete_fans_success'));
        } else {
            $this->ajaxReturn(0, L('delete_fans_failed'));
        }
    }
    public function favs(){
        $id=$this->_post('id','intval');
        $act=$this->_post('act','trim');
        if($act=='del'){
            if($id>0){
                $res=D("post_favs")->where(array('id'=>$id,'uid'=>$this->uid))->delete();
               if($res){                                  
                    $this->ajaxReturn(1,'操作成功');
                } else {
                    $this->ajaxReturn(0, '操作失败');
                }
            }    
        }
        $where=array('uid'=>$this->uid);
        $count=D("post_favs")->where($where)->count();
        $pager=$this->_pager($count,8);
        $res=D("post_favs")->relation(true)
            ->limit($pager->firstRow . ',' . $pager->listRows)->order($order)
            ->where($where)->select();
        $this->assign('page', $pager->show());                
        $this->assign('list',$res);
        $this->display();
    }
    public function comments(){        
        $mod=new Model();
        $where=" where uid=".$this->uid;
        $sql="select *,'post_comment' as m from ".table('post_comment')." $where union select *,'jky_comment' as m from ".table('jky_comment')." $where";
        $res=$mod->query("select count(id) as total from ($sql) as res");
        $count=$res[0]['total'];
        import("ORG.Util.Page");        
        $pager =$this->_pager($res[0]['total'], 8);
        $res=$mod->query($sql." order by add_time desc "." limit ".$pager->firstRow . ',' .$pager->listRows);
        foreach($res as $key=>$val){
            $res[$key]=D($val['m'])->relation(true)->where("id=$val[id]")->find();        
            $res[$key]['m']=$val['m'];
        }
        $this->assign('list',$res);
        $this->assign('page',$pager->show());
        $this->display();
    }
    public function message(){
        $where=array('to_id'=>$this->uid);
        $this->_assign_list(D("message"),$where,8,true);
        D('message')->where($where)->save(array('status'=>1));                
        $this->display();
    }    
    public function favs_add(){
        $id=$this->_get('id','intval');
        $uid=$this->visitor->info['id'];
        if(D("post_favs")->where(array('post_id'=>$id,'uid'=>$uid))->find()){
            $this->ajaxReturn(0,'已经添加了');
        }else{
            D("post_favs")->add(array(
                'post_id'=>$id,
                'uid'=>$uid,
                'add_time'=>time(),
                'ip'=>$_SERVER["REMOTE_ADDR"]
            ));
            $tag_arg = array('uid'=>$this->visitor->info['id'], 
                'uname'=>$this->visitor->info['username'], 
                'action'=>'favs');
            tag('favs_end', $tag_arg);         
            D("post")->where(array('id'=>$id))->setInc('favs');            
            $this->ajaxReturn(1,'添加成功',D("post")->where(array('id'=>$id))->getField('favs'));            
        }      
    }
    public function baoliao(){
        $type=$this->_get('type','intval',0);
        $this->_assign_list(D("post_baoliao"),"type=$type and uid=".$this->uid);
        $this->assign('type',$type);
        $this->display();
    }
    public function anhao() {
        $where = array('uid'=>$this->uid);
        $count = D('jky_anhao')->where($where)->count();
        $pager = $this->_pager($count,8);
        $res = D('jky_anhao')->relation(true)
            ->limit($pager->firstRow . ',' . $pager->listRows)->order('id DESC')
            ->where($where)->select();
        $this->assign('page', $pager->show());
        $this->assign('list',$res);
        $this->display();
    }
    public function score_order() {
        $map = array();
        $map['uid'] = $this->uid;
        $score_order_mod = D('score_order');
        $pagesize = 20;
        $count = $score_order_mod->where($map)->count('id');
        $pager = $this->_pager($count, $pagesize);
        $order_list = $score_order_mod->field('id,order_sn,item_id,item_name,order_score,status,add_time')->where($map)->limit($pager->firstRow.','.$pager->listRows)->order('id DESC')->select();
        $this->assign('order_list', $order_list);
        $this->assign('page_bar', $pager->fshow());
        $this->_config_seo();
        $this->display();
    }
    public function score_log(){
        $this->_assign_list(D("score_log"),"uid=".$this->uid);
        $this->assign('l',L('score_lang'));
        $this->display();
    }
    public function qiandao() {
        if ($this->_check_num($this->visitor->info['id'], 'qiandao')) {
            $tag_arg = array(
                'uid'=>$this->visitor->info['id'],
                'uname'=>$this->visitor->info['username'],
                'action'=>'qiandao'
            );
            tag('qiandao_end', $tag_arg);
            $this->ajaxReturn(1, '签到成功');
        }
        $this->ajaxReturn(0, '你已经签到过了');
    }
    private function _check_num($uid, $action){
        $return = false;
        $user_stat_mod = D('user_stat');
        $max_num = C('pin_score_rule.'.$action.'_nums');
        $stat = $user_stat_mod->field('num,last_time')->where(array('uid'=>$uid, 'action'=>$action))->find();
        if (!$stat) {
            $user_stat_mod->create(array('uid'=>$uid, 'action'=>$action));
            $user_stat_mod->add();
        }
        if ($max_num == 0) {
            $return = true; 
        } else {
            if ($stat['last_time'] < todaytime()) {
                $return = true;
            } else {
                $return = $stat['num'] >= $max_num ? false : true;
            }
        }
        return $return;
    }
}