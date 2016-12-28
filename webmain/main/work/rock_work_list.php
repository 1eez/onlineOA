<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params}
	var atype=params.atype,projcetid=params.projcetid;
	if(!projcetid)projcetid='0';
	var a = $('#view_{rand}').bootstable({
		tablename:'work',params:{'atype':atype,'projcetid':projcetid},fanye:true,modenum:'work',modename:'任务',
		celleditor:true,storeafteraction:'workafter',modedir:'{mode}:{dir}',
		columns:[{
			text:'操作',dataIndex:'caozuo'
		},{
			text:'名称',dataIndex:'title',align:'left'
		},{
			text:'类型',dataIndex:'type'
		},{
			text:'等级',dataIndex:'grade'
		},{
			text:'执行人',dataIndex:'dist'
		},{
			text:'开始时间',dataIndex:'startdt',sortable:true
		},{
			text:'截止时间',dataIndex:'enddt'
		},{
			text:'状态',dataIndex:'state',sortable:true
		},{
			text:'分数',dataIndex:'score'
		},{
			text:'得分',dataIndex:'mark'
		},{
			text:'创建人',dataIndex:'optname'
		}],
		itemdblclick:function(){
			c.view();
		},
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
			openxiangs('任务','work',d.id);
		},
		search:function(){
			var s=get('key_{rand}').value;
			a.setparams({key:s},true);
		},
		daochu:function(){
			a.exceldown(nowtabs.name);
		},
		clickwin:function(o1,lx){
			var id=0;
			if(lx==1)id=a.changeid;
			openinput('任务', 'work',id);
		},
		changlx:function(o1,lx){
			$("button[id^='state{rand}']").removeClass('active');
			$('#state{rand}_'+lx+'').addClass('active');
			a.setparams({zt:lx},true);
		}
	};
	js.initbtn(c);
	if(atype=='wwc'){
		$('#wense_{rand}').remove();
		$('#btngroup{rand}').hide();
	}
	if(atype!='my' && atype!='wcj')$('#wense_{rand}').remove();
});
</script>
<div>
	<table width="100%">
	<tr>
	<td id="wense_{rand}" style="padding-right:10px">
		<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 创建任务</button>
	</td>
	<td>
		<input class="form-control" style="width:200px" id="key_{rand}"   placeholder="名称/项目名称/执行人">
	</td>
	<td style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button> 
	</td>
	
	<td  width="90%" style="padding-left:10px">
		
		<div class="btn-group" id="btngroup{rand}">
		<button class="btn btn-default active" id="state{rand}_" click="changlx," type="button">全部任务</button>
		<button class="btn btn-default" id="state{rand}_0" click="changlx,0" type="button">待执行</button>
		<button class="btn btn-default" id="state{rand}_1" click="changlx,1" type="button">已完成</button>
		<button class="btn btn-default" id="state{rand}_2" click="changlx,2" type="button">执行中</button>
		<button class="btn btn-default" id="state{rand}_2" click="changlx,3" type="button">终止</button>
		</div>	
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
