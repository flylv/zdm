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
class indexAction extends frontendAction {     
    public function index() {
        $time=time();
        $time_Y=Date("Y",$time);
        $time_m=Date("m",$time);
        $time_d=Date("d",$time);
        $time_11=mktime(11,0,0,$time_m,$time_d,$time_Y);
        $time_15=mktime(15,0,0,$time_m,$time_d,$time_Y);
        $time_20=mktime(20,0,0,$time_m,$time_d,$time_Y);
        $time_11t=mktime(11,0,0,$time_m,$time_d+1,$time_Y);
        $date_11="`stime` = '{$time_11}' and `is_hot`=1 and `status`=1";
        $date_15="`stime` = '{$time_15}' and `is_hot`=1 and `status`=1";
        $date_20="`stime` = '{$time_20}' and `is_hot`=1 and `status`=1";
        if($time < $time_11){
            $content_11='正在进行';
        }elseif($time > $time_11 && $time < $time_15){
            $content_11='正在进行';
        }elseif($time > $time_15){
            $content_11='已结束';
        }
        if($time < $time_15){
            $content_15='即将开始';
        }elseif($time > $time_15 && $time < $time_20){
            $content_15='正在进行';
        }elseif($time > $time_20){
            $content_15='已结束';
        }
        if($time < $time_20){
            $content_20='即将开始';
        }elseif($time > $time_20 && $time < $time_11t){
            $content_20='正在进行';
        }elseif($time > $time_11t){
            $content_20='已结束';
        }
        $this->assign('content_11',$content_11);
        $this->assign('content_15',$content_15);
        $this->assign('content_20',$content_20);
        $today_hot_list=array(
            '11'=>array(
                'items'=>$this->_assign_list(D('jky_item'),$date_11,6,false,"`id` desc"),
                'title'=>$content_11,
            ),
            '15'=>array(
                'items'=>$this->_assign_list(D('jky_item'),$date_15,6,false,"`id` desc"),
                'title'=>$content_15,
            ),
            '20'=>array(
                'items'=>$this->_assign_list(D('jky_item'),$date_20,6,false,"`id` desc"),
                'title'=>$content_20,
            ),
        );
        $this->assign('today_hot_list',$today_hot_list);
        $time_24 = strtotime(date("y-m-d", $time)) + 3600*24;
        $jky_item_list=$this->_assign_list(D('jky_item'),"`is_recommend`=1 and `stime` < '{$time_24}' and `etime` > '{$time}' and `status`=1",60,false,"ordid asc,`id` desc");
        $this->assign('jky_item_list',$jky_item_list);
        $this->_assign_hot_list(6);
        $this->_assign_jky_common();
        $this->_config_seo(C('pin_seo_config.home'));
        $this->display();
    }
    public function mini_user()
    {
        header('Content-Type:text/html; charset=utf-8');
        echo $this->fetch('public:mini_user');
    }
    public function go(){        
        $id=$this->_get('id','intval');
        $url=trim(D("post")->where("id=$id")->getField("url"));        
        if(!empty($url)){
            header("Location:$url");
        }else{
            $this->error("未提供商品直达链接",U("index/index"));
        }
    }
}