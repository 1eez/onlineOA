﻿<?php if(!defined('HOST'))die('not access');?>
<script>
todocontent = '';
$(document).ready(function(){
	var optdt = '',loadci=0,miao=200;
	var c= {
		gettotal:function(){
			clearTimeout(this.timeteims);
			var url = js.getajaxurl('gettotal','index','home');
			$('#refresh_text').html('刷新统计中...');
			$.post(url,{loadci:loadci,optdt:optdt}, function(da){
				c.gettotalshow(js.decode(da));
			});
		},
		refresh:function(){
			this.gettotal();
		},
		shumiao:function(oi){
			clearTimeout(this.timeteims);
			if(oi<=0){
				this.gettotal();
			}else{
				$('#refresh_text').html(''+oi+'秒后刷新');
				this.timeteims = setTimeout(function(){c.shumiao(oi-1)},1000);
			}
		},
		gettotalshow:function(a){
			this.shumiao(miao);
			loadci++;
			optdt = a.optdt;
			if(loadci==1){
				jm.setJmstr(jm.base64decode(a.showkey));
				admintoken = a.token;
				this.showicons(a.menuarr);
			}
			this.showgonglist(a.gongarr);
			this.showapplylist(a.applyarr);
			$('#guestbook_wd').html(a.todo+'');
			for(var oi in a.total)this.showtotal(a.total[oi],oi);
			var d = a.worklist;
			$("span[tempid='showloat_{rand}']").remove();
			var i=0,s='',s1='';
			if(d)for(i=0; i<d.length; i++){
				s = ''+(i+1)+'、『'+d[i].type+'』'+d[i].title+' <font color="'+statecolor[d[i].state]+'">['+statearr[d[i].state]+']</font>';
				s1 = '<span tempid="showloat_{rand}" class="list-group-item">'+s+'';
				s1+=' <a href="javascript:" onclick="return openwork(\''+d[i].id+'\')">[查看]</a>';
				s1+= '</span>';
				$('#worklist_{rand}').append(s1);
			}
			var s=a.msgar[0],s1=a.msgar[1];
			if(s!=''){
				todocontent = s;
				var tx = this.opennewtx(1);
				if(tx=='0'){
					$('#tishidivshow').fadeIn();
					$('#tishicontent').html(s);
				}
			}
		},
		showtotal:function(to, sid){
			var o = $('#'+sid+'_{rand}');
			if(!o)return;
			if(to<=0){
				o.hide();
			}else{
				o.show();
				o.html(to);
			}
		},
		showicons:function(a){
			a.push({name:'刷新统计中...',icons:'refresh',num:'refresh',color:'#888888'});
			this.menuarr = a;
			var o = $('.homelishow'),s='';
			o.html('');
			for(var i=0; i<a.length;i++){
				s = '<li>';
				s+= '<div onclick="opentabsshowshwo('+i+')" class="homeiconss">';
				s+=	'<div class="div00"><span id="'+a[i].num+'_{rand}" style="display:none" class="badge red"></span></div>';
				s+=	'	<div style="background-color:'+a[i].color+'" class="homeiconss2">';
				s+=	'		<div class="div01"><i class="icon-'+a[i].icons+'"></i></div>';
				s+=	'		<div id="'+a[i].num+'_text">'+a[i].name+'<div>';
				s+=	'	</div>';
				s+=	'</div>';
				s+=	'</li>';
				o.append(s);
			}
		},
		opennewtx:function(lx){
			return '0';
		},
		showgonglist:function(a){
			var s='',a1,i;
			for(i=0;i<a.length;i++){
				a1=a[i];
				s+='<a onclick="openxiangs(\''+a1.typename+'\',\'gong\',\''+a1.id+'\');$(this).remove();" class="list-group-item">◇【'+a1.typename+'】'+a1.title+'['+a1.indate+']</a>';
			}
			$('#homegonglist').html(s);
		},
		showapplylist:function(a){
			var s='',a1,i;
			for(i=0;i<a.length;i++){
				a1=a[i];
				s+='<a onclick="openxiangs(\''+a1.modename+'\',\''+a1.modenum+'\',\''+a1.id+'\');" class="list-group-item">◇'+a1.cont+'</a>';
			}
			if(a1)$('#myapplylisttotal').html(a1.count);
			$('#myapplylist').html(s);
		}
	}
	

	
	js.initbtn(c);
	c.gettotal();
	c.opennewtx(0);
	
	opentabsshowshwo=function(oi){
		var a = c.menuarr[oi];
		if(a.num=='refresh'){
			c.refresh();
		}else{
			var anum = {num:a.num,url:a.url,name:a.name,icons:a.icons,id:a.id};
			addtabs(anum);
		}
		return false;
	}
	
	opennewtodo=function(){
		var l = screen.width-350,t=screen.height-200;
		js.open('?m=index&d=home&a=todo',350,180,'systodowin','toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,status=no,left='+l+'px,top='+t+'px');
	}
	newsetshezttt=function(o){
		var tx = '0';
		if(o.checked){
			setTimeout(function(){opennewtodo()}, 1000);
			tx = '1';
		}
		js.setoption('autoopentodo', tx);
	}
	opentixiangs=function(){
		opentixiang();
		hideTishi();
		return false;
	}
	hideTishi=function(){
		$('#tishidivshow').fadeOut();
		return false;
	}
	$('#banben').html(VERSION);
	
	$('body').append('<div id="tishidivshow" style="display:none" class="box"><div class="title"><ul><li>&nbsp;<i class="icon-bell"></i>&nbsp;系统提醒</li><li style="text-align:right"><a href="javascript:"><img src="images/wclose.png" onclick="return hideTishi()"></a>&nbsp;</li></ul></div><div id="tishicontent" style="height:130px;overflow:auto;padding:10px;text-align:left"></div></div>');
	
	openmobile=function(){
		js.tanbody('loginmobile','登录手机版', 300,200,{
			html:'<div  style="height:160px;padding:5px" align="center"><div><img id="logeweerew" src="images/logo.png" width="130" height="130"></div><div>直接扫一扫即可登录</div></div>'
		});
		var surl = js.getajaxurl('getqrcode','index','home');
		get('logeweerew').src=surl;
	}
	openwangyban=function(){
		window.open('web/login.html?user='+adminuser+'&token='+admintoken+'');
	}
	
	moregonggao=function(){
		addtabs({num:'gong',url:'system,infor,geren',icons:'volume-up',name:'通知公告'});
	}
	moemyapplylist=function(){
		addtabs({num:'applymy',url:'main,fwork,bill,atype=my',icons:'align-left',name:'我的申请'});
	}
	
	
	
	js.importjs('web/res/mode/echarts/echarts.common.min.js');
	js.importjs('web/res/js/jquery-imgview.js');
});
</script>
<style>
.homelishow{display:inline-block}
.homelishow li{float:left;text-align:center;}
.divlisssa li{float:left;padding:8px 0px;text-align:left;width:33%}
.divlisssa ul,.divlisssa{display:inline-block;width:100%}
</style>


