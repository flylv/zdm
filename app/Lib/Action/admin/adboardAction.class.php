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
class adboardAction extends backendAction {
    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('adboard');
    }
    public function _before_index() {
        $tpl_list = $this->_mod->get_tpl_list();
        $this->assign('tpl_list', $tpl_list);
        $big_menu = array(
            'title' => L('adboard_add'),
            'iframe' => U('adboard/add'),
            'id' => 'add',
            'width' => '500',
            'height' => '280'
        );
        $this->assign('big_menu', $big_menu);
    }
    public function _before_add() {
        $tpl_list = $this->_mod->get_tpl_list();
        $this->assign('tpl_list', $tpl_list);
    }
    protected function _before_insert($data) {
        if ($this->_mod->name_exists($data['name'])) {
            $this->ajaxReturn(0, L('adboard_already_exists'));
        }
    }
    public function _before_edit() {
        $tpl_list = $this->_mod->get_tpl_list();
        $this->assign('tpl_list', $tpl_list);
    }
    protected function _before_update($data) {
        if ($this->_mod->name_exists($data['name'], $data['id'])) {
            $this->ajaxReturn(0, L('adboard_already_exists'));
        }
    }
    public function ajax_check_name() {
        $name = $this->_get('name', 'trim');
        $id = $this->_get('id', 'intval');
        if ($this->_mod->name_exists($name, $id)) {
            $this->ajaxReturn(0, L('adboard_already_exists'));
        } else {
            $this->ajaxReturn();
        }
    }
}