<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var istongbu=false;
	var a = $('#view_{rand}').bootstable({
		tablename:'chargems',url:js.getajaxurl('data','{mode}','{dir}'),
		columns:[{
			text:'名称',dataIndex:'name'
		},{
			text:'说明',dataIndex:'explain',align:'left'
		},{
			text:'更新时间',dataIndex:'updatedt'
		},{
			text:'价格',dataIndex:'price',renderer:function(v){
				var s='<font color=#ff6600>免费</font>';
				if(v>0)s=v+'元';
				return s;
			}
		},{
			text:'详情',dataIndex:'view'
		},{
			text:'操作',dataIndex:'opt',renderer:function(v,d){
				var s='';
				if(v==1)s='<font color=green>已安装</font> ';
				if(v==2)s='<button onclick="upsho{rand}(2,'+d.id+',\''+d.key+'\')" class="btn btn-danger btn-sm" type="button">升级</button>';
				if(v==0)s='<button onclick="upsho{rand}(0,'+d.id+',\''+d.key+'\')" class="btn btn-info btn-sm"  type="button">安装</button>';
				if(v==0||v==2){
					if(d.price=='-1')s+='&nbsp;<a href="javascrpt:;" onclick="downup{rand}('+d.id+')">对比更新</a>';
					$('#shiw_{rand}').html('有系统模块需要升级/安装！');
				}
				if(d.price=='0'){
					istongbu=false;
					if(v==1){
						istongbu=true;
					}
				}
				return '<span id="msg'+d.id+'_{rand}">'+s+'</span>';
			}
		}],
		beforeload:function(){
			istongbu=false;
			$('#shiw_{rand}').html('');
		}
	});
	
	var c={
		reloads:function(){
			a.reload();
		},
		upsho:function(lx,id,key, slx){
			var msgid='msg'+id+'_{rand}',lxs='安装';
			if(lx==2)lxs='升级';
			js.setmsg(''+lxs+'中...','', msgid);
			js.ajax(js.getajaxurl('shengjian','{mode}','{dir}'),{id:id,key:key,slx:slx},function(s){
				if(s=='ok'){
					js.setmsg(''+lxs+'成功','green', msgid);
					a.reload();
				}else{
					js.setmsg(s,'red', msgid);
				}
			},'post');
		},
		upshos:function(lx,id,kes){
			if(kes=='null')kes='';
			js.prompt('模块安装','请输入安装key',function(lxbd,msg){
				if(lxbd=='yes'){
					if(lx==2&&msg)msg=jm.uncrypt(msg);
					c.upsho(lx,id,msg, 0);
				}
			},kes);
		},
		tontbudata:function(lx, o){
			o.innerHTML=js.getmsg('同步中...');
			js.ajax(js.getajaxurl('tontbudata','{mode}','{dir}'),{lx:lx},function(s){
				o.innerHTML=js.getmsg(s,'green');
			});
		}
	};
	upsho{rand}=function(lx,id,kes){
		c.upshos(lx,id,kes);
	}
	downup{rand}=function(id){
		alert(id);
	}
	js.initbtn(c);
	
	upfetwontbu=function(lx, o){
		if(!istongbu){
			js.alert('请先升级系统到最新才能同步');
			return;
		}
		js.confirm('谨慎啊，确定要同步嘛？同步了将覆盖你原先配置好的流程哦！',function(jg){
			if(jg=='yes')c.tontbudata(lx, o);
		});
	}
});
</script>
<div>
	<button class="btn btn-default" click="reloads"  type="button"><i class="icon-refresh"></i> 刷新</button> &nbsp;  
	<font color="red" id="shiw_{rand}"></font>
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
<div class="blank10"></div>
<div>1、同步菜单，系统上操作菜单会和官网同步。<a onclick="upfetwontbu(0,this)" href="javascript:;">[同步]</a></div>
<div class="blank10"></div>
<div>2、同步流程模块，流程模块会和官网同步。<a onclick="upfetwontbu(1,this)" href="javascript:;">[同步]</a></div>
<div class="blank10"></div>
<div style="font-size:16px;line-height:35px">
更多升级方法：<br>
1、使用svn地址升级(推荐)，地址：<a href="https://git.oschina.net/rainrock/xinhu" target="_blank">https://git.oschina.net/rainrock/xinhu</a><br>
2、去官网下载源码全部覆盖升级，如果您自己修改，请谨慎覆盖。<br>
3、根据列表升级安装。
</div>
