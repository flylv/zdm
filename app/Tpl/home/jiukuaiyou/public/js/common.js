$('.J_favs').live('click', function() {
	var $this = $(this);
	var id = $this.attr("data-id");
	$.get('index.php?m=user&a=favs_add', {
		id: id
	}, function(data) {
		$.ZhiPHP._tip({
			content: data.msg,
			status: data.status == 1
		});
		if (data.status == 1) {
			$this.html(data.data);
		}
	}, 'json');
});
$(document).ready(function() {
    $('#click_show').hover(function(){
        $('.content',this).show();
    },function(){
        $('.content',this).hide();
    });
});

/*js 点击copy*/
function copylinks(){
	copyToClipboard($(".links_in").val());
}
function copyToClipboard(txt) {
    if (window.clipboardData) {
        window.clipboardData.clearData();
        clipboardData.setData("Text", txt);
        alert("复制成功！");

    } else if (navigator.userAgent.indexOf("Opera") != -1) {
        window.location = txt;
    } else if (window.netscape) {
        try {
            netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
        } catch(e) {
            alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将 'signed.applets.codebase_principal_support'设置为'true'");
        }
        var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
        if (!clip) return;
        var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
        if (!trans) return;
        trans.addDataFlavor("text/unicode");
        var str = new Object();
        var len = new Object();
        var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
        var copytext = txt;
        str.data = copytext;
        trans.setTransferData("text/unicode", str, copytext.length * 2);
        var clipid = Components.interfaces.nsIClipboard;
        if (!clip) return false;
        clip.setData(trans, null, clipid.kGlobalClipboard);
        alert("复制成功！");
    }
}