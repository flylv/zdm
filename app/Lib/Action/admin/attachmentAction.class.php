<?php 
/**
* ZhePHP 值得买模式的海淘网站程序
* ====================================================================
* 版权所有 杭州言商网络有限公司，并保留所有权利。
* ====================================================================
* Author: brivio <brivio@qq.com>
* 授权技术支持: 1142503300@qq.com
*/
class attachmentAction extends backendAction
{
    protected function _upload_init($upload) {
        $file_type = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
        $ext_arr = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
            'flash' => array('swf', 'flv'),
            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
            'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
        );
        $allow_exts_conf = explode(',', C('pin_attr_allow_exts')); 
        $allow_max = C('pin_attr_allow_size'); 
        $allow_exts = array_intersect($ext_arr[$file_type], $allow_exts_conf);
        $allow_max && $upload->maxSize = $allow_max * 1024;   
        $allow_exts && $upload->allowExts = $allow_exts;  
        $upload->savePath =  './data/upload/editer/' . $file_type . '/';
        $upload->saveRule = 'uniqid';
        $upload->autoSub = true;
        $upload->subType = 'date';
        $upload->dateFormat = 'Y/m/d/';
        return $upload;
    }
    public function editer_upload() {
        $file_type = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
        $result = $this->_upload($_FILES['imgFile'],'',array('remove_origin'=>true,'width'=>'650','height'=>'1200'));
        if ($result['error']) {
            echo json_encode(array('error'=>1, 'message'=>$result['info']));
        } else {
            $savename=$result['info'][0]['savename'];
            $extension=$result['info'][0]['extension'];
            echo json_encode(array('error'=>0, 'url'=>'./data/upload/editer/' . $file_type . '/' 
                .substr($savename,0,strripos($savename,$extension)-1).'_thumb.'.$extension));
        }
        exit;
    }
    public function editer_manager() {
        $root_path = './data/upload/editer/';
        $root_url = './data/upload/editer/';
        $ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
        $dir_name = empty($_GET['dir']) ? '' : trim($_GET['dir']);
        if (!in_array($dir_name, array('', 'image', 'flash', 'media', 'file'))) {
            echo "Invalid Directory name.";
            exit;
        }
        if ($dir_name !== '' && $dir_name != 'file') {
            $root_path .= $dir_name . "/";
            $root_url .= $dir_name . "/";
            if (!file_exists($root_path)) {
		      mkdir($root_path);
            }
        }
        if (empty($_GET['path'])) {
            $current_path = realpath($root_path) . '/';
            $current_url = $root_url;
            $current_dir_path = '';
            $moveup_dir_path = '';
        } else {
            $current_path = realpath($root_path) . '/' . $_GET['path'];
            $current_url = $root_url . $_GET['path'];
            $current_dir_path = $_GET['path'];
            $moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
        }
        echo realpath($root_path);
        $this->_order = empty($_GET['order']) ? 'name' : strtolower($_GET['order']);
        if (preg_match('/\.\./', $current_path)) {
            echo 'Access is not allowed.';
            exit;
        }
        if (!preg_match('/\/$/', $current_path)) {
            echo 'Parameter is not valid.';
            exit;
        }
        if (!file_exists($current_path) || !is_dir($current_path)) {
            echo 'Directory does not exist.';
            exit;
        }
        $file_list = array();
        if ($handle = opendir($current_path)) {
            $i = 0;
            while (false !== ($filename = readdir($handle))) {
		if ($filename{0} == '.') continue;
		$file = $current_path . $filename;
		if (is_dir($file)) {
			$file_list[$i]['is_dir'] = true; 
			$file_list[$i]['has_file'] = (count(scandir($file)) > 2); 
			$file_list[$i]['filesize'] = 0; 
			$file_list[$i]['is_photo'] = false; 
			$file_list[$i]['filetype'] = ''; 
		} else {
			$file_list[$i]['is_dir'] = false;
			$file_list[$i]['has_file'] = false;
			$file_list[$i]['filesize'] = filesize($file);
			$file_list[$i]['dir_path'] = '';
			$file_ext = strtolower(array_pop(explode('.', trim($file))));
			$file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
			$file_list[$i]['filetype'] = $file_ext;
		}
		$file_list[$i]['filename'] = $filename; 
		$file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); 
		$i++;
            }
            closedir($handle);
        }
        usort($file_list, array($this, '_cmp_func'));
        $result = array();
        $result['moveup_dir_path'] = $moveup_dir_path;
        $result['current_dir_path'] = $current_dir_path;
        $result['current_url'] = $current_url;
        $result['total_count'] = count($file_list);
        $result['file_list'] = $file_list;
        header('Content-type: application/json; charset=UTF-8');
        echo json_encode($result);
        exit;
    }
    private function _cmp_func($a, $b) {
        if ($a['is_dir'] && !$b['is_dir']) {
            return -1;
        } else if (!$a['is_dir'] && $b['is_dir']) {
            return 1;
        } else {
            if ($this->_order == 'size') {
                if ($a['filesize'] > $b['filesize']) {
                    return 1;
                } else if ($a['filesize'] < $b['filesize']) {
                    return -1;
                } else {
                    return 0;
                }
            } else if ($this->_order == 'type') {
                return strcmp($a['filetype'], $b['filetype']);
            } else {
                return strcmp($a['filename'], $b['filename']);
            }
	}
    }
}