var DATE_PICKER_OPT={
    showWeek: true,
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd',
    showButtonPanel: true,
    timeFormat: 'HH:mm:ss',
    yearRange:'-100:+10',
    stepHour: 1,
    stepMinute: 1,
    stepSecond: 1,
    timeOnlyTitle: '1',
    timeText: '时间',
    hourText: '小时',
    minuteText: '分钟',
    secondText: '秒',
    currentText: '现在',
    closeText: '关闭'
};

function init_input() {
	$('.text,.J_tip').each(function() {	   
		$this = $(this);
        if(!empty($(this).val()))return;
        
		var tag = $this[0].tagName;
		if (tag == 'INPUT') {
			$this.val($this.attr('data-default'));
		} else if (tag == 'TEXTAREA') {
			$this.html($this.attr('data-default'));
		}
        $this.css('color','#666');
	}).click(function() {
		if ($(this).attr('data-default') == $(this).val()) {
			$(this).val('');
            $this.css('color','#000');
		}
	}).blur(function() {
		$this = $(this);
		if ($this.attr('data-default') == $this.val() || $.trim($this.val()) == '') {
			$this.val($this.attr('data-default'));
            $this.css('color','#666');
		}
	});
}

function checkbox(name, val) {
	for (var i = 0; i < val.length; i++) {
		$('input[name="' + name + '"][value="' + val[i] + '"]').attr('checked', true);
	}
}

function check_login(content) {
	if (!def.is_login) {
		$.zhiphp._tip({
			content: content || '请登录!',
			status: false,
			url: [{
				url: 'index.php?m=user&a=register',
				title: '注册'
			},
			{
				url: 'index.php?m=user&a=login',
				title: '登录'
			}]
		});
	}
	return def.is_login;
}

function cookie_exist(name, v) {
	var val = $.trim($.cookie(name));
	var ids = val.split(",");
	for (i in ids) {
		if (v == parseInt(ids[i])) {
			return true;
		}
	}
	val += "," + v;
	$.cookie(name, val);
	return;
}

function toggle_content($this) {
	var is_short = $this.attr("class") == 'short_content';
	$showtext_body = $('.showtext_body', $this.parent().parent());
	var old_height, new_height;
	if (is_short) {
		$this.removeClass('short_content').addClass('long_content').text('向上收起');
		$old_height = $showtext_body.height();
		$showtext_body.css({
			'overflow': 'visible',
			'height': 'auto'
		});
		$new_height = $showtext_body.height();
		$('img', $showtext_body).show();
		$showtext_body.removeClass('showcont_l');
		$showtext_body.removeClass('fl');
	} else {
		$this.removeClass('long_content').addClass('short_content').text('展开全文');
		$showtext_body.css({
			'overflow': 'hidden',
			'height': '169px'
		});
		$('img', $showtext_body).hide();
		$showtext_body.addClass('showcont_l');
		$showtext_body.addClass('fl');
	}
    return false;
}

function MarqueeNews() {
	$('#news').find("ul").animate({
		marginTop: "-20px"
	}, 1000, function() {
		$(this).css({
			marginTop: "0px"
		}).find("li:first").appendTo(this)
	})
}
var MarNews = setInterval(MarqueeNews, 3000);

function gstop() {
	clearInterval(MarNews);
}

function gstart() {
	MarNews = setInterval(MarqueeNews, 3000);
}

function goup() {
	$('#news').find("ul li").last().insertBefore($('#news').find("ul li").first());
	$('#news').find("ul").css({
		marginTop: '-20px'
	});
	$('#news').find("ul").animate({
		marginTop: "0px"
	}, 500)
}

function godown() {
	$('#news').find("ul").animate({
		marginTop: "-20px"
	}, 500, function() {
		$(this).css({
			marginTop: "0px"
		}).find("li:first").appendTo(this)
	})
} /*头部公告E*/

function AddFavorite(sURL, sTitle) {
	try {
		window.external.addFavorite(sURL, sTitle);
	} catch (e) {
		try {
			window.sidebar.addPanel(sTitle, sURL, "");
		} catch (e) {
			alert("您的浏览器不支持点击添加，请按下 Ctrl + D 添加到收藏夹");
		}
	}
}
/*
返回值：类似".jpg"
*/
function get_file_extension(path){
    return $.trim(path.substr(path.lastIndexOf(".")));
}

