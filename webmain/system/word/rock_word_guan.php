<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params};
	var num = params.num,pid,optlx=0,movefid='';
	var typeid=0,sspid=0;
	var at = $('#optionview_{rand}').bootstree({
		url:js.getajaxurl('getmywordtype','word','system'),
		columns:[{
			text:'文档类型',dataIndex:'name',align:'left',xtype:'treecolumn',width:'79%'
		},{
			text:'ID',dataIndex:'id',width:'20%'
		}],
		load:function(d){
			if(sspid==0){
				typeid = d.pid;
				sspid = d.pid;
				c.loadfile('0','所有文档');
			}
		},
		itemdblclick:function(d){
			typeid = d.id;
			c.loadfile(d.id,d.name);
		},
		itemclick:function(d){
			c.typeclidks(d);
		}
	});;
	
	var a = $('#view_{rand}').bootstable({
		tablename:'file',celleditor:true,autoLoad:false,checked:true,modedir:'{mode}:{dir}',storebeforeaction:'wordbeforeaction',fanye:true,
		columns:[{
			text:'类型',dataIndex:'fileext',renderer:function(v){
				var lxs = js.filelxext(v);
				return '<img src="web/images/fileicons/'+lxs+'.gif">';
			}
		},{
			text:'名称',dataIndex:'filename',editor:true,align:'left'
		},{
			text:'大小',dataIndex:'filesizecn',sortable:true
		},{
			text:'添加时间',dataIndex:'optdt',sortable:true
		},{
			text:'共享给',dataIndex:'shate'
		},{
			text:'文件ID',dataIndex:'id'
		},{
			text:'下载次数',dataIndex:'downci',sortable:true
		},{
			text:'',dataIndex:'opt',renderer:function(v,d,oi){
				return '<a href="javascript:;" onclick="showvies{rand}('+oi+')">查看</a>';
			}
		}],
		itemclick:function(){
			get('del_{rand}').disabled=false;
		},
		beforeload:function(){
			get('del_{rand}').disabled=true;
		}
	});
	_editfacech{rand}angback=function(a,typeid,pars2,sid){
		c.savefile(typeid, sid);
	};
	showvies{rand}=function(oi){
		var d=a.getData(oi);
		if(js.isimg(d.fileext)){
			$.imgview({url:d.filepath});
		}else{
			js.downshow(d.id)
		}
	}
	var c = {
		reload:function(){
			at.reload();
		},
		uploadfile:function(){
			var na = at.changedata.name;
			if(!na)na='文件';
			js.upload('_editfacech{rand}angback',{'title':'上传'+na+'','params1':typeid});	
		},
		loadfile:function(spd,nsd){
			$('#megss{rand}').html(nsd);
			a.setparams({'typeid':spd}, true);
		},
		genmu:function(){
			typeid = sspid;
			at.changedata={};
			this.loadfile('0','所有文档');
		},
		savefile:function(tps, sid){
			if(sid=='')return;
			js.ajax(js.getajaxurl('savefile','{mode}','{dir}'),{'typeid':tps,'sid':sid},function(s){
				a.reload();
			},'get',false, '保存中...,保存成功');
		},
		sharefile:function(){
			var fid = a.getchecked();
			if(fid==''){js.msg('msg','没有选中');return;}
			var cans = {
				type:'deptusercheck',
				title:'共享给...',
				callback:function(sna,sid){
					if(sid)c.sharefiles(sna,sid, fid);
				}
			}
			js.getuser(cans);
		},
		sharefiles:function(sna,sid, fid){
			if(sid==''||fid=='')return;
			js.ajax(js.getajaxurl('sharefile','{mode}','{dir}'),{'sid':sid,'sna':sna,'fid':fid},function(s){
				a.reload();
			},'post',false, '共享中...,共享成功');
		},
		qxsharefile:function(){
			var fid = a.getchecked();
			if(fid==''){js.msg('msg','没有选中');return;}
			js.ajax(js.getajaxurl('sharefile','{mode}','{dir}'),{'fid':fid},function(s){
				a.reload();
			},'post',false, '取消共享中...,取消成功');
		},
		movefile:function(){
			var fid = a.getchecked();
			if(fid==''){js.msg('msg','没有选中');return;}
			movefid=fid;
			js.msg('success','已选中，请在5秒内选择左边类型确认移动');
			clearTimeout(this.cmoeefese);
			this.cmoeefese=setTimeout(function(){movefid='';},5000);
		},
		typeclidks:function(d){
			if(movefid=='')return;
			js.confirm('确定将选中的文件移动到【'+d.name+'】下吗？',function(jg){
				if(jg=='yes'){
					c.movefiles(d.id, movefid);
				}
			});
		},
		movefiles:function(tid, moid){
			if(moid=='')return;
			movefid='';
			js.ajax(js.getajaxurl('movefile','{mode}','{dir}'),{'fid':moid,'tid':tid},function(s){
				a.reload();
			},'post',false, '移动中...,移动成功');
		},
		clicktypeeidt:function(){
			var d = at.changedata;
			if(d.id)c.clicktypewin(false, 1, d);
		},
		clicktypewin:function(o1, lx, da){
			var h = $.bootsform({
				title:'文档类型',height:250,width:300,
				tablename:'option',labelWidth:50,
				isedit:lx,submitfields:'name,sort,pid',cancelbtn:false,
				items:[{
					labelText:'名称',name:'name',required:true
				},{
					labelText:'上级id',name:'pid',value:0,type:'hidden'
				},{
					labelText:'排序号',name:'sort',type:'number',value:0
				}],
				success:function(){
					if(optlx==0)at.reload();
					if(optlx==1)a.reload();
				}
			});
			if(lx==1)h.setValues(da);
			if(lx==0)h.setValue('pid', typeid);
			optlx = 0;
			return h;
		},
		typedel:function(o1){
			at.del({
				url:js.getajaxurl('deloption','option','system'),params:{'stable':'word'}
			});
		},
		del:function(){
			a.del({url:js.getajaxurl('delword','{mode}','{dir}')});
		}
	};
	js.initbtn(c);
	$('#optionview_{rand}').css('height',''+(viewheight-70)+'px');
});
</script>


