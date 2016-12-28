<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var atype = '',nowemail='';
	var a = $('#view_{rand}').bootstable({
		tablename:'emailm',modenum:'emailm',checked:true,modedir:'{mode}:{dir}',storeafteraction:'emailtotals',fanye:true,
		columns:[{
			text:'',dataIndex:'abclx',align:'center',width:34,renderer:function(v,d){
				var s = '';
				if(d.ishui=='1'){
					s='<img title="已回复" src="mode/icons/email_go.png">';
				}else{
					s='<img src="mode/icons/email.png">'
				}
				return s;
			}
		},{
			text:'主题',dataIndex:'title',align:'left',renderer:function(v,d){
				var s = v;	
				if(d.isfile=='1')s+='&nbsp;<img title="有附件" src="mode/icons/attach.png">';
				return s;
			}
		},{
			text:'发件人',dataIndex:'sendname'
		},{
			text:'收件人',dataIndex:'recename'
		},{
			text:'发件时间',dataIndex:'senddt',sortable:true
		},{
			text:'',dataIndex:'opt',renderer:function(v,d,oi){
				var s = '<a href="javascript:;" onclick="openxiangs(\'邮件\',\'emailm\','+d.id+')">查看</a>';
				if(atype=='cgx')s+='&nbsp;<a href="javascript:;" onclick="openinput(\'写邮件\',\'emailm\','+d.id+')">编辑</a>';
				return s;
			}
		}],
		rendertr:function(d){
			var s = '';
			if(d.zt=='0' && atype=='')s='style="font-weight:bold"';
			return s;
		},
		load:function(d){
			nowemail=d.email
			c.showtotal(d.total);
		}
	});
	function btn(bo){
		get('btn1_{rand}').disabled=bo;
	}
	var c = {
		change:function(o1,lx){
			var ars = ['','cgx','yfs','ysc'];
			atype	= ars[lx];
			btn(atype!='');
			a.setparams({atype:ars[lx]}, true);
		},
		search:function(){
			var d={
				dt:get('dt2_{rand}').value,
				key:get('key_{rand}').value
			}
			a.setparams(d, true);
		},
		showtotal:function(d){
			var s1 = d.wd;
			if(d.wd>0)s1='<font color=red>'+d.wd+'</font>';
			$('#zztotal_{rand}').html('('+d.zz+'/'+s1+')');
			$('#cgtotal_{rand}').html('('+d.cgx+')');
			$('#yftotal_{rand}').html('('+d.yfs+')');
			$('#sctotal_{rand}').html('('+d.ysc+')');
		},
		recemail:function(){
			js.wait('收信中，不要关闭窗口...');
			js.ajax(js.getajaxurl('recemail', '{mode}', '{dir}'),false,function(d){
				if(d.success){
					js.tanclose('confirm');
					js.msg('success','共收取'+d.data+'封信');
					a.reload();
				}else{
					setTimeout(function(){
						js.tanclose('confirm');
						js.msg('msg',d.msg);
					},1000);
				}				
			},'get,json');
		},
		getsid:function(){
			var sid = a.getchecked();
			if(sid==''){js.msg('msg','没选中行');return false;}
			return sid;
		},
		biaoyd:function(){
			var sid = this.getsid();
			if(!sid)return;
			js.ajax(js.getajaxurl('biaoyd','{mode}','{dir}'),{sid:sid},function(s){
				js.msg('success', s);
				a.reload();
			},'post',false,'标识中...');
		},
		delyj:function(){
			var sid = this.getsid();
			if(!sid)return;
			js.confirm('确定要删除选中的行记录吗？',function(jg){
				if(jg=='yes')c.delyjs();
			});
		},
		delyjs:function(){
			var sid = this.getsid();
			if(!sid)return;
			js.ajax(js.getajaxurl('delyj','{mode}','{dir}'),{sid:sid,atype:atype},function(s){
				js.msg('success', s);
				a.reload();
			},'post',false,'删除中...');
		},
		cogemail:function(){
			var h = $.bootsform({
				title:'邮箱设置',height:400,width:400,
				tablename:'admin',isedit:1,
				url:js.getajaxurl('saveemaipass','{mode}','{dir}'),
				submitfields:'email,sort',
				items:[{
					labelText:'我邮箱',name:'email',value:nowemail.email,readOnly:true
				},{
					labelText:'我邮箱密码',name:'emailpass',value:nowemail.emailpass,required:true
				}],
				success:function(){
					a.reload();
				}
			});
			h.isValid();
		}
	};
	js.initbtn(c);
	
});
</script>


<table width="100%">
<tr valign="top">
<td width="180">
	<div>
		<div style="width:100%" class="btn-group">
		<button style="width:50%" onclick="openinput('写邮件','emailm')" class="btn btn-default" type="button"><i class="icon-pencil"></i> 写信</button>
		<button style="width:50%" class="btn btn-default" click="recemail" type="button"><i class="icon-download-alt"></i> 收信</button>
		</div>	
	</div>
	<div class="blank10"></div>
	<div align="left" class="list-group">
		<div class="list-group-item active">我的邮件</div>
		<a class="list-group-item" click="change,0">收件箱 &nbsp;<font id="zztotal_{rand}">(0/0)</font></a>
		<a class="list-group-item" click="change,1">草稿箱 &nbsp;<font id="cgtotal_{rand}">(0)</font></a>
		<a class="list-group-item" click="change,2">已发送 &nbsp;<font color="#aaaaaa" id="yftotal_{rand}">(0)</font></a>
		<a class="list-group-item" click="change,3">已删除 &nbsp;<font color="#aaaaaa" id="sctotal_{rand}">(0)</font></a>
		<a click="cogemail" class="list-group-item"><i class="icon-cog"></i> 邮箱设置</a>
	</div>
	
	<div align="left" style="display:none" class="list-group">
		<div class="list-group-item active">邮件文件夹</div>
		<a class="list-group-item"><i class="icon-plus"></i> 新建文件夹</a>
	</div>
</td>
<td width="10"></td>
<td>	
	<div>
	<table width="100%"><tr>
		<td  style="padding-right:10px">
			<div style="width:140px"  class="input-group">
				<input placeholder="日期" readonly class="form-control" id="dt2_{rand}" >
				<span class="input-group-btn">
					<button class="btn btn-default" onclick="js.changedate(this,'dt2_{rand}')" type="button"><i class="icon-calendar"></i></button>
				</span>
			</div>	
		</td>
		<td>
		<input class="form-control" style="width:200px" id="key_{rand}"   placeholder="标题/发件人">
		</td>
		<td style="padding-left:10px">
			<button class="btn btn-default" click="search" type="button">搜索</button> 
		</td>
		<td width="90%">
			
		</td>
		<td align="right" nowrap>
			<button class="btn btn-default" id="btn1_{rand}" click="biaoyd" type="button">标识已读</button>&nbsp; 
			<button class="btn btn-danger" click="delyj" type="button"><i class="icon-trash"></i> 删除</button>
		</td>
	</tr></table>
	</div>
	<div class="blank10"></div>
	<div id="view_{rand}"></div>
</td>
</tr>
</table>
