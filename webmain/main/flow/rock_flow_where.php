<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params};
	var num = params.num,mid=0,optlx=0;
	var at = $('#optionview_{rand}').bootstable({
		tablename:'flow_set',defaultorder:'`sort`',where:'and status=1',
		modedir:'{mode}:{dir}',storeafteraction:'setwherelistafter',
		columns:[{
			text:'名称',dataIndex:'name'
		},{
			text:'编号',dataIndex:'num'
		},{
			text:'条件数',dataIndex:'shu'
		},{
			text:'ID',dataIndex:'id'
		}],
		itemdblclick:function(ad,oi,e){
			$('#downshow_{rand}').html('设置<b>['+ad.id+'.'+ad.name+']</b>的条件列表');
			mid=ad.id;
			get('add_{rand}').disabled=false;
			a.search("and `setid`="+ad.id+"");
		}
	});
	
	function btn(bo){
		get('edit_{rand}').disabled = bo;
		get('del_{rand}').disabled = bo;
	}
	
	var a = $('#view_{rand}').bootstable({
		tablename:'flow_where',celleditor:true,defaultorder:'setid,id desc',
		columns:[{
			text:'名称',dataIndex:'name',
		},{
			text:'编号',dataIndex:'num'
		},{
			text:'人员',dataIndex:'recename'
		},{
			text:'人员除外',dataIndex:'nrecename'
		},{
			text:'说明',dataIndex:'explain'
		},{
			text:'排序号',dataIndex:'sort',editor:true
		},{
			text:'ID',dataIndex:'id'
		}],
		itemclick:function(d){
			mid=d.setid;
			btn(false);
		},
		beforeload:function(){
			btn(true);
		}
	});
	var c = {
		reload:function(){
			a.reload();
		},
		del:function(){
			a.del();
		},
		clickwin:function(o1,lx){
			var icon='plus',name='新增条件',id=0;
			if(lx==1){
				id = a.changeid;
				icon='edit';
				name='编辑条件';
			};
			guanflowwherelist = a;
			addtabs({num:'flowwhere'+id+'',url:'main,flow,whereedit,id='+id+',setid='+mid+',',icons:icon,name:name});
		}
	};
	js.initbtn(c);
	$('#optionview_{rand}').css('height',''+(viewheight-62)+'px');
});
</script>


<table width="100%">
<tr valign="top">
<td width="30%">
	<div class="panel panel-info" style="margin:0px">
	  <div class="panel-heading">
		<h3 class="panel-title">流程模块(双击显示)</h3>
	  </div>
	  <div id="optionview_{rand}" style="height:400px;overflow:auto"></div>
	</div>
</td>
<td width="10"></td>
<td>
	<div>
	<ul class="floats">
		<li class="floats70">
			<button class="btn btn-primary" click="clickwin,0" disabled id="add_{rand}" type="button"><i class="icon-plus"></i> 新增条件</button>&nbsp;&nbsp;
			<span id="downshow_{rand}"></span>
		</li>
		<li class="floats30" style="text-align:right">
			<button class="btn btn-info" id="edit_{rand}" click="clickwin,1" disabled type="button"><i class="icon-edit"></i> 编辑 </button> &nbsp; 
			<button class="btn btn-danger" id="del_{rand}" disabled click="del" type="button"><i class="icon-trash"></i> 删除</button>
		</li>
	</ul>
	</div>
	<div class="blank10"></div>
	<div id="view_{rand}"></div>
</td>
</tr>
</table>
