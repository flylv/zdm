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
class mailer
{
    private static $mailer_server = array();
    public $mailer;
    public $debug = false;
    public $timeout = 30;
    public $errors = array();
    public function __construct($mailer_gw) {
        vendor("PHPMailer.class#phpmailer");
        $this->mailer = new PHPMailer();
        $this->mailer->SetLanguage('zh_cn');
        if (!isset($mailer_gw['Mailer']) || $mailer_gw['Mailer'] == 'mail') {
            $this->mailer->IsMail();
        } else {
            $mailer_gw = $this->initGw($mailer_gw);
            foreach ($mailer_gw as $key=>$val) {
                $this->mailer->$key = $val;
            }
        }
    }
    public function get_instance($name = '') {
        if (!isset(self::$mailer_server[$name])) {
            $mail_config = !empty($name) ? C('pin_mail_server_'.$name) : C('pin_mail_server');
            $mailer_gw = array(
                'Mailer'=>$mail_config['mode'],
                'From' => $mail_config['from'],
                'FromName' => $mail_config['from_name'],
                'Host' => $mail_config['host'],
                'Port' => $mail_config['port'],
                'Username' => $mail_config['auth_username'],
                'Password' => $mail_config['auth_password'],
            );
            return self::$mailer_server[$name] = new self($mailer_gw);
        } else {
            return self::$mailer_server[$name];
        }
    }
    public function send($toaddress, $subject, $body, $charset='utf-8', $is_html=true, $attachs = false) {
        $this->mailer->CharSet   = $charset;
        $this->mailer->IsHTML($is_html);
        $this->mailer->Subject   = $subject;
        $this->mailer->Body      = $body;
        $this->mailer->timeout = $this->timeout;
        $this->mailer->SMTPDebug = $this->debug;
        if ($attachs) {
            $this->mailer->ClearAttachments();
            if (is_array($attachs)) {
                foreach ($attachs as $name=>$file) {
                    $this->mailer->AddAttachment($file, $name);
                }
            } else {
                $this->mailer->AddAttachment($attachs, $attachs);
            }
        }
        $this->mailer->ClearAddresses(); 
        if (is_array($toaddress)) {
            foreach ($toaddress as $name=>$mail) {
                $this->mailer->AddAddress($mail, $name);
            }
        } else {
            $this->mailer->AddAddress($toaddress);
        }
        $send_result = $this->mailer->Send();
        $this->errors[] = $this->mailer->ErrorInfo;
        return $send_result;
    }
    private function initGw($mailer_gw) {
        $init_gw = array(
            'Mailer'=>'mail',
            'From' => '',
            'FromName' => 'ZhiPHP.com',
            'Host' => 'localhost',
            'Port' => '25',
            'SMTPAuth' => true,
            'Username' => '',
            'Password' => '',
            'Timeout' => 30,
            'SMTPDebug' => false,
        );
        if (is_array($mailer_gw)) {
            $mailer_gw = array_intersect_key($mailer_gw, $init_gw);
            return array_merge($init_gw, $mailer_gw);
        } else {
            return false;
        }
    }
}