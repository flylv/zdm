<?php 
/**
* ZhePHP 值得买模式的海淘网站程序
* ====================================================================
* 版权所有 杭州言商网络有限公司，并保留所有权利。
* --------------------------------------------------------------------
* 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
* 使用；不允许对程序代码以任何形式任何目的的再发布。
* ====================================================================
* Author: brivio <brivio@qq.com>
* 授权技术支持: 1142503300@qq.com
*/
class post_cateAction extends frontendAction {     
    public function post_list(){
        $this->_assign_hot_list();
        $this->_assign_recommend_list();
        $this->_assign_post_baoliao();
        $this->_config_seo(C('pin_seo_config.home'));
        $this->_waterfall(D("post"),"status=1 and post_time<=".time(),'post_time desc');
    }
    public function index() {
        $this->_assign_hot_list();
        $this->_assign_post_baoliao();
        if(!empty($_REQUEST['keyword'])){  
            $keyword=$this->_get('keyword','trim');
            if(empty($keyword)){
                $this->_config_seo(C('pin_seo_config.home'));    
            }else{
                $this->_config_seo(C('pin_seo_config.search'),array('keyword'=>$keyword));
            }
            $this->assign('search',array(
                'keyword'=>$keyword
            ));
            $where="`title` like '%$keyword%' ";
        }elseif(($cate_id = intval($_REQUEST['id'])) >0){   
            $title=trim($_REQUEST['title']);        
            $this->assign('id',$cate_id);
            $info=D("post_cate")->where(array('id'=>$cate_id))->find();
            $this->assign('info',$info);
            $this->_config_seo(C('pin_seo_config.cate'),array('cate_name'=>$info['name'],
                'seo_title'=>$info['seo_title'],
                'seo_keywords'=>$info['seo_keys'],
                'seo_description'=>$info['seo_desc']));         
            $where="(select count(c.post_id) from ".table('post_cate_re')." as c where id=c.post_id and c.cate_id in(".implode(',',D('post_cate')->get_child_ids($cate_id,true))."))>0 ";
        }else{ 
                $where="1 ";
        }
        $this->_waterfall(D("post"),$where." and status=1 and post_time<=".time(),'post_time desc');
    }
}