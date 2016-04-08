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
function msubstr($str, $length, $start = 0, $charset = "utf-8", $suffix = true)
{
    $str = trim(strip_tags($str));
    if (function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    return strlen($str) > $length ? $slice . '...' : $slice;
}
function addslashes_deep($value)
{
    $value = is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
    return $value;
}
function stripslashes_deep($value)
{
    if (is_array($value)) {
        $value = array_map('stripslashes_deep', $value);
    } elseif (is_object($value)) {
        $vars = get_object_vars($value);
        foreach ($vars as $key => $data) {
            $value->{$key} = stripslashes_deep($data);
        }
    } else {
        $value = stripslashes($value);
    }
    return $value;
}
function todaytime()
{
    return mktime(0, 0, 0, date('m'), date('d'), date('Y'));
}
function fdate($time)
{
    if (!$time)
        return false;
    $fdate = '';
    $d = time() - intval($time);
    $ld = $time - mktime(0, 0, 0, 0, 0, date('Y')); 
    $md = $time - mktime(0, 0, 0, date('m'), 0, date('Y')); 
    $byd = $time - mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')); 
    $yd = $time - mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')); 
    $dd = $time - mktime(0, 0, 0, date('m'), date('d'), date('Y')); 
    $td = $time - mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')); 
    $atd = $time - mktime(0, 0, 0, date('m'), date('d') + 2, date('Y')); 
    if ($d == 0) {
        $fdate = '刚刚';
    } else {
        switch ($d) {
            case $d < $atd:
                $fdate = date('Y年m月d日', $time);
                break;
            case $d < $td:
                $fdate = '后天' . date('H:i', $time);
                break;
            case $d < 0:
                $fdate = '明天' . date('H:i', $time);
                break;
            case $d < 60:
                $fdate = $d . '秒前';
                break;
            case $d < 3600:
                $fdate = floor($d / 60) . '分钟前';
                break;
            case $d < $dd:
                $fdate = floor($d / 3600) . '小时前';
                break;
            case $d < $yd:
                $fdate = '昨天' . date('H:i', $time);
                break;
            case $d < $byd:
                $fdate = '前天' . date('H:i', $time);
                break;
            case $d < $md:
                $fdate = date('m月d日 H:i', $time);
                break;
            case $d < $ld:
                $fdate = date('m月d日', $time);
                break;
            default:
                $fdate = date('Y年m月d日', $time);
                break;
        }
    }
    return $fdate;
}
function ftime($time)
{
    if ($time < 0) return '0天';
    $date = intval($time / (3600 * 24));
    $hour = intval(($time - $date * 3600 * 24) / 3600) > 0 ? intval(($time - $date * 3600 * 24) / 3600) : 0;
    $minute = intval(($time - $date * 3600 * 24 - $hour * 3600) / 60) > 0 ? intval(($time - $date * 3600 * 24 - $hour * 3600) / 60) : 0;
    return $date . '天' . $hour . '小时' . $minute . '分';
}
function avatar($uid, $size = 40)
{
    $avatar_size = explode(',', C('pin_avatar_size'));
    $size = in_array($size, $avatar_size) ? $size : '100';
    $avatar_dir = avatar_dir($uid);
    $avatar_file = $avatar_dir . md5($uid) . "_{$size}.jpg";
    if (!is_file(C('pin_attach_path') . 'avatar/' . $avatar_file)) {
        $avatar_file = "default_{$size}.jpg";
    }
    return __SITEROOT__ . '/' . C('pin_attach_path') . 'avatar/' . $avatar_file;
}
function avatar_dir($uid)
{
    $uid = abs(intval($uid));
    $suid = sprintf("%09d", $uid);
    $dir1 = substr($suid, 0, 3);
    $dir2 = substr($suid, 3, 2);
    $dir3 = substr($suid, 5, 2);
    return $dir1 . '/' . $dir2 . '/' . $dir3 . '/';
}
function attach($attach, $type, $full_url = false)
{
    $attach = trim($attach);
    if (is_url($attach)) {
        return $attach;
    }
    $attach = ltrim($attach, '/');
    $is_local = strstr($attach, 'static/') != false;
    $url_preix = __ROOT__;
    if ($full_url) {
        $url_preix = __SITEROOT__;
    }
    $attach_path = $is_local ? $attach : "data/upload/" . $type . '/' . $attach;
    if (!file_exists('./' . $attach_path) || empty($attach)) {
        return $url_preix . "/data/upload/no_picture.gif";
    } else {
        return $url_preix . '/' . $attach_path;
    }
}
function save_attach($url, $type)
{
    if (!is_url($url)) {
        return $url;
    }
    $urlinfo = pathinfo($url);
    $img_dir = C('pin_attach_path') . $type . '/';
    $date_dir = date('ym/d/'); 
    $save_path = $img_dir . $date_dir;
    if (!is_dir($save_path)) {
        if (!mkdir($save_path, 0777, true)) {
            exit('上传目录' . $save_path . '不存在');
        }
    } else {
        if (!is_writeable($save_path)) {
            exit('上传目录' . $save_path . '不可写');
        }
    }
    $file_name = uniqid() . '.' . $urlinfo['extension'];
    $file_content = file_get_contents($url);
    file_put_contents($img_dir . $date_dir . $file_name, $file_content);
    return $date_dir . $file_name;
}
function get_thumb($img, $suffix = '_thumb')
{
    if (false === strpos($img, 'http://')) {
        $ext = array_pop(explode('.', $img));
        $thumb = str_replace('.' . $ext, $suffix . '.' . $ext, $img);
    } else {
        if (false !== strpos($img, 'taobaocdn.com') || false !== strpos($img, 'taobao.com')) {
            switch ($suffix) {
                case '_s':
                    $thumb = $img . '_100x100.jpg';
                    break;
                case '_m':
                    $thumb = $img . '_210x1000.jpg';
                    break;
                case '_b':
                    $thumb = $img . '_480x480.jpg';
                    break;
            }
        }
    }
    return $thumb;
}
function object_to_array($obj)
{
    $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
    foreach ($_arr as $key => $val) {
        $val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
        $arr[$key] = $val;
    }
    return $arr;
}
function get_child_ids($mod, $id)
{
    $ids = '';
    $list = $mod->where("pid=$id")->select();
    if ($list) {
        foreach ($list as $key => $val) {
            $ids .= $val['id'] . ',';
            $ids .= get_child_ids($mod, $val['id']);
        }
    } else {
        return '';
    }
    return trim($ids, ',');
}
function get_cate_tree($mod, $id = 0)
{
    $where = array();
    if ($id > 0) {
        $where['id'] = $id;
    } else {
        $where['pid'] = 0;
    }
    $list = $mod->where($where)->select();
    foreach ($list as $key => $val) {
        $list[$key]['depth'] = 0;
        $list[$key]['child'] = get_child_tree($mod, $val['id'], 0);
    }
    return $list;
}
function get_child_tree($mod, $pid, $depth = 0)
{
    $where['pid'] = $pid;
    $list = $mod->where($where)->select();
    if ($list) {
        $depth++;
        foreach ($list as $key => $val) {
            $list[$key]['depth'] = $depth;
            $list[$key]['child'] = get_child_tree($mod, $val['id'], $depth);
        }
    } else {
        return false;
    }
    return $list;
}
function html_select($name, $list, $id = -1)
{
    if ($id == null) {
        $id = -1;
    }
    $html = "<select name='$name' id='$name'>";
    $html .= "<option value='-1'>请选择...</option>";
    foreach ($list as $key => $val) {
        $html .= "<option value='$key'";
        if ($key == $id) {
            $html .= " selected='selected'";
        }
        $html .= ">$val</option>";
    }
    $html .= "</select>";
    return $html;
}
function html_radio($name, $list, $id = -1)
{
    $html = "";
    if (is_array($list)) {
        foreach ($list as $key => $val) {
            $html .= "<span class='radio_item'><input type='radio' name='$name' value='$key'";
            if ($key == $id) {
                $html .= " checked='checked'";
            }
            $html .= "/>$val</span>";
        }
    } else {
        $html .= "<script type='text/javascript'>\$(function(){\$(\"input[name='$name'][value='$list']\").attr('checked','checked');});</script>";
    }
    return $html;
}
function topinyin($title)
{
    include(APP_PATH . 'Lib/Inslib/pinyin.class.php');
    $py = new cls_pinyin();
    return $py->tourl($title);
}
function get_index()
{
    $list = array();
    $list[9] = '0~9';
    for ($i = 65; $i < 91; $i++) {
        $list[chr($i)] = chr($i);
    }
    return $list;
}
function table($table)
{
    return C('DB_PREFIX') . $table;
}
function get_baoliao_type($cid)
{
    switch ($cid) {
        case 0:
            return '爆料';
        case 1:
            return '投稿';
        case 2:
            return '建议';
    }
}
function user_level($level)
{
    $img = D('score_level')->where(intval($level) . ">=val")->order("val desc")->getField('img');
    return "<img src='" . $img . "' width='120' height='14'/>";
}
function post_url($info)
{
    if (empty($info['post_key']) || C('') == 0) {
        return U('post/index', array('id' => $info['id']));
    } else {
        return U('post/index', array('post_key' => $info['post_key']));
    }
}
function parse_uri($url)
{
    $res = parse_url($url);
    $list = explode('&', $res['query']);
    foreach ($list as $item) {
        $kv = explode('=', $item);
        $res['_query'][$kv[0]] = $kv[1];
    }
    return $res;
}
function mall_url($mall_info)
{
    if (empty($mall_info['url']) || empty($mall_info['url_' . $mall_info['url']])) {
        return $mall_info['domain'];
    }
    if ($mall_info['url'] == 'yqf') {
        $urls = parse_uri($mall_info['url_' . $mall_info['url']]);
        $url = $urls['scheme'] . "://" . $urls['host'] . $urls['path'] . "?";
        foreach (array('s', 'w', 'c', 'i', 'l', 'e', 't') as $val) {
            if ($val == 'w') {
                $url .= "$val=" . C('pin_cps_' . $mall_info['url']) . "&";
            } else {
                $url .= "$val=" . $urls['_query'][$val] . "&";
            }
        }
        return trim($url, '&');
    } elseif ($mall_info['url'] == 'other') {
        return $mall_info['url_' . $mall_info['url']];
    } else {
        return $mall_info['url_' . $mall_info['url']] . '&sid=' . C('pin_cps_' . $mall_info['url']);
    }
}
function _exit($str)
{
    header("Content-Type: text/html; charset=utf-8");
    exit("<script>alert('$str');window.location.href='" . u('user/logout') . "';</script>");
}
function filter_data($data)
{
    foreach ($data as $key => $val) {
        $data[$key] = strip_tags($val);
    }
    return $data;
}
function get_jky_state($info)
{
    if ($info['stime'] <= time() && $info['etime'] >= time()) {
        return 'underway';
    }
    if ($info['stime'] > time()) {
        return 'notstart';
    }
    if ($info['etime'] < time()) {
        return 'end';
    }
}
function get_ret_url()
{
    $res = parse_url($_SERVER['REQUEST_URI']);
    $query_list = explode('&', $res['query']);
    foreach ($query_list as $key => $val) {
        $param = explode('=', $val);
        if ($param[0] == 'ret_url') {
            unset($query_list[$key]);
        }
    }
    $url = 'http://' . $_SERVER["HTTP_HOST"] . ($_SERVER["SERVER_PORT"] == 80 ? '' : ':' . $_SERVER["SERVER_PORT"]) . $res['path'] . '?' . implode('&', $query_list);
    return urlencode(rtrim($url, '?'));
}
function check_url($str)
{
    if (empty($str)) {
        return "#";
    }
    $info = parse_url(ltrim($str, '.'));
    empty($info['scheme']) && $info['scheme'] = "http";
    if (empty($info['host'])) {
        $host = $_SERVER['HTTP_HOST'];
    } else {
        $host = $info['host'];
    }
    if (isset($info['port'])) {
        $port = ':' . $info['port'];
    }
    $url = $info['scheme'] . "://" . $host . $port;
    if (empty($info['host'])) {
        $url .= rtrim(__ROOT__, '/');
    }
    $url .= '/' . ltrim($info['path'], '/');
    if (!empty($info['query'])) {
        $url .= '?' . $info['query'];
    }
    $url . $info['fragment'];
    return $url;
}
function get_site_logo($theme)
{
    $site_logo = C('pin_site_logo');
    return $site_logo[$theme];
}
function check_entry_permission($path)
{
    if (is_file($path)) {
        $path = dirname($path);
    }
    $test_file = rtrim($path, DIR_SEP) . "/__test__" . time() . '.txt';
    file_put_contents($test_file, "test");
    if (trim(file_get_contents($test_file) != "test")) {
        return array('status' => false, 'msg' => "$path 无法读写");
    }
    if (!unlink($test_file)) {
        return array('status' => false, 'msg' => "$path 无法删除");
    }
    return array('status' => true, 'msg' => "$path 可读可写");
}
function is_url($str)
{
    $res = parse_url(trim($str));
    return !empty($res['scheme']);
}
function post_go($info)
{
    if ($info['link_type'] == 'other') {
        return U('index/go', array('id' => $info['id']));
    } else {
        $res = parse_url($info['url']);
        if (in_array($res['host'], array('item.taobao.com', 'detail.tmall.com'))) {
            return U('public/go', array('type' => 'post', 'id' => $info['id']));
        }
        return $info['url'];
    }
}
function jky_go($info)
{
    $res = parse_url($info['url']);
    if (in_array($res['host'], array('item.taobao.com', 'detail.tmall.com'))) {
        return U('public/go', array('type' => 'jky', 'id' => $info['id']));
    }
    return $info['url'];
}
function parse_editor_img($info)
{
    $list = array(); 
    $c1 = preg_match_all('/<img\s.*?>/', $info, $m1); 
    for ($i = 0; $i < $c1; $i++) { 
        $c2 = preg_match_all('/(\w+)\s*=\s*(?:(?:(["\'])(.*?)(?=\2))|([^\/\s]*))/', $m1[0][$i],
            $m2); 
        for ($j = 0; $j < $c2; $j++) { 
            $list[$i][$m2[1][$j]] = !empty($m2[4][$j]) ? $m2[4][$j] : $m2[3][$j];
        }
    }
    $res = array();
    foreach ($list as $val) {
        if (is_url($val['src'])) continue;
        $res[] = ltrim($val['src'], '/');
    }
    return $res;
}
function parse_editor_info($str)
{
    include_once(APP_PATH . "Lib/Inslib/simple_html_dom.php");
    $html = str_get_html($str);
    if ($html) {
        $img_list = $html->find('img');
        foreach ($img_list as $k => $v) {
            $src = $html->find('img', $k)->src;
            if (strstr($src, 'data/upload/')) {
                $html->find('img', $k)->src = __SITEROOT__ . '/' . substr($src, strpos($src, "data/upload/"));
            }
        }
        return $html->innertext;
    } else {
        return $str;
    }
}
function item_rewrite($info, $m)
{
    if (!in_array($m, array('post', 'jky_item'))) {
        return;
    }
    $rewrite_type = C('rewrite_detail');
    $url = '';
    if ($m == 'post') {
        $dir = '/zhi';
        $a = 'index';
        $date = Date('/Y/m', $info['post_time']);
    } else {
        $dir = '/zhe';
        $a = 'detail';
        $date = Date('/Y/m', $info['stime']);
    }
    $suffix = '.html';
    switch ($rewrite_type) {
        case 'rewrite':
            $url = $dir . "/detail-$info[id]" . $suffix;
            break;
        case 'date':
            $url = $m == 'post' ? $date . "/detail-$info[id]" . $suffix : $date . "/item-$info[id]" . $suffix;
            break;
        case 'dir':
            $url = $dir . "/$info[id]";
            break;
        case 'pinyin':
            if (!empty($info['post_key'])) {
                $url = $dir . "-$info[post_key]" . $suffix;
                break;
            }
        case 'orig':
        default:
            $url = "/index.php?m=$m&a=$a&id=$info[id]";
    }
    return __ROOT__ . $url;
}
function zhi_footer()
{
    ?>    <!--[if lte IE 6]>
    <script src="__STATIC__/js/DD_belatedPNG_0.0.8a.js" type="text/javascript"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('div, ul, img, li, input , a,h3,span,em,i,dt,dd,button');
    </script>
    <![endif]-->
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=0"></script>
    <script type="text/javascript" id="bdshell_js"></script>
    <script type="text/javascript">
        document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date() / 3600000)
    </script>
    <?php 
    C('pin_cps_yqf_js');
}
function get_float_digit($val)
{
    return str_pad(round($val - intval($val), 2) * 100, 2, '0', STR_PAD_LEFT);
}
function yesno_where($field)
{
    if (!isset($_REQUEST[$field])) {
        return "";
    }
    $val = intval($_REQUEST[$field]);
    if (in_array($val, array(0, 1))) {
        return " and $field=$val ";
    }
    return "";
}
function js_toggle($val, $field)
{
    $html = '<img data-tdtype="toggle" data-id="{$val.id}" data-field="is_recommend"
        data-value="{$val.is_recommend}" 
        src="__TMPL__public/images/toggle_<if condition="$val.is_recommend eq 0">disabled<else/>enabled</if>.gif" />';
}