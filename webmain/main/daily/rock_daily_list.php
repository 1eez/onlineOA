<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params}
	var atype=params.atype;
	var modenum = 'daily';
	var a = $('#view_{rand}').bootstable({
		tablename:modenum,params:{'atype':atype},fanye:true,modenum:modenum,
		modedir:'{mode}:{dir}',storeafteraction:'dailyafter',
		columns:[{
			text:'',dataIndex:'caozuo'
		},{
			text:'类型',dataIndex:'type',sortable:true
		},{
			text:'日期',dataIndex:'dt',sortable:true,align:'left'
		},{
			text:'操作人',dataIndex:'optname'
		},{
			text:'日志内容',dataIndex:'content',align:'left'
		},{
			text:'分数',dataIndex:'mark',sortable:true
		},{
			text:'新增时间',dataIndex:'adddt',sortable:true,renderer:function(v){
				return v.replace(' ','<br>');
			}
		},{
			text:'操作时间',dataIndex:'optdt',sortable:true,renderer:function(v){
				return v.replace(' ','<br>');
			}
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
		del:function(){
			a.del();
		},
		reload:function(){
			a.reload();
		},
		view:function(){
			var d=a.changedata;
			openxiangs('工作日报',modenum,d.id);
		},
		search:function(){
			a.setparams({
				key:get('key_{rand}').value,
				dt:get('dt2_{rand}').value,
				type:get('type_{rand}').value
			},true);
		},
		daochu:function(){
			a.exceldown(nowtabs.name);
		},
		clickwin:function(o1,lx){
			var id=0;
			if(lx==1)id=a.changeid;
			openinput('工作日报', modenum,id);
		},
		clickdt:function(o1, lx){
			$(o1).rockdatepicker({initshow:true,view:'date',inputid:'dt'+lx+'_{rand}'});
		}
	};
	js.initbtn(c);
	if(atype!='my')$('#tsdsse{rand}').hide();
});
</script>
<div>
	<table width="100%">
	<tr>
	<td id="tsdsse{rand}" style="padding-right:10px">
		<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增</button>
	</td>
	<td>
		<input class="form-control" style="width:180px" id="key_{rand}"  placeholder="内容/操作人">
	</td>
	<td  style="padding-left:10px">
		<div style="width:140px"  class="input-group">
			<input placeholder="日期" readonly class="form-control" id="dt2_{rand}" >
			<span class="input-group-btn">
				<button class="btn btn-default" click="clickdt,2" type="button"><i class="icon-calendar"></i></button>
			</span>
		</div>	
	</td>
	<td style="padding-left:10px">
		<select class="form-control" id="type_{rand}" style="width:100px"><option value="">所有类型</option><option value="0">日报</option><option value="1">周报</option><option value="2">月报</option><option value="3">年报</option></select>
	</td>
	<td style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button> 
	</td>
	<td style="padding-left:10px">
		
	</td>
	<td width="80%"></td>
	<td align="right" nowrap>
		<button class="btn btn-default" id="xiang_{rand}" click="view" disabled type="button">详情</button> &nbsp; 
		<button class="btn btn-default" click="daochu,1" type="button">导出</button> 
	</td>
	</tr>
	</table>
	
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
<div class="tishi">提示：灰色标识已读了</div>
