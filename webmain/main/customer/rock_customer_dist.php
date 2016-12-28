<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params}
	var atype='dist';
	var a = $('#view_{rand}').bootstable({
		tablename:'customer',params:{'atype':atype},fanye:true,modenum:'customer',celleditor:false,checked:true,
		columns:[{
			text:'',dataIndex:'caozuo'
		},{
			text:'类型',dataIndex:'type'
		},{
			text:'名称',dataIndex:'name'
		},{
			text:'单位名称',dataIndex:'unitname'
		},{
			text:'来源',dataIndex:'laiyuan'
		},{
			text:'拥有者',dataIndex:'optname'
		},{
			text:'电话',dataIndex:'tel'
		},{
			text:'状态',dataIndex:'status',sortable:true
		},{
			text:'供应商',dataIndex:'isgys',type:'checkbox',editor:true,sortable:true
		},{
			text:'共享给',dataIndex:'shate'
		},{
			text:'创建人',dataIndex:'createname'
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
			openxiangs('客户','customer',d.id);
		},
		changlx:function(o1,lx){
			$("button[id^='state{rand}']").removeClass('active');
			$('#state{rand}_'+lx+'').addClass('active');
			var as = ['all','yfp','wfp'];
			a.setparams({'atype':atype+'_'+as[lx]},true);
		},
		daochu:function(){
			a.exceldown(nowtabs.name);
		},
		clickwin:function(o1,lx){
			var id=0;
			if(lx==1)id=a.changeid;
			openinput('客户', 'customer',id);
		}
	};
	js.initbtn(c);
	
	if(atype!='my')$('#btnbnts_{rand}').remove();
});
</script>
<div>
	<table width="100%">
	<tr>
	<td id="btnbnts_{rand}" style="padding-right:10px" >
		<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增</button>
	</td>
	<td>
		<input class="form-control" style="width:180px" id="key_{rand}"   placeholder="名称/拥有者">
	</td>
	<td style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button> 
	</td>
	<td  width="90%" style="padding-left:10px">
		
		<div id="stewwews{rand}" class="btn-group">
		<button class="btn btn-default active" id="state{rand}_0" click="changlx,0" type="button">全部状态</button>
		<button class="btn btn-default" id="state{rand}_1" click="changlx,1" type="button">已分配</button>
		<button class="btn btn-default" id="state{rand}_2" click="changlx,2" type="button">未分配</button>
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
<div class="tishi">客户分配：客户负责人是我，可从新分配对应人员。</div>
