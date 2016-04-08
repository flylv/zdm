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
class score_orderAction extends backendAction
{
    public function _initialize()
    {
        parent::_initialize();
        $this->_mod = D('score_order');
        $this->_cate_mod = D('score_item_cate');
    }
    protected function _search() {
        $map = array();
        ($time_start = $this->_request('time_start', 'trim')) && $map['add_time'][] = array('egt', strtotime($time_start));
        ($time_end = $this->_request('time_end', 'trim')) && $map['add_time'][] = array('elt', strtotime($time_end)+(24*60*60-1));
        ($order_score_min = $this->_request('order_score_min', 'trim')) && $map['order_score'][] = array('egt', $order_score_min);
        ($order_score_max = $this->_request('order_score_max', 'trim')) && $map['order_score'][] = array('elt', $order_score_max);
        ($rates_min = $this->_request('rates_min', 'trim')) && $map['rates'][] = array('egt', $rates_min);
        ($rates_max = $this->_request('rates_max', 'trim')) && $map['rates'][] = array('elt', $rates_max);
        ($uname = $this->_request('uname', 'trim')) && $map['uname'] = array('like', '%'.$uname.'%');
        $cate_id = $this->_request('cate_id', 'intval') && $map['cate_id'] = array('IN', $cate_id);
        if( $_GET['status']==null ){
            $status = -1;
        }else{
            $status = intval($_GET['status']);
        }
        $status>=0 && $map['status'] = array('eq',$status);
        ($keyword = $this->_request('keyword', 'trim')) && $map['order_sn'] = array('like', '%'.$keyword.'%');
        $this->assign('search', array(
            'time_start' => $time_start,
            'time_end' => $time_end,
            'order_score_min' => $order_score_min,
            'order_score_max' => $order_score_max,
            'rates_min' => $rates_min,
            'rates_max' => $rates_max,
            'uname' => $uname,
            'status' =>$status,
            'cate_id' => $cate_id,
            'keyword' => $keyword,
        ));
        return $map;
    }
    public function _before_index(){
        $cate_lists = $this->_cate_mod->field('id,name')->select();
        $this->assign('cate_lists',$cate_lists);
    }
    public function _before_update($data){
        $data['status']=1;
        return $data;
    }
}