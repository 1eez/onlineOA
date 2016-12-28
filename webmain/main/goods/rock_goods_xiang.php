<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var a = $('#view_{rand}').bootstable({
		tablename:'goodss',celleditor:true,fanye:true,dir:'desc',sort:'a.id',
		url:publicstore('{mode}','{dir}'),storebeforeaction:'xiangbeforeshow',storeafteraction:'xiangaftershow',
		columns:[{
			text:'名称',dataIndex:'name',align:'left'
		},{
			text:'分类',dataIndex:'typeid'
		},{
			text:'类型',dataIndex:'kind'
		},{
			text:'日期',dataIndex:'applydt'
		},{
			text:'操作人',dataIndex:'optname'
		},{
			text:'数量',dataIndex:'count',sortable:true,align:'right'
		},{
			text:'说明',dataIndex:'explain',align:'left'
		},{
			text:'状态',dataIndex:'status'
		}]
	});
	var c = {
		search:function(){
			var s=get('key_{rand}').value;
			a.setparams({key:s,dt:get('dt1_{rand}').value},true);
		},
		clickdt:function(o1, lx){
			$(o1).rockdatepicker({initshow:true,view:'month',inputid:'dt'+lx+'_{rand}'});
		},
		daochu:function(){
			a.exceldown('物品出入库详情');
		}
	};
	

	js.initbtn(c);
});
</script>
<div>
<table width="100%"><tr>
	<td nowrap>
		<div style="width:120px"  class="input-group">
			<input placeholder="月份" readonly class="form-control" id="dt1_{rand}" >
			<span class="input-group-btn">
				<button class="btn btn-default" click="clickdt,1" type="button"><i class="icon-calendar"></i></button>
			</span>
		</div>
	</td>
	<td  style="padding-left:10px">
		<div class="input-group" style="width:250px">
			<input class="form-control" id="key_{rand}"   placeholder="名称">
			<span class="input-group-btn">
				<button class="btn btn-default" click="search" type="button"><i class="icon-search"></i></button>
			</span>
		</div>
	</td>
	
	<td width="80%"></td>
	<td align="right" nowrap>
		<button class="btn btn-default" click="daochu,1" type="button">导出</button>
	</td>
</tr></table>
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
