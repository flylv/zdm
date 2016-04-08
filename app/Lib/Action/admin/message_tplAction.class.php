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
class message_tplAction extends backendAction
{
    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('message_tpl');
    }
    protected function _search() {
        $type = $this->_get('type', 'trim');
        $map = array();
        $map['type'] = $type;
        if( $keyword = $this->_request('keyword', 'trim') ){
            $map['_string'] = "name like '%".$keyword."%' OR alias like '%".$keyword."%'";
        }
        $this->assign('search', array(
            'keyword' => $keyword,
        ));
        return $map;
    }
}