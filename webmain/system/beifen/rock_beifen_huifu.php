<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var xu=0;
	var at = $('#viewss_{rand}').bootstable({
		tablename:'option',celleditor:false,url:js.getajaxurl('getdata', '{mode}', '{dir}'),
		columns:[{
			text:'名称',dataIndex:'filename',align:'align'
		},{
			text:'备份时间',dataIndex:'editdt'
		},{
			text:'操作',dataIndex:'opt',renderer:function(v,d){
				return '<a href="javascript:;" onclick="huifww{rand}(\''+d.xu+'\')">恢复</a>';
			}
		}]
	});
	
	var a = $('#view_{rand}').bootstable({
		tablename:'option',celleditor:true,checked:true,url:js.getajaxurl('getdatssss', '{mode}', '{dir}'),
		autoLoad:false,params:{xu:0},
		columns:[{
			text:'表名',dataIndex:'id'
		},{
			text:'字段数',dataIndex:'fields'
		},{
			text:'记录数',dataIndex:'total'
		}],
		load:function(){
			get('btnss_{rand}').focus();
		}
	});
	
	huifww{rand}=function(f){
		c.huifu(f);
	}
	
	var c = {
		huifu:function(f){
			xu = f;
			a.setparams({'xu':f},true);
		},
		clickwin:function(){
			var sid = a.getchecked();
			if(sid==''){
				js.msg('msg','没有选中记录');
				return;
			}
			js.wait('恢复中请不要关闭...');
			js.ajax(js.getajaxurl('huifdata', '{mode}', '{dir}'),{sid:sid,'xu':xu},function(s){
				setTimeout(function(){
					js.tanclose('confirm');
					js.msg('success','恢复'+s+'');
				}, 1000);	
			},'post');
		}
	};
	js.initbtn(c);
});
</script>


<table width="100%">
<tr valign="top">
<td width="500">
	<div id="viewss_{rand}"></div>
</td>
<td width="10"></td>
<td>	
	<div align="right"><font color="#888888">系统只会恢复数据并不会恢复字段，建议选择单表恢复，以免超时。</font>&nbsp;
	<button class="btn btn-default" id="btnss_{rand}" click="clickwin,0" type="button">恢复选中表</button>
	</div>
	<div class="blank10"></div>
	<div id="view_{rand}"></div>
</td>
</tr>
</table>