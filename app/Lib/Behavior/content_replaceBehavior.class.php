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
defined('THINK_PATH') or exit();
class content_replaceBehavior extends Behavior {
    public function run(&$content){
        $content = $this->_replace($content);
    }
    private function _replace($content) {
        $replace = array();
        $statics_url = C('pin_statics_url');
        if ($statics_url != '') {
            $replace['__STATIC__'] = $statics_url;
        } else {
            $replace['__STATIC__'] = __ROOT__.'/static';
        }
        $replace['__UPLOAD__'] = __ROOT__.'/data/upload';
        $replace['__ASSETS__'] = __ROOT__."/app/Tpl/".GROUP_NAME;
        if(C("DEFAULT_THEME")){
            $replace['__ASSETS__'].="/".C("DEFAULT_THEME");    
        }
        $replace['__ASSETS__'].="/public";
        $site_logo = C('pin_site_logo');
        $replace['__LOGO__'] = __ROOT__.'/data/upload/logo/' .$site_logo[C('DEFAULT_THEME')];
        $replace['__SITEROOT__'] =__SITEROOT__;
        $content = str_replace(array_keys($replace),array_values($replace),$content);
        return $content;
    }
}