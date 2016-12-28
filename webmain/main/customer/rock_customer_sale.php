<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params}
	var atype=params.atype;
	var a = $('#view_{rand}').bootstable({
		tablename:'custsale',params:{'atype':atype},fanye:true,modenum:'custsale',celleditor:true,modename:'销售机会',
		columns:[{
			text:'',dataIndex:'caozuo'
		},{
			text:'客户',dataIndex:'custname',align:'left'
		},{
			text:'来源',dataIndex:'laiyuan'
		},{
			text:'销售',dataIndex:'optname'
		},{
			text:'状态',dataIndex:'state'
		},{
			text:'金额',dataIndex:'money'
		},{
			text:'操作时间',dataIndex:'optdt'
		},{
			text:'创建人',dataIndex:'createname'
		},{
			text:'说明',dataIndex:'explain',align:'left'
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
			openxiangs('销售机会','custsale',d.id);
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
			openinput('销售机会', 'custsale',id);
		},
		changlx:function(o1,lx){
			$("button[id^='state{rand}']").removeClass('active');
			$('#state{rand}_'+lx+'').addClass('active');
			a.setparams({zt:lx},true);
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
		<input class="form-control" style="width:180px" id="key_{rand}"  placeholder="名称/销售人">
	</td>
	<td style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button> 
	</td>
	<td  width="90%" style="padding-left:10px">
		
		<div id="stewwews{rand}" class="btn-group">
		<button class="btn btn-default active" id="state{rand}_" click="changlx," type="button">全部状态</button>
		<button class="btn btn-default" id="state{rand}_0" click="changlx,0" type="button">跟进中</button>
		<button class="btn btn-default" id="state{rand}_1" click="changlx,1" type="button">已成交</button>
		<button class="btn btn-default" id="state{rand}_2" click="changlx,2" type="button">已丢失</button>
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
