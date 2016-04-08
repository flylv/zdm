<?php 
/**
* ====================================================================
* Author: brivio <brivio@qq.com>
* 授权技术支持: 1142503300@qq.com
*/
class jky_itemAction extends backendAction {
    var $list_relation = true;
    var $_cate_re_mod;
    var $_cate_mod;
    public function _initialize() {
        parent::_initialize();
        $this->_cate_mod = D('jky_cate');
        $this->_cate_re_mod=D('jky_cate_re');
        $this->assign('img_dir', './data/upload/jky_item/');
        $this->py = new cls_pinyin();
        $res = D("jky_orig")->select();
        foreach ($res as $key => $val) {
            $orig_list[$val['id']] = $val['name'];
        }
        $this->assign("orig_list", $orig_list);
    }
    public function _before_index() {
        $res = D("mall")->field('id,title')->select();
        $mall_list = array();
        foreach ($res as $val) {
            $mall_list[$val['id']] = $val['title'];
        }
        $this->assign('mall_list', $mall_list);
        $this->sort = 'id';
        $this->order = 'desc';
        $list = array();
        $res = D("jky_cate")->field("id,name")->where("pid=1 and status=1")->select();
        foreach ($res as $key => $val) {
            $list[$val['id']] = $val['name'];
        }
        $this->assign('type_list', $list);
        $list = array();
        $res = D("jky_cate")->field("id,name")->where("pid=2 and status=1")->select();
        foreach ($res as $key => $val) {
            $list[$val['id']] = $val['name'];
        }
        $this->assign('cate_list', $list);
    }
    protected function _search() {
        $where= "1 ";
        ($time_start = $this->_request('time_start', 'trim')) && $where .= " and stime>=" . strtotime($time_start);
        ($time_end = $this->_request('time_end', 'trim')) && $where .= " and etime<=" . strtotime($time_end) + (24 * 60 * 60 - 1);
        ($keyword = $this->_request('keyword', 'trim')) && $where .= " and title like '%$keyword%'";
        $mall_id = $this->_request('mall_id', 'intval');
        if ($mall_id > 0) {
            $where .= " and mall_id=$mall_id";
        }
        $cate_id = $_REQUEST['cate_id'];
        for ($i = 0; $i < 2; $i++) {
            $cid = intval($cate_id[$i]);
            if ($cid > 0) {
                $where .= " and (select count(c.item_id) from " . table("jky_cate_re") . " as c where c.item_id=id and c.cate_id=$cid)>0 ";
            }
        }
        if($min_price=$this->_request('min_price','trim')){
            $where.=" and price>=$min_price ";
        }
        if($max_price=$this->_request('max_price','trim')){
            $where.=" and price<=$max_price ";
        }
        $yet_cate=$this->_get('yet_cate','intval',-1);
        if(in_array($yet_cate,array(0,1))){
            $where.=" and (select count(c.item_id) from ".table("jky_cate_re")." as c where c.item_id=id)";
            if($yet_cate==0){
                $where.="=0 ";            
            }elseif($yet_cate==1){
                $where.=">0 ";
            }
        }
        $where.=yesno_where('collect_flag');
        $where.=yesno_where('is_recommend');
        $where.=yesno_where('is_hot');
        $where.=yesno_where('status');
        $this->assign('search', array(
            'time_start' => $time_start,
            'time_end' => $time_end,
            'cate_id[0]' => $cate_id[0],
            'cate_id[1]' => $cate_id[1],
            'selected_ids' => $selected_ids,
            'status' => $status,
            'keyword' => $keyword,
            'mall_id' => $mall_id
        ));
        return $where;
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
    public function _before_add($info=array()) {
        $where = "`id`='{$_GET['id']}'";
        $fields = "title,img as zs_images,info as info,mprice,price,url";
        if($zs_info=D('zhaoshang_item')->where($where)->field($fields)->find()){
            $info =array_merge($info,$zs_info);
        }
        $this->assign('info', $info);
        $cate_tree = $this->_get_cate_tree(get_cate_tree($this->_cate_mod));
        $this->assign('cate_tree', $cate_tree);
        $ico_table = D('jky_icon_type');
        $ico_tree = $ico_table->where("`status`=1")->field("`title`,`id`")->select();
        $this->assign('ico_tree', $ico_tree);
    }
    protected function _before_insert($data) {
        if (!empty($_FILES['img']['name'])) {
            $art_add_time = date('ym/d');
            $result = $this->_upload($_FILES['img'], 'jky_item/' . $art_add_time);
            if ($result['error']) {
                $this->error($result['info']);
            } else {
                $data['img'] = $art_add_time . '/' . $result['info'][0]['savename'];
            }
        } else{
    		$data['img']=$this->_post('img_url','trim');
    	}
	   if (!empty($_POST['zs_images'])) {
            $upload_path = C('pin_attach_path');
            $savePath = explode("/", $_POST['zs_images']);
            foreach ($savePath as $k => $value) {
                if ($k == 2) {
                    break; 
                }
                $value2 .= $value . "/";
                $savePath2 = $upload_path . 'jky_item/' . $value2;
                if (!is_dir($savePath2)) {
                    @mkdir($savePath2, 0777);
                    @chmod($savePath2, 0777);
                }
            }
            @copy($upload_path . 'zhaoshang/' . $_POST['zs_images'], $upload_path . 'jky_item/' . $_POST['zs_images']);
            $data['img'] = $_POST['zs_images'];
        }
        if (empty($data['post_key'])) {
            $data['post_key'] = $this->py->tourl($data['title']);
        }
        if (D("post")->where(array('post_key' => trim($data['post_key'])))->count() > 0) {
            $data['post_key'] .= '_' . time();
        }
        $data['post_key'] = str_replace($this->spec_chars, '', $data['post_key']);
        $data['stime'] = strtotime($_REQUEST['stime']);
        $data['etime'] = strtotime($_REQUEST['etime']);
        $data['add_time'] = time();
        return $data;
    }
    protected function _after_insert($id) {
        $cids = $_REQUEST['cate_id'];
        foreach ($cids as $key => $val) {
            D("jky_cate_re")->add(array(
                'item_id' => $id,
                'cate_id' => $val,
            ));
        }
        $get_type_id = $this->_post('type_id');
        $add_ico = D('jky_icon');
        foreach ($get_type_id as $val) {
            $add_arr = array('item_id' => $id, 'type_id' => $val);
            $add_ico->add($add_arr);
        }
    }
    public function _before_edit() {
        $id = $this->_get('id', 'intval', 0);
        $where = array('item_id' => $id);
        $ids = array();
        $list = D("jky_cate_re")->where($where)->select();
        foreach ($list as $key => $val) {
            $ids[] = $val['cate_id'];
        }
        $cate_tree = $this->_get_cate_tree(get_cate_tree($this->_cate_mod), $ids);
        $this->assign('cate_tree', $cate_tree);
        $ico_table = D('jky_icon_type');
        $ico_tree = $ico_table->where("`status`=1")->field("`title`,`id`")->select();
        foreach ($ico_tree as $key => $val) {
            $ico_tree[$key]['flag'] = D('jky_icon')->where("item_id=$id and type_id=$val[id]")->count() > 0;
        }
        $this->assign('ico_tree', $ico_tree);
    }
    public function _after_edit($data) {
        $this->assign('orig_name',D('jky_orig')->where(array('id'=>$data['orig_id']))->getField('name'));
    }
    protected function _before_update($data) {
        D("jky_cate_re")->where(array('item_id' => $data['id']))->delete();
        $cids = $_REQUEST['cate_id'];
        foreach ($cids as $key => $val) {
            D("jky_cate_re")->add(array(
                'item_id' => $data['id'],
                'cate_id' => $val,
            ));
        }
        if (!empty($_FILES['img']['name'])) {
            $art_add_time = date('ym/d');
            $old_img = $this->_mod->where(array('id' => $data['id']))->getField('img');
            $old_img = $this->_get_imgdir() . $old_img;
            is_file($old_img) && @unlink($old_img);
            $result = $this->_upload($_FILES['img'], 'jky_item/' . $art_add_time);
            if ($result['error']) {
                $this->error($result['info']);
            } else {
                $data['img'] = $art_add_time . '/' . $result['info'][0]['savename'];
            }
        }else{
            $data['img']=$this->_post('img_url','trim');
        }
        $data['post_key'] =$this->get_post_key($data['title']);
        $data['stime'] = strtotime($_REQUEST['stime']);
        $data['etime'] = strtotime($_REQUEST['etime']);
        D('jky_icon')->where("item_id=$data[id]")->delete();
        $get_type_id = $this->_post('type_id');
        foreach ($get_type_id as $val) {
            $add_arr = array('item_id' => $data['id'], 'type_id' => $val);
            D('jky_icon')->add($add_arr);
        }
        return $data;
    }
    private function _get_imgdir() {
        static $dir = null;
        if ($dir === null) {
            $dir = './data/upload/jky_item/';
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
    function  _before_batch_edit() {
        $cate_tree = $this->_get_cate_tree(get_cate_tree($this->_cate_mod));
        $this->assign('cate_tree', $cate_tree);
        $this->assign('uname', $_SESSION['admin']['username']);
    }
    function _before_batch_edit_update($data) {
        if(!empty($_REQUEST['cate_id'])){
            $ids = explode(',', $this->_request('id', 'trim'));
            foreach ($ids as $id) {
                $id = intval($id);
                D('jky_cate_re')->where("item_id=$id")->delete();
                foreach ($_REQUEST['cate_id'] as $val) {
                    D('jky_cate_re')->add(array(
                        'item_id' => $id,
                        'cate_id' => $val
                    ));
                }
            }    
        }        
        !empty($data['stime'])&&$data['stime'] = strtotime($data['stime']);
        !empty($data['etime'])&&$data['etime'] = strtotime($data['etime']);
        $data=$this->_mod->parse_data($data);
        return $data;
    }
    function collect() {
        $this->assign('list_table', true);
        $act = $this->_request("act", 'trim','search');
        if ($act == 'search') {
            $p = $this->_request('p', 'intval', 1);
            $params=array_merge($_REQUEST,array('a' => MODULE_NAME));
            $res = json_decode($this->api_collect($params));
            $data = unserialize($res->data);
            foreach ($data['items'] as $key => $val) {
                $data['items'][$key]['is_collect'] = D(MODULE_NAME)->where(array('key_id' =>$val['keys']))->count() > 0;
            }
            $this->assign('list', $data['items']);
            $pager = new Page($data['total'], $data['page_size']);
            $this->assign('page', $pager->show());
            $this->assign('p', $p);
            $this->assign('api_params', urlencode(serialize($params)));
        } elseif ($act == 'batch_collect_form') {
            $this->_before_batch_edit();
            $this->ajaxReturn(1, '', $this->fetch("batch_collect_form"));
        } elseif ($act == 'add') {
            $item=D('jky_item')->create();
            unset($item['id']);
            $ids = explode(',', $this->_request('id', 'trim'));
            $res = json_decode($this->api_collect(unserialize(urldecode($this->_request('api_params')))));
            $data = unserialize($res->data);
            $collect_ids=array();
            foreach ($data['items'] as $key => $val) {
                if (in_array($val['keys'], $ids)) {
                    if (D(MODULE_NAME)->where(array('key_id' => $val['keys']))->count() > 0) continue;
                    $item['title'] = $item['seo_title'] = trim($val['title']);
                    $item['price'] = round(floatval($val['price']), 2);
                    $mprice = round(floatval($val['mprice']), 2);
                    $tprice = round(floatval($val['tprice']), 2);
                    $item['mprice'] = $mprice > $tprice ? $mprice : $tprice;
                    $item['key_id'] = $val['keys'];
                    $item['img'] =trim($val['img']);
                    $item['url'] =trim($val['url']);
                    $item['add_time'] = time();
                    $item['collect_flag'] =intval($item['collect_flag']);
                    $item['post_key']=$this->get_post_key($item['title']);
                    $item['orig_id']=$this->_request('orig_id','intval',0);
                    if(!empty($item['stime'])){
                        $item['stime'] = strtotime($this->_request('stime', 'trim', 0));
                    } 
                    if(!empty($item['etime'])){
                        $item['etime'] = strtotime($this->_request('etime', 'trim', 0));
                    }
                    $item=$this->_mod->parse_data($item);
                    D(MODULE_NAME)->add($item);
                    $item_id = D(MODULE_NAME)->getLastInsID();
                    if(!empty($item_id)){
                        $collect_ids[]=$val['id'];
                    }
                    if(!empty($_REQUEST['cate_id'])){
                        foreach ($_REQUEST['cate_id'] as $val) {
                            if (empty($val)) continue;
                            D('jky_cate_re')->add(array(
                                'item_id' => $item_id,
                                'cate_id' => $val
                            ));
                        }
                    }    
                }
            }
            $this->api_collect(array('id'=>implode(',',$collect_ids),'a'=>'collect_log','type'=>MODULE_NAME.'_log','return'=>false));
            $this->ajaxReturn(1, L('operation_success'));
        }
        $this->display();
    }
    function get_post_key($title){
        $data['post_key']=$this->py->tourl($title);
        if ($this->_mod->where(array('post_key' => trim($data['post_key'])))->count() > 0) {
            $data['post_key'] .= '_' . time();
        }
        return $data['post_key'];
    }
    function auto_cate(){
        if(IS_POST){
            $where="status=".$this->_post('status','intval',1);
            ($start_time=$this->_post('start_time','strtotime',0))>0&&$where.=" and stime>=$start_time ";                
            ($end_time=$this->_post('end_time','strtotime',0))>0&&$where.=" and etime<=$end_time ";
            $cate_list=$this->_cate_mod->select();
            $tags=array();
            foreach($cate_list as $val){                
                $tags[$val['id']]=explode(',',$val['tags']);
            }         
            $start=0;
            $offset=1000;
            $total=D('jky_item')->where($where)->count();
            while($start<$total){
                $res=$this->_mod->where($where)->limit($start.",".$offset)->select();
                $start+=count($res);
                foreach($res as $key=>$val){
                    $cate_ids=array();
                    foreach($tags as $k=>$tag){
                        foreach($tag as $t){
                            if(empty($t))continue;
                            if(strpos($val['title'],$t)!==false){
                                if(!$this->_cate_re_mod->where(array('cate_id'=>$k,'item_id'=>$val['id']))->find()){
                                    $this->_cate_re_mod->add(array('item_id'=>$val['id'],'cate_id'=>$k));
                                    continue;
                                }
                            }    
                        }                                            
                    }        
                }
            }                              
            $this->success(L('operation_success'));             
        }else{
            $this->display();    
        }    
    }
    function auto_price_cate(){
        if(IS_POST){
            $where="status=".$this->_post('status','intval',1);
            ($start_time=$this->_post('start_time','strtotime',0))>0&&$where.=" and stime>=$start_time ";                
            ($end_time=$this->_post('end_time','strtotime',0))>0&&$where.=" and etime<=$end_time ";
            ($min_price=$this->_post('min_price','floatval',0))>0&&$where.=" and price>=$min_price";
            ($max_price=$this->_post('max_price','floatval',0))>0&&$where.=" and price<=$max_price";
            $cate_ids=$this->_post('cate_id','trim');    
            $start=0;
            $offset=1000;
            $total=$this->_mod->where($where)->count();
            while($start<$total){
                $res=$this->_mod->where($where)->limit($start.",".$offset)->select();
                $start+=count($res);
                foreach($res as $key=>$val){
                    foreach($cate_ids as $v){
                        if(!$this->_cate_re_mod->where(array('cate_id'=>$v,'item_id'=>$val['id']))->find()){
                            $this->_cate_re_mod->add(array(
                                'item_id'=>$val['id'],
                                'cate_id'=>$v
                            )); 
                        }  
                    }
                }
            }  
            $this->success(L('operation_success'));                                                
        }else{
            $cate_tree = $this->_get_cate_tree(get_cate_tree($this->_cate_mod));
            $this->assign('cate_tree', $cate_tree);
            $this->display();            
        }
    }
    protected function _after_tb_collect($info){
        $this->_before_add($info);
        $this->display('add');
    }
    function get_orig_id($url){
        $urlinfo=parse_url($url);
        $host=$this->top_domain($urlinfo['host']);
        return intval(D('jky_orig')->where("url like '%$host%'")->getField('id'));     
    }    
}