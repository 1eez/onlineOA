<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params}
	var atype=params.atype;
	var modename='合同',modenum='custract';
	var a = $('#view_{rand}').bootstable({
		tablename:modenum,params:{'atype':atype+'_all'},fanye:true,modenum:modenum,celleditor:true,modename:modename,
		columns:[{
			text:'',dataIndex:'caozuo'
		},{
			text:'合同编号',dataIndex:'num'
		},{
			text:'客户',dataIndex:'custname',align:'left'
		},{
			text:'拥有者',dataIndex:'optname'
		},{
			text:'签约日期',dataIndex:'signdt',sortable:true
		},{
			text:'生效日期',dataIndex:'startdt'
		},{
			text:'截止日期',dataIndex:'enddt'
		},{
			text:'类型',dataIndex:'type',sortable:true
		},{
			text:'合同金额',dataIndex:'money',sortable:true
		},{
			text:'待收付款',dataIndex:'moneys',sortable:true
		},{
			text:'状态',dataIndex:'statetext'
		},{
			text:'操作时间',dataIndex:'optdt'
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
			openxiangs(modename,modenum,d.id);
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
			openinput(modename, modenum,id);
		},
		changlx:function(o1,lx){
			$("button[id^='state{rand}']").removeClass('active');
			$('#state{rand}_'+lx+'').addClass('active');
			var as = ['all','ygq','qbsfk','bfsfk','daisfk'];
			a.setparams({'atype':atype+'_'+as[lx]},true);
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
	<td >
		<input class="form-control" style="width:200px" id="key_{rand}"   placeholder="合同编号/客户/操作人">
	</td>
	<td style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button> 
	</td>
	<td  width="90%" style="padding-left:10px">
		
		<div id="stewwews{rand}" class="btn-group">
		<button class="btn btn-default active" id="state{rand}_0" click="changlx,0" type="button">全部状态</button>
		<button class="btn btn-default" id="state{rand}_1" click="changlx,1" type="button">已过期</button>
		<button class="btn btn-default" id="state{rand}_4" click="changlx,4" type="button">待收/付款</button>
		<button class="btn btn-default" id="state{rand}_2" click="changlx,2" type="button">已全部收/付款</button>
		<button class="btn btn-default" id="state{rand}_3" click="changlx,3" type="button">部分收/付款</button>
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
