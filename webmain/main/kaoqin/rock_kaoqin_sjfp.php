<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params}
	var gzdata=[],type=params.type;if(!type)type='0';
	var a = $('#view_{rand}').bootstable({
		tablename:'kqdist',celleditor:true,fanye:true,params:{'type':type},
		url:publicstore('{mode}','{dir}'),storeafteraction:'kqdistafter',storebeforeaction:'kqdistbefore',
		columns:[{
			text:'针对人员',dataIndex:'recename',sortable:true
		},{
			text:'对应规则',dataIndex:'mid',sortable:true
		},{
			text:'开始日期',dataIndex:'startdt',sortable:true
		},{
			text:'截止日期',dataIndex:'enddt',sortable:true
		},{
			text:'状态',dataIndex:'status',type:'checkbox',editor:true,sortable:true
		},{
			text:'ID',dataIndex:'id'
		}],
		itemclick:function(){
			btn(false);
		},
		beforeload:function(){
			btn(true);
		},
		load:function(d){
			gzdata=d.gzdata;
		}
	});
	
	function btn(bo){
		get('del_{rand}').disabled = bo;
		get('edit_{rand}').disabled = bo;
	}
	
	var c = {
		del:function(){
			a.del({url:js.getajaxurl('kqsjgzdatadel','{mode}','{dir}',{type:1})});
		},
		clickwin:function(o1,lx){
			var h = $.bootsform({
				title:'分配',height:320,width:400,
				tablename:'kqdist',isedit:lx,submitfields:'recename,receid,mid,startdt,enddt',
				params:{otherfields:'type='+type+''},
				items:[{
					labelText:'针对人员',name:'recename',required:true,type:'changeuser',changeuser:{
						type:'deptusercheck',idname:'receid',title:'选择人员'
					},clearbool:true
				},{
					name:'receid',type:'hidden'
				},{
					labelText:'开始日期',name:'startdt',type:'date',view:'date',required:true
				},{
					labelText:'截止日期',name:'enddt',type:'date',view:'date',required:true
				},{
					labelText:'对应规则',name:'mid',type:'select',valuefields:'id',displayfields:'name',store:gzdata,required:true
				}],
				success:function(){
					a.reload();
				}
			});
			if(lx==1){
				var d = a.changedata;d.mid=d.mids;
				h.setValues(d);
			}
		}
	};
	

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
