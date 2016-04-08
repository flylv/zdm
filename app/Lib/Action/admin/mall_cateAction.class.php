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
class mall_cateAction extends backendAction {
    public function _initialize() {
        parent::_initialize();
        $this->_mod = D(MODULE_NAME);
    }
    function _before_index(){
        $big_menu = array(
            'title' => L('add_cate'),
            'iframe' => U(MODULE_NAME.'/add'),
            'id' => 'add',
            'width' => '500',
            'height' => '360'
        );
        $this->assign('big_menu', $big_menu);        
    }  
    public function ajax_getchilds() {
        $id = $this->_get('id', 'intval');
        $return = $this->_mod->field('id,title')->where(array('pid'=>$id))->select();
        if ($return) {
            $this->ajaxReturn(1, L('operation_success'), $return);
        } else {
            $this->ajaxReturn(0, L('operation_failure'));
        }
    }    
}