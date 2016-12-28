<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params};
	var atype=params.atype;
	var a = $('#veiw_{rand}').bootstable({
		tablename:'log',celleditor:true,sort:'id',dir:'desc',modedir:'{mode}:{dir}',params:{'atype':atype},checked:true,fanye:true,
		storebeforeaction:'logbefore',
		columns:[{
			text:'类型',dataIndex:'type'
		},{
			text:'操作人',dataIndex:'optname',sortable:true
		},{
			text:'备注',dataIndex:'remark',align:'left'
		},{
			text:'操作时间',dataIndex:'optdt',sortable:true
		},{
			text:'IP',dataIndex:'ip'
		},{
			text:'浏览器',dataIndex:'web'
		},{
			text:'Device',dataIndex:'device'
		},{
			text:'ID',dataIndex:'id',sortable:true
		}]
	});
	

	var c = {
		delss:function(){
			a.del({url:js.getajaxurl('dellog','{mode}','{dir}'),checked:true});
		},
		search:function(){
			var s=get('key_{rand}').value;
			a.setparams({key:s},true);
		},
		daochu:function(){
			a.exceldown();
		}
	};
	js.initbtn(c);
});
</script>


<div>


<table width="100%"><tr>
	<td>
		<input class="form-control" style="width:300px" id="key_{rand}"   placeholder="类型/操作人/浏览器/IP/备注">
	</td>
	<td nowrap style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button>&nbsp; 
		<button class="btn btn-default" click="daochu,1" type="button">导出</button>
	</td>
	
	
	
	<td width="80%"></td>
	<td align="right" nowrap>
	
		<button class="btn btn-danger" id="del_{rand}" click="delss" type="button"><i class="icon-trash"></i> 删除</button>
	</td>
</tr>
</table>
</div>
<div class="blank10"></div>
<div id="veiw_{rand}"></div>