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
class exchangeAction extends frontendAction {
    public function _initialize() {
        parent::_initialize();
        $this->assign('nav_curr', 'exchange');
    }
    public function index() {
        $cid = $this->_get('cid', 'intval');
        $sort = $this->_get('sort', 'trim', 'hot');
        switch ($sort) {
            case 'hot':
                $sort_order = 'buy_num DESC,id DESC';
                break;
            case 'new':
                $sort_order = 'id DESC';
                break;
        }
        $cname = D('score_item_cate')->get_name($cid);
        $where = array('status'=>'1');
        $cid && $where['cate_id'] = $cid;
        $score_item = D('score_item');
        $count = $score_item->where($where)->count('id');
        $pager = $this->_pager($count, 20);
        $item_list = $score_item->where($where)->order($sort_order)->limit($pager->firstRow.','.$pager->listRows)->select();
        $this->assign('item_list', $item_list);
        $this->assign('page_bar', $pager->fshow());
        $this->assign('cid', $cid);
        $this->assign('sort', $sort);
        $this->assign('cname', $cname);
        $this->_config_seo(C('pin_seo_config.exchange')); 
        $this->display();
    }
    public function detail() {
        $id = $this->_get('id', 'intval');
        !$id && $this->_404();
        $item_mod = D('score_item');
        $item = $item_mod->field('id,cate_id,title,img,score,stock,user_num,buy_num,desc')->find($id);
        $exchange_desc = D('article_page')->where(array('cate_id'=>'7'))->getField('info');
        $cname = D('score_item_cate')->get_name($item['cate_id']);
        $this->assign('exchange_desc', $exchange_desc);
        $this->assign('item', $item);
        $this->assign('cname', $cname);
        $this->assign('score_rule',C('pin_score_rule'));
        $this->_config_seo(C('pin_seo_config.exchange_info'),array(
            'exchange_title'=>$item['title'],
        )); 
        $this->display();
    }
    public function ec() {
        !$this->visitor->is_login && $this->ajaxReturn(0, L('login_please'));
        $id = $this->_get('id', 'intval');
        $num = $this->_get('num', 'intval', 1);
        if (!$id || !$num) $this->ajaxReturn(0, L('invalid_item'));
        $item_mod = D('score_item');
        $user_mod = D('user');
        $order_mod = D('score_order');
        $uid = $this->visitor->info['id'];
        $uname = $this->visitor->info['username'];
        $item = $item_mod->find($id);
        !$item && $this->ajaxReturn(0, L('invalid_item'));
        !$item['stock'] && $this->ajaxReturn(0, L('no_stock'));
        $user_score = $user_mod->where(array('id'=>$uid))->getField('score');
        $user_score < $item['score'] && $this->ajaxReturn(0, L('no_score'));
        $eced_num = $order_mod->where(array('uid'=>$uid, 'item_id'=>$item['id']))->sum('item_num');
        if ($item['user_num'] && $eced_num + $num > $item['user_num']) {
            $this->ajaxReturn(0, sprintf(L('ec_user_maxnum'), $item['user_num']));
        }
        $order_score = $num * $item['score'];
        $data = array(
            'uid' => $uid,
            'uname' => $uname,
            'item_id' => $item['id'],
            'item_name' => $item['title'],
            'item_num' => $num,
            'order_score' => $order_score,
        );
        if (false === $order_mod->create($data)) {
            $this->ajaxReturn(0, L('ec_failed'));
        }
        $order_id = $order_mod->add();
        $user_mod->where(array('id'=>$uid))->setDec('score', $order_score);
        $score_log_mod = D('score_log');
        $score_log_mod->create(array(
            'uid' => $uid,
            'uname' => $uname,
            'action' => 'exchange',
            'score' => $order_score*-1,
        ));
        $score_log_mod->add();
        $item_mod->save(array(
            'id' => $item['id'],
            'stock' => $item['stock'] - $num,
            'buy_num' => $item['buy_num'] + $num,
        ));
        if ($item['type'] == '1') {
            $this->ajaxReturn(1, L('ec_success'));
        } else {
            $address_list = D('user_address')->field('id,consignee,address,zip,mobile')->where(array('uid'=>$uid))->select();
            $this->assign('address_list', $address_list);
            $this->assign('order_id', $order_id);
            $resp = $this->fetch('dialog:address');
            $this->ajaxReturn(2, L('please_input_address'), $resp);
        }
    }
    public function address() {
        !$this->visitor->is_login && $this->ajaxReturn(0, L('login_please'));
        $order_id = $this->_post('order_id', 'intval');
        $address_id = $this->_post('address_id', 'intval');
        $consignee = $this->_post('consignee', 'trim');
        $address = $this->_post('address', 'trim');
        $zip = $this->_post('zip', 'trim');
        $mobile = $this->_post('mobile', 'trim');
        if (!$address_id && (!$order_id || !$consignee || !$address || !$mobile)) {
            $this->ajaxReturn(0, L('please_input_address_info'));
        }
        $order_mod = D('score_order');
        if (!$order_mod->where(array('uid'=>$this->visitor->info['id'], 'id'=>$order_id))->count('id')) {
            $this->ajaxReturn(0, L('order_not_foryou'));
        }
        $user_address_mod = D('user_address');
        if ($address_id) {
            $address = $user_address_mod->field('consignee,address,zip,mobile')->find($address_id);
        } else {
            $address = array(
                'uid' => $this->visitor->info['id'],
                'consignee' => $consignee,
                'address' => $address,
                'zip' => $zip,
                'mobile' => $mobile,
            );
            $user_address_mod->add($address);
        }
        $result = $order_mod->save(array(
            'id' => $order_id,
            'consignee' => $address['consignee'],
            'address' => $address['address'],
            'zip' => $address['zip'],
            'mobile' => $address['mobile'],
        ));
        $this->ajaxReturn(1, L('ec_success'));
    }
    public function rule() {
        $info = D('article_page')->find(6);
        $this->assign('info', $info);
        $this->_config_seo();
        $this->display();
    }
}