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
class postAction extends frontendAction {     
    public function index() {       
        $this->_assign_hot_list();
        $this->_assign_post_baoliao();
        $id=intval($_REQUEST['id']);
        $post_key=$this->_get('post_key','trim');
        if(empty($id)){
            $where=array('post_key'=>$post_key);
        }else{
            $where=array('id'=>$id);
        }
        $where['post_time'] = array('elt',time());
        $where['status'] = 1;        
        $res=D("post")->relation(true)->where($where)->find();
        if($res){               
            $res['cate_list']=D("post_cate_re")->relation(true)->where(array('post_id'=>$res['id']))->select();
            $this->assign('info',$res);         
            $tag_list=D("post_tag")->relation(true)->where("post_id=$res[id]")->select();
            $this->assign('tag_list',$tag_list);            
            $this->assign('prev_post',D("post")->where("id>$res[id] and status=1 and post_time<=".time())->order("id asc")->find());            
            $this->assign('next_post',D("post")->where("id<$res[id] and status=1 and post_time<=".time())->order("id desc")->find());
            $where="id in(select post_id from ".table('post_tag')." where 
                tag_id in(select tag_id from ".table('post_tag')." where post_id=$res[id]) 
                and post_id!=$res[id]) and post_time<=".time();
            $this->assign('like_list',D("post")->where($where)->limit(4)->select());
            $post_tag='';
            foreach($tag_list as $val){
                $post_tag.=$val['tag']['name'];
            }
            $this->_config_seo(C('pin_seo_config.post'),array('post_title'=>$res['title'],
                'post_tag'=>$post_tag,
                'user_name'=>$res['uname'],
                'seo_title'=>$res['seo_title'],
                'seo_keywords'=>$res['seo_keys'],
                'seo_description'=>$res['seo_desc']));
            $this->comment_list($res['id']);
        }else{
            $this->error("作品不存在");
        }
        $this->display();     
    }
    public function rate(){
        $type=$this->_post('type','trim');
        $id=$this->_post('id','intval');
        if(in_array($type,array('rate_best','rate_good','rate_bad'))){
            $where=array('id'=>$id);
            D("post")->where($where)->setInc($type);
            $res=D("post")->where($where)->find();
            $this->ajaxReturn(1,'',array(
                'total'=>$res['rate_best']+$res['rate_good']+$res['rate_bad'],
                'valid'=>$res['rate_best']+$res['rate_good']
            ));
        }
    }
    public function comment() {
        foreach ($_POST as $key=>$val) {
            $_POST[$key] = Input::deleteHtmlTags($val);
        }
        $data = array();
        $data['post_id'] = $this->_post('id', 'intval');
        !$data['post_id'] && $this->ajaxReturn(0, L('invalid_item'));
        $data['info'] = $this->_post('content', 'trim');
        !$data['info'] && $this->ajaxReturn(0, L('please_input') . L('comment_content'));
        $check_result = D('badword')->check($data['info']);
        switch ($check_result['code']) {
            case 1: 
                $this->ajaxReturn(0, L('has_badword'));
                break;
            case 3: 
                $data['status'] = 0;
                break;
        }
        $data['info'] = $check_result['content'];
        $data['uid'] = $this->visitor->info['id'];
        $data['uname'] = $this->visitor->info['username'];
        $data['add_time']=time();
        $data['pid']=$this->_post('pid','intval');
        $item = D("post")->field('id,uid,uname')->where(array('id' => $data['post_id'], 'status' => '1'))->find();
        !$item && $this->ajaxReturn(0, L('invalid_item'));
        if (false === D("post_comment")->create($data)) {
            $this->ajaxReturn(0, D("post_comment")->getError());
        }
        $comment_id = D("post_comment")->add(filter_data($data));
        if ($comment_id) {
            $tag_arg = array('uid'=>$this->visitor->info['id'], 
                'uname'=>$this->visitor->info['username'], 
                'action'=>'comment');
            tag('comment_end', $tag_arg); 
            $to_id=$this->_post('to_id','intval');
            if($to_id>0){
                D("message")->add(array(
                    'ftid'=>$data['uid'],
                    'from_id'=>$data['uid'],
                    'from_name'=>$data['uname'],
                    'to_id'=>$this->_post('to_id','intval'),
                    'to_name'=>$this->_post('to_name','trim'),
                    'add_time'=>time(),
                    'info'=>$data['info'],
                ));    
            }
            $this->assign('cmt_list', array(
                array(
                    'id'=>$comment_id,
                    'floor'=>D('post_comment')->where(array('post_id'=>$data['post_id'],'status'=>1))->count(),
                    'uid' => $data['uid'],
                    'uname' => $data['uname'],
                    'info' => $data['info'],
                    'add_time' => time(),
                    'digg'=>0,
                    'burn'=>0,
                    'quote'=>D("post_comment")->where(array('id'=>$data['pid']))->find(),
                    'user'=>D("user")->where(array('id'=>$data['uid']))->find(),
                )
            ));
            $resp['html'] = $this->fetch('ajax_comment_list');
            $resp['total']=D("post_comment")->where(array('post_id' => $data['post_id']))->count('id');  
            $this->ajaxReturn(1, L('comment_success'), $resp);
        } else {
            $this->ajaxReturn(0, L('comment_failed'));
        }
    }    
    public function comment_list($id){
        if(empty($id)){
            $id = $this->_get('id', 'intval');    
        }        
        !$id && $this->ajaxReturn(0, L('invalid_item'));        
        $post = D("post")->where(array('id' => $id, 'status' => '1'))->count('id');
        !$post && $this->ajaxReturn(0, L('invalid_item'));        
        $pagesize = 8;
        $map = array('post_id' => $id);
        $count = D("post_comment")->where($map)->count('id');
        $pager = $this->_pager($count, $pagesize,__ROOT__."/index.php?m=post&a=comment_list&id=$id");
        $pager->path = 'comment_list';
        $cmt_list = D("post_comment")->relation(true)
            ->where($map)->order('id DESC')
            ->limit($pager->firstRow . ',' . $pager->listRows)->select();
        $floor=$count-$pager->firstRow;            
        foreach($cmt_list as $key=>$val){
            $cmt_list[$key]['quote']=D("post_comment")->where(array('id'=>$val['pid']))->find();
            $cmt_list[$key]['floor']=$floor;
            $floor--;
        }
        $this->assign('cmt_list', $cmt_list);
        $data = array();
        $data['list'] = $this->fetch('ajax_comment_list');
        $data['page'] = $pager->fshow();
        $data['total']=$count;
        $this->assign('cmt_page',$data['page']);
        $this->assign('cmt_total',$data['total']); 
        if(IS_AJAX){                 
            $this->ajaxReturn(1,'',$data);    
        }
    }
    public function digg_burn(){        
        $id=$this->_get('id','intval');
        $type=$this->_get('type','trim');
        if(in_array($type,array('digg','burn'))){        
            D("post_comment")->where(array('id'=>$id))->setInc($type);
            $this->ajaxReturn(1,'',D("post_comment")->where(array('id'=>$id))->getField($type));    
        }
    }
    public function submit(){
        if(!$this->visitor->is_login){
            header("Location:".u('user/login'));
        }  
        if(IS_POST){
            $data=D("post_baoliao")->create();
            $type=intval($data['type']); 
            if($type==1){
                $data['title']='我要投稿';
            }
            elseif($type==2){
                $data['title']='改进建议';
            }            
            $data['info']=$this->_post("info_".$data['type'],'trim');
            $data['uid']=$this->visitor->info['id'];
            D("post_baoliao")->add(filter_data($data));   
            $tag_arg = array('uid'=>$this->visitor->info['id'], 
                'uname'=>$this->visitor->info['username'], 
                'action'=>'submit');
            tag('submit_end', $tag_arg);   
            $this->ajaxReturn(1);
        }     
        $this->assign('page_seo',array('title'=>'用户爆料'));          
        $this->display();
    }
}