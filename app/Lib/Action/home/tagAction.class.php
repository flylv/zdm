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
class tagAction extends frontendAction {     
    public function index() {    
        $this->_assign_hot_list();
        $where="1 ";
        if(($id=$this->_get('id','intval'))>0){
            $this->assign('id',$id);        
            $info=D('tag')->where(array('id'=>$id))->find(); 
            $this->_config_seo(array('title'=>$info['name'].'_标签'));  
            $where.=" and (select count(t.post_id) from ".table('post_tag')." as t where id=t.post_id and t.tag_id=$id)>0 ";  
        }elseif($uname=$this->_get('uname','trim')){            
            $uname=$this->_get('uname','trim');
            $this->assign('uname',$uname);  
            $this->_config_seo(array('title'=>$uname.'_推荐的商品'));   
            $where.= " and uname='$uname'";          
        }
        $this->_waterfall(D("post"),$where." and status=1 and collect_flag=1 and post_time<=".time(),'post_time desc');        
    }
}