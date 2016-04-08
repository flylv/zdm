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
class taobao_itemcollect {
    private $_code = 'taobao';
    public function fetch($url) {
        $id = $this->get_id($url);
        if (!$id) {
            return false;
        }
        $key = 'tb_' . $id;
        $item_site = D('item_site')->where(array('code' => $this->_code))->find();
        $api_config = unserialize($item_site['config']);
        vendor('Taobaotop.TopClient');
        vendor('Taobaotop.RequestCheckUtil');
        vendor('Taobaotop.Logger');
        $tb_top = new TopClient;
        $tb_top->appkey = $api_config['app_key'];
        $tb_top->secretKey = $api_config['app_secret'];
        $req = $tb_top->load_api('ItemGetRequest');
        $req->setFields('detail_url,title,nick,pic_url,price,item_img');
        $req->setNumIid($id);
        $resp = $tb_top->execute($req);
        if (!isset($resp->item)) {
            return false;
        }
        $item = (array) $resp->item;
        $result = array();
        $result['item']['key_id'] = $key;
        $result['item']['title'] = strip_tags($item['title']);
        $result['item']['price'] = $item['price'];
        $result['item']['img'] = $item['pic_url'];
        $result['item']['url'] = $item['detail_url'];
        $result['item']['imgs'] = array();
        $item_imgs = (array) $item['item_imgs'];
        $item_imgs = (array) $item_imgs['item_img'];
        foreach ($item_imgs as $_img) {
            $_img = (array) $_img;
            if ($_img['url']) {
                $result['item']['imgs'][] = array(
                    'url' => $_img['url'],
                    'ordid' => $_img['position']
                );
            }
        }
        if (empty($result['item']['imgs'])) {
            $result['item']['imgs'][] = array(
                'url' => $result['item']['img'],
            );
        }
        $req = $tb_top->load_api('TaobaokeItemsDetailGetRequest');
        $req->setFields("click_url");
        $req->setNumIids($id);
        $resp = $tb_top->execute($req);
        if (isset($resp->taobaoke_item_details)) {
            $taoke = (array) $resp->taobaoke_item_details->taobaoke_item_detail;
            if ($taoke['click_url']) {
                $result['item']['url'] = $taoke['click_url'];
            }
        }
        $result['item']['url'] = Url::replace($result['item']['url'], array('spm' => '2014.21069764.' . $api_config['app_key'] . '.0'));
        return $result;
    }
    public function get_id($url) {
        $id = 0;
        $parse = parse_url($url);
        if (isset($parse['query'])) {
            parse_str($parse['query'], $params);
            if (isset($params['id'])) {
                $id = $params['id'];
            } elseif (isset($params['item_id'])) {
                $id = $params['item_id'];
            } elseif (isset($params['default_item_id'])) {
                $id = $params['default_item_id'];
            }
        }
        return $id;
    }
    public function get_key($url) {
        $id = $this->get_id($url);
        return 'taobao_' . $id;
    }
}