function create_datepicker() {
    if ($.fn.datepicker) {
        $(".J_date_picker").each(function () {
            var opt = DATE_PICKER_OPT,is_short=$(this).hasClass('short');

            if ($(this).attr("data-minDate")) {
                opt.onClose = function (selectedDate) {
                    if(is_short){
                        $($(this).attr("data-minDate")).datepicker("option", "minDate", selectedDate);
                    }else{
                        $($(this).attr("data-minDate")).datetimepicker("option", "minDate", selectedDate);
                    }
                };
            }
            if ($(this).attr("data-maxDate")) {
                opt.onClose = function (selectedDate) {
                    if(is_short){
                        $($(this).attr("data-maxDate")).datepicker("option", "maxDate", selectedDate);
                    }else{
                        $($(this).attr("data-maxDate")).datetimepicker("option", "maxDate", selectedDate);
                    }
                };
            }
            if(is_short){
                $(this).datepicker(opt);
            }else{
                $(this).datetimepicker(opt);
            }
        });
    }
};
function parse_form(){
    $('select').each(function(){
        $('option[value="'+$(this).attr('data-selected')+'"]').attr('selected','selected');
    });
}
function subtext(str,length){
    str=$.trim(str);
    if(parseInt(str.length)>parseInt(length)){
        str=str.substr(0,length/2)+'...'+str.substr(str.length-length/2,str.length-1);
    }
    return str;
}
function htmlspecialchars(str){
    str = str.replace(/&/g, '&amp;');
    str = str.replace(/</g, '&lt;');
    str = str.replace(/>/g, '&gt;');
    str = str.replace(/"/g, '&quot;');
    str = str.replace(/'/g, '&#039;');
    return str;
}
function htmlspecialchars_decode (str) {
    str = str.replace(/&amp;/g, '&');
    str = str.replace(/&quot;/g, '"');
    str = str.replace(/&#039;/g, '\'');
    return str;
}
function create_share_widget(){
    $('.J_share_widget .item').live('click',function(){
        var type=$(this).attr('type');
    });
}
function php_date(format, timestamp) {
    var that = this,
        jsdate,
        f,
        txt_words = ["Sun", "Mon", "Tues", "Wednes", "Thurs", "Fri", "Satur", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        formatChr = /\\?(.?)/gi,
        formatChrCb = function (t, s) {
            return f[t] ? f[t]() : s;
        },
        _pad = function (n, c) {
            n = String(n);
            while (n.length < c) {
                n = '0' + n;
            }
            return n;
        };
    f = {
        // Day
        d: function () { // Day of month w/leading 0; 01..31
            return _pad(f.j(), 2);
        },
        D: function () { // Shorthand day name; Mon...Sun
            return f.l().slice(0, 3);
        },
        j: function () { // Day of month; 1..31
            return jsdate.getDate();
        },
        l: function () { // Full day name; Monday...Sunday
            return txt_words[f.w()] + 'day';
        },
        N: function () { // ISO-8601 day of week; 1[Mon]..7[Sun]
            return f.w() || 7;
        },
        S: function () { // Ordinal suffix for day of month; st, nd, rd, th
            var j = f.j(),
                i = j % 10;
            if (i <= 3 && parseInt((j % 100) / 10, 10) == 1) {
                i = 0;
            }
            return ['st', 'nd', 'rd'][i - 1] || 'th';
        },
        w: function () { // Day of week; 0[Sun]..6[Sat]
            return jsdate.getDay();
        },
        z: function () { // Day of year; 0..365
            var a = new Date(f.Y(), f.n() - 1, f.j()),
                b = new Date(f.Y(), 0, 1);
            return Math.round((a - b) / 864e5);
        },

        // Week
        W: function () { // ISO-8601 week number
            var a = new Date(f.Y(), f.n() - 1, f.j() - f.N() + 3),
                b = new Date(a.getFullYear(), 0, 4);
            return _pad(1 + Math.round((a - b) / 864e5 / 7), 2);
        },

        // Month
        F: function () { // Full month name; January...December
            return txt_words[6 + f.n()];
        },
        m: function () { // Month w/leading 0; 01...12
            return _pad(f.n(), 2);
        },
        M: function () { // Shorthand month name; Jan...Dec
            return f.F().slice(0, 3);
        },
        n: function () { // Month; 1...12
            return jsdate.getMonth() + 1;
        },
        t: function () { // Days in month; 28...31
            return (new Date(f.Y(), f.n(), 0)).getDate();
        },

        // Year
        L: function () { // Is leap year?; 0 or 1
            var j = f.Y();
            return j % 4 === 0 & j % 100 !== 0 | j % 400 === 0;
        },
        o: function () { // ISO-8601 year
            var n = f.n(),
                W = f.W(),
                Y = f.Y();
            return Y + (n === 12 && W < 9 ? 1 : n === 1 && W > 9 ? -1 : 0);
        },
        Y: function () { // Full year; e.g. 1980...2010
            return jsdate.getFullYear();
        },
        y: function () { // Last two digits of year; 00...99
            return f.Y().toString().slice(-2);
        },

        // Time
        a: function () { // am or pm
            return jsdate.getHours() > 11 ? "pm" : "am";
        },
        A: function () { // AM or PM
            return f.a().toUpperCase();
        },
        B: function () { // Swatch Internet time; 000..999
            var H = jsdate.getUTCHours() * 36e2,
            // Hours
                i = jsdate.getUTCMinutes() * 60,
            // Minutes
                s = jsdate.getUTCSeconds(); // Seconds
            return _pad(Math.floor((H + i + s + 36e2) / 86.4) % 1e3, 3);
        },
        g: function () { // 12-Hours; 1..12
            return f.G() % 12 || 12;
        },
        G: function () { // 24-Hours; 0..23
            return jsdate.getHours();
        },
        h: function () { // 12-Hours w/leading 0; 01..12
            return _pad(f.g(), 2);
        },
        H: function () { // 24-Hours w/leading 0; 00..23
            return _pad(f.G(), 2);
        },
        i: function () { // Minutes w/leading 0; 00..59
            return _pad(jsdate.getMinutes(), 2);
        },
        s: function () { // Seconds w/leading 0; 00..59
            return _pad(jsdate.getSeconds(), 2);
        },
        u: function () { // Microseconds; 000000-999000
            return _pad(jsdate.getMilliseconds() * 1000, 6);
        },

        // Timezone
        e: function () {
            throw 'Not supported (see source code of date() for timezone on how to add support)';
        },
        I: function () {
            var a = new Date(f.Y(), 0),
            // Jan 1
                c = Date.UTC(f.Y(), 0),
            // Jan 1 UTC
                b = new Date(f.Y(), 6),
            // Jul 1
                d = Date.UTC(f.Y(), 6); // Jul 1 UTC
            return ((a - c) !== (b - d)) ? 1 : 0;
        },
        O: function () { // Difference to GMT in hour format; e.g. +0200
            var tzo = jsdate.getTimezoneOffset(),
                a = Math.abs(tzo);
            return (tzo > 0 ? "-" : "+") + _pad(Math.floor(a / 60) * 100 + a % 60, 4);
        },
        P: function () { // Difference to GMT w/colon; e.g. +02:00
            var O = f.O();
            return (O.substr(0, 3) + ":" + O.substr(3, 2));
        },
        T: function () {
            return 'UTC';
        },
        Z: function () { // Timezone offset in seconds (-43200...50400)
            return -jsdate.getTimezoneOffset() * 60;
        },

        // Full Date/Time
        c: function () { // ISO-8601 date.
            return 'Y-m-d\\TH:i:sP'.replace(formatChr, formatChrCb);
        },
        r: function () { // RFC 2822
            return 'D, d M Y H:i:s O'.replace(formatChr, formatChrCb);
        },
        U: function () { // Seconds since UNIX epoch
            return jsdate / 1000 | 0;
        }
    };
    this.date = function (format, timestamp) {
        that = this;
        jsdate = (timestamp === undefined ? new Date() : // Not provided
            (timestamp instanceof Date) ? new Date(timestamp) : // JS Date()
                new Date(timestamp * 1000) // UNIX timestamp (auto-convert to int)
            );
        return format.replace(formatChr, formatChrCb);
    };
    return this.date(format, timestamp);
}
function strtotime(text, now) {
    var parsed, match, year, date, days, ranges, len, times, regex, i;

    if (!text) {
        return null;
    }
    // Unecessary spaces
    text = text.trim()
        .replace(/\s{2,}/g, ' ')
        .replace(/[\t\r\n]/g, '')
        .toLowerCase();

    if (text === 'now') {
        return now === null || isNaN(now) ? new Date().getTime() / 1000 | 0 : now | 0;
    }
    if (!isNaN(parsed = Date.parse(text))) {
        return parsed / 1000 | 0;
    }
    if (text === 'now') {
        return new Date().getTime() / 1000; // Return seconds, not milli-seconds
    }
    if (!isNaN(parsed = Date.parse(text))) {
        return parsed / 1000;
    }

    match = text.match(/^(\d{2,4})-(\d{2})-(\d{2})(?:\s(\d{1,2}):(\d{2})(?::\d{2})?)?(?:\.(\d+)?)?$/);
    if (match) {
        year = match[1] >= 0 && match[1] <= 69 ? +match[1] + 2000 : match[1];
        return new Date(year, parseInt(match[2], 10) - 1, match[3],
            match[4] || 0, match[5] || 0, match[6] || 0, match[7] || 0) / 1000;
    }

    date = now ? new Date(now * 1000) : new Date();
    days = {
        'sun': 0,
        'mon': 1,
        'tue': 2,
        'wed': 3,
        'thu': 4,
        'fri': 5,
        'sat': 6
    };
    ranges = {
        'yea': 'FullYear',
        'mon': 'Month',
        'day': 'Date',
        'hou': 'Hours',
        'min': 'Minutes',
        'sec': 'Seconds'
    };

    function lastNext(type, range, modifier) {
        var diff, day = days[range];

        if (typeof day !== 'undefined') {
            diff = day - date.getDay();

            if (diff === 0) {
                diff = 7 * modifier;
            }
            else if (diff > 0 && type === 'last') {
                diff -= 7;
            }
            else if (diff < 0 && type === 'next') {
                diff += 7;
            }

            date.setDate(date.getDate() + diff);
        }
    }
    function process(val) {
        var splt = val.split(' '), // Todo: Reconcile this with regex using \s, taking into account browser issues with split and regexes
            type = splt[0],
            range = splt[1].substring(0, 3),
            typeIsNumber = /\d+/.test(type),
            ago = splt[2] === 'ago',
            num = (type === 'last' ? -1 : 1) * (ago ? -1 : 1);

        if (typeIsNumber) {
            num *= parseInt(type, 10);
        }

        if (ranges.hasOwnProperty(range) && !splt[1].match(/^mon(day|\.)?$/i)) {
            return date['set' + ranges[range]](date['get' + ranges[range]]() + num);
        }
        if (range === 'wee') {
            return date.setDate(date.getDate() + (num * 7));
        }

        if (type === 'next' || type === 'last') {
            lastNext(type, range, num);
        }
        else if (!typeIsNumber) {
            return false;
        }
        return true;
    }

    times = '(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec' +
        '|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?' +
        '|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?)';
    regex = '([+-]?\\d+\\s' + times + '|' + '(last|next)\\s' + times + ')(\\sago)?';

    match = text.match(new RegExp(regex, 'gi'));
    if (!match) {
        return false;
    }
    for (i = 0, len = match.length; i < len; i++) {
        if (!process(match[i])) {
            return false;
        }
    }
    return (date.getTime() / 1000);
}
function time () {  
  return Math.floor(new Date().getTime() / 1000);
}

function empty (mixed_var) {
  var undef, key, i, len;
  var emptyValues = [undef, null, false, 0, "", "0"];

  for (i = 0, len = emptyValues.length; i < len; i++) {
    if (mixed_var === emptyValues[i]) {
      return true;
    }
  }

  if (typeof mixed_var === "object") {
    for (key in mixed_var) {
      // TODO: should we check for own properties only?
      //if (mixed_var.hasOwnProperty(key)) {
      return false;
      //}
    }
    return true;
  }

  return false;
}
function parse_url (str, component) {
  var query, key = ['source', 'scheme', 'authority', 'userInfo', 'user', 'pass', 'host', 'port',
            'relative', 'path', 'directory', 'file', 'query', 'fragment'],
    ini = (this.php_js && this.php_js.ini) || {},
    mode = (ini['phpjs.parse_url.mode'] &&
      ini['phpjs.parse_url.mode'].local_value) || 'php',
    parser = {
      php: /^(?:([^:\/?#]+):)?(?:\/\/()(?:(?:()(?:([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?()(?:(()(?:(?:[^?#\/]*\/)*)()(?:[^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
      strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
      loose: /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/\/?)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/ // Added one optional slash to post-scheme to catch file:/// (should restrict this)
    };

  var m = parser[mode].exec(str),
    uri = {},
    i = 14;
  while (i--) {
    if (m[i]) {
      uri[key[i]] = m[i];
    }
  }

  if (component) {
    return uri[component.replace('PHP_URL_', '').toLowerCase()];
  }
  if (mode !== 'php') {
    var name = (ini['phpjs.parse_url.queryKey'] &&
        ini['phpjs.parse_url.queryKey'].local_value) || 'queryKey';
    parser = /(?:^|&)([^&=]*)=?([^&]*)/g;
    uri[name] = {};
    query = uri[key[12]] || '';
    query.replace(parser, function ($0, $1, $2) {
      if ($1) {uri[name][$1] = $2;}
    });
  }
  delete uri.source;
  return uri;
}
function in_array (needle, haystack, argStrict) {
  var key = '',
    strict = !! argStrict;

  if (strict) {
    for (key in haystack) {
      if (haystack[key] === needle) {
        return true;
      }
    }
  } else {
    for (key in haystack) {
      if (haystack[key] == needle) {
        return true;
      }
    }
  }

  return false;
}

$(function () {
    if (typeof ACTION_NAME == 'undefined')return;
    if (ACTION_NAME == 'edit') {
        $('#info_form').append("<input type='hidden' name='referrer' value='" + document.referrer + "'/>");
    }
    init_input();
});

$(function ($) {
    //AJAX请求效果
    $('#J_ajax_loading').ajaxStart(function () {
        $(this).show();
    }).ajaxSuccess(function () {
            $(this).hide();
        });

    //确认操作
    $('.J_confirmurl').live('click', function () {
        var self = $(this),
            uri = self.attr('data-uri'),
            acttype = self.attr('data-acttype'),
            title = (self.attr('data-title') != undefined) ? self.attr('data-title') : lang.confirm_title,
            msg = self.attr('data-msg'),
            callback = self.attr('data-callback');
        if (acttype == 'batch_action') {
            $('.J_checkitem').attr("checked", false);
            $('.J_checkitem[value="' + self.attr('data-row_id') + '"]').attr("checked", 'checked');
            $('input[data-tdtype="batch_action"]').trigger('click');
            $.dialog.get(self.attr('data-id')).title(self.attr('data-title'));
            return;
        }
        $.dialog({
            title: title,
            content: msg,
            padding: '10px 20px',
            lock: true,
            ok: function () {
                if (acttype == 'ajax') {
                    $.getJSON(uri, function (result) {
                        if (result.status == 1) {
                            $.zhiphp.tip({content: result.msg});
                            if (callback != undefined) {
                                eval(callback + '(self)');
                            } else {
                                window.location.reload();
                            }
                        } else {
                            $.zhiphp.tip({content: result.msg, icon: 'error'});
                        }
                    });
                } else {
                    location.href = uri;
                }
            },
            cancel: function () {
            }
        });
    });

    //弹窗表单
    $('.J_showdialog').live('click', function () {
        var self = $(this),
            dtitle = self.attr('data-title'),
            did = self.attr('data-id'),
            duri = self.attr('data-uri'),
            dwidth = parseInt(self.attr('data-width')),
            dheight = parseInt(self.attr('data-height')),
            dpadding = (self.attr('data-padding') != undefined) ? self.attr('data-padding') : '',
            dcallback = self.attr('data-callback');
        $.dialog({id: did}).close();
        $.dialog({
            id: did,
            zIndex: 100,
            title: dtitle,
            width: dwidth ? dwidth : 'auto',
            height: dheight ? dheight : 'auto',
            padding: dpadding,
            lock: true,
            ok: function () {
                var info_form = this.dom.content.find('#info_form');
                if (info_form[0] != undefined) {
                    $(info_form).append('<input type="hidden" name="ajax" value="1"/>');
                    info_form.submit();
                    if (dcallback != undefined) {
                        eval(dcallback + '()');
                    }
                    return false;
                }
                if (dcallback != undefined) {
                    eval(dcallback + '()');
                }
            },
            cancel: function () {
            }
        });
        $.getJSON(duri, function (result) {
            if (result.status == 1) {
                var script = "<script type='text/javascript'>\
                $(function(){\
                    var form_id= $('#d-content-" + did + " form').attr('id');\
                    $.formValidator.initConfig({formid:form_id,autotip:true});\
                    $('#'+form_id).ajaxForm({success:complate,dataType:'json'});\
                    function complate(result){\
                        if(result.status == 1){\
                            $.dialog.get(result.dialog).close();\
                            $.zhiphp.tip({content:result.msg});\
                            window.location.reload();\
                        } else {\
                            $.zhiphp.tip({content:result.msg, icon:'alert'});\
                        }\
                    };\
                });</script>";

                $.dialog.get(did).content(script + result.data);
                create_datepicker();
            }
        });
        return false;
    });

    //附件预览
    $('.J_attachment_icon').live('mouseover',function () {
        var ftype = $(this).attr('file-type');
        var rel = $(this).attr('file-rel');
        switch (ftype) {
            case 'image':
                if (!$(this).find('.attachment_tip')[0]) {
                    $('<img class="attachment_tip" width="160" height="80" src="' + rel + '" />').prependTo($(this)).fadeIn();
                } else {
                    $(this).find('.attachment_tip').fadeIn();
                }
                break;
        }
    }).live('mouseout', function () {
            $('.attachment_tip').hide();
        });
    //积分等级
    $('.J_user_level').live('click', function () {
        var $overlay = $('.overlay', this);
        if ($overlay.size() == 0) {
            var html = '<div class="overlay clearfix"><div class="title">选择图标</div><ul class="clearfix">';
            for (i = 0; i <= 21; i++) {
                html += '<li><img src="static/images/user_level/' + i + '.gif" title="编号' + i + '"></li>';
            }
            html += '</ul></div>';
            $(this).append(html);
            $('img', this).click(function () {
                $('#J_img').val($(this).attr('src'));
            });
        } else {
            $overlay.remove();
        }
    });
});

//显示大图
;
(function ($) {
    $.fn.preview = function () {
        var w = $(window).width();
        var h = $(window).height();

        $(this).each(function () {
            $(this).hover(function (e) {
                if (/.png$|.gif$|.jpg$|.bmp$|.jpeg$/.test($(this).attr("data-bimg"))) {
                    $('#preview').remove();
                    $("body").append("<div id='preview'><img src='" + $(this).attr('data-bimg') + "' /></div>");
                }
                var show_x = $(this).offset().left + $(this).width();
                var show_y = $(this).offset().top;
                var scroll_y = $(window).scrollTop();
                $("#preview").css({
                    position: "absolute",
                    padding: "4px",
                    border: "1px solid #f3f3f3",
                    backgroundColor: "#eeeeee",
                    top: show_y + "px",
                    left: show_x + "px",
                    zIndex: 1000
                });

                $("#preview > div").css({
                    padding: "5px",
                    backgroundColor: "white",
                    border: "1px solid #cccccc"
                });
                if (show_y + 230 > h + scroll_y) {
                    $("#preview").css("bottom", h - show_y - $(this).height() + "px").css("top", "auto");
                } else {
                    $("#preview").css("top", show_y + "px").css("bottom", "auto");
                }
                $("#preview").fadeIn("fast");
                $("#preview img").css({
                    'maxWidth': '500px',
                    'maxHeight': '500px'
                });
            }, function () {
                $("#preview").remove();
            })
        });
    };
})(jQuery);

;
(function ($) {
    //联动菜单
    $.fn.cate_select = function (options) {
        var cate_sel = this.selector;
        //console.log(cate_sel);
        var settings = {
            field: 'J_cate_id',
            top_option: lang.please_select
        };
        if (options) {
            $.extend(settings, options);
        }

        var self = $(this),
            pid = self.attr('data-pid'),
            uri = self.attr('data-uri'),
            selected = self.attr('data-selected'),
            selected_arr = [];
        if (selected != undefined && selected != '0') {
            if (selected.indexOf('|')) {
                selected_arr = selected.split('|');
            } else {
                selected_arr = [selected];
            }
        }
        self.nextAll(cate_sel).remove();
        $('<option value="">--' + settings.top_option + '--</option>').appendTo(self);
        $.getJSON(uri, {id: pid}, function (result) {
            if (result.status == '1') {
                for (var i = 0; i < result.data.length; i++) {
                    $('<option value="' + result.data[i].id + '">' + result.data[i].name + '</option>').appendTo(self);
                }
            }
            if (selected_arr.length > 0) {
                //IE6 BUG
                setTimeout(function () {
                    self.find('option[value="' + selected_arr[0] + '"]').attr("selected", true);
                    self.trigger('change');
                }, 1);
            }
        });

        var j = 1;
        $(this.selector).die('change').live('change', function () {
            var _this = $(this),
                _pid = _this.val();
            _this.nextAll(cate_sel).remove();
            if (_pid != '') {
                $.getJSON(uri, {id: _pid}, function (result) {
                    if (result.status == '1') {
                        var _childs = $('<select class="' + cate_sel.substr(1) + ' mr10" data-pid="' + _pid + '"><option value="">--' + settings.top_option + '--</option></select>')
                        for (var i = 0; i < result.data.length; i++) {
                            $('<option value="' + result.data[i].id + '">' + result.data[i].name + '</option>').appendTo(_childs);
                        }
                        _childs.insertAfter(_this);
                        if (selected_arr[j] != undefined) {
                            //IE6 BUG
                            //setTimeout(function(){
                            _childs.find('option[value="' + selected_arr[j] + '"]').attr("selected", true);
                            _childs.trigger('change');
                            //}, 1);
                        }
                        j++;
                    }
                });
                $('#' + settings.field).val(_pid);
            } else {
                $('#' + settings.field).val(_this.attr('data-pid'));
            }
        });
    }
})(jQuery);
function add_cate($this) {
    $region = $("#cate_selected");
    var val = parseInt($this.prev().val()) || 0;
    var text = $this.prev().find("option:selected").text();
    if (val == 0) {
        val = parseInt($this.prev().prev().val()) || 0;
        text = $this.prev().prev().find("option:selected").text();
    }
    if (val > 0 && $("input[value='" + val + "']", $region).size() == 0) {
        var html = '<input type="checkbox" name="cate_id[]" value="' + val + '" checked="checked"/>'
            + text;
        $region.append(html);
    }
}
function checkbox(name, val) {
    for (var i = 0; i < val.length; i++) {
        $('input[name="' + name + '"][value="' + val[i] + '"]').attr('checked', true);
    }
}
function create_mall_index($context) {
    var url = ROOT_PATH + '/index.php',
        $index=$('.index', $context),
        $list=$('.list', $context);
    var html = '<option value="-1">请选择……</option>' +
        '<option value="9">0~9</option>';
    for (var i = 65; i < 91; i++) {
        html += '<option value="' + String.fromCharCode(i) + '">' + String.fromCharCode(i) + '</option>';
    }
    $index.html(html);
    $index.change(function (event,id) {
        var params = {
            g: 'admin',
            m: 'mall',
            a: 'get_mall_list',
            index: $(this).val()
        };
        $.get(url, params, function (data) {
            var html = "";
            for (var i = 0; i < data.length; i++) {
                html += '<option value="' + data[i].id + '">' + data[i].title + '</option>';
            }
            $list.html(html);
            if(id){
                $list.val(id);
            }
        }, 'json');
    });
    var selected_id = $context.attr('data-id');
    if (!empty(selected_id)) {
        var params = {
            g: 'admin',
            m: 'mall',
            a: 'get_mall',
            id: selected_id
        };
        $.get(url, params, function (data) {
            $index.val(data.index);
            $index.trigger('change',[data.id]);
        }, 'json');
    }

}
function create_brand_index($context) {
    var url = ROOT_PATH + '/index.php',
    $list=$('.brandlist', $context);

    var params = {
        g: 'admin',
        m: 'post',
        a: 'get_brand_list'
    };
    $.get(url, params, function (data) {
        var html = '<option value="-1">请选择……</option>';
        for (var i = 0; i < data.length; i++) {
            html += '<option value="' + data[i].id + '">' + data[i].name_cn + ' / '+  data[i].name_fr + '</option>';
        }
        $list.html(html);
        if(id){
            $list.val(id);
        }
    }, 'json');
    
    var selected_id = $context.attr('data-id');
    if (!empty(selected_id)) {
        var params = {
            g: 'admin',
            m: 'post',
            a: 'get_brand',
            id: selected_id
        };
        $.get(url, params, function (data) {
            $list.val(data.id);
        }, 'json');
    }
}