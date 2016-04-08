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
class post_baoliaoAction extends backendAction
{
    var $list_relation=true;
    public function _initialize() {
        parent::_initialize();
        $this->assign('type_list',array(
            '爆料','投稿','建议'
        ));
    }
    protected function _search() {
        $map = array();
        ($time_start = $this->_request('time_start', 'trim')) && $map['add_time'][] = array('egt', strtotime($time_start));
        ($time_end = $this->_request('time_end', 'trim')) && $map['add_time'][] = array('elt', strtotime($time_end)+(24*60*60-1));
        ($keyword = $this->_request('keyword', 'trim')) && $map['title'] = array('like', '%'.$keyword.'%');
        $type= $this->_request('type');        
        if($type!=null&&intval($type)>=0){
            $map['type'] =$type;  
        }
        $this->assign('search', array(
            'time_start' => $time_start,
            'time_end' => $time_end,
            'type' => $type,
            'keyword' => $keyword,
        ));
        return $map;
    }    
}