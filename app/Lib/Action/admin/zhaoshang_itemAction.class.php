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
class zhaoshang_itemAction extends backendAction
{
    public function _initialize()
    {
        parent::_initialize();
        $this->_mod = D('zhaoshang_item');
    }    protected function _search() {
        $map = array();
        $status = $this->_request('status'); 
        if($status!=null){
            $map['status'] = $status;
        }
        ($cate_id = $this->_request('cate_id', 'trim')) && $map['cid'] = array('eq', $cate_id);
        ($keyword = $this->_request('keyword', 'trim')) && $map['title'] = array('like', '%'.$keyword.'%');
        $this->assign('search', array(
            'status' => $status,
            'keyword' => $keyword,
            'cate_id' => $cate_id,
        ));
        return $map;
    }    public function _before_index() {
        $cate_list = D('zhaoshang_cate')->where(array('status'=>1))->order("ordid desc")->select();
        $this->assign('cate_list',$cate_list);
        $zhaoshang_cate_list = array();
        foreach ($cate_list as $val) {
            $zhaoshang_cate_list[$val['id']] = $val['name'];
        }
        $this->assign('zhaoshang_cate_list', $zhaoshang_cate_list);  
        $this->sort = 'id';
        $this->order = 'desc';
    }}