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
class templateAction extends backendAction
{
    public function index() {
        $site_logo = C('pin_site_logo');
        $config_file = CONF_PATH . 'home/config.php';
        $config = include $config_file;        
        if(IS_POST){
            foreach($_REQUEST['tpl'] as $key=>$val){
                if (!empty($_FILES['site_logo']['name'][$key])) {
                    $data=array(
                        'name'=>$_FILES['site_logo']['name'][$key],
                        'type'=>$_FILES['site_logo']['type'][$key],
                        'tmp_name'=>$_FILES['site_logo']['tmp_name'][$key],
                        'error'=>$_FILES['site_logo']['error'][$key],
                        'size'=>$_FILES['site_logo']['size'][$key],
                    );
                    $result = $this->_upload($data, 'logo/' );
                    if ($result['error']) {
                        $this->error($result['info']);
                    } else {
                        $site_logo_data[$val] = $dir . $result['info'][0]['savename'];
                        unlink(C('pin_attach_path').'logo/'.$site_logo[$val]);
                    }
                }else{
                    $site_logo_data[$val]=$_REQUEST["site_logo_data"][$key];
                }
            }
            $data=serialize($site_logo_data);            
            D('setting')->where(array('name'=>'site_logo'))->setField('data',$data);
            if ($dirname = $this->_post('dirname', 'trim')) {
                $config['DEFAULT_THEME'] = $dirname;
                file_put_contents($config_file, "<?php \nreturn " . var_export($config, true) . ";", LOCK_EX);
                $obj_dir = new Dir;
                is_dir(CACHE_PATH.'home/') && $obj_dir->delDir(CACHE_PATH.'home/');
                @unlink(RUNTIME_FILE);
            }
            $this->success(L('operation_success'),U(MODULE_NAME.'/'.ACTION_NAME));        
        }else{
            $tpl_dir = TMPL_PATH.'home/';
            $opdir = dir($tpl_dir);
            $template_list = array();
            while (false !== ($entry = $opdir->read())) {
                if ($entry{0} == '.') {
                    continue;
                }
                if (!is_file($tpl_dir . $entry . '/info.php')) {
                    continue;
                }
                $info = include_once($tpl_dir . $entry . '/info.php');
                $info['preview'] = TMPL_PATH . 'home/' . $entry . '/preview.gif';
                $info['dirname'] = $entry;
                $info['logo']=__ROOT__.'/'.C("pin_attach_path").'logo/'.$site_logo[$entry];
                $template_list[$entry] = $info;
            }
            $this->assign('template_list',$template_list);
            $this->assign('def_tpl', $config['DEFAULT_THEME']);
            $this->assign('signature',$config['TPL_SIGNATURE']);
            $this->display();            
        }
    }
}