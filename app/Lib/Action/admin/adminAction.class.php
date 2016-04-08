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
class adminAction extends backendAction
{
    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('admin');
    }
    public function _before_index() {
        $big_menu = array(
            'title' => '添加管理员',
            'iframe' => U('admin/add'),
            'id' => 'add',
            'width' => '500',
            'height' => '210'
        );
        $this->assign('big_menu', $big_menu);
        $this->list_relation = true;
    }
    public function _before_add() {
        $role_list = D('admin_role')->where('status=1')->select();
        $this->assign('role_list', $role_list);
    }
    public function _before_insert($data='') {
        if( ($data['password']=='')||(trim($data['password']=='')) ){
            unset($data['password']);
        }else{
            $data['password'] = md5($data['password']);
        }
        return $data;
    }
    public function _before_edit() {
        $this->_before_add();
    }
    public function _before_update($data=''){
        if( ($data['password']=='')||(trim($data['password']=='')) ){
            unset($data['password']);
        }else{
            $data['password'] = md5($data['password']);
        }
        return $data;
    }
    public function ajax_check_name() {
        $name = $this->_get('username', 'trim');
        $id = $this->_get('id', 'intval');
        if ($this->_mod->name_exists($name, $id)) {
            echo 0;
        } else {
            echo 1;
        }
    }
}