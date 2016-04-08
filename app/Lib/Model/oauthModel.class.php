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
class oauthModel extends baseModel
{
    public function get_installed() {
        $installed_list = array();
        $installed_res = $this->order('ordid')->select();
        foreach ($installed_res as $val) {
            $installed_list[$val['code']] = $val;
        }
        return $installed_list;
    }
    public function oauth_cache() {
        $oauth_list = array();
        $oauth_data = $this->field('code,name,config')->where(array('status'=>'1'))->order('ordid')->select();
        foreach ($oauth_data as $val) {
            $oauth_list[$val['code']] = $val;
        }
        F('oauth_list', $oauth_list);
        return $oauth_list;
    }
    public function get_file_info($code) {
        return include(LIB_PATH . 'Inslib/oauth/'.$code.'/info.php');
    }
    protected function _before_write($data, $options) {
        F('oauth_list', NULL);
    }
    protected function _after_delete($data, $options) {
        F('oauth_list', NULL);
    }
}