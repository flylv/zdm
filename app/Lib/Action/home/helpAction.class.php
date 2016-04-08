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
class helpAction extends frontendAction {     
    public function _initialize() {
        parent::_initialize();
        $this->assign('href', trim($_SERVER['REDIRECT_URL'],' '));
    }
    public function index() {
        $id=$this->_get('id','intval');
        $res=D("article")->where('id='.$id)->find();
        if($res){
            $this->assign('info',$res);
            $this->_config_seo(array('title'=>$res['title'],
                'keywords'=>$res['seo_keys'],
                'description'=>$res['seo_desc']));               
        }else{
            header("Location:/");
        }
        $this->display();     
    }
    public function page(){
        $id=$this->_get('id','intval');
        $res=D("article_page")->where('cate_id='.$id)->find();
        if($res){            
            $this->assign('info',$res);
            $this->_config_seo(array('title'=>$res['title'],
                'keywords'=>$res['seo_keys'],
                'description'=>$res['seo_desc']));               
        }else{
            header("Location:".__ROOT__.'/');
        }
        $this->display('index');             
    }
    public function faq(){
        $cate_id=$this->_get('cate_id','intval');
        $this->assign('cate_id',$cate_id);
        $cate_info=D("article_cate")->where(array('id'=>$cate_id))->find();
        $this->assign('cate_info',$cate_info);
        $this->_config_seo(C('pin_seo_config.article'),array('article_title'=>$cate_info['name'],
                'seo_title'=>$res['seo_title'],
                'keywords'=>$res['seo_keys'],
                'description'=>$res['seo_desc']));          
        $res=D("article")->where(array('cate_id'=>$cate_id,'status'=>1))->select();
        $this->assign('faq_list',$res);
        $this->display();
    }   
    public function flink(){
        $this->_config_seo(C('pin_seo_config.article'),array('article_title'=>'友情链接',
                'seo_title'=>$res['seo_title'],
                'keywords'=>$res['seo_keys'],
                'description'=>$res['seo_desc']));            
        $res=D("flink")->where("status=1")->order('ordid desc')->select();
        $this->assign('flink_list',$res);
        $this->display();
    } 
}