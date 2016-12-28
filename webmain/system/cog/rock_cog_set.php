<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	
	var barr = {};
	var c={
		init:function(){
			js.ajax(js.getajaxurl('getinfo','{mode}','{dir}'),{},function(a){
				barr = a;
				for(var i in a)$('#'+i+'_{rand}').val(a[i]);
			},'get,json');
		},
		save:function(o){
			var d={};
			for(var i in barr){
				d[i] = $('#'+i+'_{rand}').val();
			}
			if(d.title==''){
				js.msg('msg','系统标题不能为空');
				return;
			}
			if(d.url==''){
				js.msg('msg','系统URL地址不能为空');
				return;
			}
			js.ajax(js.getajaxurl('savecong','{mode}','{dir}'), d, function(s){
				if(s!='ok')js.msg('msg', s);
			},'post',false,'保存中...,保存成功');
		},
		blurls:function(o){
			var val = strreplace(o.value);
			if(val=='')return;
			var la  = val.substr(val.length-1);
			if(la!='/')val+='/';
			o.value=val;
		}
	};
	js.initbtn(c);
	c.init();
	
	$('#url_{rand}').blur(function(){
		c.blurls(this);
	});
	$('#localurl_{rand}').blur(function(){
		c.blurls(this);
	});
});
</script>

<div align="left">
<div  style="padding:10px;">

		
		<table cellspacing="0" width="550" border="0" cellpadding="0">
		
		<tr>
			<td  colspan="2"><div class="inputtitle">基本信息</div></td>
		</tr>
		
		<tr>
			<td  align="right" width="180">系统标题：</td>
			<td class="tdinput"><input id="title_{rand}" class="form-control"></td>
		</tr>
		
		<tr>
			<td  align="right">APP移动端PC上标题：</td>
			<td class="tdinput"><input id="apptitle_{rand}" class="form-control"></td>
		</tr>
		
		<tr>
			<td  align="right">系统URL地址：</td>
			<td class="tdinput"><input id="url_{rand}" class="form-control"></td>
		</tr>
		
		<tr>
			<td  align="right">系统本地地址：</td>
			<td class="tdinput"><input id="localurl_{rand}" class="form-control">
			<font color="#888888">用于计划任务异步任务使用</font></td>
		</tr>
		
		<tr>
			<td  colspan="2"><div class="inputtitle">高级设置</div></td>
		</tr>
		
		<tr>
			<td  align="right">异步任务key：</td>
			<td class="tdinput"><input id="asynkey_{rand}" class="form-control"></td>
		</tr>
		
		<tr>
			<td  align="right">对外接口openkey：</td>
			<td class="tdinput"><input id="openkey_{rand}" class="form-control"></td>
		</tr>
		
		<tr>
			<td  align="right">操作数据库驱动：</td>
			<td class="tdinput"><select id="db_drive_{rand}"  class="form-control"><option value="mysql">mysql(不推荐)</option><option value="mysqli">mysqli</option><option value="pdo">pdo</option></select></td>
		</tr>
		
		<tr>
			<td  align="right">提醒消息发送方式：</td>
			<td class="tdinput"><select id="asynsend_{rand}"  class="form-control"><option value="0">同步发送</option><option value="1">异步发送</option></select>
			<font color="#888888">提醒消息发送微信消息提示发送，邮件提醒发送等。选择[异步发送]需安装服务端，异步发送能大大提高效率。</font></td>
		</tr>
		
		<tr>
			<td  align="right">是否记录访问sql日志：</td>
			<td class="tdinput"><select id="sqllog_{rand}"  class="form-control"><option value="0">否</option><option value="1">是</option></select><font color="#888888">开启了日志将记录在目录upload/sqllog下</font></td>
		</tr>
		
		
		<tr>
			<td  align="right"></td>
			<td style="padding:15px 0px" colspan="3" align="left"><button click="save" class="btn btn-success" type="button"><i class="icon-save"></i>&nbsp;保存</button></span>
		</td>
		</tr>
		

	
</div>
</div>