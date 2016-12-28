<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params}
	var atype=params.atype;
	var a = $('#view_{rand}').bootstable({
		tablename:'kqdkjl',celleditor:true,fanye:true,modenum:'kqdkjl',sort:'id',dir:'desc',
		modedir:'{mode}:{dir}',params:{'atype':atype},storeafteraction:'kqdkjlaftershow',storebeforeaction:'kqdkjlbeforeshow',
		columns:[{
			text:'部门',dataIndex:'deptname',align:'left'
		},{
			text:'姓名',dataIndex:'name'
		},{
			text:'打卡时间',dataIndex:'dkdt',sortable:true
		},{
			text:'星期',dataIndex:'week'
		},{
			text:'类型',dataIndex:'type',sortable:true
		},{
			text:'添加时间',dataIndex:'optdt',sortable:true
		},{
			text:'IP',dataIndex:'ip'
		},{
			text:'MAC地址',dataIndex:'mac'
		},{
			text:'说明',dataIndex:'explain',align:'left'
		}],
		itemdblclick:function(d){
			//openxiang('kqdkjl',d.id);
		},
		itemclick:function(){
			btn(false);
		},
		beforeload:function(){
			btn(true);
		}
	});
	
	function btn(bo){
		get('del_{rand}').disabled = bo;
	}
	
	var c = {
		search:function(){
			var s=get('key_{rand}').value;
			a.setparams({key:s,dt1:get('dt1_{rand}').value,dt2:get('dt2_{rand}').value},true);
		},
		delss:function(){
			a.del();
		},
		clickdt:function(o1, lx){
			$(o1).rockdatepicker({initshow:true,view:'date',inputid:'dt'+lx+'_{rand}'});
		},
		daochu:function(){
			a.exceldown();
		},
		adddaka:function(){
			var h = $.bootsform({
				title:'打卡记录',height:240,width:380,
				tablename:'kqdkjl',isedit:0,submitfields:'dkdt,uid,explain',
				params:{otherfields:'type=3,optdt={now}'},
				items:[{
					labelText:'人员',name:'recename',required:true,type:'changeuser',changeuser:{
						type:'user',idname:'uid',title:'选择人员'
					},clearbool:true
				},{
					name:'uid',type:'hidden'
				},{
					labelText:'打卡时间',name:'dkdt',type:'date',view:'datetime',required:true
				},{
					labelText:'说明',name:'explain',type:'textarea',height:60
				}],
				success:function(){
					a.reload();
				}
			});
		},
		daoru:function(){
			dkjlmanagesss = a;
			addtabs({num:'admindkjlpl',url:'main,kaoqin,dkjlpl',name:'导入打卡记录'});
		}
	};
	if(atype=='all')$('#btnss{rand}').show();
	
	js.initbtn(c);
});
</script>
<div>
<table width="100%"><tr>
	<td nowrap>日期&nbsp;</td>
	<td nowrap>
		<div style="width:140px"  class="input-group">
			<input placeholder="" readonly class="form-control" id="dt1_{rand}" >
			<span class="input-group-btn">
				<button class="btn btn-default" click="clickdt,1" type="button"><i class="icon-calendar"></i></button>
			</span>
		</div>
	</td>
	<td nowrap>&nbsp;至&nbsp;</td>
	<td nowrap>
		<div style="width:140px"  class="input-group">
			<input placeholder="" readonly class="form-control" id="dt2_{rand}" >
			<span class="input-group-btn">
				<button class="btn btn-default" click="clickdt,2" type="button"><i class="icon-calendar"></i></button>
			</span>
		</div>
	</td>
	<td  style="padding-left:10px">
		<input class="form-control" style="width:150px" id="key_{rand}"   placeholder="姓名/部门">
	</td>
	<td  style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button>
	</td>
	<td  style="padding-left:5px">
		<button class="btn btn-default" click="daochu,1" type="button">导出</button>
	</td>
	<td width="80%"></td>
	<td align="right" id="btnss{rand}" style="display:none" nowrap>
		<button class="btn btn-default" click="daoru" type="button">导入</button>&nbsp;
		<button class="btn btn-default" click="adddaka" type="button"><i class="icon-plus"></i> 新增</button>&nbsp;
		<button class="btn btn-danger" id="del_{rand}" disabled click="delss" type="button"><i class="icon-trash"></i> 删除</button>
	</td>
</tr></table>
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