<div style="padding:10px;">
	
	<div align="left">
		<ul class="homelishow">
			<li>
				<div  click="refresh" class="homeiconss">
					<div style="background-color:#888888" class="homeiconss2">
						<div class="div01"><i class="icon-refresh"></i></div>
						<div id="refresh_text">刷新中<div>
					</div>	
				</div>	
			</li>
		</ul>
	</div>
	
	<div class="blank1" style="margin:10px 0px"></div>
	<div class="blank10"></div>
	
	<div align="left" style="padding:0px 10px">
		<table  border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr valign="top">
			
			<td width="50%">
				<div align="left" style="min-width:300px" class="list-group">
				<div class="list-group-item  list-group-item-info">
					<i class="icon-volume-up"></i> 通知公告
					<a style="float:right" onclick="moregonggao()">更多&gt;&gt;</a>
				</div>
				<span id="homegonglist"></span>
				</div>
				
				<div class="panel panel-danger">
				  <div class="panel-heading">
					<h3 class="panel-title">微信企业号办公</h3>
				  </div>
				  <div class="panel-body">
						<table><tr valign="top">
						<td align="center"><img src="images/wxqcode.jpg" height="140">
						<div style="color:#888888">扫一扫体验微信办公</div></td>
						<td>
							<div style="line-height:26px;padding:5px;">
							<b>微信办公</b><br>&nbsp; &nbsp; 结合了信呼上IM无缝隙的对接会话交流，单据待办推送提醒，<a href="http://xh829.com/view_weixin.html" target="_blank">[详情介绍]</a>。<br>
							1、请先申请添加帐号才可以体验，去<a href="http://xh829.com/view_weixinty.html" target="_blank">[申请]</a>。<br>
							2、扫一扫验证帐号即可使用。<br>
							3、可到【系统→系统工具→升级系统】下安装，有问题？<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=290802026&site=qq&menu=yes"><img border="0" align="absmiddle" src="http://xh829.com/images/qquser.png" height="22" title="在线交流"/></a>
							</div>
						</td>
						</tr></table>
					
					
				  </div>
				</div>
				
			
				
			</td>
			
			<td style="padding-left:20px;">
				<div align="left" style="min-width:300px" class="list-group">
				<div class="list-group-item  list-group-item-info">
					<i class="icon-align-left"></i> 我的申请(<span id="myapplylisttotal">0</span>)
					<a style="float:right" onclick="moemyapplylist()">更多&gt;&gt;</a>
				</div>
				<span id="myapplylist"></span>
				</div>
				
				<div class="panel panel-success">
				  <div class="panel-heading">
					<h3 class="panel-title">关于信呼</h3>
				  </div>
				  <div class="panel-body">
					
					<div style="line-height:25px">
					软件：信呼<br>
					官网：<a href="http://xh829.com/" target="_blank">http://xh829.com/</a><br>
					版本：V<span id="banben">1.0</span><br>
					下载：服务端，PC客户端，APP<a href="http://xh829.com/view_down.html" target="_blank">[去下载]</a><br>
					声明：我们是开源的，请遵守我们的<a href="http://xh829.com/view_version.html" target="_blank">开源协议</a>，谢谢！<br>
					帮助：提供开发帮助使用文档<a href="http://xh829.com/help.html" target="_blank">[查看]</a>
					</div>
	
					
					
				  </div>
				</div>
				
			</td>
			
			
			
		</tr>
		</table>
	</div>
	

	<div align="left" style="padding:0px 10px">
		<table  border="0" cellspacing="0" cellpadding="0">
		<tr valign="top">
			
			<td>
				
				
				
				<div class="tishi">&nbsp;本页面路径：webmain/home/index/rock_index.php</div>
				
				
			
			</td>
			
	
			
			
			<td style="padding-left:20px">
			
				<div class="panel panel-info" style="display:none">
				  <div class="panel-heading">
					<h3 class="panel-title">今日考勤</h3>
				  </div>
				  <div class="panel-body">
					
						<div>
							今日：2016-08-21(周日)<br>
							上班：<br>
							下班：<br>
						</div>
						<div class="blank1" style="margin:5px 0px"></div>
						<div>
							昨日：2016-08-20(周六)<br>
							上班：<br>
							下班：<br>
						</div>
					
					
				  </div>
				</div>
				
				
			
			</td>
		</tr>
		</table>
	</div>
	
	<div class="tishi" align="center">Copyright ©2016 技术支持：信呼开发团队</div>
	
</div>