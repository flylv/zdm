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
class cmt_taobaoAction extends backendAction
{
    public function index() {
        $auto_user = D('auto_user')->select();
        $this->assign('auto_user', $auto_user);
    	$this->display();
    }
    public function setting() {
        $cate_id = $this->_post('cate_id', 'intval'); 
        $priority = $this->_post('priority', 'trim'); 
        $pagesize = $this->_post('pagesize', 'intval'); 
        $cmt_num = $this->_post('cmt_num', 'intval'); 
        $auid = $this->_post('auid', 'intval'); 
        $rate_type = $this->_post('rate_type', 'intval'); 
        $sort_type = $this->_post('sort_type', 'trim'); 
        !$cate_id && $this->ajaxReturn(0, L('please_select').L('item_cate'));
        !$auid && $this->ajaxReturn(0, L('please_select').L('auto_user'));
        $auto_user_mod = D('auto_user');
        $user_mod = D('user');
        $unames = $auto_user_mod->where(array('id'=>$auid))->getField('users');
        $unamea = explode(',', $unames);
        $users = $user_mod->field('id,username')->where(array('username'=>array('in', $unamea)))->select();
        !$users && $this->ajaxReturn(0, L('auto_user_error'));
        $map = array(
            'status' => 1,
            'key_id' => array('like', 'taobao_%'),
        );
        $id_arr = D('item_cate')->get_child_ids($cate_id, true);
        $map['cate_id'] = array('IN', $id_arr);
        $count = D('item')->where($map)->count('id'); 
        $page_total = ceil($count/$pagesize); 
        F('cmt_taobao_setting', array(
            'cate_id' => $cate_id,
            'map' => $map,
            'order' => $priority.' DESC',
            'users' => $users,
            'count' => $count,
            'pagesize' => $pagesize,
            'page_total' => $page_total,
            'cmt_num' => $cmt_num,
            'rate_type' => $rate_type,
            'sort_type' => $sort_type,
        ));
        $this->assign('page_total', $page_total);
        $this->assign('count', $count);
        $this->assign('p', 0);
        $resp = $this->fetch('collect');
        $this->ajaxReturn(1, '评论采集', $resp); 
    }
    public function collect() {
        if (false === $setting = F('cmt_taobao_setting')) {
            $this->ajaxReturn(0, L('illegal_parameters'));
        }
        $p = $this->_get('p', 'intval', 1);
        $start = ($p - 1) * $setting['pagesize'];
        $item_mod = D('item');
        $item_list = $item_mod->field('id,key_id')->where($setting['map'])->order($setting['order'])->limit($start.','.$setting['pagesize'])->select();
        foreach ($item_list as $val) {
            $iid = array_pop(explode('_', $val['key_id']));
            $this->_collect_one($iid, $val['id'], $setting['cmt_num'], $setting['users']);
            $item_mod->where(array('id'=>$val['id']))->save(array('cmt_taobao_time'=>time()));
        }
        $p >= $setting['page_total'] && $this->ajaxReturn(2, '采集完成！'); 
        $this->assign('page_total', $setting['page_total']);
        $this->assign('count', $setting['count']);
        $this->assign('p', $p);
        $resp = $this->fetch('collect');
        $this->ajaxReturn(1, '', $resp);
    }
    private function _collect_one($iid, $item_id, $cmt_num, $users) {
        $seller = $this->_get_seller_id($iid);
        if (!$seller['id']) return false;
        $item_mod = D('item');
        $item_comment_mod = D('item_comment');
        if ($seller['type'] == 'tmall') {
            $rate_tmall_api = 'http://rate.tmall.com/list_detail_rate.htm?itemId='.$iid.'&spuId=&sellerId='.$seller_id.'&order=0&forShop=1&append=0&currentPage=1';
            $source = Http::fsockopenDownload($rate_tmall_api);
            $source = rtrim(ltrim(trim($source), '('), ')');
            $source = iconv('GBK', 'UTF-8//IGNORE', $source);
            $source = str_replace('"rateDetail":', '', $source);
            $rate_resp = json_decode($source, true);
            $rate_list = $rate_resp['rateList'];
            for ($i = 0; $i < $cmt_num; $i++) {
                $user_rand = array_rand($users);
                $time = strtotime($rate_list[$i]['rateDate']);
                $cmt_taobao_time = $item_mod->where(array('id'=>$item['id']))->getField('cmt_taobao_time');
                if ($time <= $cmt_taobao_time) {
                    return false;
                }
                $item_comment_mod->add(array(
                    'item_id' => $item_id,
                    'uid' => $users[$user_rand]['id'],
                    'uname' => $users[$user_rand]['username'],
                    'info' => $rate_list[$i]['rateContent'],
                    'add_time' => $time,
                ));
            }
        } else {
            $rate_taobao_api = 'http://rate.taobao.com/feedRateList.htm?userNumId='.$seller['id'].'&auctionNumId='.$iid.'&currentPageNum=1';
            $source = Http::fsockopenDownload($rate_taobao_api);
            $source = rtrim(ltrim(trim($source), '('), ')');
            $source = iconv('GBK', 'UTF-8//IGNORE', $source);
            $rate_resp = json_decode($source, true);
            $rate_list = $rate_resp['comments'];
            for ($i = 0; $i < $cmt_num; $i++) {
                $user_rand = array_rand($users);
                $date = explode('.', $rate_list[$i]['date']);
                $time = mktime(0,0,0,$date[1],$date[2],$date[0]);
                $cmt_taobao_time = $item_mod->where(array('id'=>$item['id']))->getField('cmt_taobao_time');
                if ($time <= $cmt_taobao_time) {
                    return false;
                }
                $item_comment_mod->add(array(
                    'item_id' => $item_id,
                    'uid' => $users[$user_rand]['id'],
                    'uname' => $users[$user_rand]['username'],
                    'info' => $rate_list[$i]['content'],
                    'add_time' => $time,
                ));
            }
        }
    }
    private function _get_seller_id($iid) {
        $result = array('type'=>'taobao', 'id'=>0);
        $page_content = Http::fsockopenDownload('http://item.taobao.com/item.htm?id='.$iid);
        if (!$page_content) {
            $page_content = file_get_contents('http://detail.tmall.com/item.htm?id='.$iid);
            $result['type'] = 'tmall';
        }
        preg_match('|; userid=(\d+);">|', $page_content, $out);
        $result['id'] = $out[1];
        return $result;
    }
}