var touchobj=false;
var strformat = {
	sendcodearr:{},
	sendcuxo:0,
	emotsstr:',[微笑],[撇嘴],[色],[发呆],[得意],[流泪],[害羞],[闭嘴],[睡],[大哭],[尴尬],[发怒],[调皮],[呲牙],[惊讶],[难过],[酷],[冷汗],[抓狂],[吐],[偷笑],[愉快],[白眼],[傲慢],[饥饿],[困],[恐惧],[流汗],[憨笑],[悠闲],[奋斗],[咒骂],[疑问],[嘘],[晕],[疯了],[衰],[骷髅],[敲打],[再见],[擦汗],[抠鼻],[鼓掌],[糗大了],[坏笑],[左哼哼],[右哼哼],[哈欠],[鄙视],[委屈],[快哭了],[阴险],[亲亲],[吓],[可怜],[菜刀],[西瓜],[啤酒],[篮球],[乒乓],[咖啡],[饭],[猪头],[玫瑰],[凋谢],[嘴唇],[爱心],[心碎],[蛋糕],[闪电],[炸弹],[刀],[足球],[瓢虫],[便便],[月亮],[太阳],[礼物],[拥抱],[强],[弱],[握手],[胜利],[抱拳],[勾引],[拳头],[差劲],[爱你],[NO],[OK],[爱情],[飞吻],[跳跳],[发抖],[怄火],[转圈],[磕头],[回头],[跳绳],[投降],[激动],[街舞],[献吻],[左太极],[右太极]',
	addcode:function(key, val){
		this.sendcuxo++;
		key	= key+','+this.sendcuxo;
		this.sendcodearr[key] = val;
		return '[C]'+key+'[/C]'
	},
	geturl:function(d){
		if(!d)d={'url':''};
		var url = d.url;
		if(!url&&d.table&&d.mid)url='?m=flow&a=view&d=taskrun&table='+d.table+'&mid='+d.mid+'&uid='+adminid+'';
		return url;
	},
	emotspath:'',
	strcont:function(nr){
		var str = unescape(nr);
		str	= this.strcontss(str,'A', '<a target="_blank" href="{s1}">{s2}</a>');
		str	= this.strcontss(str,'IMGS', '<img src="{s1}" onclick="strformat.openimg(this.src)">');
		str	= this.strcontss(str,'IMG', '<img src="{s1}" onclick="strformat.openimg(this.src)" width="150">');
		str	= this.strcontss(str,'FILE', '<a onclick="strformat.downshow(\'{s1}\')" href="javascript:;"><img src="'+this.emotspath+'images/fileicons/{s3}.gif" align="absmiddle" class="icon">{s2}</a>');
		var patt1	= new RegExp("\\[(.*?)\\](.*?)", "gi"),emu,i,st1,oi;
		 emu		= str.match(patt1);
		if(emu!=null){
			for(i=0;i<emu.length; i++){
				st1=emu[i];
				oi=this.emotsarrss[st1];
				if(oi)str	= str.replace(st1, '<img height="24" width="24" src="'+this.emotspath+'images/im/emots/qq/'+(oi-1)+'.gif">');
			}
		}
		str	= str.replace(/\n/gi, '<br>');
		return str;
	},
	downshow:function(sid){
		var url = 'mode/upload/uploadshow.php?id='+sid+'';
		openurlla(url, 400, 300);
		return false;
	},
	strcontss:function(str,bq,rstr){
		var patt1	= new RegExp("\\["+bq+"\\](.*?)\\[\\/"+bq+"\\]", "gi");
		var emu		= str.match(patt1);
		if(emu != null){
			bq1	= bq.toLowerCase();
			for(var i=0;i<emu.length; i++){
				var s0	= emu[i].replace('['+bq+']','').replace('[/'+bq+']','');
				s0		= s0.replace('['+bq1+']','').replace('[/'+bq1+']','');
				var s1	= s0,s2 = s0,s3='',sa;
				if(s0.indexOf('|')>0){
					sa = s0.split('|');
					s1 = sa[1];
					s2 = sa[0];
					s3 = sa[2];
				}
				var s4	= rstr.replace('{s1}',s1).replace('{s2}',s2).replace('{s3}',s3);
				str		= str.replace(emu[i], s4);
			}
		}
		return str;
	},
	sendinstr:function(str, tuas){
		var bq		= 'C';
		var patt1	= new RegExp("\\["+bq+"\\](.*?)\\[\\/"+bq+"\\]", "gi");
		var emu		= str.match(patt1);
		
		if(emu != null){
			for(var i=0;i<emu.length; i++){
				var s0	= emu[i].replace('['+bq+']','').replace('[/'+bq+']','');
				str		= str.replace(emu[i], this.sendcodearr[s0]);
			}
		}
		var nowa	= js.serverdt('Y-m-d H:i:s 星期W'),
			nowas	= nowa.split(' ');
		var ztstr	= [['now',nowa],['date',nowas[0]],['time',nowas[1]],['week',nowas[2]],['百度','https://www.baidu.com/',1],['官网','http://xh829.com/',1]];
		var patt1,a,thnr,ths='';
		for(var i=0; i<ztstr.length; i++){
			a	=	ztstr[i];
			if(a[2] == 1){
				patt1	= new RegExp(""+a[0]+"", "gi");
				thnr	= '[A]'+a[0]+'|'+a[1]+'[/A]';
			}else{
				thnr	= a[1];
				patt1	= new RegExp("\\["+a[0]+"\\]", "gi");
			}
			str	= str.replace(patt1, thnr);
		}
		return str;
	},
	picshow:function(str, wj){
		var s=str,sa;
		if(s.indexOf('[图片.')==0){
			s=s.substr(1,s.length-1);
			sa=s.split('.');
			if(wj)s='<img src="'+apiurl+''+wj+'">';
		}
		return s;
	},
	showdt:function(sj){
		if(!sj)sj='';
		var s='';
		sja=sj.split(' ');
		if(sj.indexOf(this.dt)==0){
			s=sja[1];
		}else{
			s=sj.substr(5,11);
		}
		return s;
	},
	showqp:function(type,name,dt,cont,nuid, fase,rnd){
		var str = this.strcont(cont);
		if(!rnd)rnd=js.getrand();
		var nr	= '';
		nr+='<div id="ltcont_'+rnd+'" class="ltcont">';
		nr+='	<div class="qipao" align="'+type+'">';
		nr+='		<div class="dt" style="padding-'+type+':65px"><font id="ltname_'+rnd+'">'+name+'</font>('+this.showdt(dt)+')</div>';
		
		nr+='		<table border="0" cellspacing="0" cellpadding="0">';
		
		nr+='		<tr valign="top">';
		if(type == 'left'){
			nr+='			<td width="50" align="center"><img src="'+fase+'" class="qipaoface" width="40" height="40"></td>';
			nr+='			<td><div class="qipao'+type+'"></div></td>';
		}else{
			nr+='			<td width="60" align="right">';
			if(nuid)nr+='<img src="images/loadings.gif" title="发送中..." id="'+nuid+'" style="margin-top:5px" align="absmiddle">&nbsp;';
			nr+='			</td>';
		}
		
		nr+='			<td>';
		nr+='			<div ontouchstart="touchobj=this" id="qipaocont_'+rnd+'" rand="'+rnd+'" class="qipaocont qipaocont'+type+'">'+str+'</div>';
		nr+='			</td>';
		
		if(type == 'right'){
			nr+='			<td><div class="qipao'+type+'"></div></td>';
			nr+='			<td width="50" align="center"><img src="'+fase+'" class="qipaoface" width="40" height="40"></td>';
		}else{
			nr+='			<td width="60"></td>';
		}
		
		nr+='		</tr></table>';
		nr+='	</div>';
		nr+='</div>';
		return nr;
	},
	showupfile:function(f){
		var nuid= js.now('time'),optdt = js.serverdt(),nr='';
		nr = '<div style="width:150px;font-size:14px;">';
		if(f.isimg){
			nr+='<div><img width="150" id="imgview_'+nuid+'" src="'+this.emotspath+'images/noimg.jpg"><br>'+f.filesizecn+'</div>';
		}else{
			nr+= '<div><img src="'+this.emotspath+'images/fileicons/'+js.filelxext(f.fileext)+'.gif" align="absmiddle">&nbsp;'+f.filename+'('+f.filesizecn+')</div>';
		}
		nr+= '<div class="progresscls"><div id="progresscls_'+nuid+'" class="progressclssse"></div><div class="progressclstext"  id="progresstext_'+nuid+'">0%</div></div>';
		nr+= '<div id="progcanter_'+nuid+'"><a href="javascript:;" onclick="strformat.cancelup(\''+nuid+'\')">取消</a></div>';
		nr+= '</div>';
		this.nuidup_tep = nuid;
		var cont= this.showqp('right','我',optdt, nr, nuid, f.face, nuid);
		return {'cont':cont,optdt:optdt,nuid:nuid};
	},
	upprogresss:function(per, nuid){
		if(!nuid)nuid=this.nuidup_tep;
		$('#progresscls_'+nuid+'').css('width',''+per+'%');
		$('#progresstext_'+nuid+'').html(''+per+'%');
		if(per==100)$('#progcanter_'+nuid+'').remove();
	},
	upsuccess:function(f){
		var nuid=this.nuidup_tep;
		$('#progresstext_'+nuid+'').html('上传成功');
		if(f.isimg)get('imgview_'+nuid+'').src=''+apiurl+''+f.thumbpath+'';
	},
	cancelup:function(nuid){
		if(!nuid)nuid=this.nuidup_tep;
		if(this.upobj)this.upobj.abort();
		$('#ltcont_'+nuid+'').remove();
	},
	openimg:function(src)
	{
		var img = src;
		if(src.indexOf('thumb')>0){
			var ext = src.substr(src.lastIndexOf('.')+1);
			img = src.substr(0,src.lastIndexOf('_'))+'.'+ext;
		}
		js.open(img);
	},
	emotsarrss:{},
	init:function(){
		var a = this.emotsstr.split(',');
		this.emotsarr=a;
		var len = a.length,i;
		for(i=1;i<len;i++){
			this.emotsarrss[a[i]]=i;
		}
		this.dt=js.now();
	}
}
strformat.init();