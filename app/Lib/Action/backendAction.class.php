<?php 
/**
* ZhePHP 值得买模式的海淘网站程序
* ====================================================================
* ====================================================================
* Author: brivio <brivio@qq.com>
* 授权技术支持: 1142503300@qq.com
*/
class backendAction extends baseAction {
    protected $_name = '';
    protected $menuid = 0;
    protected $_mod;
    public function _initialize() {
        parent::_initialize();        
        $this->_name = $this->getActionName();
        try {
            $this->_mod = D($this->_name);
        } catch (Exception $e) {
        }
        $this->check_priv();
        $this->menuid = $this->_request('menuid', 'trim', 0);
        if ($this->menuid) {
            $sub_menu = D('menu')->sub_menu($this->menuid, false);            
            $selected = '';
            foreach ($sub_menu as $key => $val) {
                $sub_menu[$key]['class'] = '';
                if (MODULE_NAME == $val['module_name'] && ACTION_NAME == $val['action_name'] && strpos(__SELF__, $val['data'])) {
                    $sub_menu[$key]['class'] = $selected = 'on';
                }
            }
            if (empty($selected)) {
                foreach ($sub_menu as $key => $val) {
                    if (MODULE_NAME == $val['module_name'] && ACTION_NAME == $val['action_name']) {
                        $sub_menu[$key]['class'] = 'on';
                        break;
                    }
                }
            }
            $this->assign('sub_menu', $sub_menu);
        }
        $this->assign('menuid', $this->menuid);
    }
    public function index() {
        $map = $this->_search();
        $mod = D($this->_name);
        !empty($mod) && $this->_list($mod, $map);
        $this->display();
    }
    public function add() {
        $mod = D($this->_name);
        if (IS_POST) {
            if (false === $data = $mod->create()) {
                IS_AJAX && $this->ajaxReturn(0, $mod->getError());
                $this->error($mod->getError());
            }
            if (method_exists($this, '_before_insert')) {
                $data = $this->_before_insert($data);
            }
            if ($mod->add($data)) {
                if (method_exists($this, '_after_insert')) {
                    $id = $mod->getLastInsID();
                    $this->_after_insert($id);
                }
                IS_AJAX && $this->ajaxReturn(1, L('operation_success'), '', 'add');
                $this->success(L('operation_success'), U(MODULE_NAME . '/index'));
            } else {
                IS_AJAX && $this->ajaxReturn(0, L('operation_failure'));
                $this->error(L('operation_failure'));
            }
        } else {
            $this->assign('open_validator', true);
            if (IS_AJAX) {
                $response = $this->fetch();
                $this->ajaxReturn(1, '', $response);
            } else {
                $this->display();
            }
        }
    }
    public function edit() {
        $mod = D($this->_name);
        $pk = $mod->getPk();
        if (IS_POST) {
            if (false === $data = $mod->create()) {
                IS_AJAX && $this->ajaxReturn(0, $mod->getError());
                $this->error($mod->getError());
            }
            if (method_exists($this, '_before_update')) {
                $data = $this->_before_update($data);
            }
            if (false !== $mod->save($data)) {
                if (method_exists($this, '_after_update')) {
                    $id = $data['id'];
                    $this->_after_update($id);
                }
                IS_AJAX && $this->ajaxReturn(1, L('operation_success'), '', 'edit');
                $referrer=$this->_post('referrer','trim',U(MODULE_NAME . '/index'));
                $this->success(L('operation_success'),$referrer);
            } else {
                IS_AJAX && $this->ajaxReturn(0, L('operation_failure'));
                $this->error(L('operation_failure'));
            }
        } else {
            $id = $this->_get($pk, 'intval');
            $info = $mod->find($id);
            $this->assign('info', $info);
            $this->assign('open_validator', true);
            if (method_exists($this, '_after_edit')) {
                $this->_after_edit($info);
            }
            if (IS_AJAX) {
                $response = $this->fetch();
                $this->ajaxReturn(1, '', $response);
            } else {
                $this->display();
            }
        }
    }
    public function ajax_edit() {
        $mod = D($this->_name);
        $pk = $mod->getPk();
        $id = $this->_request($pk, 'intval');
        $field = $this->_request('field', 'trim');
        $val = $this->_request('val', 'trim');
        $mod->where(array($pk => $id))->setField($field, $val);
        $this->ajaxReturn(1);
    }
    public function delete() {
        $mod = D($this->_name);
        $pk = $mod->getPk();
        $ids = trim($this->_request($pk), ',');
        if ($ids) {
            if (method_exists($this, '_before_drop')) {
                $this->_before_drop(explode(',', $ids));
            }
            $this->_delete_attach($ids);
            if (false !== $mod->delete($ids)) {
                IS_AJAX && $this->ajaxReturn(1, L('operation_success'));
                $this->success(L('operation_success'));
            } else {
                IS_AJAX && $this->ajaxReturn(0, L('operation_failure'));
                $this->error(L('operation_failure'));
            }
        } else {
            IS_AJAX && $this->ajaxReturn(0, L('illegal_parameters'));
            $this->error(L('illegal_parameters'));
        }
    }
    private function _delete_attach($ids) {
        $rule = array(
        );
        $table_list = array(
            'ad', 'article', 'article_page', 'flink', 'jky_cate', 'jky_icon_type',
            'jky_item', 'jky_orig', 'mall', 'post', 'score_item', 'score_level',
        );
        if (empty($ids)) return;
        if (!in_array($this->_name, $table_list)) return;
        $res = $this->_mod->where("id in($ids)")->select();
        $dirname=$this->_name;
        if (!empty($rule[$this->_name]['dir'])) {
            $dirname=$rule[$this->_name]['dir'];
        }
        foreach ($res as $val) {
            if (empty($val)) continue;
            !empty($val['img']) && @unlink(C('pin_attach_path') .$dirname. '/' . $val['img']);
            !empty($val['extimg']) && @unlink(C('pin_attach_path') .$dirname. '/' . $val['extimg']);
            $editor_imgs = array();
            if (!empty($val['info'])) {
                $editor_imgs = array_merge($editor_imgs, parse_editor_img($val['info']));
            }
            if (!empty($val['intro'])) {
                $editor_imgs = array_merge($editor_imgs, parse_editor_img($val['intro']));
            }
            foreach ($editor_imgs as $img_src) {
                if (is_url($img_src)) continue;
                @unlink(substr($img_src, strpos($img_src, C('pin_attach_path'))));
            }
        }
    }
    protected function _search() {
        $mod = D($this->_name);
        $map = array();
        foreach ($mod->getDbFields() as $key => $val) {
            if (substr($key, 0, 1) == '_') {
                continue;
            }
            if ($this->_request($val)) {
                $map[$val] = $this->_request($val);
            }
        }
        return $map;
    }
    protected function _list($model, $map = array(), $sort_by = '', $order_by = '', $field_list = '*', $pagesize = 20) {
        $mod_pk = $model->getPk();
        if ($this->_request("sort", 'trim')) {
            $sort = $this->_request("sort", 'trim');
        } else if (!empty($sort_by)) {
            $sort = $sort_by;
        } else if ($this->sort) {
            $sort = $this->sort;
        } else {
            $sort = $mod_pk;
        }
        if ($this->_request("order", 'trim')) {
            $order = $this->_request("order", 'trim');
        } else if (!empty($order_by)) {
            $order = $order_by;
        } else if ($this->order) {
            $order = $this->order;
        } else {
            $order = 'DESC';
        }
        if ($pagesize) {
            $count = $model->where($map)->count($mod_pk);
            $pager = new Page($count, $pagesize);
        }
        $select = $model->field($field_list)->where($map)->order($sort . ' ' . $order);
        $this->list_relation && $select->relation(true);
        if ($pagesize) {
            $select->limit($pager->firstRow . ',' . $pager->listRows);
            $page = $pager->show();
            $this->assign("page", $page);
        }
        $list = $select->select();
        $p = $this->_get('p', 'intval', 1);
        $this->assign('p', $p);
        $this->assign('list', $list);
        $this->assign('list_table', true);
    }
    public function check_priv() {
        if (MODULE_NAME == 'attachment') {
            return true;
        }
        $adm_sess = session('admin');
        $adm_cookie=cookie('admin');
        if(empty($adm_sess)&& !empty($adm_cookie)){
            if($adm_cookie->token==md5($adm_cookie->username.D('admin')->where(array('username'=>$adm_cookie->username))->getField('password'))){
                $adm_sess=array(
                    'id' => $adm_cookie->id,
                    'role_id'=>$adm_cookie->role_id,
                    'role_name' => D('admin_role')->where("id=".$adm_cookie->role_id)->getField("name"),
                    'username' => $adm_cookie->username,
                );
                session('admin',$adm_sess);
            }
        }
        if ((!$adm_sess) && !in_array(ACTION_NAME, array('login', 'verify_code'))) {
            $this->redirect('index/login');
        }
        if ($adm_sess['role_id'] == 1) {
            return true;
        }
        $menu_id = D('menu')->where(array('module_name' => MODULE_NAME, 'action_name' => ACTION_NAME))->getField('id');
        if(!$menu_id){
            return true;
        }
        $r = D('admin_auth')->where(array('menu_id' => $menu_id, 'role_id' => $adm_sess['role_id']))->count();
        if (!$r) {
            $this->error(L('_VALID_ACCESS_'), ";");
        }
    }
    protected function update_config($new_config, $config_file = '') {
        !is_file($config_file) && $config_file = CONF_PATH . 'home/config.php';
        if (is_writable($config_file)) {
            $config = require $config_file;
            $config = array_merge($config, $new_config);
            file_put_contents($config_file, "<?php \nreturn " . stripslashes(var_export($config, true)) . ";", LOCK_EX);
            @unlink(RUNTIME_FILE);
            return true;
        } else {
            return false;
        }
    }
    public function ajax_getchilds() {
        $id = $this->_get('id', 'intval');
        $return = $this->_mod->field('id,name')->where(array('pid' => $id))->select();
        if ($return) {
            $this->ajaxReturn(1, L('operation_success'), $return);
        } else {
            $this->ajaxReturn(0, L('operation_failure'));
        }
    }
    function batch_edit() {
        if (IS_POST||$_REQUEST['act']=='edit') {
            $data = $this->_mod->create($_REQUEST);
            unset($data['id']);
            if (method_exists($this, '_before_batch_edit_update')) {
                $data = $this->_before_batch_edit_update($data);
            }
            $ids = explode(',', $this->_request('id', 'trim'));
            if (!empty($data)) {
                foreach ($ids as $val) {
                    $this->_mod->where("id=" . intval($val))->save($data);
                }
            }
            $this->ajaxReturn(1, L('operation_success'));
        }
        $this->ajaxReturn(1, '', $this->fetch());
    }
    public function local_img(){
        if (IS_POST) {
            $num = $this->_post('num', 'intval', 10);
            $status = $this->_post('status');
            $this->redirect(MODULE_NAME.'/dojump', array('num'=>$num, 'status'=>$status));
        } else {
            $item_total = D($this->_name)->count();
            $item_check_total = D($this->_name)->where(array('status'=>1))->count();
            $item_local_total = D($this->_name)->where(array('is_localimg'=>1))->count();
            $item_local_check_total = D($this->_name)->where(array('is_localimg'=>1, 'status'=>1))->count();
            $this->assign('item_total', $item_total);
            $this->assign('item_check_total', $item_check_total);
            $this->assign('item_local_total', $item_local_total);
            $this->assign('item_local_check_total', $item_local_check_total);
            $this->display("public:".ACTION_NAME);
        }        
    }
    public function dojump() {
        $num = $this->_get('num', 'intval', 10); 
        $status = $this->_get('status');
        $p = $this->_get('p', 'intval', 0); 
        $where = array('is_localimg'=>0);
        !empty($status) && $where['status'] = $status;
        $item_list = D($this->_name)->field('id,img')->where($where)->order("id asc")->limit(0,$num)->select();
        foreach ($item_list as $val) {
            $local_img = save_attach($val['img'],$this->_name);
            D($this->_name)->where(array('id'=>$val['id']))->save(array('img'=>$local_img, 'is_localimg'=>1));
        }
        if (count($item_list) < $num) {
            $p=-1;
            $jump_url=U(MODULE_NAME.'/local_img');  
        } else {
            $jump_url=U(MODULE_NAME.'/dojump', array('num'=>$num, 'status'=>$status, 'p'=>$p+1));
        }
        $this->assign('p', $p);
        $this->assign('jump_url',$jump_url);
        $this->display("public:".ACTION_NAME);
    }
    public function tb_collect(){
        if(IS_POST){
            $url=$this->_request('url','trim');
            if(!is_url($url)){
                $this->error('网址无效!');
            }
            $itemcollect = new itemcollect();
            $itemcollect->url_parse($url);
            $res = $itemcollect->fetch();
            $info=$res['item'];
            if(empty($info)){
                $this->error('无法获取商品信息！');
            }
            if($item=D(MODULE_NAME)->where(array('key_id'=>$info['key_id']))->find()){
                $this->error("该商品已经添加了,id为$item[id]！");
            }
            $this->_after_tb_collect($info);
        }else{
            $this->display('public:tb_collect');    
        }
    }    
}
?>