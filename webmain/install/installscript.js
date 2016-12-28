function initbody(){
	var tit = document.title;
	if(tit.indexOf('<?')>-1){
		alert('提示：您没有开启php短标签，系统将不能使用\n\n请到php.ini下将short_open_tag = ON。');
	}
}
var bool = false;
function nextabc(){
	$('#step1').hide();
	$('#step2').show();
}

function backabc(){
	$('#step2').hide();
	$('#step1').show();
}

function wancla(){
	$('#step2').hide();
	$('#step3').show();
}

function delinstall(){
	var url = js.getajaxurl('delinstall','install');
	$.get(url,function(){
		js.msg('success','删除成功');
	});
	return false;
}

function submitla(){
	if(bool)return;
	var a = js.getformdata();
	if(isempt(a.host)){
		js.setmsg('数据库地址不能为空');
		return;
	}
	if(isempt(a.user)){
		js.setmsg('用户名不能为空');
		return;
	}
	if(isempt(a.base)){
		js.setmsg('数据库名称不能为空');
		return;
	}
	if(isempt(a.perfix)){
		js.setmsg('表名前缀不能为空');
		return;
	}
	var url = location.href;
	a.url = url.substr(0, url.lastIndexOf('/')+1);
	js.setmsg('处理中...');
	bool = true;
	$.post(js.getajaxurl('save','install'), a, function(da){
		js.setmsg();
		if(da!='success'){
			js.setmsg(da);
			bool = false;
		}else{
			wancla();
		}
	});
}