

$(function() {
    $('.showtext_body').show();
    if (def.m != 'post') {
        $('.showtext_body img').hide();
    }
    $('.J_worth a').live('click', function() {
        var $this = $(this);
        var id = parseInt($this.attr('data-id'));
        var type = $this.attr('data-type');
        if (cookie_exist('rate_ids', id)) {
            $.zhiphp._tip({
                content: '您已经评过分',
                status: false
            });
            return;
        }
        $.post('index.php?m=post&a=rate', {
            'type': type,
            'id': id
        }, function(data) {
            $this.text(parseInt($this.text()) + 1);
            $('#J_rate_result_' + id).html(data.data.total + "位网友中的 <i>" + data.data.valid + "</i> 位认为值得买！");
        }, 'json');
    });
    $('.JKY_worth a').live('click', function() {
        var $this = $(this);
        var id = parseInt($this.attr('data-id'));
        var type = $this.attr('data-type');
        if (cookie_exist('rate_ids', id)) {
            $.zhiphp._tip({
                content: '您已经评过分',
                status: false
            });
            return;
        }
        $.post('index.php?m=post&a=rate', {
            'type': type,
            'id': id
        }, function(data) {
            $this.children('span').text(parseInt($this.children('span').text()) + 1);
            return;
        }, 'json');
    });
    $('.J_scrollto').live('click', function() {
        $.scrollTo('#' + $(this).attr('data-id'), 100, {
            offset: {
                top: -40
            }
        });
    });

    $(".login_btn").mouseover(function() {
        $('ul.loginsub').css('visibility', 'visible');
    });
    $(".login_btn").mouseout(function() {
        $('ul.loginsub').css('visibility', 'hidden');
    });
    $("ul.loginsub").mouseover(function() {
        $(this).css('visibility', 'visible');
    });
    $("ul.loginsub").mouseout(function() {
        $(this).css('visibility', 'hidden');
    });

    /*页头 特色推荐 子菜单*/
    $('.nav .tese').hover(function() {
        $('.navicon', this).css({
            'background-position': '-100px -68px'
        });
        $('.sub_menu').show();
    }, function() {
        $('.navicon', this).css({
            'background-position': '-100px -16px'
        });
        $('.sub_menu').hide();
    });

    init_input();
    $('.J_fav_item').hover(function() {
        $('.J_panel', this).show();
    }, function() {
        $('.J_panel', this).hide();
    });
    $('.J_panel .J_del').live('click', function() {
        var id = $(this).attr('data-id');
        $.post('index.php?m=user&a=favs', {
            act: 'del',
            id: id
        }, function(data) {
            $.zhiphp._tip({
                content: data.msg,
                status: data.status == 1
            });
            if (data.status == 1) {
                $('#J_fav_item_' + id).remove();
            }
        }, 'json');
    });
    /*js 添加到收藏夹, 函数 AddFavorite(兼容IE,FF,OP)*/
    $('.J_add_bookmark').click(function(){
        AddFavorite(window.location,def.site_name);
    });

    $('.J_get_anhao').click(function(){
        if(check_login()){
            $.post(PINER.root + '/?m=jky_item&a=anhao',{id:$(this).attr('data-id')}, function(result){
                $.dialog({title:'暗号领取成功，使用有效期三天！', content:result, padding:'', fixed:true,lock:true});
            });
        }
        return false;
    });
    $('.J_remain_time').each(function(){
        $this=$(this);
        var time=parseInt($this.attr('data-time'));
        var intervalId=setInterval(function(){
            var html="";
            if(time<=0){
                html="已经结束";
                clearInterval(intervalId);
            }else{
                if((day=parseInt(time/(3600*24)))>0){
                    html+= '<i class="day num">'+day+'</i>天';
                }
                if((hour=parseInt((time-day*3600*24)/3600))>0){
                    html+= '<i class="hour num">'+hour+'</i>小时';
                }
                if((minute=parseInt((time-day*3600*24-hour*3600)/60))>0){
                    html+='<i class="min num">'+minute+'</i>分';
                }
                html+='<i class="sencond num">'+parseInt(time-day*3600*24-hour*3600-minute*60)+'</i><i class="ms"></i>秒';
            }
            $this.html(html);
            time--;
        },1000);
    });
});
/**
 * @name 前台UI&TOOLS
 * @author andery@foxmail.com
 * @url http://www.zhiphp.com
 */
