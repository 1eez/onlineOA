<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var modenum='reward';
	var a = $('#view_{rand}').bootstable({
		tablename:'reward',celleditor:true,fanye:true,modenum:modenum,statuschange:false,
		columns:[{
			text:'奖惩对象',dataIndex:'object'
		},{
			text:'申请日期',dataIndex:'applydt',sortable:true
		},{
			text:'类型',dataIndex:'type'
		},{
			text:'发送时间',dataIndex:'happendt',sortable:true
		},{
			text:'发生地点',dataIndex:'hapaddress'
		},{
			text:'奖惩结果',dataIndex:'result'
		},{
			text:'奖惩金额',dataIndex:'money',sortable:true
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
			openxiangs('奖惩处罚',modenum,d.id);
		},
		clickwin:function(){
			openinput('奖惩处罚',modenum);
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
		<input class="form-control" style="width:250px" id="key_{rand}"   placeholder="奖惩对象">
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
