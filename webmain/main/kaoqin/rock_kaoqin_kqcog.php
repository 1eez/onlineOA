<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var a = $('#view_{rand}').bootstable({
		tablename:'userinfo',celleditor:true,fanye:true,
		url:js.getajaxurl('publicstore','userinfo','main'),storeafteraction:'userinfoafter',storebeforeaction:'userinfobefore',
		columns:[{
			text:'部门',dataIndex:'deptname',align:'left',sortable:true
		},{
			text:'姓名',dataIndex:'name',sortable:true
		},{
			text:'职位',dataIndex:'ranking'
		},{
			text:'是否启用',dataIndex:'status',type:'checkbox'
		},{
			text:'在线打卡IP',dataIndex:'dkip',editor:true
		},{
			text:'在线打卡MAC地址',dataIndex:'dkmac',editor:true
		},{
			text:'是否考勤',dataIndex:'iskq',type:'checkbox',editor:true
		},{
			text:'是否定位打卡',dataIndex:'isdwdk',type:'checkbox',editor:true
		},{
			text:'ID',dataIndex:'id'
		}]
	});
	var c = {
		search:function(){
			var s=get('key_{rand}').value;
			a.setparams({key:s},true);
		}
	};
	js.initbtn(c);
});
</script>
<div>
<table width="100%"><tr>
	<td nowrap>
		<input class="form-control" style="width:200px" id="key_{rand}"   placeholder="姓名/部门/职位">
	</td>
	<td  style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button>
	</td>

	<td width="90%"></td>
	<td align="right" nowrap>
		
	</td>
</tr></table>
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
<div class="tishi">人员必须设置打卡IP，IP一般是内网Ip196.168的，或者电脑的物理MAC地址，才可以在线打卡，多个用,分开。</div>
