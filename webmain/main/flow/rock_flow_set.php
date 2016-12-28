<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var qianss='';
	var a = $('#view_{rand}').bootstable({
		tablename:'flow_set',dir:'asc',sort:'sort',celleditor:true,
		url:publicstore('{mode}','{dir}'),fanye:true,pageSize:10,storeafteraction:'modeafter',
		columns:[{
			text:'类型',dataIndex:'type',sortable:true,editor:true
		},{
			text:'编号',dataIndex:'num'
		},{
			text:'模块名',dataIndex:'name',editor:true
		},{
			text:'对应表',dataIndex:'table'
		},{
			text:'排序号',dataIndex:'sort',editor:true,sortable:true
		},{
			text:'针对人员',dataIndex:'recename'
		},{
			text:'状态',dataIndex:'status',type:'checkbox',editor:true,sortable:true
		},{
			text:'有流程',dataIndex:'isflow',type:'checkbox',sortable:true
		},{
			text:'PC端提醒',dataIndex:'pctx',type:'checkbox',editor:true,sortable:true
		},{
			text:'邮件提醒',dataIndex:'emtx',type:'checkbox',editor:true,sortable:true
		},{
			text:'APP提醒',dataIndex:'mctx',type:'checkbox',editor:true,sortable:true
		},{
			text:'微信提醒',dataIndex:'wxtx',type:'checkbox',editor:true,sortable:true
		},{
			text:'录入',dataIndex:'islu',type:'checkbox',editor:true,sortable:true
		},{
			text:'编号规则',dataIndex:'sericnum'
		},{
			text:'ID',dataIndex:'id'
		}],
		itemclick:function(d){
			btn(false, d);
		},
		beforeload:function(){
			btn(true);
		},
		load:function(d){
			qianss=d.qian;
		}
	});
	function btn(bo, d){
		get('edit_{rand}').disabled = bo;
		get('downbtn_{rand}').disabled = bo;
		get('biaoge_{rand}').disabled = bo;
		get('biaoges_{rand}').disabled = bo;
		if(d && d.type=='系统')bo=true;
		get('del_{rand}').disabled = bo;
	}
	var c = {
		del:function(){
			js.confirm('确定要删除选中模块吗？删除了所有数据就都没了，不能恢复的哦',function(jg){
				if(jg=='yes')c.delss();
			});
		},
		delss:function(){
			if(a.changeid==0)return;
			js.ajax(js.getajaxurl('delmode','{mode}','{dir}'),{id:a.changeid},function(){
				a.reload();
			},'post',false,'删除中...,删除成功');
		},
		reload:function(){
			a.reload();
		},
		clickwin:function(o1,lx){
			var icon='plus',name='新增流程模块',id=0;
			if(lx==1){
				id = a.changeid;
				icon='edit';
				name='编辑流程模块';
			};
			guanflowsetlist = a;
			addtabs({num:'flowset'+id+'',url:'main,flow,setedit,id='+id+'',icons:icon,name:name});
		},
		input:function(at){
			var url='?m=flow&d=main&a=input&setid='+a.changeid+'&atype='+at+'';
			js.open(url,900,500);
		},
		elements:function(){
			var name='['+a.changedata.name+']表单元素';
			var id = a.changeid;
			addtabs({num:'flowelements'+id+'',url:'main,flow,element,mid='+id+'',name:name});
		},
		pipei:function(){
			js.ajax(js.getajaxurl('reloadpipei','{mode}','{dir}'),{},function(s){
				js.msg('success', s);
			},'get',false,'匹配中...,匹配完成');
		},
		clearalldata:function(id){
			js.confirm('确定要清空此['+a.changedata.name+']模块所有数据嘛？<b style="color:red">慎重慎重慎重慎重！</b>',function(ssal){
				if(ssal=='yes')c.clearalldatas(id);
			});
		},
		clearalldatas:function(id){
			js.msg('msg','不允许清空');
		},
		biaoge:function(){
			this.showtalbe(a.changedata.table);
		},
		biaoges:function(){
			this.showtalbe(a.changedata.tables);
		},
		showtalbe:function(table){
			if(!table)return;
			var name=''+qianss+''+table+'';
			addtabs({num:'tablefields'+name+'',url:'system,table,fields,table='+name+'',name:'['+name+']字段管理'});
		}
	};
	js.initbtn(c);
	
	$('#downbtn_{rand}').rockmenu({
		width:170,top:35,donghua:false,
		data:[{
			name:'表单元素管理',lx:0
		},{
			name:'PC端录入页面布局',lx:1
		},{
			name:'清空此模块数据',lx:2
		}],
		itemsclick:function(d, i){
			var id = a.changedata.id;
			if(!id)return;
			if(d.lx==1)c.input(0);
			if(d.lx==0)c.elements();
			if(d.lx==2)c.clearalldata(id);
		}
	});
});
</script>

<div>
	<table width="100%">
	<tr>
	<td align="left" nowrap>
		<button class="btn btn-warning" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增</button>&nbsp; 
		<button class="btn btn-primary" disabled id="downbtn_{rand}" type="button">模块开发管理 <i class="icon-angle-down"></i></button>&nbsp; 
		<button class="btn btn-default" click="pipei" type="button">重新匹配流程</button>&nbsp; 
		<button class="btn btn-default" id="biaoge_{rand}" disabled click="biaoge,1" type="button"><i class="icon-table"></i> 对应主表管理</button>
		<button class="btn btn-default" id="biaoges_{rand}" disabled click="biaoges,1" type="button"><i class="icon-table"></i> 对应子表管理</button>
	</td>
	<td align="left"  style="padding:0px 10px;">
		
	</td>
	<td width="90%">
		
	</td>
	<td align="right" nowrap>
		
		<button class="btn btn-info" id="edit_{rand}" click="clickwin,1" disabled type="button"><i class="icon-edit"></i> 编辑 </button>&nbsp; 
		<button class="btn btn-danger" click="del" disabled id="del_{rand}" type="button"><i class="icon-trash"></i> 删除</button>
	</td>
	</tr>
	</table>
	
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
<div class="tishi">提示：对应表请使用数据库管理工具管理，如phpMyadmin,Navicat等<div>