<table width="100%">
<tr valign="top">
<td width="220">
	<div style="border:1px #cccccc solid">
	  <div id="optionview_{rand}" style="height:400px;overflow:auto;"></div>
	  <div  class="panel-footer">
		<a href="javascript:" click="clicktypewin,0" onclick="return false"><i class="icon-plus"></i></a>&nbsp; &nbsp; 
		<a href="javascript:" click="clicktypeeidt" onclick="return false"><i class="icon-edit"></i></a>&nbsp; &nbsp; 
		<a href="javascript:" click="typedel" onclick="return false"><i class="icon-trash"></i></a>&nbsp; &nbsp; 
		<a href="javascript:" click="reload" onclick="return false"><i class="icon-refresh"></i></a>
	  </div>
	</div>  
</td>
<td width="10"></td>
<td>	
	<div>
	<table width="100%"><tr>
		<td align="left">
			<button class="btn btn-primary" click="uploadfile"  type="button"><i class="icon-upload-alt"></i> 上传文件</button>&nbsp; 
			<button class="btn btn-default" click="genmu"  type="button">所有文档</button>&nbsp; 
			<span id="megss{rand}"></span>
		</td>
		
		<td align="right">
			<button class="btn btn-default" click="sharefile" type="button"><i class="icon-share-alt"></i> 共享</button>&nbsp; 
			<button class="btn btn-default" click="qxsharefile" type="button">取消共享</button>&nbsp; 
			<button class="btn btn-default" click="movefile" type="button">移动</button>&nbsp; 
			<button class="btn btn-danger" id="del_{rand}" disabled click="del" type="button"><i class="icon-trash"></i> 删除</button>
		</td>
	</tr></table>
	</div>
	<div class="blank10"></div>
	<div id="view_{rand}"></div>
</td>
</tr>
</table>
