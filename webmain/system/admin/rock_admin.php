<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var a = $('#admin_{rand}').bootstable({
		tablename:'admin',modenum:'user',celleditor:true,sort:'sort',dir:'asc',fanye:true,
		storebeforeaction:'beforeshow',modedir:'{mode}:{dir}',fieldsafteraction:'fieldsafters',
		columns:[{
			text:'头像',dataIndex:'face',renderer:function(v,d){
				if(isempt(v))v='images/noface.png';
				return '<img src="'+v+'" id="faceviewabc_'+d.id+'" height="24" width="24">';
			}
		},{
			text:'用户名',dataIndex:'user'
		},{
			text:'姓名',dataIndex:'name',sortable:true
		},{
			text:'部门',dataIndex:'deptname',sortable:true
		},{
			text:'上级主管',dataIndex:'superman'
		},{
			text:'职位',dataIndex:'ranking',editor:true
		},{
			text:'状态',dataIndex:'status',type:'checkbox',editor:true,sortable:true
		},{
			text:'管理员',dataIndex:'type',type:'checkbox',sortable:true
		},{
			text:'登录次',dataIndex:'loginci',sortable:true
		},{
			text:'性别',dataIndex:'sex',sortable:true,type:'select',store:js.arraystr('男,女'),editor:false
		},{
			text:'办公电话',dataIndex:'tel',editor:true
		},{
			text:'入职',dataIndex:'workdate',sortable:true
		},{
			text:'排序号',dataIndex:'sort',editor:true,sortable:true
		},{
			text:'编号',dataIndex:'num'	
		},{
			text:'ID',dataIndex:'id'	
		}],
		itemclick:function(){
			btn(false);
		},
		beforeload:function(){
			btn(true);
		}
	});
	
	var c = {
		del:function(){
			a.del({check:function(lx){if(lx=='yes')btn(true)}});
		},
		search:function(){
			var s=get('key_{rand}').value;
			a.setparams({key:s},true);
		},
		clickwin:function(o1,lx){
			var icon='plus',name='新增',id=0;
			if(lx==1){
				id = a.changeid;
				icon='edit';
				name='编辑['+a.changedata.name+']';
			};
			adminusermanage = a;
			addtabs({num:'admin'+id+'',url:'system,admin,edit,id='+id+'',icons:icon,name:name+'用户'});
		},
		piliang:function(){
			adminusermanage = a;
			addtabs({num:'admina',url:'system,admin,editpl',icons:'plus',name:'批量添加用户'});
		},
		refresh:function(){
			js.msg('wait', '更新中...');
			$.get(js.getajaxurl('updatedata','admin','system'), function(da){
				js.msg('success', da);
			});
		},
		daochu:function(){
			a.exceldown();
		},
		editface:function(){
			editfacechang(a.changeid, a.changedata.name);
		}
	};
	
	function btn(bo){
		get('del_{rand}').disabled = bo;
		get('edit_{rand}').disabled = bo;
		get('face_{rand}').disabled = bo;
	}
	
	js.initbtn(c);
});
</script>



<div>

<table width="100%"><tr>
	<td nowrap>
		<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增用户</button> 
	</td>
	
	<td  style="padding-left:10px">
		<button class="btn btn-primary" click="piliang,0" type="button"><i class="icon-plus"></i> 批量添加用户</button>
	</td>
	<td  style="padding-left:10px">
		<div class="input-group" style="width:250px">
			<input class="form-control" id="key_{rand}"   placeholder="姓名/部门/职位/用户名">
			<span class="input-group-btn">
				<button class="btn btn-default" click="search" type="button"><i class="icon-search"></i></button>
			</span>
		</div>
	</td>
	<td  style="padding-left:10px">
		<button class="btn btn-default" click="daochu,1" type="button">导出</button>
	</td>
	<td width="80%"></td>
	<td align="right" nowrap>
		<button class="btn btn-success" click="refresh" type="button"><i class="icon-refresh"></i> 更新数据</button> &nbsp; 
		<button class="btn btn-danger" id="del_{rand}" click="del" disabled type="button"><i class="icon-trash"></i> 删除</button> &nbsp; 
		<button class="btn btn-info" id="edit_{rand}" click="clickwin,1" disabled type="button"><i class="icon-edit"></i> 编辑 </button> &nbsp; 
		<button class="btn btn-info" id="face_{rand}" click="editface" disabled type="button"><i class="icon-picture"></i> 修改头像</button>
	</td>
</tr>
</table>
</div>
<div class="blank10"></div>
<div id="admin_{rand}"></div>