<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params}
	var atype=params.atype;
	var col1 = [{
		text:'部门',dataIndex:'deptname',align:'left',sortable:true
	},{
		text:'姓名',dataIndex:'name',sortable:true
	},{
		text:'职位',dataIndex:'ranking'
	}];
	var col2 = [{
		text:'正常',dataIndex:'state0'
	},{
		text:'迟到',dataIndex:'state1'
	},{
		text:'早退',dataIndex:'state2'
	}];
	var col3 = [{
		text:'未打卡',dataIndex:'weidk'
	},{
		text:'请假(小时)',dataIndex:'qingjia'
	},{
		text:'加班(小时)',dataIndex:'jiaban'
	},{
		text:'外出(次数)',dataIndex:'outci'
	}];
	function getcolumns(a1,a2,a3){
		var a4 = [].concat(a1,a2,a3);
		return a4;
	}
	var colemsn = getcolumns(col1, col2, col3);
	var a = $('#view_{rand}').bootstable({
		tablename:'admin',celleditor:true,fanye:true,params:{'atype':atype},modedir:'{mode}:{dir}',storeafteraction:'kqtotalaftershow',storebeforeaction:'kqtotalbeforeshow',
		columns:colemsn,
		itemclick:function(){
			get('xqkaoqb_{rand}').disabled=false;
		},
		loadbefore:function(d){
			var cs = [];
			for(var i in d.columns)cs.push({text:i,dataIndex:d.columns[i]});
			if(cs.length>0){
				var cols = getcolumns(col1, cs, col3);
				a.setColumns(cols);
			}
		}
	});
	var c = {
		search:function(){
			var s=get('key_{rand}').value;
			a.setparams({key:s,dt1:get('dt1_{rand}').value},true);
		},
		clickdt:function(o1, lx){
			$(o1).rockdatepicker({initshow:true,view:'month',inputid:'dt'+lx+'_{rand}'});
		},
		anaynow:function(){
			var dt = get('dt1_{rand}').value;
			if(dt==''){
				js.msg('msg','请选择月份');
				return;
			}
			js.msg('wait','['+dt+']月份的考勤分析中...');
			js.ajax(js.getajaxurl('kqanayall','{mode}','{dir}'),{dt:dt,atype:atype},function(){
				js.msg('success','分析成功');
				a.reload();
			});
		},
		xqkaoqb:function(){
			var d=a.changedata;
			addtabs({num:'adminkaoqin'+d.id+'',url:'main,kaoqin,geren,uid='+d.id+'',icons:'time',name:''+d.name+'的考勤'});
		},
		daochu:function(){
			a.exceldown('考勤统计('+get('dt1_{rand}').value+')');
		}
	};
	
	$('#dt1_{rand}').val(js.now('Y-m'));
	js.initbtn(c);
});
</script>
<div>
<table width="100%"><tr>
	<td nowrap>
		<div style="width:120px"  class="input-group">
			<input placeholder="月份" readonly class="form-control" id="dt1_{rand}" >
			<span class="input-group-btn">
				<button class="btn btn-default" click="clickdt,1" type="button"><i class="icon-calendar"></i></button>
			</span>
		</div>
	</td>
	<td  style="padding-left:10px">
		<input class="form-control" style="width:150px" id="key_{rand}"   placeholder="姓名/部门">
	</td>
	<td  style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button>
	</td>
	<td  style="padding-left:10px">
		<button class="btn btn-default" click="daochu" type="button">导出</button>
	</td>
	<td  style="padding-left:5px">
		
	</td>
	<td width="80%"></td>
	<td align="right" nowrap>
		<button class="btn btn-info" click="xqkaoqb" disabled id="xqkaoqb_{rand}" type="button">详情考勤表</button>&nbsp;&nbsp;
		<button class="btn btn-default" click="anaynow" type="button">全部重新分析</button>
	</td>
</tr></table>
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
<div class="tishi">如考勤异常有申请请假外出视为正常，统计已审核完成的。</div>
