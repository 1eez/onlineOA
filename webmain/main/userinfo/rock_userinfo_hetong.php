<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var modenum='userract';
	var a = $('#view_{rand}').bootstable({
		tablename:'userract',celleditor:true,fanye:true,modenum:modenum,modedir:'userinfo:main',
		storeafteraction:'userractafterabc',storebeforeaction:'userractbeforeabc',
		columns:[{
			text:'',dataIndex:'caozuo'
		},{
			text:'部门',dataIndex:'deptname',align:'left',sortable:true
		},{
			text:'名称',dataIndex:'name'
		},{
			text:'签署人',dataIndex:'uname',sortable:true
		},{
			text:'签署单位',dataIndex:'company'
		},{
			text:'合同类型',dataIndex:'httype'
		},{
			text:'开始日期',dataIndex:'startdt'
		},{
			text:'截止日期',dataIndex:'enddt'
		},{
			text:'提前终止日期',dataIndex:'tqenddt'
		},{
			text:'状态',dataIndex:'state',sortable:true
		}]
	});
	


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
			openxiangs('员工合同',modenum,d.id);
		},
		edit:function(){
			openinput('员工合同',modenum,a.changeid);
		},
		addss:function(){
			openinput('员工合同',modenum,0);
		},
		changlx:function(o1,lx){
			$("button[id^='state{rand}']").removeClass('active');
			$('#state{rand}_'+lx+'').addClass('active');
			var arr = ['all','kdq','sxz','ygq','yzz'];
			a.setparams({atype:arr[lx]},true);
		}
	};
	js.initbtn(c);
});
</script>
<div>
<table width="100%">
<tr>
	<td nowrap>
		<button class="btn btn-primary" click="addss" type="button"><i class="icon-plus"></i> 新增</button>
	</td>
	<td  style="padding-left:10px">
		<input class="form-control" style="width:300px" id="key_{rand}"   placeholder="签署人/签署单位/合同类型/名称">
	</td>
	<td  style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button>
	</td>
	<td  style="padding-left:10px" width="90%">
	
		<div class="btn-group" id="btngroup{rand}">
		<button class="btn btn-default active" id="state{rand}_0" click="changlx,0" type="button">全部</button>
		<button class="btn btn-default" id="state{rand}_1" click="changlx,1" type="button">30天内到期</button>
		<button class="btn btn-default" id="state{rand}_2" click="changlx,2" type="button">生效中</button>
		<button class="btn btn-default" id="state{rand}_3" click="changlx,3" type="button">已过期</button>
		<button class="btn btn-default" id="state{rand}_4" click="changlx,4" type="button">已终止</button>
		</div>	
	
	
	</td>
	<td align="right" nowrap>
		<button class="btn btn-default" click="daochu,1" type="button">导出</button> 
	</td>
</tr>
</table>
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
