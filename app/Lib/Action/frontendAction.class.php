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
class frontendAction extends baseAction {
    protected $visitor = null;
    protected $uid;
    public function _initialize() {
        parent::_initialize();
        if (!C('pin_site_status')) {
            header('Content-Type:text/html; charset=utf-8');
            exit(C('pin_closed_reason'));
        }
        if($this->is_mobile()&&file_exists(LIB_PATH.'/Action/wap')){
            header("Location:".__SITEROOT__."/wap/");
            exit();
        }
        $homepage = D("nav")->where("homepage=1")->find();
        if (!empty($homepage)) {
            if ($_SERVER['REQUEST_URI'] == __ROOT__ . '/' 
                &&$homepage['link']!='index.php?m=index&a=index') {                
                header("Location:" . U($homepage['link']) );
            }
            $homepage['link'] = U($homepage['link']);
        } else {
            $homepage['link'] = U('index/index');
        }
        $this->assign('homepage', $homepage);
        $this->_init_visitor();
        $this->_assign_oauth();
        $this->assign('nav_curr', '');
        $this->assign('recommend_cate', D("post_cate")->where("pid=1 and status=1")->select());
        $this->assign('tese_cate', D("post_cate")->where("pid=2 and status=1")->select());
        $this->assign('main_nav_list', D("nav")->where("type='main' and status=1 and homepage=0")->order('ordid')->select());
        $this->assign('bottom_nav_list', D("nav")->where("type='bottom' and status=1")->order('ordid')->select());
        $this->assign('new_post_list', D("post")->where("status=1 and collect_flag=1 and post_time<=" . time())->limit("9")->order("id desc")->select());
        $this->assign('jky_item_list',D('jky_item')->where("`status`=1")->limit("3")->order("`id` desc")->select());
        $this->assign('flink_list',D("flink")->where("status=1")->order("ordid desc")->select());
        $help_list=D("article_cate")->where("pid=1 and status=1")->select();
        foreach($help_list as $key=>$val){
            $help_list[$key]['articles']=D("article")->where("cate_id=$val[id]")->select();
        }        
        $this->assign('help_list',$help_list);
        $this->assign('gonggao_list',D("article")->where('cate_id=13 and status=1')->order("ordid desc")->select());
        $this->uid=intval($this->visitor->info['id']);      
        $this->assign('req',$_REQUEST);  
        $this->assign('server',$_SERVER);      
        $this->_assign_common();
		$def = array(
            'is_login' => $this->uid > 0,
            'm' => MODULE_NAME,
            'a' => ACTION_NAME,
            'url_prefix' => __ROOT__ . '/',
            'site_name' => C('pin_site_name'),
            'cps_alimama_pid' => C('pin_cps_alimama_pid'),
        );
        $this->assign('def', $def);
        if ($_REQUEST['act'] == 'loadjs') {
            header("content-type:text/javascript");
            echo "var def=" . json_encode($def) . ';';
            exit();
        }
    }
    protected function _assign_jky_common() {
        $this->assign('c1', intval($_REQUEST['c1']));
        $this->assign('c2', intval($_REQUEST['c2']));
        $cate_list = D("jky_cate")->where("pid=2 and status=1")->order("ordid desc")->select();
        foreach ($cate_list as $key => $val) {
            $cate_list[$key]['item_num'] = D('jky_cate_re')->DISTINCT(true)->where("cate_id=$val[id] and (select count(i.id) from " . table('jky_item') . " as i where i.status=1 and i.id=item_id)>0")->count();
        }
        $this->assign('cat_list', $cate_list);
        $this->assign('total_jky_num', D('jky_item')->where("status=1")->count());
        $this->assign('type_list', D("jky_cate")->where("pid=1 and status=1")->order("ordid desc")->select());
    }
    protected function _assign_post_baoliao() {
        $prefix = C('DB_PREFIX');
        $post_baoliao = D("post_baoliao")->DISTINCT(true)->where($prefix . "post_baoliao.`type`='0'")->join($prefix . 'user on ' . $prefix . 'user.id =' . $prefix . 'post_baoliao.uid')->field("count(*) as number," . $prefix . "post_baoliao.uid," . $prefix . "user.username")->group($prefix . "post_baoliao.uid")->order("number desc")->limit("0,5")->select();
        $this->assign('post_baoliao', $post_baoliao);
    }
    protected function _assign_common() {
        $this->assign("quick_mall_list", D("mall")->where("status=1")->order("ordid desc")->limit("10")->select());
        $this->assign("all_post_cate_list", D("post_cate")->where("status=1 and pid<2")->order("ordid desc")->select());
        $about_content = msubstr(strip_tags(D("article_page")->where("cate_id=2")->getField("info")), 350);
        $this->assign("about_content", $about_content);
    }
    private function _init_visitor() {
        $this->visitor = new user_visitor();
        $this->assign('visitor', $this->visitor->info);
    }
    private function _assign_oauth() {
        if (false === $oauth_list = F('oauth_list')) {
            $oauth_list = D('oauth')->oauth_cache();
        }
        $this->assign('oauth_list', $oauth_list);
    }
    protected function _config_seo($seo_info = array(), $data = array()) {
        $page_seo = array(
            'title' => C('pin_site_title'),
            'keywords' => C('pin_site_keyword'),
            'description' => C('pin_site_description')
        );
        $page_seo = array_merge($page_seo, $seo_info);
        $searchs = array('{site_name}', '{site_title}', '{site_keywords}', '{site_description}');
        $replaces = array(C('pin_site_name'), C('pin_site_title'), C('pin_site_keyword'), C('pin_site_description'));
        preg_match_all("/\{([a-z0-9_-]+?)\}/", implode(' ', array_values($page_seo)), $pageparams);
        if ($pageparams) {
            foreach ($pageparams[1] as $var) {
                $searchs[] = '{' . $var . '}';
                $replaces[] = $data[$var] ? strip_tags($data[$var]) : '';
            }
            $searchspace = array('((\s*\-\s*)+)', '((\s*\,\s*)+)', '((\s*\|\s*)+)', '((\s*\t\s*)+)', '((\s*_\s*)+)');
            $replacespace = array('-', ',', '|', ' ', '_');
            foreach ($page_seo as $key => $val) {
                $page_seo[$key] = trim(preg_replace($searchspace, $replacespace, str_replace($searchs, $replaces, $val)), ' ,-|_');
            }
        }
        if ($page_seo['title'] != C('pin_site_title')) {
        }
        $this->assign('page_seo', $page_seo);
    }
    protected function _user_server() {
        $passport = new passport(C('pin_integrate_code'));
        return $passport;
    }
    protected function _parse_post($list) {
        foreach ($list as $key => $val) {
            $list[$key]['cate_list'] = D("post_cate_re")->relation(true)->where(array('post_id' => $val['id']))->select();
            $list[$key]['tag_list'] = D("tag")->where("id in(select tag_id from " . table("post_tag") . " where post_id=$val[id])")->select();
        }
        return $list;
    }
    protected function _waterfall($mod, $where = '', $order = "", $pagesize = 5, $s_list_rows = '') {
        import("ORG.Util.Page");
        $p = !empty($_GET['p']) ? intval($_GET['p']) : 1;
        $sp = !empty($_GET['sp']) ? intval($_GET['sp']) : 1;
        $sp > C('pin_wall_spage_max') && exit;
        !$s_list_rows && $s_list_rows = C('pin_wall_spage_size');
        $list_rows = C('pin_wall_spage_max') * $s_list_rows;
        $show_sp = 0;
        $count = $mod->where($where)->count();
        $count > $s_list_rows && $show_sp = 1;
        $pager = new Page($count, $list_rows);
        $pager->setConfig('theme', '%upPage% %first% %linkPage% %end% %downPage%');
        $first_row = $pager->firstRow + $s_list_rows * ($sp - 1);
        $items_list = $mod->relation(true)->where($where)
            ->limit($first_row . ',' . $s_list_rows)->order($order)
            ->select();
        $this->assign('p', $p);
        $this->assign('show_sp', $show_sp);
        $this->assign('sp', $sp);
        $_parse = '_parse_' . $mod->getModelName();
        if (method_exists($this, $_parse)) {
            eval('$items_list=$this->' . $_parse . '($items_list);');
        }
        $_before = '_before_' . ACTION_NAME;
        if (method_exists($this, $_before)) {
            eval('$items_list=$this->' . $_before . '($items_list);');
        }
        $this->assign('show_load', 1);
        $this->assign('page_bar', $pager->fshow());
        $this->assign($mod->getModelName() . '_list', $items_list);
        if (IS_AJAX && $sp >= 2) {
            $resp = $this->fetch('public:ajax_' . $mod->getModelName() . '_list');
            $data = array(
                'isfull' => 1,
                'html' => $resp
            );
            $this->ajaxReturn(1, '', $data);
        } else {
            $this->display();
        }
    }
    protected function _assign_hot_list($limit = 8) {
        $hot_list = D("post")->where("is_hot=1 and status=1 and post_time<=" . time())->order("ordid")->limit("0,{$limit}")->select();
        $this->assign('hot_list', $hot_list);
    }
    protected function _assign_recommend_list($limit = 6) {
        $recommend_list = D("post")->where("is_recommend=1 and status=1 and post_time<=" . time())->order("ordid")->limit("0,{$limit}")->select();
        $this->assign('recommend_list', $recommend_list);
    }
    function is_mobile() {
    	$user_agent = $_SERVER['HTTP_USER_AGENT'];
    	$mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte");
    	$is_mobile = false;
    	foreach ($mobile_agents as $device) {
    		if (stristr($user_agent, $device)) {
    			$is_mobile = true;
    			break;
    		}
    	}
    	return $is_mobile;
    }
    protected function _parse_assign_list($list) {
        foreach ($list as $key => $val) {
            $list[$key]['buys'] = D('jky_anhao')->where("item_id=$val[id]")->count();
            $list[$key]['state'] = get_jky_state($val);
            $list[$key]['discount'] = round(($val['price'] / $val['mprice']) * 10);
            $list[$key]['icon_list'] = D('jky_icon_type')
                ->where("status=1 and id in(select type_id from " . table('jky_icon') . " as c where c.item_id=$val[id])")
                ->order("id desc,ordid asc")->select();
        }
        return $list;
    }
}