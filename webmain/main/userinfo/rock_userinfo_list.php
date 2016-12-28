<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var modenum='userinfo';
	var a = $('#view_{rand}').bootstable({
		tablename:'userinfo',celleditor:true,fanye:true,modenum:modenum,modedir:'userinfo:main',
		storeafteraction:'userinfoafterabc',fieldsafteraction:'fieldsafters',cellautosave:false,
		columns:[{
			text:'部门',dataIndex:'deptname',align:'left',sortable:true
		},{
			text:'姓名',dataIndex:'name',sortable:true
		},{
			text:'性别',dataIndex:'sex'
		},{
			text:'职位',dataIndex:'ranking'
		},{
			text:'编号',dataIndex:'num'
		},{
			text:'状态',dataIndex:'state',sortable:true,editor:true,type:'select',store:js.arraystr('0|试用期,1|正式,2|实习生,3|兼职,4|临时工,5|离职')
		},{
			text:'入职日期',dataIndex:'workdate',sortable:true,editor:true,type:'date'
		},{
			text:'转正日期',dataIndex:'positivedt',sortable:true,editor:true,type:'date'
		},{
			text:'电话',dataIndex:'tel'
		},{
			text:'手机号',dataIndex:'mobile'
		},{
			text:'离职日期',dataIndex:'quitdt',sortable:true,editor:true,type:'date'
		},{
			text:'ID',dataIndex:'id',sortable:true
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
		get('edit_{rand}').disabled = bo;
		get('del_{rand}').disabled = bo;
	}
	
	var c = {
		del:function(){
			a.del();
		},
		search:function(){
			var s=get('key_{rand}').value;
			a.setparams({key:s,'state':get('state_{rand}').value},true);
		},
		daochu:function(){
			a.exceldown();
		},
		view:function(){
			var d=a.changedata;
			openxiangs('人员档案',modenum,d.id);
		},
		edit:function(){
			openinput('人员档案',modenum,a.changeid);
		},
		refresh:function(){
			js.msg('wait', '更新中...');
			$.get(js.getajaxurl('updatedata','admin','system'), function(da){
				js.msg('success', da);
				a.reload();
			});
		}
	};
	js.initbtn(c);
});
</script>
<div>
<table width="100%">
<tr>
	<td>
		<button class="btn btn-default" click="refresh" type="button"><i class="icon-refresh"></i> 更新数据</button>
	</td>
	<td style="padding-left:10px">
		<select class="form-control" style="width:100px" id="state_{rand}">
		<option value="">-全部状态-</option><option value="0">试用期</option><option value="1">正式</option><option value="2">实习生</option><option value="3">兼职</option><option value="4">临时工</option><option value="5">离职</option>
		</select>
	</td>
	<td style="padding-left:10px">
		<input class="form-control" style="width:200px" id="key_{rand}"   placeholder="姓名/部门/职位">
	</td>
	<td  style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button>
	</td>

	<td width="90%"></td>
	<td align="right" nowrap>
		<button class="btn btn-default" id="xiang_{rand}" click="view" disabled type="button">详情</button> &nbsp; 
		<button class="btn btn-default" id="del_{rand}" click="del" disabled type="button">删除</button> &nbsp; 
		<button class="btn btn-default" id="edit_{rand}" click="edit" disabled type="button">编辑</button> &nbsp; 
		<button class="btn btn-default" click="daochu,1" type="button">导出</button> 
	</td>
</tr>
</table>
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
<div class="tishi">添加人员请到用户管理那添加，人员信息会有一下个人信息，建议填写一些有用信息即可，删除档案，需要先删除用户在删除档案。</div>
