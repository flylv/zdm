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
require_once dirname(__FILE__) . '/saetv2.ex.class.php';
class sina_oauth
{
    private $_need_request = array('code');
    public function __construct($setting) {
		$this->redirect_uri ="http://".$_SERVER["HTTP_HOST"]."/index.php?m=oauth&a=callback&mod=sina";
        $this->setting = $setting;
    }
    public function getAuthorizeURL() {
        $oauth = new SaeTOAuthV2($this->setting['app_key'], $this->setting['app_secret']);
        return $oauth->getAuthorizeURL($this->redirect_uri);
    }
    public function getUserInfo($request_args) {
        is_null($request_args['code']) && exit();
        $oauth = new SaeTOAuthV2($this->setting['app_key'], $this->setting['app_secret']);
        $keys = array('code'=>$request_args['code'], 'redirect_uri'=>$this->redirect_uri);
        $token = $oauth->getAccessToken('code', $keys);
        $client = new SaeTClientV2($this->setting['app_key'], $this->setting['app_secret'], $token['access_token']);
        $user = $client->show_user_by_id($token['uid']);        
        $result['keyid'] = $user['id'];
        $result['keyname'] = $user['name'];
        $result['keyavatar_small'] = $user['profile_image_url'];
        $result['keyavatar_big'] = $user['avatar_large'];
        $result['bind_info'] = $token;
        return $result;
    }
    public function getFriends($bind_user, $page, $count) {
        $info = unserialize($bind_user['info']);
        $client = new SaeTClientV2($this->setting['app_key'], $this->setting['app_secret'], $info['access_token']);
        $res = $client->bilateral($bind_user['keyid'], $page, $count);
        $friends = $users = array();
        foreach ($res['users'] as $u) {
            $users[] = array(
                'id'    => $u['id'],
                'sid'   => $u['screen_name'], 
                'name'  => $u['name'], 
                'avatar'=> $u['profile_image_url']
            );
        }
        $friends['users'] = $users;
        $friends['total_number'] = $res['total_number'];
        return $friends;
    }
    public function send($bind_user, $data) {
        $info = unserialize($bind_user['info']);
        $client = new SaeTClientV2($this->setting['app_key'], $this->setting['app_secret'], $info['access_token']);
        try {
            isset($data['url']) && $data['content'] = $data['content'] . $data['url'];
            if (isset($data['img']) && !empty($data['img'])) {
                return $client->upload($data['content'], $data['img']);
            } else {
                return $client->update($data['content']);
            }
        }catch(Exception $e){}
    }
    public function follow($bind_user, $uid) {
        $info = unserialize($bind_user['info']);
        $client = new SaeTClientV2($this->setting['app_key'], $this->setting['app_secret'], $info['access_token']);
        try {
            return $client->follow_by_id($uid);
        }catch(Exception $e){}
    }
    public function NeedRequest() {
        return $this->_need_request;
    }
}