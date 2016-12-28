<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var modenum='hrredund';
	var a = $('#view_{rand}').bootstable({
		tablename:'hrredund',celleditor:true,fanye:true,modenum:modenum,statuschange:false,
		columns:[{
			text:'部门',dataIndex:'deptname'
		},{
			text:'姓名',dataIndex:'name'
		},{
			text:'职位',dataIndex:'ranking'
		},{
			text:'入职日期',dataIndex:'entrydt',sortable:true
		},{
			text:'离职日期',dataIndex:'quitdt',sortable:true
		},{
			text:'离职类型',dataIndex:'redundtype'
		},{
			text:'离职原因',dataIndex:'redundreson',align:'left'
		},{
			text:'申请时间',dataIndex:'optdt'
		},{
			text:'状态',dataIndex:'statustext'
		}],
		itemclick:function(){
			btn(false);
		},
		beforeload:function(){
			btn(true);
		}
	});
	
	function btn(bo){
		get('xiang_{rand}').disabled = bo;
	}

	var c = {
		search:function(){
			var s=get('key_{rand}').value;
			a.setparams({key:s},true);
		},
		daochu:function(){
			a.exceldown();
		},
		view:function(){
			var d=a.changedata;
			openxiangs('离职申请',modenum,d.id);
		}
	};
	js.initbtn(c);
});
</script>
<div>
<table width="100%">
<tr>
	<td>
		<input class="form-control" style="width:250px" id="key_{rand}"   placeholder="姓名/职位/部门">
	</td>
	<td  style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button>
	</td>
	<td  style="padding-left:10px" width="90%">
	
	
	</td>
	<td align="right" nowrap>
		<button class="btn btn-default" id="xiang_{rand}" click="view" disabled type="button">详情</button> &nbsp; 
		<button class="btn btn-default" click="daochu,1" type="button">导出</button> 
	</td>
</tr>
</table>
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
