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
class postAction extends mobileAction {
    function index() {        
        $where.="status=1 and post_time<=".time();
        $cate_id=$this->_request('cate_id','intval',0);
        $res=array();
        if($cate_id>0){
            $where.=" and (select count(c.post_id) from ".table('post_cate_re')." as c where id=c.post_id and c.cate_id in(".implode(',',D('post_cate')->get_child_ids($cate_id,true))."))>0";
            $res['cate']=D('post_cate')->field("id,name")->where("id=$cate_id")->find();
        }else{
            $res['cate']=array('id'=>'0','name'=>'全部');
        }
        if($title=$this->_request('title','trim','')){
            $where.=" and title like '%$title%'";
        }
        $list= D("post")->field("id,title,img,prices,mall_id")->where($where)->limit(($this->pageIndex*$this->pageSize).",".$this->pageSize)->order("ordid asc,id desc")->select();
        foreach($list as $key=>$val){
            $list[$key]=$this->_format_post($val);            
        }
        $res['items']=$list;    
        $res['pageSize']=$this->pageSize;
        $res['totalCount']=D("post")->where($where)->count();    
        $this->response($res);                  
    }    
    function detail(){
        $id=$this->_get("id");
        $res=D("post")->field("id,title,info,url,img,prices,mall_id,uid,uname,add_time")->where("id=$id")->find();
        if(empty($res)){
            $this->error("商品不存在");
        }else{
            $res=$this->_format_post($res);            
            $this->response($res);    
        }
    } 
    function comment_list(){
        $id=$this->_get("id",'intval',0);
        $res=array();
        $where="post_id=$id and status=1";
        $res['allCount']=D('post_comment')->where($where)->count();
        $res['pageSize']=$this->pageSize;
        $items=D('post_comment')->where($where)->order("id desc")->select();
        foreach($items as $key=>$val){
            $items[$key]['avatar']=avatar($val['uid']);
            $items[$key]['add_time']=Date("Y-m-d H:i:s",$val['add_time']);
        }
        $res['items']=$items;
        $this->response($res);
    }
    function comment_pub(){
        $id=$this->_request('id','intval',0);
        $uid=$this->_request('uid','intval',0);
        $info=$this->_request('info','trim');
        $data=array(
            'post_id'=>$id,
            'uid'=>$uid,
            'uname'=>D('user')->where("id=$uid")->getField('username'),
            'info'=>$info,
            'add_time'=>time(),
            'client'=>$this->client_info['platform'].' '.$this->client_info['platform_version']
        );
        D('post_comment')->add($data);
        $res['result']=array('error_code'=>1,'error_message'=>'发布成功!');
        $res['comment']=array(
            'id'=>D('post_comment')->getLastInsID(),
            'avatar'=>avatar($uid),
            'uname'=>$data['uname'],
            'uid'=>$uid,
            'info'=>$info,
            'add_time'=>Date("Y-m-d H:i:s",$data['add_time']),
        );
        $this->response($res);
    }
    private function _format_post($info){
        !empty($info['title'])&&$info['title']=strip_tags($info['title']);
        !empty($info['img'])&&$info['img']=attach($info['img'],'post',true);
        !empty($info['info'])&&$info['info']=parse_editor_info($info['info'],'http://192.168.1.102/zhiphp_svn');    
        !empty($info['prices'])&&$info['price']=strip_tags($info['prices']);   
        !empty($info['add_time'])&&$info['add_time']=Date('Y-m-d H:i:s',$info['add_time']);
        $info['mall_title']=D('mall')->where(array('id'=>$info['mall_id']))->getField("title");
        unset($info['mall_id']);
        $info['comment_count']=D('post_comment')->where("post_id=$info[id] and status=1")->count();
        return $info;
    }
}