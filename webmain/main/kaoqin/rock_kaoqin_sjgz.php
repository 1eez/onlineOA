<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var a = $('#view_{rand}').bootstable({
		tablename:'kqsjgz',celleditor:true,tree:true,
		url:js.getajaxurl('kqsjgzdata','{mode}','{dir}'),
		columns:[{
			text:'规则名称',dataIndex:'name',align:'left',editor:true
		},{
			text:'开始时间',dataIndex:'stime'
		},{
			text:'结束时间',dataIndex:'etime'
		},{
			text:'取值类型',dataIndex:'qtype',renderer:function(v, d){
				var s='&nbsp;';
				if(d.level!=1){
					if(v==0)s='最小值';
					if(v==1)s='<font color="#ff6600">最大值</font>';
				}
				return s;
			}
		},{
			text:'排序号',dataIndex:'sort',editor:true
		},{
			text:'ID',dataIndex:'id'
		}],
		itemclick:function(){
			btn(false);
		},
		beforeload:function(){
			btn(true);
		}
	});
	
	function btn(bo){
		get('del_{rand}').disabled = bo;
		get('edit_{rand}').disabled = bo;
		get('down_{rand}').disabled = bo;
	}
	
	var c = {
		del:function(){
			a.del({url:js.getajaxurl('kqsjgzdatadel','{mode}','{dir}')});
		},
		clickwin:function(o1,lx){
			var h = $.bootsform({
				title:'考勤规则',height:380,width:400,
				tablename:'kqsjgz',isedit:lx,
				params:{int_filestype:'pid,sort,qtype'},
				submitfields:'name,pid,sort,qtype,stime,etime',
				items:[{
					labelText:'名称',name:'name',required:true
				},{
					labelText:'上级ＩＤ',name:'pid',required:true,value:'0',type:'hidden'
				},{
					labelText:'开始时间',name:'stime',type:'date',view:'time'
				},{
					labelText:'结束时间',name:'etime',type:'date',view:'time'
				},{
					labelText:'取值类型',name:'qtype',type:'select',valuefields:'id',displayfields:'name',store:[{id:'0',name:'最小值'},{id:'1',name:'最大值'}]
				},{
					labelText:'序号',name:'sort',type:'number',value:'0'
				}],
				success:function(){
					a.reload();
				}
			});
			if(lx==1)h.setValues(a.changedata);
			h.getField('name').focus();
			if(lx==2)h.setValue('pid', a.changedata.id);
		}
	};
	

	js.initbtn(c);
});
</script>
<div>
<table width="100%"><tr>
	<td nowrap>
		<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增规则</button>
	</td>
	
	<td></td>
	<td align="right" nowrap>
		<button class="btn btn-warning" click="clickwin,2" id="down_{rand}" disabled type="button">新增下级</button> &nbsp; 
		<button class="btn btn-info" id="edit_{rand}" click="clickwin,1" disabled type="button"><i class="icon-edit"></i> 编辑 </button> &nbsp; 
		<button class="btn btn-danger" id="del_{rand}" click="del" disabled type="button"><i class="icon-trash"></i> 删除</button>
		
	</td>
</tr></table>
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
<div class="tishi">此结构为3级结构，顶级为考勤规则名称，第2级此规则下每天考勤的名称，第3级考勤名称对应状态值取值时间。</div>
