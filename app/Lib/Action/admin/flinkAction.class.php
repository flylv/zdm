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
class flinkAction extends backendAction
{
    public function _initialize()
    {
        parent::_initialize();
        $this->_mod = D('flink');
    }
    protected function _search() {
        $map = array();
        ($cate_id = $this->_request('cate_id', 'trim')) && $map['cate_id'] = array('eq', $cate_id);
        ($keyword = $this->_request('keyword', 'trim')) && $map['name'] = array('like', '%'.$keyword.'%');
        $this->assign('search', array(
            'keyword' => $keyword,
            'cate_id' => $cate_id,
        ));
        return $map;
    }
    public function _before_index() {
        $big_menu = array(
            'title' => L('add_flink'),
            'iframe' => U('flink/add'),
            'id' => 'add',
            'width' => '500',
        );
        $this->assign('big_menu', $big_menu);
        $this->list_relation = true;
        $this->_before_add();
        $this->assign('img_dir',$this->_get_imgdir());
        $this->sort = 'id';
        $this->order = 'desc';
    }
    public function _before_add() {
        $cate_list = D('flink_cate')->where(array('status'=>1))->select();
        $this->assign('cate_list',$cate_list);
    }
    public function _before_edit()
    {
        $this->_before_add();
        $this->assign('img_dir',$this->_get_imgdir());
    }
    public function ajax_upload_img() {
        if (!empty($_FILES['img']['name'])) {
            $result = $this->_upload($_FILES['img'], 'flink');
            if ($result['error']) {
                $this->ajaxReturn(0, $result['info']);
            } else {
                $data['img'] = $result['info'][0]['savename'];
                $this->ajaxReturn(1, L('operation_success'), $data['img']);
            }
        } else {
            $this->ajaxReturn(0, L('illegal_parameters'));
        }
    }
    public function ajax_check_name()
    {
        $name = $this->_get('name', 'trim');
        $id = $this->_get('id', 'intval');
        if ($this->_mod->name_exists($name, $id)) {
            $this->ajaxReturn(0, '链接名称已经存在');
        } else {
            $this->ajaxReturn();
        }
    }
    private function _get_imgdir() {
        static $dir = null;
        if ($dir === null) {
            $dir = './data/upload/flink/';
        }
        return $dir;
    }
}