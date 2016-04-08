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
class zhaoshangAction extends frontendAction {
    public function _initialize() {
        parent::_initialize();
        $this->assign("zs_dahang", D("article_cate")->where("pid=27 and status=1")->order("ordid asc,id desc")->select()); 
        if($zs_huodong=D("zhaoshang_cate")->where("status=1")->order("ordid asc,id desc")->select()){
            foreach($zs_huodong as $k=>$value){
                $zs_huodong[$k]['zs_count']=D("zhaoshang_item")->where("`cid`='{$value['id']}'")->count();
            }
        }
        $this->assign("zs_huodong",$zs_huodong);
    }
    public function index() {
        $this->assign("zs_zhanshi",D("article")->where("cate_id=29 and status=1")->order("ordid asc,id desc")->select());
        $this->assign("zs_gonggao",D("article")->where("cate_id=30 and status=1")->getField("info"));
        $this->_config_seo(array('title' => '淘宝网限时折扣 最新打折信息 淘宝商城品牌商品 淘宝网购物推荐 - zhephp'));
        $this->display();   
    }
    public function zs_page() {
        $id=$this->_get('id','intval',0);
        $res=D("article")->where("`cate_id`='{$id}' and status=1")->find();
        if($res){
            $this->assign("catename",D("article_cate")->where("`id`='{$id}'")->getField("name"));
            $this->assign('info',$res);
            $this->_config_seo(array('title'=>$res['title'],
                'keywords'=>$res['seo_keys'],
                'description'=>$res['seo_desc']));               
        }else{
            header("Location:/");
        }
        $this->display();   
    }
    public function zs_add()
    {
        $this->is_merchant(1);
        $id=$this->_get('id','intval',0);
        $this->assign("huodongcat",D("zhaoshang_cate")->where("`id`='{$id}'")->field("id,name")->find());
        if(IS_POST){
            $data=D("zhaoshang_item")->create();
            $data['uid']=$this->visitor->info['id'];
            $data['add_time']=time();
            if (!empty($_FILES['img']['name'])) {
                $art_add_time = date('ym/d');
                $result = $this->_upload($_FILES['img'], 'zhaoshang/' . $art_add_time);
                if ($result['error']) {
                    $this->ajaxReturn(0,$result['info']);
                } else {                
                    $data['img'] = $art_add_time .'/'.$result['info'][0]['savename'];
                }
            }
            if (!empty($_FILES['img2']['name'])) {
                $art_add_time2 = date('ym/d');
                $result2 = $this->_upload($_FILES['img2'], 'zhaoshang/' . $art_add_time2);
                if ($result2['error']) {
                    $this->ajaxReturn(0,$result2['info']);
                } else {                
                    $data['img2'] = $art_add_time2 .'/'.$result2['info'][0]['savename'];
                }
            }
            D("zhaoshang_item")->add(filter_data($data));   
            $tag_arg = array('uid'=>$this->visitor->info['id'], 
                'uname'=>$this->visitor->info['username'], 
                'action'=>'submit');
            tag('submit_end', $tag_arg);   
            $this->ajaxReturn(1);
        } 
        $this->display();
    }
    public function zs_list() {
        $this->is_merchant(1);
        $where = array('uid'=>$this->visitor->info['id']);
        $count = D('zhaoshang_item')->where($where)->count();
        $pager = $this->_pager($count,10);
        $res = D('zhaoshang_item')->where($where)->limit($pager->firstRow . ',' . $pager->listRows)->order('id DESC')->select();
        $this->assign('page', $pager->show());
        $this->assign("shenhe_list",$res);
        $cate_list = D('zhaoshang_cate')->where(array('status'=>1))->order("ordid desc")->select();
        $zhaoshang_cate_list = array();
        foreach ($cate_list as $val) {
            $zhaoshang_cate_list[$val['id']] = $val['name'];
        }
        $this->assign('zhaoshang_cate_list', $zhaoshang_cate_list);  
        $this->_config_seo(array('title'=>'审核结果'));
        $this->assign('empty','<span class="empty">没有数据</span>');
        $this->display();   
    }
    public function login() {
        $this->is_merchant();
        $this->_config_seo(array('title'=>'商家登录'));
        if (!empty($_GET['synlogout'])) {
            $passport = $this->_user_server();
            $synlogout = $passport->synlogout();
        }
        $ret_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : __APP__;
        $this->assign('ret_url', $ret_url);
        $this->assign('synlogout', $synlogout);
        $this->display();
    }
    public function logout() {
        $this->visitor->logout();
        $passport = $this->_user_server();
        $synlogout = $passport->synlogout();
        $this->success(L('logout_successe').$synlogout, $this->_request('ret_url', 'urldecode',U('zhaoshang/index')));
    }
    public function is_merchant($type=0) {
        if($this->visitor->is_login){
            if($this->visitor->info['is_merchant'] == 1){
                if($type == 0){
                    $this->redirect('zhaoshang/index');
                }
            }else{
                if($type == 1){
                    $this->error('您的帐号不是商家帐号,请联系官方了解相关信息！',U('zhaoshang/login'));
                }
            }
        }else{
            if($type == 1){
                $this->redirect('zhaoshang/login');
            }
        }
    }
}
?>