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
class zhaoshang_cateAction extends backendAction
{    public function _before_index() {
        $big_menu = array(
            'title' => L('add_zhaoshang_cate'),
            'iframe' => U('zhaoshang_cate/add'),
            'id' => 'add',
            'width' => '560',
            'height' => '100'
        );
        $this->assign('big_menu', $big_menu);
        $this->sort = 'ordid';
        $this->order = 'ASC';
    }    public function _before_delete() {
        $ids = trim($this->_request('id'), ',');
        $ids_arr = explode(',', $ids);
        foreach ($ids_arr as $val) {
            if (D('zhaoshang_item')->where(array('cid'=>$val))->count()) {
                IS_AJAX && $this->ajaxReturn(0, '分类下面存在数据，不能删除！');
                $this->error('分类下面存在数据，不能删除！');
            }
        }
    }    public function ajax_check_name() {
        $name = $this->_get('name', 'trim');
        $id = $this->_get('id', 'intval');
        if (D('zhaoshang_cate')->name_exists($name, $id)) {
            $this->ajaxReturn(0, L('zhaoshang_cate_already_exists'));
        } else {
            $this->ajaxReturn(1);
        }
    }
}