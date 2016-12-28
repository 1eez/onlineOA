<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var modenum='hrtransfer';
	var a = $('#view_{rand}').bootstable({
		tablename:'hrtransfer',celleditor:true,fanye:true,modenum:modenum,statuschange:false,
		columns:[{
			text:'调动人',dataIndex:'tranname'
		},{
			text:'调动类型',dataIndex:'trantype'
		},{
			text:'原来部门',dataIndex:'olddeptname'
		},{
			text:'原来职位',dataIndex:'oldranking'
		},{
			text:'生效日期',dataIndex:'effectivedt',sortable:true
		},{
			text:'调动后部门',dataIndex:'newdeptname'
		},{
			text:'调动后职位',dataIndex:'newranking'
		},{
			text:'申请人',dataIndex:'optname'
		},{
			text:'操作时间',dataIndex:'optdt'
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
			openxiangs('人事调动',modenum,d.id);
		},
		clickwin:function(){
			openinput('人事调动',modenum);
		}
	};
	js.initbtn(c);
});
</script>
<div>
<table width="100%">
<tr>
	<td style="padding-right:10px">
		<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增</button>
	</td>
	<td>
		<input class="form-control" style="width:250px" id="key_{rand}"   placeholder="调动人/调动类型/职位/部门">
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
