/**
*	无刷新上传
*	createname：雨中磐石
*	homeurl：http://xh829.com/
*	Copyright (c) 2016 rainrock (xh829.com)
*	Date:2016-01-01
*/

(function ($) {

	function rockupload(opts){
		var me 		= this;
		var maxs 	= parseFloat(js.getoption('uploadmaxsize','5'));
		var opts	= js.apply({inputfile:'',initremove:true,uptype:'*',maxsize:maxs,onchange:function(){},onprogress:function(){},onsuccess:function(){},xu:0,fileallarr:[],autoup:true,
		onerror:function(){},fileidinput:'fileid',
		onabort:function(){},
		allsuccess:function(){}
		},opts);
		this._init=function(){
			for(var a in opts)this[a]=opts[a];
			if(!this.autoup)return;
			if(this.initremove){
				$('#'+this.inputfile+'').parent().remove();
				var s='<form style="display:none;height:0px;width:0px" name="form_'+this.inputfile+'"><input type="file" id="'+this.inputfile+'"></form>';
				$('body').append(s);
			}
			$('#'+this.inputfile+'').change(function(){
				me.change(this);
			});
		};
		this.reset=function(){
			if(!this.autoup)return;
			var fids = 'form_'+this.inputfile+'';
			if(document[fids])document[fids].reset();
		};
		this.click=function(ars){
			if(this.upbool)return;
			this.oparams = js.apply({uptype:'*'}, ars);
			this.uptype=this.oparams.uptype;
			get(this.inputfile).click();
		};
		this.change=function(o1){
			if(!o1.files){
				js.msg('msg','当前浏览器不支持上传1');
				return;
			}
			var f = o1.files[0];
			var a = {filename:f.name,filesize:f.size,filesizecn:js.formatsize(f.size)};
			if(a.filesize<=0){
				js.msg('msg',''+f.name+'不存在');
				return;
			}
			if(this.isfields(a))return;
			if(f.size>this.maxsize*1024*1024){
				this.reset();
				js.msg('msg','文件不能超过'+this.maxsize+'MB,当前文件'+a.filesizecn+'');
				return;
			}
			var filename = f.name;
			var fileext	 = filename.substr(filename.lastIndexOf('.')+1).toLowerCase();
			if(this.uptype=='image')this.uptype='jpg,gif,png,bmp,jpeg';
			if(this.uptype!='*'){
				var upss=','+this.uptype+',';
				if(upss.indexOf(','+fileext+',')<0){
					js.msg('msg','禁止文件类型,请选择'+this.uptype+'');
					return;
				}
			}
			
			a.fileext	 = fileext;
			a.isimg		 = js.isimg(fileext);
			if(a.isimg)a.imgviewurl = this.getimgview(o1);
			a.xu		 = this.xu;
			a.f 		 = f;
			for(var i in this.oparams)a[i]=this.oparams[i];
			this.filearr = a;
			this.fileallarr.push(a);
			this.xu++;
			if(!this.autoup){
				var s='<div style="padding:3px;font-size:14px;border-bottom:1px #dddddd solid">'+filename+'('+a.filesizecn+')&nbsp;<span style="color:#ff6600" id="'+this.fileview+'_'+a.xu+'"></span>&nbsp;<a onclick="$(this).parent().remove()" href="javascript:;">×</a></div>';
				$('#'+this.fileview+'').append(s);
				return;
			}
			this.onchange(a);
			this.reset();
			this._startup(f);
		};
		this.getimgview=function(o1){
			try{
				return URL.createObjectURL(o1.files.item(0));
			}catch(e){return false;}
		};
		this.isfields=function(a){
			var bo = false,i,d=this.fileallarr;
			for(i=0;i<d.length;i++){
				if(this.fileviewxu(d[i].xu) && d[i].filename==a.filename && d[i].filesize==a.filesize){
					return true;
				}
			}
			return bo;
		};
		this.sendbase64=function(nr,ocs){
			this.filearr=js.apply({filename:'截图.png',filesize:0,filesizecn:'',isimg:true,fileext:'png'}, ocs);
			this._startup(false, nr);
		};
		this.start=function(){
			this.startss(0);
		};
		this.startss=function(oi){
			if(oi>=this.xu){
				var ids='';
				var a = this.fileallarr;
				for(var i=0;i<a.length;i++)if(a[i].id)ids+=','+a[i].id+'';
				if(ids!='')ids=ids.substr(1);
				try{if(form(this.fileidinput))form(this.fileidinput).value=ids;}catch(e){};
				this.allsuccess(this.fileallarr, ids);
				return;
			}
			this.nowoi = oi;
			var f=this.fileallarr[oi];
			if(!f || !this.fileviewxu(f.xu)){
				this.startss(this.nowoi+1);
				return;
			}
			this.filearr = f;
			this.onsuccess=function(f,str){
				var dst= js.decode(str);
				if(dst.id){
					this.fileallarr[this.nowoi].id=dst.id;
					this.fileallarr[this.nowoi].filepath=dst.filepath;
				}else{
					js.msg('msg', str);
					this.fileviewxu(this.nowoi, '<font color=red>失败1</font>');
				}
				this.startss(this.nowoi+1);
			}
			this.onprogress=function(f,bil){
				this.fileviewxu(this.nowoi, ''+bil+'%');
			}
			this.onerror=function(){
				this.fileviewxu(this.nowoi, '<font color=red>失败0</font>');
				this.startss(this.nowoi+1);
			}
			this._startup(f.f);
		};
		this.fileviewxu=function(oi,st){
			if(typeof(st)=='string')$('#'+this.fileview+'_'+oi+'').html(st);
			return get(''+this.fileview+'_'+oi+'');
		};
		this._startup=function(fs, nr){
			this.upbool = true;
			try{var xhr = new XMLHttpRequest();}catch(e){js.msg('msg','当前浏览器不支持2');return;}
			var url = js.apiurl('upload','upfile');
			if(nr)url = js.apiurl('upload','upcont');
			xhr.open('POST', url, true); 
			xhr.onreadystatechange = function(){me._statechange(this);};
			xhr.upload.addEventListener("progress", function(evt){me._onprogress(evt, this);}, false);  
			xhr.addEventListener("load", function(){me._onsuccess(this);}, false);  
			xhr.addEventListener("error", function(){me._error(false,this);}, false); 
			if(fs){
				var fd = new FormData();  
				fd.append('file', fs); 
				xhr.send(fd);
			}
			if(nr){
				xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");  
				nr = nr.substr(nr.indexOf(',')+1);
				nr = nr.replace(/\+/g, '!');	
				nr = nr.replace(/\//g, '.');	
				nr = nr.replace(/\=/g, ':');
				xhr.send('content='+nr+'');
			}
			this.xhr = xhr;
		};
		this._onsuccess=function(o){
			this.upbool = false;
			var bstr 	= o.response;
			if(bstr.indexOf('id')<0){
				this._error(bstr);
			}else{
				this.onsuccess(this.filearr,bstr,o);
			}
		};
		this._error=function(ts,xr){
			this.upbool = false;
			if(!ts)ts='上传内部错误';
			this.onerror(ts);
		};
		this._statechange=function(o){
			
		};
		this._onprogress=function(evt){
			var loaded 	= evt.loaded;  
			var tot 	= evt.total;  
			var per 	= Math.floor(100*loaded/tot);
			this.onprogress(this.filearr,per, evt);
		};
		this.abort=function(){
			this.xhr.abort();
			this.upbool = false;
			this.onabort();
		};
		this._init();
	}
	
	
	$.rockupload = function(options){
		var cls  = new rockupload(options,false);
		return cls;
	}
	
})(jQuery); 