<?php if (!defined('THINK_PATH')) exit();?><!doctype html><html><head><meta charset="utf-8" /><link href="__TMPL__public/css/style.css" rel="stylesheet"/><title>管理中心</title></head><body scroll="no" class="login_body"><table class="login_table"><tbody><tr><td class="logo"><h1>管理中心</h1></td><td class="loginform"><form action="<?php echo U('index/login');?>" method="post" id="myform"><table><tr><th><?php echo (L("login_username")); ?>：</th><td><input class="text user" type="text" name="username" id="username" /></td></tr><tr><th><?php echo (L("login_password")); ?>：</th><td><input class="text pass" type="password" name="password" id="password" /></td></tr><?php if(C('pin_captcha_status')): ?><tr><th><?php echo (L("verify_code")); ?>：</th><td><input class="text vifity" type="text" name="verify_code" id="verify_code" /><img title="<?php echo (L("refresh_verify_code")); ?>" class="verify_img" src="<?php echo U('index/verify_code', array('t'=>time()));?>" /></td></tr><?php endif; ?><tr><th></th><td><input type="submit" name="do" value=" " class="login_btn" /></td></tr></table><input type="hidden" name="ret_url" value=""/></form></td></tr></tbody></table><script language="javascript" type="text/javascript" src="__STATIC__/js/jquery/jquery.js"></script><script>
$(function(){
    if(self != top){
        top.location = self.location;
    }
    if(window.location.href!="<?php echo U('index/login');?>"){
        $('input[name="ret_url"]').val(window.location.href);
    }
    $(".verify_img").click(function(){
        var timenow = new Date().getTime();
        $(this).attr("src","<?php echo U('index/verify_code');?>&"+timenow)
    });
});
</script></body></html>