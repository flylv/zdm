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
class jky_itemAction extends baseAction {     
    public function index() {
        $where="status=1";
        if($cid=$this->_get('cid','intval')){
            $where.=" and (select count(c.item_id) from ".table("jky_cate_re")." as c where c.cate_id=$cid and c.item_id=id)>0 ";
            $this->assign('cate_info',D('jky_cate')->where("id=$cid")->find());
        }
        if($keyword=$this->_get('keyword','trim')){
            $where.=" and title like '%$keyword%'";
        }
        $this->_assign_list(D(MODULE_NAME),$where);
        $this->display();
    }
    public function search(){
        $list=D('jky_cate')->get_child(0);
        foreach($list as $key=>$val){
            $tr_row=count($val['child'])%3==0?intval(count($val['child'])/3):intval(count($val['child'])/3)+1;
            $html="";
            for($i=1;$i<=$tr_row;$i++){
                $html.="<tr>";
                for($j=0;$j<3;$j++){
                    $html.="<td>";
                    if(!empty($val['child'][($i-1)*3+$j])){
                        $html.="<a href='".U(MODULE_NAME."/index",array('cid'=>$val['child'][($i-1)*3+$j]['id']))."'>".$val['child'][($i-1)*3+$j]['name']."</a>";
                    }
                    $html.="</td>";
                }
                $html.="</tr>";
            }
            $list[$key]['html']=$html;
        }
        $this->assign('list',$list);
        $this->display();
    }
}