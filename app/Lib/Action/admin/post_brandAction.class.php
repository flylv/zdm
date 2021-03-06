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
class post_brandAction extends backendAction {

    var $list_relation = true;

    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('post_brand');
        $this->_cate_mod = D('post_cate');
        $this->assign('img_dir', './data/upload/post/');
        $this->py = new cls_pinyin();
    }

    public function _before_index() {
//        $res = D("mall")->field('id,title')->select();
//        $mall_list = array();
//        foreach ($res as $val) {
//            $mall_list[$val['id']] = $val['title'];
//        }
//        $this->assign('mall_list', $mall_list);
//        $this->sort = 'id';
//        $this->order = 'desc';
    }

    protected function _search() {
        $map = array();
        $collect_flag = $this->_request('collect_flag', 'intval', 1);
        $map['collect_flag'] = $collect_flag;
        $status = $this->_request('status');
        if ($status != null) {
            $map['status'] = $status;
        }
        ($keywordfr = $this->_request('keywordfr', 'trim')) && $map['name_fr'] = array('like', '%' . $keywordfr . '%' );
        ($keywordcn = $this->_request('keywordcn', 'trim')) && $map['name_cn'] = array('like', '%' . $keywordcn . '%' );
        $this->assign('search', array(
            'status' => $status,
            'keywordfr' => $keywordfr,
            'keywordcn' => $keywordcn,
            'collect_flag' => $collect_flag,
        ));

        return $map;
    }

    protected function _get_cate_tree($list, $checked_ids = array()) {
        $html = "";
        foreach ($list as $key => $val) {
            $margin_left = $val['depth'] * 20;
            $html .= "<div style='margin-left:" . $margin_left . "px;'>
                <input type='checkbox'";
            if (in_array($val['id'], $checked_ids)) {
                $html .= " checked='checked' ";
            }
            $html .= " name='cate_id[]' value='$val[id]'/>&nbsp;&nbsp;$val[name]</div>";
            $html .= $this->_get_cate_tree($val['child'], $checked_ids);
        }
        return $html;
    }

    public function _before_add($info = array()) {
        $where = "`id`='{$_GET['id']}'";
        $fields = "cover_image_name,create_time,description,last_update_time,logo_image_name,name_cn,name_fr,num_version,status,info_template_id,description";
        $this->assign('info', $info);
        $cate_tree = $this->_get_cate_tree(get_cate_tree(D("post_cate")));
        $this->assign('cate_tree', $cate_tree);
    }

    protected function _before_insert($data) {
//         $mod = D("post_brand");  
//        $datatest = array("cover_image_name"=>"mytry","logo_image_name" => "","name_cn"=>  "", "name_fr"=>  "", "num_version"=>  "", "status"=>  "0", "description"=>  "","id"=>  "" ); 
//         var_dump( $mod->add($datatest));exit;
       if (!empty($_FILES['cover_image_name']['name'])) {
           $art_add_time = date('ym/d');
           $result = $this->_upload($_FILES['cover_image_name'], 'post/' . $art_add_time);
           if ($result['error']) {
               $this->error($result['info']);
           } else {
               $data['cover_image_name'] = $art_add_time . '/' . $result['info'][0]['savename'];
           }
       } else {
           $data['cover_image_name'] = $this->_post('cover_image_name', 'trim');
       }

       if (!empty($_FILES['logo_image_name']['name'])) {
           $art_add_time = date('ym/d');
           $result = $this->_upload($_FILES['logo_image_name'], 'post/' . $art_add_time);
           if ($result['error']) {
               $this->error($result['info']);
           } else {
               $data['logo_image_name'] = $art_add_time . '/' . $result['info'][0]['savename'];
           }
       } else {
           $data['logo_image_name'] = $this->_post('logo_image_name', 'trim');
       }

       $data['last_update_time'] = date("Y-m-d H:i:s");

       return $data;
    }

    protected function _after_insert($id) {
//        $cids = $_REQUEST['cate_id'];
//        var_dump($cids);exit;
//        foreach ($cids as $key => $val) {
//            D("post_cate_re")->add(array(
//                'post_id' => $id,
//                'cate_id' => $val,
//            ));
//        }
//        $where = array('post_id' => $id);
//        $tags = $this->update_tag(D("post_tag"), $where, $data['title']);
//        D("post_tag")->where($where)->delete();
//        foreach ($tags as $key => $val) {
//            D("post_tag")->add(array(
//                'post_id' => $id,
//                'tag_id' => $key,
//            ));
//        }
    }

    public function _after_edit($data) {
//        $where = array('post_id' => $data['id']);
//        $ids = array();
//        $list = D("post_cate_re")->where($where)->select();
//        foreach ($list as $key => $val) {
//            $ids[] = $val['cate_id'];
//        }
//        $cate_tree = $this->_get_cate_tree(get_cate_tree(D("post_cate")), $ids);
//        $this->assign('cate_tree', $cate_tree);
//        $this->assign("mall_title", D("mall")->where(array('id' => $data['mall_id']))->getField("title"));
//        $tag_list = D("post_tag")->relation(true)->where($where)->select();
//        foreach ($tag_list as $key => $val) {
//            $tags .= " " . $val['tag']['name'] . " ";
//        }
//        $this->assign("tags", $tags);
    }

    protected function _before_update($data) {
       if (!empty($_FILES['cover_image_name']['name'])) {
           $art_add_time = date('ym/d');
           $result = $this->_upload($_FILES['cover_image_name'], 'post/' . $art_add_time);
           if ($result['error']) {
               $this->error($result['info']);
           } else {
               $data['cover_image_name'] = $art_add_time . '/' . $result['info'][0]['savename'];
           }
       } else {
           $data['cover_image_name'] = $this->_post('cover_image_name', 'trim');
       }

       if (!empty($_FILES['logo_image_name']['name'])) {
           $art_add_time = date('ym/d');
           $result = $this->_upload($_FILES['logo_image_name'], 'post/' . $art_add_time);
           if ($result['error']) {
               $this->error($result['info']);
           } else {
               $data['logo_image_name'] = $art_add_time . '/' . $result['info'][0]['savename'];
           }
       } else {
           $data['logo_image_name'] = $this->_post('logo_image_name', 'trim');
       }

       $data['last_update_time'] = date("Y-m-d H:i:s");

       return $data;
    }

    private function _get_imgdir() {
        static $dir = null;
        if ($dir === null) {
            $dir = './data/upload/post/';
        }
        return $dir;
    }

    public function ajax_mall_list() {
        $index = $this->_post('index', 'trim');
        $res = D("mall")->where(array('index' => $index))->select();
        $data = "";
        foreach ($res as $key => $val) {
            $data .= "<option value='$val[id]'>$val[title]</option>";
        }
        $this->ajaxReturn(1, '', $data);
    }

    public function ajax_post_key() {
        echo $this->py->tourl($this->_post('title'));
    }

    function get_post_key($title) {
        $data['post_key'] = $this->py->tourl($title);
        if ($this->_mod->where(array('post_key' => trim($data['post_key'])))->count() > 0) {
            $data['post_key'] .= '_' . time();
        }
        return $data['post_key'];
    }

    function _before_batch_edit_update($data) {
        if (!empty($_REQUEST['cate_id'])) {
            $ids = explode(',', $this->_request('id', 'trim'));
            foreach ($ids as $post_id) {
                $post_id = intval($post_id);
                D('post_cate_re')->where("post_id=$post_id")->delete();
                foreach ($_REQUEST['cate_id'] as $val) {
                    D('post_cate_re')->add(array(
                        'post_id' => $post_id,
                        'cate_id' => $val
                    ));
                }
            }
        }
        $data['post_time'] > 0 && $data['post_time'] = strtotime($data['post_time']);
        $data = D('post')->parse_data($data);
        return $data;
    }

    function collect() {
        $this->assign('list_table', true);
        $act = $this->_request("act", 'trim', 'search');
        if ($act == 'search') {
            $p = $this->_request('p', 'intval', 1);
            $params = array_merge($_REQUEST, array('a' => MODULE_NAME));
            $res = json_decode($this->api_collect($params));
            $data = unserialize($res->data);
            foreach ($data['items'] as $key => $val) {
                $data['items'][$key]['is_collect'] = D(MODULE_NAME)->where(array('key_id' => $val['id']))->count() > 0;
            }
            $this->assign('list', $data['items']);
            $pager = new Page($data['total'], $data['page_size']);
            $this->assign('page', $pager->show());
            $this->assign('p', $p);
            $this->assign('api_params', urlencode(serialize($params)));
        } elseif ($act == 'add') {
            $data = D('post_brand')->create();
            unset($data['id']);
            $ids = explode(',', $this->_request('id', 'trim'));
            $res = json_decode($this->api_collect(unserialize(urldecode($this->_request('api_params')))));
            $resdata = unserialize($res->data);
            $collect_ids = array();
            foreach ($resdata['items'] as $key => $val) {
                if (in_array($val['id'], $ids)) {
                    $data['create_time'] = time();
                    $data['img'] = trim($val['img']);
                    $data = D('post_brand')->parse_data($data);
                    D('post_brand')->add($data);
                    $post_id = D('post_brand')->getLastInsID();
                    if (!empty($post_id)) {
                        $collect_ids[] = $val['id'];
                    }
                    if (!empty($_REQUEST['cate_id'])) {
                        foreach ($_REQUEST['cate_id'] as $val) {
                            D('post_cate_re')->add(array(
                                'post_id' => $post_id,
                                'cate_id' => $val
                            ));
                        }
                    }
                }
            }
            $this->api_collect(array('id' => implode(',', $collect_ids), 'a' => 'collect_log', 'type' => MODULE_NAME . '_log', 'return' => false));
            $this->ajaxReturn(1, L('operation_success'));
        }
        $this->display();
    }

    protected function _after_tb_collect($info) {
        $info['prices'] = $info['price'];
        $this->_before_add($info);
        $this->display('add');
    }

    protected function get_mall_id($url) {
        $urlinfo = parse_url($url);
        $host = $this->top_domain($urlinfo['host']);
        $mall_id = intval(D('mall')->where("domain like '%$host%'")->getField('id'));
        return $mall_id;
    }

}
