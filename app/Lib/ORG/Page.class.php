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
class Page {
    public $rollPage = 5;
    public $path = '';
    public $parameter  ;
    public $url     =   '';
    public $listRows = 20;
    public $firstRow    ;
    protected $totalPages  ;
    protected $totalRows  ;
    protected $nowPage    ;
    protected $coolPages   ;
    protected $config  =    array('header'=>'条记录','prev'=>'<上一页','next'=>'下一页>','first'=>'第一页','last'=>'最后一页','theme'=>'%totalRow% %header% %nowPage%/%totalPage% 页 %first% %upPage% %linkPage% %downPage% %end%');
    protected $varPage;
    public function __construct($totalRows,$listRows='',$parameter='',$url='') {
        $this->totalRows    =   $totalRows;
        $this->parameter    =   $parameter;
        $this->varPage      =   C('VAR_PAGE') ? C('VAR_PAGE') : 'p' ;
        if(!empty($listRows)) {
            $this->listRows =   intval($listRows);
        }
        $this->totalPages   =   ceil($this->totalRows/$this->listRows);     
        $this->nowPage      =   !empty($_GET[$this->varPage])?intval($_GET[$this->varPage]):1;
        if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage  =   $this->totalPages;
        }
        $this->firstRow     =   $this->listRows*($this->nowPage-1);
    }
    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }
    public function show() {
        if(0 == $this->totalRows) return '';
        $p              =   $this->varPage;
        $middle = ceil($this->rollPage/2); 
        if($this->url){
            $depr       =   C('URL_PATHINFO_DEPR');
            $url        =   rtrim(U('/'.$this->url,'',false),$depr).$depr.'__PAGE__';
        }else{
            if($this->parameter && is_string($this->parameter)) {
                parse_str($this->parameter,$parameter);
            }elseif(empty($this->parameter)){
                unset($_GET[C('VAR_URL_PARAMS')]);
                if(empty($_GET)) {
                    $parameter  =   array();
                }else{
                    $parameter  =   $_GET;
                }
            }
            $parameter[$p]  =   '__PAGE__';
            $url            =   U($this->path,$parameter);
        }
        $upRow          =   $this->nowPage-1;
        $downRow        =   $this->nowPage+1;
        if ($upRow>0){
            $upPage     =   "<a href='".str_replace('__PAGE__',$upRow,$url)."'>".$this->config['prev']."</a>";
        }else{
            $upPage     =   '';
        }
        if ($downRow <= $this->totalPages){
            $downPage   =   "<a href='".str_replace('__PAGE__',$downRow,$url)."'>".$this->config['next']."</a>";
        }else{
            $downPage   =   '';
        }
        $theFirst = $theEnd = '';
        if ($this->totalPages > $this->rollPage) {
            if($this->nowPage - $middle < 1){
                $theFirst   =   '';
            }else{
                $theFirst   =   "<a href='".str_replace('__PAGE__',1,$url)."' >".$this->config['first']."</a>";
            }
            if($this->nowPage + $middle > $this->totalPages){
                $theEnd     =   '';
            }else{
                $theEndRow  =   $this->totalPages;
                $theEnd     =   "<a href='".str_replace('__PAGE__',$theEndRow,$url)."' >".$this->config['last']."</a>";
            }
        }
        $linkPage = "";
        if ($this->totalPages != 1) {
            if ($this->nowPage < $middle) { 
                $start = 1;
                $end = $this->rollPage;
            } elseif ($this->totalPages < $this->nowPage + $middle - 1) {
                $start = $this->totalPages - $this->rollPage + 1;
                $end = $this->totalPages;
            } else {
                $start = $this->nowPage - $middle + 1;
                $end = $this->nowPage + $middle - 1;
            }
            $start < 1 && $start = 1;
            $end > $this->totalPages && $end = $this->totalPages;
            for ($page = $start; $page <= $end; $page++) {
                if ($page != $this->nowPage) {
                    $linkPage .= " <a href='".str_replace('__PAGE__',$page,$url)."'>&nbsp;".$page."&nbsp;</a>";
                } else {
                    $linkPage .= " <span class='current'>".$page."</span>";
                }
            }
        }
        $pageStr     =   str_replace(
            array('%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%linkPage%','%end%'),
            array($this->config['header'],$this->nowPage,$this->totalRows,$this->totalPages,$upPage,$downPage,$theFirst,$linkPage,$theEnd),$this->config['theme']);
        return $pageStr;
    }
    public function fshow() {
        if(0 == $this->totalRows) return '';
        $p              =   $this->varPage;
        $middle         =   ceil($this->rollPage/2); 
        if($this->url){
            $depr       =   C('URL_PATHINFO_DEPR');
            $url        =   rtrim(U('/'.$this->url,'',false),$depr).'&'.$this->varPage.'=__PAGE__';
        }else{
            if($this->parameter && is_string($this->parameter)) {
                parse_str($this->parameter,$parameter);
            }elseif(empty($this->parameter)){
                unset($_GET[C('VAR_URL_PARAMS')]);
                if(empty($_GET)) {
                    $parameter  =   array();
                }else{
                    $parameter  =   $_GET;
                }
            }
            $parameter[$p]  =   '__PAGE__';
            $url            =   U($this->path, $parameter);
        }        
        $upRow          =   $this->nowPage-1;
        $downRow        =   $this->nowPage+1;
        if ($upRow>0){
            $upPage     =   "<a href='".str_replace('__PAGE__',$upRow,$url)."' class='prev'>".$this->config['prev']."</a>";
        }else{
            $upPage     =   '';
        }
        if ($downRow <= $this->totalPages){
            $downPage   =   "<a href='".str_replace('__PAGE__',$downRow,$url)."' class='next'>".$this->config['next']."</a>";
        }else{
            $downPage   =   '';
        }
        $theFirst = $theEnd = '';
        if ($this->totalPages > $this->rollPage) {
            if($this->nowPage - $middle < 1){
                $theFirst   =   '';
            }else{
                $theFirst   =   "<a href='".str_replace('__PAGE__',1,$url)."' >1</a> <i>...</i>";
            }
            if($this->nowPage + $middle > $this->totalPages){
                $theEnd     =   '';
            }else{
                $theEndRow  =   $this->totalPages;
                $theEnd     =   "<i>...</i> <a href='".str_replace('__PAGE__',$theEndRow,$url)."' >".$theEndRow."</a>";
            }
        }
        $linkPage = "";
        if ($this->totalPages != 1) {
            if ($this->nowPage < $middle) { 
                $start = 1;
                $end = $this->rollPage;
            } elseif ($this->totalPages < $this->nowPage + $middle - 1) {
                $start = $this->totalPages - $this->rollPage + 1;
                $end = $this->totalPages;
            } else {
                $start = $this->nowPage - $middle + 1;
                $end = $this->nowPage + $middle - 1;
            }
            $start < 1 && $start = 1;
            $end > $this->totalPages && $end = $this->totalPages;
            for ($page = $start; $page <= $end; $page++) {
                if ($page != $this->nowPage) {
                    $linkPage .= " <a href='".str_replace('__PAGE__',$page,$url)."'>&nbsp;".$page."&nbsp;</a>";
                } else {
                    $linkPage .= " <span class='current'>".$page."</span>";
                }
            }
        }
        $pageStr     =   str_replace(
            array('%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%linkPage%','%end%'),
            array($this->config['header'],$this->nowPage,$this->totalRows,$this->totalPages,$upPage,$downPage,$theFirst,$linkPage,$theEnd),$this->config['theme']);
        return $pageStr;
    }
}