<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var a = $('#view_{rand}').bootstable({
		tablename:'kqdw',celleditor:true,
		columns:[{
			text:'规则名称',dataIndex:'name',align:'left',editor:true
		},{
			text:'经度',dataIndex:'location_x',renderer:function(v,d,i){
				return ''+v+'&nbsp;<a href="javascript:;" onclick="changeweizhi{rand}('+i+')">选择位置</a>';
			}
		},{
			text:'纬度',dataIndex:'location_y'
		},{
			text:'位置名称',dataIndex:'address',editor:true
		},{
			text:'允许误差(米)',dataIndex:'precision',editor:true
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
	}
	
	var c = {
		del:function(){
			a.del({url:js.getajaxurl('kqdwdkdatadel','{mode}','{dir}')});
		},
		clickwin:function(o1,lx){
			var h = $.bootsform({
				title:'位置',height:380,width:400,
				tablename:'kqdw',isedit:lx,
				submitfields:'name,address,precision',
				items:[{
					labelText:'名称',name:'name',required:true
				},{
					labelText:'位置名称',name:'address',required:true
				},{
					labelText:'允许误差(米)',name:'precision',type:'number',value:0
				}],
				success:function(){
					a.reload();
				}
			});
			if(lx==1)h.setValues(a.changedata);
			h.getField('name').focus();
		}
	};
	
	changeweizhi{rand}=function(oi){
		var d = a.getData(oi);
		var url = '?m=kaoqin&d=main&a=locationchange';
		if(!isempt(d.location_x))url+='&location_x='+d.location_x+'&location_y='+d.location_y+'&scale='+d.scale+'';
		openxiangs('选择位置',url,'','backshow{rand}');
	}
	backshow{rand}=function(d){
		d.id = a.changeid;
		js.ajax(js.getajaxurl('savaweizz','{mode}','{dir}'),d, function(s){
			a.reload();
		},'post');
	}
	js.initbtn(c);
});
</script>
<div>
<table width="100%"><tr>
	<td nowrap>
		<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增</button>
	</td>
	
	<td></td>
	<td align="right" nowrap>
		<button class="btn btn-info" id="edit_{rand}" click="clickwin,1" disabled type="button"><i class="icon-edit"></i> 编辑 </button> &nbsp; 
		<button class="btn btn-danger" id="del_{rand}" click="del" disabled type="button"><i class="icon-trash"></i> 删除</button>
		
	</td>
</tr></table>
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
<div class="tishi">位置必须从地图上选择哦</div>
