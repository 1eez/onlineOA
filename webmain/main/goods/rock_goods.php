<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var a = $('#view_{rand}').bootstable({
		tablename:'goods',celleditor:true,fanye:true,modenum:'goods',
		url:publicstore('{mode}','{dir}'),storebeforeaction:'beforeshow',storeafteraction:'aftershow',
		columns:[{
			text:'名称',dataIndex:'name'
		},{
			text:'分类',dataIndex:'typeid'
		},{
			text:'单价',dataIndex:'price',sortable:true
		},{
			text:'单位',dataIndex:'unit'
		},{
			text:'规格',dataIndex:'guige'
		},{
			text:'型号',dataIndex:'xinghao'
		},{
			text:'库存',dataIndex:'stock',sortable:true
		},{
			text:'ID',dataIndex:'id'	
		}],
		itemclick:function(){
			btn(false);
		},
		itemdblclick:function(d){
			openxiang('goods',d.id);
		}
	});
	goodsrocks = function(s){
		a.reload();
	}
	var c = {
		del:function(){
			a.del({check:function(lx){if(lx=='yes')btn(true)}});
		},
		search:function(){
			var s=get('key_{rand}').value;
			a.setparams({key:s},true);
		},
		clickwin:function(o1,lx){
			var icon='plus',name='新增',id=0;
			if(lx==1){
				id = a.changeid;
			};
			openinput('物品产品','goods', id, 'goodsrocks');
		},
		piliang:function(){
			goodsmanagesss=a;
			addtabs({num:'goodspladd',url:'main,goods,pladd',icons:'plus',name:'批量添加物品产品'});
		},
		rukuchu:function(o1, lx){
			var s='物品产品入库';
			if(lx==1)s='物品产品出库';
			addtabs({num:'rukuchugood'+lx+'',url:'main,goods,churuku,type='+lx+'',icons:'plus',name:s});
		}
	};
	
	function btn(bo){
		get('del_{rand}').disabled = bo;
		get('edit_{rand}').disabled = bo;
	}
	
	js.initbtn(c);
});
</script>
<div>
<table width="100%"><tr>
	<td nowrap>
		<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增</button>
	</td>
	<td  style="padding-left:10px">
		<button class="btn btn-primary" click="piliang" type="button">批量添加</button>
	</td>
	<td  style="padding-left:10px">
		<div class="input-group" style="width:250px">
			<input class="form-control" id="key_{rand}"   placeholder="名称">
			<span class="input-group-btn">
				<button class="btn btn-default" click="search" type="button"><i class="icon-search"></i></button>
			</span>
		</div>
	</td>
	<td  width="80%" style="padding-left:10px">
		<div class="btn-group">
		<button class="btn btn-default" click="rukuchu,0" type="button">入库操作</button>
		<button class="btn btn-default" click="rukuchu,1" type="button">出库操作</button>
		</div>
	</td>
	<td align="right" nowrap>
		<button class="btn btn-danger" id="del_{rand}" click="del" disabled type="button"><i class="icon-trash"></i> 删除</button> &nbsp; 
		<button class="btn btn-info" id="edit_{rand}" click="clickwin,1" disabled type="button"><i class="icon-edit"></i> 编辑 </button>
	</td>
</tr></table>
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
