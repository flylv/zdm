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
class collect_alimamaAction extends backendAction {
    private $_tbconfig = null;
    public function _initialize() {
        parent::_initialize();
        $api_config = D('item_site')->where(array('code' => 'taobao'))->getField('config');
        $this->_tbconfig = unserialize($api_config);
    }
    public function index() {
        if (!function_exists("curl_getinfo")) {
            $this->error(L('curl_not_open'));
        }
        $item_cate = $this->_get_tbcats();
        $this->assign('item_cate', $item_cate);
        $this->display();
    }
    public function batch_publish() {
        if (IS_POST) {
            $cate_id = $this->_post('cate_id', 'intval');
            !$cate_id && $this->ajaxReturn(0, L('please_select') . L('publish_item_cate'));
            $auid = $this->_post('auid', 'intval');
            !$auid && $this->ajaxReturn(0, L('please_select') . L('auto_user'));
            $status = $this->_post('status', 'intval', 0);
            $page_num = $this->_post('page_num', 'intval', 10);
            $auto_user_mod = D('auto_user');
            $user_mod = D('user');
            $unames = $auto_user_mod->where(array('id' => $auid))->getField('users');
            $unamea = explode(',', $unames);
            $users = $user_mod->field('id,username')->where(array('username' => array('in', $unamea)))->select();
            !$users && $this->ajaxReturn(0, L('auto_user_error'));
            $form_data = $this->_post('form_data', 'urldecode');
            parse_str($form_data, $form_data);
            F('batch_publish_cache', array(
                'cate_id' => $cate_id,
                'status' => $status,
                'users' => $users,
                'page_num' => $page_num,
                'form_data' => $form_data,
            ));
            $this->ajaxReturn(1);
        } else {
            $auto_user = D('auto_user')->select(); 
            $this->assign('auto_user', $auto_user);
            $response = $this->fetch();
            $this->ajaxReturn(1, '', $response);
        }
    }
    public function batch_publish_do() {
        if (false === $batch_publish_cache = F('batch_publish_cache')) {
            $this->ajaxReturn(0, L('illegal_parameters'));
        }
        $p = $this->_get('p', 'intval', 1);
        if ($p > $batch_publish_cache['page_num']) {
            $this->ajaxReturn(0, L('import_success'));
        }
        $result = $this->_get_list($batch_publish_cache['form_data'], $p);
        if ($result['item_list']) {
            foreach ($result['item_list'] as $val) {
                $val['status'] = $batch_publish_cache['status'];
                $this->_publish_insert($val, $batch_publish_cache['cate_id'], $batch_publish_cache['users']);
            }
            $this->ajaxReturn(1);
        } else {
            $this->ajaxReturn(0, L('import_success'));
        }
    }
    public function search() {
        $taobaoke_item_list = array();
        if ($this->_get('search')) {
            $map['keyword'] = $this->_get('keyword', 'trim'); 
            $map['cid'] = $this->_get('cid', 'intval'); 
            $p = $this->_get('p', 'intval', 1);
            if ($p > 10) {
                $this->redirect('collect_alimama/search', array('keyword' => $map['keyword'], 'cid' => $map['cid'], 'search' => 1));
            }
            if (!$map['keyword'] && !$map['cid']) {
                $this->error(L('select_cid_or_keyword'));
            }
            $map['start_price'] = $this->_get('start_price', 'trim'); 
            $map['end_price'] = $this->_get('end_price', 'trim'); 
            $map['start_commissionRate'] = $this->_get('start_commissionRate', 'trim'); 
            $map['end_commissionRate'] = $this->_get('end_commissionRate', 'trim'); 
            $map['start_commissionNum'] = $this->_get('start_commissionNum', 'intval'); 
            $map['end_commissionNum'] = $this->_get('end_commissionNum', 'intval'); 
            $map['start_totalnum'] = $this->_get('start_totalnum', 'intval'); 
            $map['end_totalnum'] = $this->_get('end_totalnum', 'intval'); 
            $map['start_credit'] = $this->_get('start_credit', 'trim'); 
            $map['end_credit'] = $this->_get('end_credit', 'trim'); 
            $map['mall_item'] = $this->_get('mall_item', 'intval'); 
            $map['guarantee'] = $this->_get('guarantee', 'intval'); 
            $map['sevendays_return'] = $this->_get('sevendays_return', 'intval'); 
            $map['real_describe'] = $this->_get('real_describe', 'intval'); 
            $map['cash_coupon'] = $this->_get('cash_coupon', 'intval'); 
            $map['sort'] = $this->_get('sort', 'trim'); 
            $map['like_init'] = $this->_get('like_init', 'trim');
            $result = $this->_get_list($map, $p);
            $pager = new Page($result['count'], 20);
            $page = $pager->show();
            $this->assign("page", $page);
            $taobaoke_item_list = $result['item_list'];
        }
        $taobaoke_item_list && F('taobaoke_item_list', $taobaoke_item_list);
        $this->assign('list', $taobaoke_item_list);
        $this->assign('list_table', true);
        $this->display();
    }
    public function publish() {
        if (IS_POST) {
            $ids = $this->_post('ids', 'trim');
            $cate_id = $this->_post('cate_id', 'intval');
            !$cate_id && $this->ajaxReturn(0, L('please_select') . L('publish_item_cate'));
            $auid = $this->_post('auid', 'intval');
            !$auid && $this->ajaxReturn(0, L('please_select') . L('auto_user'));
            $status = $this->_post('status', 'intval', 0);
            $auto_user_mod = D('auto_user');
            $user_mod = D('user');
            $unames = $auto_user_mod->where(array('id' => $auid))->getField('users');
            $unamea = explode(',', $unames);
            $users = $user_mod->field('id,username')->where(array('username' => array('in', $unamea)))->select();
            !$users && $this->ajaxReturn(0, L('auto_user_error'));
            $ids_arr = explode(',', $ids);
            $taobaoke_item_list = F('taobaoke_item_list');
            foreach ($taobaoke_item_list as $key => $val) {
                if (in_array($key, $ids_arr)) {
                    $val['status'] = $status;
                    $this->_publish_insert($val, $cate_id, $users);
                }
            }
            $this->ajaxReturn(1, L('operation_success'), '', 'publish');
        } else {
            $ids = trim($this->_get('id'), ',');
            $this->assign('ids', $ids);
            $auto_user = D('auto_user')->select();
            $this->assign('auto_user', $auto_user);
            $response = $this->fetch();
            $this->ajaxReturn(1, '', $response);
        }
    }
    private function _publish_insert($item, $cate_id, $users) {
        $user_rand = array_rand($users);
        $item['title'] = strip_tags($item['title']);
        $item['click_url'] = Url::replace($item['click_url'], array('spm' => '2014.21069764.' . $this->_tbconfig['app_key'] . '.0'));
        $insert_item = array(
            'key_id' => 'taobao_' . $item['num_iid'],
            'taobao_sid' => $item['taobao_sid'],
            'cate_id' => $cate_id,
            'uid' => $users[$user_rand]['id'],
            'uname' => $users[$user_rand]['username'],
            'title' => $item['title'],
            'intro' => $item['title'],
            'img' => $item['pic_url'],
            'price' => $item['price'],
            'url' => $item['click_url'],
            'rates' => $item['commission_rate'] / 100,
            'likes' => $item['likes'],
            'imgs' => $item['imgs'],
            'status' => $item['status'],
        );
        if (empty($item['imgs'])) {
            $insert_item['imgs'] = array(array(
                    'url' => $insert_item['img'],
                    ));
        }
        $result = D('item')->publish($insert_item);
        return $result;
    }
    public function ajax_get_tbcats() {
        $cid = $this->_get('cid', 'intval', 0);
        $item_cate = $this->_get_tbcats($cid);
        if ($item_cate) {
            $this->ajaxReturn(1, '', $item_cate);
        } else {
            $this->ajaxReturn(0);
        }
    }
    private function _get_list($map, $p) {
        $tb_top = $this->_get_tb_top();
        $req = $tb_top->load_api('TaobaokeItemsGetRequest');
        $req->setFields('num_iid,title,nick,pic_url,price,click_url,commission,commission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume');
        $req->setPageNo($p);
        $req->setPageSize(20);
        $map['keyword'] && $req->setKeyword($map['keyword']); 
        $map['cid'] && $req->setCid($map['cid']); 
        $map['start_price'] && $req->setStartPrice($map['start_price']); 
        $map['end_price'] && $req->setEndPrice($map['end_price']); 
        $map['start_commissionRate'] && $req->setStartCommissionRate($map['start_commissionRate'] * 100); 
        $map['end_commissionRate'] && $req->setEndCommissionRate($map['end_commissionRate'] * 100); 
        $map['start_commissionNum'] && $req->setStartCommissionNum($map['start_commissionNum']); 
        $map['end_commissionNum'] && $req->setEndCommissionNum($map['end_commissionNum']); 
        $map['start_totalnum'] && $req->setStartTotalnum($map['start_totalnum']); 
        $map['end_totalnum'] && $req->setEndTotalnum($map['end_totalnum']); 
        $map['start_credit'] && $req->setStartCredit($map['start_credit']); 
        $map['end_credit'] && $req->setEndCredit($map['end_credit']); 
        $map['mall_item'] && $req->setMallItem('true'); 
        $map['guarantee'] && $req->setGuarantee('true'); 
        $map['sevendays_return'] && $req->setSevendaysReturn('true'); 
        $map['real_describe'] && $req->setRealDescribe('true'); 
        $map['cash_coupon'] && $req->setCashCoupon('true'); 
        $map['sort'] && $req->setSort($map['sort']);
        $req->setStartCommissionRate(1000);
        $req->setEndCommissionRate(2000);
        $resp = $tb_top->execute($req);
        $count = $resp->total_results;
        $iids = array();
        $resp_items = (array) $resp->taobaoke_items;
        $taobaoke_item_list = array();
        foreach ($resp_items['taobaoke_item'] as $val) {
            $val = (array) $val;
            switch ($map['like_init']) {
                case 'volume':
                    $val['likes'] = $val['volume'];
                    break;
                default:
                    $val['likes'] = 0;
                    break;
            }
            $taobaoke_item_list[$val['num_iid']] = $val;
        }
        $iids = array_keys($taobaoke_item_list);
        $req = $tb_top->load_api('ItemsListGetRequest');
        $req->setFields('num_iid,item_img');
        $req->setNumIids(implode(',', $iids));
        $resp = $tb_top->execute($req);
        $resp_items = (array) $resp->items;
        $resp_item_list = $resp_items['item'];
        foreach ($resp_item_list as $val) {
            $imgs = array();
            $val = (array) $val;
            $item_imgs = (array) $val['item_imgs'];
            $item_imgs = (array) $item_imgs['item_img'];
            foreach ($item_imgs as $_img) {
                $_img = (array) $_img;
                if ($_img['url']) {
                    $imgs[] = array(
                        'url' => $_img['url'],
                        'surl' => $_img['url'] . '_100x100.jpg',
                        'ordid' => $_img['position']
                    );
                }
            }
            $taobaoke_item_list[$val['num_iid']]['imgs'] = $imgs;
        }
        return array(
            'count' => intval($count),
            'item_list' => $taobaoke_item_list,
        );
    }
    private function _get_tbcats($cid = 0) {
        $tb_top = $this->_get_tb_top();
        $req = $tb_top->load_api('ItemcatsGetRequest');
        $req->setFields("cid,parent_cid,name,is_parent");
        $req->setParentCid($cid);
        $resp = $tb_top->execute($req);
        $res_cats = (array) $resp->item_cats;
        $item_cate = array();
        foreach ($res_cats['item_cat'] as $val) {
            $val = (array) $val;
            $item_cate[] = $val;
        }
        return $item_cate;
    }
    private function _get_tb_top() {
        vendor('Taobaotop.TopClient');
        vendor('Taobaotop.RequestCheckUtil');
        vendor('Taobaotop.Logger');
        $tb_top = new TopClient;
        $tb_top->appkey = $this->_tbconfig['app_key'];
        $tb_top->secretKey = $this->_tbconfig['app_secret'];
        return $tb_top;
    }
}