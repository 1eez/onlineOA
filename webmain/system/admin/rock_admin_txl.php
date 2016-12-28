<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var a = $('#admin_{rand}').bootstable({
		tablename:'admin',sort:'sort',dir:'asc',fanye:true,
		storebeforeaction:'tongxlbeforeshow',modedir:'{mode}:{dir}',
		columns:[{
			text:'头像',dataIndex:'face',notexcel:true,renderer:function(v,d){
				if(isempt(v))v='images/noface.png';
				return '<img src="'+v+'" height="24" width="24">';
			}
		},{
			text:'姓名',dataIndex:'name',sortable:true
		},{
			text:'部门',dataIndex:'deptallname',align:'left'
		},{
			text:'职位',dataIndex:'ranking',sortable:true
		},{
			text:'办公电话',dataIndex:'tel'
		},{
			text:'手机号',dataIndex:'mobile'
		},{
			text:'邮箱',dataIndex:'email'
		},{
			text:'排序号',dataIndex:'sort',sortable:true
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
		changlx:function(o1,lx){
			$("button[id^='state{rand}']").removeClass('active');
			$('#state{rand}_'+lx+'').addClass('active');
			a.setparams({zt:lx},true);
		}
	};
	js.initbtn(c);
});
</script>



<div>

<table width="100%"><tr>

	<td>
		<div class="input-group" style="width:250px">
			<input class="form-control" id="key_{rand}"   placeholder="姓名/部门/职位">
			<span class="input-group-btn">
				<button class="btn btn-default" click="search" type="button"><i class="icon-search"></i></button>
			</span>
		</div>
	</td>
	<td  style="padding-left:10px">
	</td>
	<td width="80%">
		<div class="btn-group" id="btngroup{rand}">
		<button class="btn btn-default active" id="state{rand}_" click="changlx," type="button">全部</button>
		<button class="btn btn-default" id="state{rand}_0" click="changlx,0" type="button">我直属下属</button>
		</div>	
	</td>
	<td align="right" nowrap>
		<button class="btn btn-default" click="daochu,1" type="button">导出</button>
	</td>
</tr>
</table>
</div>
<div class="blank10"></div>
<div id="admin_{rand}"></div>