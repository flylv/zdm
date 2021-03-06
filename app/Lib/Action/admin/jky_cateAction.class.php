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
class jky_cateAction extends backendAction {
    public function index() {
        $sort = $this->_request("sort", 'trim', 'ordid');
        $order = $this->_request("order", 'trim', 'ASC');
        $tree = new Tree();
        $tree->icon = array('│ ','├─ ','└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $result = $this->_mod->order($sort . ' ' . $order)->select();
        $array = array();
        foreach($result as $r) {
            $r['str_img'] = $r['img'] ? '<div class="img_border"><img src="'.$r['_img'].'" width="26" height="26" class="J_preview" data-bimg="'.$r['_img'].'"/></div>' : '';
            $r['str_status'] = '<img data-tdtype="toggle" data-id="'.$r['id'].'" data-field="status" data-value="'.$r['status'].'" src="__TMPL__public/images/toggle_' . ($r['status'] == 0 ? 'disabled' : 'enabled') . '.gif" />';
            $r['str_manage'] = '<a href="javascript:;" class="J_showdialog" data-uri="'.U(MODULE_NAME.'/add',array('pid'=>$r['id'])).'" data-title="'.L('add_article_cate').'" data-id="add" data-width="500" data-height="360">'.L('add_article_subcate').'</a> |
                                <a href="javascript:;" class="J_showdialog" data-uri="'.U(MODULE_NAME.'/edit',array('id'=>$r['id'])).'" data-title="'.L('edit').' - '. $r['name'] .'" data-id="edit" data-width="500" data-height="360">'.L('edit').'</a> |
                                <a href="javascript:;" data-acttype="ajax" class="J_confirmurl" data-uri="'.U(MODULE_NAME.'/delete',array('id'=>$r['id'])).'" data-msg="'.sprintf(L('confirm_delete_one'),$r['name']).'">'.L('delete').'</a>';
            $r['parentid_node'] = ($r['pid'])? ' class="child-of-node-'.$r['pid'].'"' : '';
            $r['cate_type'] = $r['type'] ? '<span class="blue">'.L('article_cate_type_'.$r['type']).'</span>' : L('article_cate_type_'.$r['type']);
            $array[] = $r;
        }
        $str  = "<tr id='node-\$id' \$parentid_node>
                <td align='center'><input type='checkbox' value='\$id' class='J_checkitem'></td>
                <td>\$spacer<span data-tdtype='edit' data-field='name' data-id='\$id' class='tdedit'>\$name</span></td>
                <td align='center'>\$id</td>
                <td align='center'>\$str_img</td>
                <td align='center'><span data-tdtype='edit' data-field='ordid' data-id='\$id' class='tdedit'>\$ordid</span></td>
                <td align='center'>\$str_status</td>
                <td align='center'>\$str_manage</td>
                </tr>";
        $tree->init($array);
        $list = $tree->get_tree(0, $str);
        $this->assign('list', $list);
        $big_menu = array(
            'title' => L('add_cate'),
            'iframe' => U(MODULE_NAME.'/add'),
            'id' => 'add',
            'width' => '500',
            'height' => '360'
        );
        $this->assign('big_menu', $big_menu);
        $this->assign('list_table', true);
        $this->display();
    }
    public function _before_add() {
        $pid = $this->_get('pid', 'intval', 0);
        if ($pid) {
            $spid = $this->_mod->where(array('id'=>$pid))->getField('spid');
            $spid = $spid ? $spid.$pid : $pid;
            $this->assign('spid', $spid);
        }
    }
    protected function _before_insert($data = '') {
        if($this->_mod->name_exists($data['name'], $data['pid'])){
            $this->ajaxReturn(0, L('article_cate_already_exists'));
        }
        $data['spid'] = $this->_mod->get_spid($data['pid']);
        return $data;
    }
    protected function _before_update($data = '') {
        if ($this->_mod->name_exists($data['name'], $data['pid'], $data['id'])) {
            $this->ajaxReturn(0, L('article_cate_already_exists'));
        }
        $old_pid = $this->_mod->field('img,pid')->where(array('id'=>$data['id']))->find();
        if ($data['pid'] != $old_pid['pid']) {
            $wp_spid_arr = $this->_mod->get_child_ids($data['id'], true);
            if (in_array($data['pid'], $wp_spid_arr)) {
                $this->ajaxReturn(0, L('cannot_move_to_child'));
            }
        }
        $data['spid'] = $this->_mod->get_spid($data['pid']);
        return $data;
    }
    protected function _before_delete(){
        $id=intval($_REQUEST['id']);
        $ids=get_child_ids($this->_mod,$id);        
        $this->_mod->where("id in($ids)")->delete();         
    }
}