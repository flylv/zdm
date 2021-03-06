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
class messageAction extends backendAction{
    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('message');
    }
    public function _before_index() {
        $type = $this->_get('type','intval',1);
        if( $type==1 ){
            $big_menu = array(
                'title' => '发送通知',
                'iframe' => U('message/add'),
                'id' => 'add',
                'width' => '500',
                'height' => '320'
            );
            $this->assign('big_menu', $big_menu);
        }
        $this->assign('type',$type);
    }
    protected function _search() {
        $map = array();
        ($time_start = $this->_request('time_start', 'trim')) && $map['add_time'][] = array('egt', strtotime($time_start));
        ($time_end = $this->_request('time_end', 'trim')) && $map['add_time'][] = array('elt', strtotime($time_end)+(24*60*60-1));
        ($keyword = $this->_request('keyword', 'trim')) && $map['info'] = array('like', '%'.$keyword.'%');
        ($from_name = $this->_request('from_name', 'trim')) && $map['from_name'] = array('like', '%'.$from_name.'%');
        ($to_name = $this->_request('to_name', 'trim')) && $map['to_name'] = array('like', '%'.$to_name.'%');
        $type = $this->_request('type', 'intval');
        if( $type ){
            if( $type==1 ){
                $map['from_id'] = 0;
            }else if( $type==2 ){
                $map['from_id'] = array('gt',0);
            }
        }
        $this->assign('search', array(
            'time_start' => $time_start,
            'time_end' => $time_end,
            'from_name' => $from_name,
            'to_name'   => $to_name,
            'type'  => $type,
            'keyword' => $keyword,
        ));
        return $map;
    }
    public function add() {
        if (IS_POST) {
            $type = $this->_post('type', 'trim', 'custom');
            $to_name = $this->_post('to_name', 'trim');
            $from_user = session('admin');
            $from_name = $from_user['username'];
            $to_user = array(array('id'=>'0', 'username'=>'0'));
            if ($to_name) {
                $to_name = split(PHP_EOL, $to_name);
                $to_user = D('user')->field('id,username')->where(array('username'=>array('in', $to_name)))->select();
            }
            if ($type == 'custom') {
                $info = $this->_post('info', 'trim');
                !$info && $this->ajaxReturn(0, L('message_empty'));
            } else {
                $tpl_alias = $this->_post('tpl_alias', 'trim');
            }
            $message_tpl_mod = D('message_tpl');
            $user_msgtip_mod = D('user_msgtip');
            foreach ($to_user as $val) {
                if ($type == 'tpl') {
                    $info = $message_tpl_mod->get_msg_info($tpl_alias, array('username'=>$val['username']));
                    !$info && $this->ajaxReturn(0, L('message_tplfile_notexists'));
                }
                $this->_mod->create(array(
                    'ftid' => $val['id'],
                    'from_id' => 0,
                    'from_name' => $from_name,
                    'to_id' => $val['id'],
                    'to_name' => $val['username'],
                    'info' => $info,
                ));
                $this->_mod->add();
                if ($val['id'] != '0') {
                    $user_msgtip_mod->add_tip($val['id'], 4);
                }
            }
            $this->ajaxReturn(1, L('operation_success'), '', 'add');
        } else {
            $tpl_list = D('message_tpl')->field('id,alias,name')->where(array('type'=>'msg', 'is_sys'=>'0'))->select();
            $this->assign('tpl_list', $tpl_list);
            $response = $this->fetch();
            $this->ajaxReturn(1, '', $response);
        }
    }
}