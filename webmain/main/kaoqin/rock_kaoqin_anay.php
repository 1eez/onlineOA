<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var a = $('#view_{rand}').bootstable({
		tablename:'kqanay',celleditor:true,fanye:true,
		url:publicstore('{mode}','{dir}'),storeafteraction:'kqanayaftershow',storebeforeaction:'kqanaybeforeshow',
		columns:[{
			text:'部门',dataIndex:'deptname',align:'left'
		},{
			text:'姓名',dataIndex:'name',sortable:true
		},{
			text:'日期',dataIndex:'dt',sortable:true
		},{
			text:'星期',dataIndex:'week'
		},{
			text:'状态名称',dataIndex:'ztname'
		},{
			text:'状态值',dataIndex:'state',align:'left',renderer:function(v,d){
				var s=''+v+'';
				if(d.miaocn!='')s+='['+d.miaocn+']';
				if(!isempt(d.time))s+='('+d.time.substr(11)+')';
				if(!isempt(d.states)){
					v='正常';
					s=d.states;
				}
				if(v!='正常' && d.iswork==1)s='<font color="red">'+s+'</font>';
				return s;
			}
		},{
			text:'是否工作日',dataIndex:'iswork',sortable:true,renderer:function(v){
				return ['否','是'][v];
			}
		}],
		itemclick:function(){
			get('xqkaoqb_{rand}').disabled=false;
		}
	});
	var c = {
		search:function(){
			var s=get('key_{rand}').value;
			var is = (get('iswork_{rand}').checked)?'1':'0';
			a.setparams({key:s,dt1:get('dt1_{rand}').value,iswork:is},true);
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
			js.ajax(js.getajaxurl('kqanayall','{mode}','{dir}'),{dt:dt},function(){
				js.msg('success','分析成功');
				a.reload();
			});
		},
		xqkaoqb:function(){
			var d=a.changedata;
			addtabs({num:'adminkaoqin'+d.uid+'',url:'main,kaoqin,geren,uid='+d.uid+'',icons:'time',name:''+d.name+'的考勤'});
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
	<td nowrap style="padding-left:10px">
		<label><input id="iswork_{rand}" checked type="checkbox">只看工作日</label>
	</td>
	<td  style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button>
	</td>
	<td style="padding-left:5px">
		
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
