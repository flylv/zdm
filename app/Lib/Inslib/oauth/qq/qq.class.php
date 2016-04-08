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
class QqTOAuthV2 {
    public $appid = '';
    public $appkey = '';
    public $scope = 'get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo';
    private $_authorize_url = 'https://graph.qq.com/oauth2.0/authorize';
    function __construct($appid, $appkey) {
        $this->appid = $appid;
        $this->appkey = $appkey;
    }
    function getAuthorizeURL($callback) {
        $state = md5(uniqid(rand(), TRUE));
        $url = $this->_authorize_url . "?response_type=code&client_id="
          . $this->appid . "&redirect_uri=" . urlencode($callback)
          . "&state=" . $state
          . "&scope=".$this->scope;
        cookie('qq_state', $state);
      	return $url;
    }
    function getAccessToken($keys) {
        $qq_state = cookie('qq_state');
        if ($keys['state'] == $qq_state) {
            $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
              . "client_id=" . $this->appid . "&redirect_uri=" . urlencode($keys['redirect_uri'])
              . "&client_secret=" . $this->appkey . "&code=" . $keys["code"];
            $response = $this->get_url_contents($token_url);
            if (!$response) {
                exit('system error');
            }
            if (strpos($response, "callback") !== false) {
                $lpos = strpos($response, "(");
                $rpos = strrpos($response, ")");
                $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
                $msg = json_decode($response);
                if (isset($msg->error))
                {
                    echo "<h3>error:</h3>" . $msg->error;
                    echo "<h3>msg  :</h3>" . $msg->error_description;
                    exit;
                }
            }
            $params = array();
            parse_str($response, $params);
            return $params;
        } else {
            echo("The state does not match. You may be a victim of CSRF.");
        }
    }
    function getOpenid($access_token) {
        $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" . $access_token;
        $str  = $this->get_url_contents($graph_url);
        if (strpos($str, "callback") !== false) {
            $lpos = strpos($str, "(");
            $rpos = strrpos($str, ")");
            $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
        }
        $user = json_decode($str);
        if (isset($user->error)) {
            echo "<h3>error:</h3>" . $user->error;
            echo "<h3>msg  :</h3>" . $user->error_description;
            exit;
        }
        return $user->openid;
    }
    function getUserInfo($access_token, $openid) {
        $get_user_info = "https://graph.qq.com/user/get_user_info?"
            . "access_token=".$access_token
            . "&oauth_consumer_key=".$this->appid
            . "&openid=".$openid
            . "&format=json";
        $info = $this->get_url_contents($get_user_info);
        $arr = json_decode($info, true);
        return $arr;
    }
    function add_topic($access_token, $openid, $topic) {
        $url  = "https://graph.qq.com/shuoshuo/add_topic";
        $data = "access_token=".$access_token
            ."&oauth_consumer_key=".$this->appid
            ."&openid=".$openid
            ."&format=".$topic["format"]
            ."&richtype=".$topic["richtype"]
            ."&richval=".urlencode($topic["richval"])
            ."&con=".urlencode($topic["con"])
            ."&lbs_nm=".$topic["lbs_nm"]
            ."&lbs_x=".$topic["lbs_x"]
            ."&lbs_y=".$topic["lbs_y"]
            ."&third_source=".$topic["third_source"];
        $ret = $this->do_post($url, $data);
        return $ret;
    }
    function do_post($url, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_URL, $url);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }
    function get_url_contents($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $result =  curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}