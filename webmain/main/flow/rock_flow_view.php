<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){

	var modeid = 0;
	var a = $('#view_{rand}').bootstable({
		tablename:'flow_set',celleditor:true,fanye:true,params:{modeid:0},autoLoad:false,dir:'desc',sort:'optdt',statuschange:false,
		url:publicstore('{mode}','{dir}'),storebeforeaction:'viewshowbefore',storeafteraction:'viewshowafter',
		columns:[{
			text:'操作人',dataIndex:'optname',sortable:true
		},{
			text:'操作时间',dataIndex:'optdt',sortable:true
		},{
			text:'摘要',dataIndex:'summary',align:'left'
		},{
			text:'ID',dataIndex:'id',sortable:true
		},{
			text:'状态',dataIndex:'status',sortable:true
		}],
		itemclick:function(d){
			btn(false, d);
		},
		beforeload:function(){
			btn(true);
		},
		celldblclick:function(){
			c.view();
		}
	});
	function btn(bo, d){
		get('edit_{rand}').disabled = bo;
		get('del_{rand}').disabled = bo;
	}
	var c = {
		changemode:function(){
			var v=this.value;
			modeid=v;
			a.setparams({modeid:v},true);
		},
		del:function(){
			a.del({
				url:js.getajaxurl('delmodeshuju','{mode}','{dir}'),
				params:{modeid:modeid,mid:a.changeid}
			});
		},
		view:function(){
			var d=a.changedata;
			openxiangs(d.modename,d.modenum,d.id);
		}
	};
	$('#mode_{rand}').change(c.changemode);
	$.get(js.getajaxurl('getmodearr','{mode}','{dir}'),function(str){
		var d=js.decode(str);
		js.setselectdata(get('mode_{rand}'),d.data,'id');
	});
	js.initbtn(c);
});
</script>

<div>
	<table width="100%">
	<tr>
	<td align="left">
		<select style="width:180px" id="mode_{rand}" class="form-control" ><option value="0">-选择模块-</option></select>
	</td>
	<td align="left"  style="padding:0px 10px;">
		
	</td>
	<td align="right">
		
		<button class="btn btn-info" id="edit_{rand}" click="view" disabled type="button"><i class="icon-edit"></i> 查看 </button>&nbsp; 
		<button class="btn btn-danger" click="del" disabled id="del_{rand}" type="button"><i class="icon-trash"></i> 删除</button>
	</td>
	</tr>
	</table>
	
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
<div class="tishi">提示：删除将会是彻底删除，不能恢复，请谨慎操作！如提示无删除权限，请到[流程模块→流程模块权限]上添加权限。<div>
