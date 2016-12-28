<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var a = $('#veiw_{rand}').bootstable({
		tablename:'task',celleditor:true,modenum:'task',sort:'sort',dir:'asc',
		columns:[{
			text:'分类',dataIndex:'fenlei',editor:true,sortable:true
		},{
			text:'名称',dataIndex:'name',editor:true,align:'left'
		},{
			text:'地址',dataIndex:'url',editor:true
		},{
			text:'频率',dataIndex:'type',editor:true
		},{
			text:'运行时间',dataIndex:'time',editor:true
		},{
			text:'运行说明',dataIndex:'ratecont',editor:true
		},{
			text:'状态',dataIndex:'status',editor:true,type:'checkbox',editor:true,sortable:true
		},{
			text:'排序号',dataIndex:'sort',editor:true,sortable:true
		},{
			text:'最后运行',dataIndex:'lastdt',sortable:true,renderer:function(v){
				return v.replace(' ','<br>');
			}
		},{
			text:'最后状态',dataIndex:'state',renderer:function(v){
				var s='<font color=#888888>待运行</font>';
				if(v==1)s='<font color=green>成功</font>';
				if(v==2)s='<font color=red>失败</font>';
				return s;
			}
		},{
			text:'最后内容',dataIndex:'lastcont'
		},{
			text:'说明',dataIndex:'explain',type:'textarea',editor:true,align:'left'
		},{
			text:'提醒给',dataIndex:'todoname'	
		},{
			text:'ID',dataIndex:'id'	
		}],
		itemclick:function(){
			btn(false);
		}
	});
	
	var c = {
		del:function(){
			a.del({check:function(lx){if(lx=='yes')btn(true)}});
		},
		clickwin:function(o1,lx){
			var h = $.bootsform({
				title:'计划任务',height:400,width:500,
				tablename:'task',isedit:lx,
				params:{int_filestype:'sort,status'},
				submitfields:'fenlei,name,url,sort,status,type,time,ratecont,todoid,todoname',
				items:[{
					labelText:'分类',name:'fenlei',required:true
				},{
					labelText:'名称',name:'name',required:true
				},{
					labelText:'运行地址',name:'url',required:true
				},{
					labelText:'频率',name:'type',required:true
				},{
					labelText:'运行时间',name:'time',required:true
				},{
					labelText:'说明',name:'ratecont'
				},{
					name:'status',labelBox:'启用',type:'checkbox',checked:true
				},{
					name:'todoid',type:'hidden'
				},{
					labelText:'通知给',type:'changeuser',changeuser:{
						type:'usercheck',idname:'todoid',title:'选择人员'
					},name:'todoname',clearbool:true
				},{
					labelText:'序号',name:'sort',type:'number',value:'0'
				}],
				success:function(){
					a.reload();
				}
			});
			if(lx==1){
				h.setValues(a.changedata);
			}
			h.getField('name').focus();
		},
		refresh:function(){
			a.reload();
		},
		creaefile:function(){
			js.msg('wait','创建中...');
			js.ajax(js.getajaxurl('creaefile','{mode}','{dir}'),{},function(s){
				js.msg('success','创建成功');
			});
		},
		yunx:function(){
			if(a.changedata.status!=1){
				js.msg('msg','没有启用不能运行');
				return;
			}
			js.msg('wait','运行中...');
			var url='task.php?m=runt&a=run&mid='+a.changeid+'';
			var ase = a.changedata.url.split(',');
			var url='task.php?m='+ase[0]+'|runt&a='+ase[1]+'&runid='+a.changeid+'';
			js.ajax(url,{},function(s){
				if(s=='success'){
					js.msg('success','运行成功');
					a.reload();
				}else{
					js.msg('msg','运行失败');
				}
			});
		},
		start:function(){
			js.msg('wait','启动中...');
			js.ajax(js.getajaxurl('starttask','{mode}','{dir}'),{},function(s){
				if(s=='ok'){
					js.msg('success', '启动成功');
				}else{
					js.msg('msg', s);
				}
			});
		},
		clearzt:function(){
			js.msg('wait','清空中...');
			js.ajax(js.getajaxurl('clearzt','{mode}','{dir}'),{},function(s){
				js.msg();
				a.reload();
			});
		}
	};
	
	function btn(bo){
		get('del_{rand}').disabled = bo;
		get('edit_{rand}').disabled = bo;
		get('yun_{rand}').disabled = bo;
	}
	js.initbtn(c);
});
</script>


<div>


<table width="100%"><tr>
	<td nowrap>
		<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增</button> &nbsp; 
		<button class="btn btn-default" click="refresh" type="button"><i class="icon-refresh"></i> 刷新</button> &nbsp; 
		<button class="btn btn-default" click="clearzt" type="button">清空状态</button> &nbsp; 
		<button class="btn btn-success" click="start" type="button"><i class="icon-stop"></i> 重启任务</button>
	</td>
	
	
	
	<td width="80%"></td>
	<td align="right" nowrap>
		
		<button class="btn btn-default" id="yun_{rand}" click="yunx" disabled type="button">运行</button> &nbsp; 
		
		<button class="btn btn-danger" id="del_{rand}" click="del" disabled type="button"><i class="icon-trash"></i> 删除</button> &nbsp; 
		<button class="btn btn-info" id="edit_{rand}" click="clickwin,1" disabled type="button"><i class="icon-edit"></i> 编辑 </button>
	</td>
</tr>
</table>
</div>
<div class="blank10"></div>
<div id="veiw_{rand}"></div>
<div class="tishi">提示：执行地址如[sys,beifen]也就是运行webmain/task/runt/sysAction.php文件的beifenAction方法，以此类推。频率d每天,i分钟</div>
