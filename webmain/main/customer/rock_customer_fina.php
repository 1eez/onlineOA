<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params}
	var atype=params.atype,vlx='收',type='0';
	if(atype.indexOf('fkd')>0){
		vlx='付';type='1';
	}
	var modename=''+vlx+'款单',modenum='custfina';
	var a = $('#view_{rand}').bootstable({
		tablename:modenum,params:{'atype':atype+'_all'},fanye:true,modenum:modenum,celleditor:true,modename:modename,
		columns:[{
			text:'',dataIndex:'caozuo'
		},{
			text:'所属日期',dataIndex:'dt'
		},{
			text:'合同编号',dataIndex:'htnum'
		},{
			text:'拥有者',dataIndex:'optname'
		},{
			text:'客户',dataIndex:'custname',align:'left'
		},{
			text:'金额',dataIndex:'money',sortable:true
		},{
			text:'状态',dataIndex:'ispay'
		},{
			text:''+vlx+'款时间',dataIndex:'paydt'
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
			openinput(modename, modenum,id,'&def_type='+type+'');
		},
		changlx:function(o1,lx){
			$("button[id^='state{rand}']").removeClass('active');
			$('#state{rand}_'+lx+'').addClass('active');
			var as = ['all','yi','wei'];
			a.setparams({'atype':atype+'_'+as[lx]},true);
		}
	};
	js.initbtn(c);
	$('#state{rand}_1').html('已'+vlx+'款');
	$('#state{rand}_2').html('未'+vlx+'款');
});
</script>
<div>
	<table width="100%">
	<tr>
	<td style="padding-right:10px">
		<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增</button>
	</td>
	<td>
		<input class="form-control" style="width:200px" id="key_{rand}"   placeholder="合同编号/客户/操作人">
	</td>
	<td style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button> 
	</td>
	<td  width="90%" style="padding-left:10px">
		
		<div id="stewwews{rand}" class="btn-group">
		<button class="btn btn-default active" id="state{rand}_0" click="changlx,0" type="button">全部状态</button>
		<button class="btn btn-default" id="state{rand}_1" click="changlx,1" type="button">已收款</button>
		<button class="btn btn-default" id="state{rand}_2" click="changlx,2" type="button">未收款</button>
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