;(function($){
    $.zhiphp.init = function(){
        $.zhiphp.ui.init();
        $.zhiphp.tool.sendmail();
        $.zhiphp.tool.msgtip();
    }
    $.zhiphp.ui = {
        init: function() {
            $.zhiphp.ui.input_init();
            $.zhiphp.ui.fixed_nav();
            $.zhiphp.ui.return_top();
            $.zhiphp.ui.drop_down();
            $.zhiphp.ui.decode_img($(document));
            $.zhiphp.ui.qiandao();
            $.zhiphp.ui.captcha();
        },
        lazyload: function() {
            $('img').lazyload();
        },
        //导航浮动
        fixed_nav: function() {
            if(!$("#J_m_nav")[0]) return !1;
            var nt = !1;
            $(window).bind("scroll", function() {
                var st = $(document).scrollTop();
                nt = nt ? nt : $("#J_m_nav").offset().top;
                if (nt < st) {
                    $("#J_m_nav").addClass("nav_fixed");
                    $('#J_m_head').css('margin-bottom', '50px');
                } else {
                    $("#J_m_nav").removeClass("nav_fixed");
                    $('#J_m_head').css('margin-bottom', '10px');
                }
            });
        },
        //返回顶部
        return_top: function() {
            $('#J_returntop')[0] && $('#J_returntop').returntop();
        },
        //下拉菜单
        drop_down: function() {
            var h = null,
                onshow = false;
            $('.J_down_menu_box').hover(
                function(){
                    var self = $(this);
                    if (onshow) clearTimeout(h);
                    if (!self.find('.J_down_menu').is(":animated") && !onshow) {
                        h = setTimeout(function(){
                            self.addClass('down_hover').find('.J_down_menu').slideDown(200);
                            onshow = true;
                        }, 200);
                    }
                },
                function(){
                    var self = $(this);
                    if (!onshow) clearTimeout(h);
                    h = setTimeout(function(){
                        self.removeClass('down_hover').find('.J_down_menu').slideUp(200);
                        onshow = false;
                    }, 200);
                    
                }
            );
        },
        //刷新验证码
        captcha: function() {
            $('#J_captcha_img').click(function(){
                var timenow = new Date().getTime(),
                    url = $(this).attr('data-url').replace(/js_rand/g,timenow);
                $(this).attr("src", url);
            });
            $('#J_captcha_change').click(function(){
                $('#J_captcha_img').trigger('click');
            });
        },
        input_init: function() {
            $('input[def-val],textarea[def-val]').live('focus', function(){
                var self = $(this);
                $.trim(self.val()) == $.trim(self.attr('def-val')) && self.val("");
                self.css("color", "#484848")
            });
            $('input[def-val],textarea[def-val]').live('blur', function(){
                var self = $(this);
                $.trim(self.val()) == "" && (self.val(self.attr('def-val')), self.css("color", "#999999"));
            });
        },
        decode_img: function(context) {
            $('.J_decode_img', context).each(function(){
                var uri = $(this).attr('data-uri')||"";
                $(this).attr('src', $.zhiphp.util.base64_decode(uri));
            });
        },
        qiandao: function(){
            $('.J_qiandao').live('click', function(){
                $.getJSON(PINER.root + '/?m=user&a=qiandao', function(result){
                    if(result.status == 0){
                        $.zhiphp._tip({
                			content:result.msg,
                			status: 0,
                			url: [{
                				url: 'index.php?m=user&a=register',
                				title: '注册'
                			},
                			{
                				url: 'index.php?m=user&a=login',
                				title: '登录'
                			}]
                		});
                    }else{
                        $.zhiphp._tip({content:result.msg, status:1});
                    }
                });
            });
        }
    },
    $.zhiphp.tool = {
        //发送邮件
        sendmail: function() {
            return PINER.async_sendmail ? ($.get(PINER.root + '/?a=send_mail'), !0) : !1;
        },
        //信息提示
        msgtip: function() {
            return;
            if(PINER.uid){
                var is_update = !1;
                var update = function() {
                    is_update = !0;
                    $.getJSON(PINER.root + '/?m=user&a=msgtip', function(result){
                        if(result.status == 1){
                            var fans = parseInt(result.data.fans),
                                atme = parseInt(result.data.atme),
                                msg = parseInt(result.data.msg),
                                system = parseInt(result.data.system),
                                msgtotal = fans + atme + msg + system;
                            fans > 0 && $('#J_fans').html('(' + fans + ')');
                            atme > 0 && $('#J_atme').html('(' + atme + ')');
                            msg > 0 && $('#J_msg').html('(' + msg + ')');
                            system > 0 && $('#J_system').html('(' + system + ')');
                            msgtotal > 0 && $('#J_msgtip').html('(' + msgtotal + ')');
                            is_update = !1;
                            setTimeout(function(){update()}, 5E3);
                        }
                    });
                };
                !is_update && update();
            }
        }
    }
    $.zhiphp.init();
})(jQuery);