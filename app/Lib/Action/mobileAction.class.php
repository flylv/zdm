<?php 
/**
* ZhePHP 值得买模式的海淘网站程序
* ====================================================================
* ====================================================================
*/
class mobileAction extends baseAction {
    var $pageIndex=0;
    var $pageSize=20;
    var $client_info;
    protected function _initialize() {
        $this->pageIndex=$this->_request('pageIndex','intval',0);
        $pageSize=$this->_request('pageSize','intval',20);
        parent::_initialize();
        $user_agent=explode('/',$_SERVER['HTTP_USER_AGENT']);
        $this->client_info=array(
            'app_version'=>$user_agent[1],
            'platform'=>strtolower($user_agent[2]),
            'platform_version'=>$user_agent[3],
        );
    }       
    protected function response($data){
        header("Content-Type: text/html; charset=utf-8");
        exit(json_encode($data));
    }
    protected function error($msg){
        $this->response(array('error_code'=>0,'error_message'=>$msg));
    }
    protected function success($msg){
        $this->response(array('error_code'=>1,'error_message'=>$msg));
    }
}