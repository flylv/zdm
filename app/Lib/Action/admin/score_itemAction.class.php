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
class score_itemAction extends backendAction
{
    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('score_item');
        $this->_cate_mod =D('score_item_cate');
    }
    public function _before_index() {
        $this->sort = 'ordid';
        $this->order = 'ASC';
        $res = $this->_cate_mod->field('id,name')->select();
        $cate_list = array();
        foreach ($res as $val) {
            $cate_list[$val['id']] = $val['name'];
        }
        $this->assign('cate_list', $cate_list);
    }
    protected function _search() {
        $map = array();
        ($cate_id = $this->_request('cate_id', 'trim')) && $map['cate_id'] = array('eq', $cate_id);
        ($keyword = $this->_request('keyword', 'trim')) && $map['title'] = array('like', '%'.$keyword.'%');
        $this->assign('search', array(
            'keyword' => $keyword,
            'cate_id' => $cate_id,
        ));
        return $map;
    }
    public function _before_add() {
        $cate_list = $this->_cate_mod->field('id,name')->select();
        $this->assign('cate_list',$cate_list);
    }
    public function _before_edit() {
        $this->_before_add();
    }
    protected function _before_insert($data) {
        if (!empty($_FILES['img']['name'])) {
            $time_dir = date('ym/d');
            $result = $this->_upload($_FILES['img'], 'score_item/' . $time_dir, array(
                'width' => C('pin_score_item_img.swidth').','.C('pin_score_item_img.bwidth'),
                'height' => C('pin_score_item_img.sheight').','.C('pin_score_item_img.bheight'),
                'suffix' => '_s,_b',
                'remove_origin' => true
            ));
            if ($result['error']) {
                $this->error($result['info']);
            } else {
                $ext = array_pop(explode('.', $result['info'][0]['savename']));
                $data['img'] = $time_dir .'/'. str_replace('.' . $ext, '_s.' . $ext, $result['info'][0]['savename']);
            }
        }
        return $data;
    }
    protected function _before_update($data) {
        if (!empty($_FILES['img']['name'])) {
            $time_dir = date('ym/d');
            $old_img = $this->_mod->where(array('id'=>$data['id']))->getField('img');
            $old_img = 'score_item/' . $time_dir . $old_img;
            is_file($old_img) && @unlink($old_img);
            $result = $this->_upload($_FILES['img'], 'score_item/' . $time_dir, array(
                'width' => C('pin_score_item_img.swidth').','.C('pin_score_item_img.bwidth'),
                'height' => C('pin_score_item_img.sheight').','.C('pin_score_item_img.bheight'),
                'suffix' => '_s,_b',
                'remove_origin' => true
            ));
            if ($result['error']) {
                $this->error($result['info']);
            } else {
                $ext = array_pop(explode('.', $result['info'][0]['savename']));
                $data['img'] = $time_dir .'/'. str_replace('.' . $ext, '_s.' . $ext, $result['info'][0]['savename']);
            }
        } else {
            unset($data['img']);
        }
        return $data;
    }
}