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
class backupAction extends backendAction
{
    public $backup_path = ''; 
    public $backup_name = ''; 
    public $offset = '500'; 
    public $dump_sql = '';
    public function _initialize()
    {
        parent::_initialize();
        $this->backup_path = 'backup/';        
        $this->_database_mod = new Model();
    }
    public function index()
    {
        if (IS_POST || isset($_GET['dosubmit']))
        {
            if (isset($_GET['type']) && $_GET['type'] == 'url')
            {
                $sizelimit = isset($_GET['sizelimit']) && abs(intval($_GET['sizelimit'])) ? abs(intval
                    ($_GET['sizelimit'])) : $this->error(L('input') . L('sizelimit'));
                $this->backup_name = isset($_GET['backup_name']) && trim($_GET['backup_name']) ?
                    trim($_GET['backup_name']) : $this->error(L('input') . L('backup_name'));
                $vol = $this->_get_vol();
                $vol++;
            } else
            {
                $sizelimit = isset($_POST['sizelimit']) && abs(intval($_POST['sizelimit'])) ?
                    abs(intval($_POST['sizelimit'])) : $this->error(L('input') . L('sizelimit'));
                $this->backup_name = isset($_POST['backup_name']) && trim($_POST['backup_name']) ?
                    trim($_POST['backup_name']) : $this->error(L('input') . L('backup_name'));
                $backup_tables = isset($_POST['backup_tables']) && $_POST['backup_tables'] ? $_POST['backup_tables'] :
                    $this->error(L('plsease_select') . L('backup_tables'));
                if (is_dir(ZHI_DATA_PATH . $this->backup_path . $this->backup_name))
                {
                    $this->error(L('backup_name') . L('exists'));
                }
                mkdir(ZHI_DATA_PATH . $this->backup_path . $this->backup_name);
                if (!is_file(ZHI_DATA_PATH . $this->backup_path . $this->backup_name .
                    '/tbl_queue.log'))
                {
                    $this->_put_tbl_queue($backup_tables);
                }
                $vol = 1;
            }
            $tables = $this->_dump_queue($vol, $sizelimit * 1024);
            if ($tables === false)
            {
                $this->error(L('invalid_queue_file'));
            }
            $this->_deal_result($tables, $vol, $sizelimit);
            exit();
        }
        $allow_max_size = $this->_return_bytes(@ini_get('upload_max_filesize'));
        $this->assign('sizelimit', 10*1024*1024 / 1024);
        $this->assign('backup_name', $this->_make_backup_name());
        $this->assign('tables', D()->db()->getTables()); 
        $this->display();
    }
    public function restore()
    {
        $this->assign('backups', $this->_get_backups());
        $this->assign('table_list', true);
        $this->display();
    }
    public function import()
    {
        $backup_name = isset($_GET['backup']) && trim($_GET['backup']) ? trim($_GET['backup']) :
            $this->error(L('plsease_select') . L('backup_name'));
        $vol = empty($_GET['vol']) ? 1 : intval($_GET['vol']);
        $this->backup_name = $backup_name;
        $backups = $this->_get_vols($this->backup_name);
        $backup = isset($backups[$vol]) && $backups[$vol] ? $backups[$vol] : $this->
            error(L('no_such_file'));
        if ($this->_import_vol($backup['file']))
        {
            if ($vol < count($backups))
            {
                $vol++;
                $link = 'index.php?g=admin&m=' . MODULE_NAME . '&a=import&vol=' . $vol .
                    '&backup=' . urlencode($this->backup_name);
                $this->success(sprintf(L('bakup_import_succ'), $vol - 1), $link);
            } else
            {
                $this->success(L('restore_success'), 'index.php?g=admin&m=' . MODULE_NAME .
                    '&a=restore');
            }
        }
    }
    private function _import_vol($sql_file_name)
    {
        $sql_file = ZHI_DATA_PATH . $this->backup_path . $this->backup_name . '/' . $sql_file_name;
        $sql_str = file($sql_file);
        $sql_str = str_replace("\r", '', implode('', $sql_str));
        $ret = explode(";\n", $sql_str);
        $ret_count = count($ret);
        for ($i = 0; $i < $ret_count; $i++)
        {
            $ret[$i] = trim($ret[$i], " \r\n;"); 
            if (!empty($ret[$i]))
            {
                $this->_database_mod->query($ret[$i]);
            }
        }
        return true;
    }
    public function del_backup()
    {
        if ((!isset($_GET['backup']) || empty($_GET['backup'])) && (!isset($_POST['backup']) ||
            empty($_POST['backup'])))
        {
            $this->error(L('illegal_parameters'));
        } 
        import('@.ORG.Dir'); 
        $dir=new Dir();
        $dir->delDir(ZHI_DATA_PATH . $this->backup_path . $_GET['backup'].'/');             
        $this->success(L('operation_success'));
    }
    public function download()
    {
        $backup_name = isset($_GET['backup']) && trim($_GET['backup']) ? trim($_GET['backup']) :
            $this->error(L('plsease_select') . L('backup_name'));
        $file = isset($_GET['file']) && trim($_GET['file']) ? trim($_GET['file']) : $this->
            error(L('plsease_select') . L('backup_file'));
        $sql_file = ZHI_DATA_PATH . $this->backup_path . $backup_name . '/' . $file;
        if (file_exists($sql_file))
        {
            header('Content-type: application/unknown');
            header('Content-Disposition: attachment; filename="' . $file . '"');
            header("Content-Length: " . filesize($sql_file) . "; ");
            readfile($sql_file);
        } else
        {
            $this->error(L('no_such_file'));
        }
    }
    private function _get_vols($backup_name)
    {
        $vols = array(); 
        $bytes = 0;
        $vol_path = ZHI_DATA_PATH . $this->backup_path . $backup_name . '/';
        if (is_dir($vol_path))
        {
            if ($handle = opendir($vol_path))
            {
                $vol = array();
                while (($file = readdir($handle)) !== false)
                {
                    $file_info = pathinfo($vol_path . $file);
                    if ($file_info['extension'] == 'sql')
                    {
                        $vol = $this->_get_head($vol_path . $file);
                        $vol['file'] = $file;
                        $bytes += filesize($vol_path . $file);
                        $vol['size'] = ceil(10 * filesize($vol_path . $file) / 1024) / 10;
                        $vol['total_size'] = ceil(10 * $bytes / 1024) / 10;
                        $vols[$vol['vol']] = $vol;
                    }
                }
            }
        }
        ksort($vols);
        return $vols;
    }
    private function _get_backups()
    {
        $backups = array(); 
        if (is_dir(ZHI_DATA_PATH . $this->backup_path))
        {
            if ($handle = opendir(ZHI_DATA_PATH . $this->backup_path))
            {
                while (($file = readdir($handle)) !== false)
                {
                    if ($file{0} != '.' && filetype(ZHI_DATA_PATH . $this->backup_path . $file) == 'dir')
                    {
                        $backup['name'] = $file;
                        $backup['date'] = filemtime(ZHI_DATA_PATH . $this->backup_path . $file) - date('Z');
                        $backup['date_str'] = date('Y-m-d H:i:s', $backup['date']);
                        $backup['vols'] = $this->_get_vols($file);
                        $end_vol = end($backup['vols']);
                        $backup['total_size'] =round($this->_get_dir_size(ZHI_DATA_PATH . $this->backup_path . $file)/1024,2);
                        $backups[] = $backup;
                    }
                }
            }
        }
        ksort($backups);        
        return $backups;
    }
    private function _deal_result($tables, $vol, $sizelimit)
    {
        $this->_sava_sql($vol);
        if (empty($tables))
        {
            $this->_drop_tbl_queue();
            $vol != 1 && $this->_drop_vol(); 
            $this->success(L('bakup_succ'), 'index.php?g=admin&m=' . MODULE_NAME .
                '&a=restore');
        } else
        {
            $this->_set_vol($vol); 
            $link = 'index.php?g=admin&m=' . MODULE_NAME .
                '&a=index&dosubmit=1&type=url&backup_name=' . $this->backup_name . '&sizelimit=' .
                $sizelimit;
            $this->success(sprintf(L('bakup_write_succ'), $vol), $link);
        }
    }
    private function _dump_queue($vol, $sizelimit)
    {
        $queue_tables = $this->_get_tbl_queue();
        if (!$queue_tables)
        {
            return false;
        }
        $this->dump_sql = $this->_make_head($vol);
        foreach ($queue_tables as $table => $pos)
        {
            if ($pos == '-1')
            {
                $table_df = $this->_get_table_df($table);
                if (strlen($this->dump_sql) + strlen($table_df) > $sizelimit)
                {
                    break;
                } else
                {
                    $this->dump_sql .= $table_df;
                    $pos = 0;
                }
            }
            $post_pos = $this->_get_table_data($table, $pos, $sizelimit);
            if ($post_pos == -1)
            {
                unset($queue_tables[$table]); 
            } else
            {
                $queue_tables[$table] = $post_pos;
                break;
            }
        }
        $this->_put_tbl_queue($queue_tables);
        return $queue_tables;
    }
    private function _get_table_df($table)
    {
        $table_df = "DROP TABLE IF EXISTS `$table`;\n";
        $tmp_sql = $this->_database_mod->query("SHOW CREATE TABLE `$table` ");
        $tmp_sql = $tmp_sql['0']['Create Table'];
        $tmp_sql = substr($tmp_sql, 0, strrpos($tmp_sql, ")") + 1); 
        $tmp_sql = str_replace("\n", "\r\n", $tmp_sql);
        $table_df .= $tmp_sql . " COLLATE='utf8_general_ci' ENGINE=MyISAM;\r\n";
        return $table_df;
    }
    private function _get_table_data($table, $pos, $sizelimit)
    {
        $post_pos = $pos;
        $total = $this->_database_mod->query("SELECT COUNT(*) FROM $table"); 
        $total = $total[0]['COUNT(*)'];
        if ($total == 0 || $pos >= $total)
        {
            return - 1;
        }
        $cycle_time = ceil(($total - $pos) / $this->offset); 
        for ($i = 0; $i < $cycle_time; $i++){
            $data = $this->_database_mod->query("SELECT * FROM $table LIMIT " .($this->offset * $i + $pos) . ', ' . $this->offset);
            $data_count = count($data);
            $fields = array_keys($data[0]);
            $start_sql = "INSERT INTO $table ( `" . implode("`, `", $fields) . "` ) VALUES ";
            for ($j = 0; $j < $data_count; $j++)
            {
                $record = array_map(array($this, 'dump_escape_string'), $data[$j]); 
                $tmp_dump_sql = $start_sql . " (" . $this->_implode_insert_values($record) . ");\r\n";
                if (strlen($this->dump_sql) + strlen($tmp_dump_sql) > $sizelimit - 32)
                {
                    return $post_pos;
                } else
                {
                    $this->dump_sql .= $tmp_dump_sql;
                    $post_pos++;
                }
            }
        }
        return - 1;
    }
    public function dump_escape_string($str){
        return str_replace(array("\r","\n"),array('\r','\n'),addslashes($str));
    }
    private function _make_head($vol)
    {
        $date = date('Y-m-d H:i:s', time());
        $head = "-- TuanPhp SQL Dump Program\r\n" . "-- \r\n" . "-- DATE : " . $date . "\r\n" .
            "-- Vol : " . $vol . "\r\n";
        return $head;
    }
    private function _get_head($path)
    {
        $fp = fopen($path, 'rb');
        $str = fread($fp, 90);
        fclose($fp);
        $arr = explode("\n", $str);
        foreach ($arr as $val)
        {
            $pos = strpos($val, ':');
            if ($pos > 0)
            {
                $type = trim(substr($val, 0, $pos), "-\n\r\t ");
                $value = trim(substr($val, $pos + 1), "/\n\r\t ");
                if ($type == 'DATE')
                {
                    $sql_info['date'] = $value;
                } elseif ($type == 'Vol')
                {
                    $sql_info['vol'] = $value;
                }
            }
        }
        return $sql_info;
    }
    private function _make_backup_name()
    {
        $backup_path = ZHI_DATA_PATH . '/data/backup/';
        $today = date('Ymd_', time());
        $today_backup = array(); 
        if (is_dir($backup_path))
        {
            if ($handle = opendir($backup_path))
            {
                while (($file = readdir($handle)) !== false)
                {
                    if ($file{0} != '.' && filetype($backup_path . $file) == 'dir')
                    {
                        if (strpos($file, $today) === 0)
                        {
                            $no = intval(str_replace($today, '', $file)); 
                            if ($no)
                            {
                                $today_backup[] = $no;
                            }
                        }
                    }
                }
            }
        }
        if ($today_backup)
        {
            $today .= max($today_backup) + 1;
        } else
        {
            $today .= '1';
        }
        return $today;
    }
    private function _put_tbl_queue($tables)
    {
        return file_put_contents(ZHI_DATA_PATH . $this->backup_path . $this->backup_name .
            '/tbl_queue.log', "<?php return " . var_export($tables, true) . ";\n?>");
    }
    private function _get_tbl_queue()
    {
        $tbl_queue_file = ZHI_DATA_PATH . $this->backup_path . $this->backup_name .
            '/tbl_queue.log';
        if (!is_file($tbl_queue_file))
        {
            return false;
        } else
        {
            return include ($tbl_queue_file);
        }
    }
    private function _drop_tbl_queue()
    {
        $tbl_queue_file = ZHI_DATA_PATH . $this->backup_path . $this->backup_name .
            '/tbl_queue.log';
        return @unlink($tbl_queue_file);
    }
    private function _set_vol($vol)
    {
        $log_file = ZHI_DATA_PATH . $this->backup_path . $this->backup_name . '/vol.log';
        return file_put_contents($log_file, $vol);
    }
    private function _get_vol()
    {
        $log_file = ZHI_DATA_PATH . $this->backup_path . $this->backup_name . '/vol.log';
        if (!is_file($log_file))
        {
            return 0;
        }
        $content = file_get_contents($log_file);
        return is_numeric($content) ? intval($content) : false;
    }
    private function _drop_vol()
    {
        $log_file = ZHI_DATA_PATH . $this->backup_path . $this->backup_name . '/vol.log';
        return @unlink($log_file);
    }
    private function _sava_sql($vol)
    {
        return file_put_contents(ZHI_DATA_PATH . $this->backup_path . $this->backup_name .
            '/' . $this->backup_name . '_' . $vol . '.sql', $this->dump_sql);
    }
    private function _implode_insert_values($values)
    {
        $str = '';
        $values = array_values($values);
        foreach ($values as $k => $v)
        {
            $v = ($v === null) ? 'null' : "'" . $v . "'";
            $str = ($k == 0) ? $str . $v : $str . ',' . $v;
        }
        return $str;
    }
    private function _return_bytes($val)
    {
        $val = trim($val);
        $last = strtolower($val[strlen($val) - 1]);
        switch ($last)
        {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $val;
    }
    function _get_dir_size($dir)
    {
        $handle = opendir($dir);
        while (false !== ($FolderOrFile = readdir($handle)))
        {
            if ($FolderOrFile != "." && $FolderOrFile != "..")
            {
                if (is_dir("$dir/$FolderOrFile"))
                {
                    $sizeResult += getDirSize("$dir/$FolderOrFile");
                } else
                {
                    $sizeResult += filesize("$dir/$FolderOrFile");
                }
            }
        }
        closedir($handle);
        return $sizeResult;
    }
}
?>