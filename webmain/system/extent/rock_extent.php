<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params};
	var type = params.type;
	
	
	var ucans= {
		tablename:'admin',sort:'sort',dir:'asc',modedir:'{mode}:{dir}',storebeforeaction:'beforeextentuser',
		title:'人员',bodyStyle:'height:'+(viewheight-135)+'px;overflow:auto',
		columns:[{
			text:'用户名',dataIndex:'user',sortable:true
		},{
			text:'姓名',dataIndex:'name',sortable:true
		},{
			text:'部门',dataIndex:'deptname',sortable:true
		}]
	};
	
	var mcans = {
		tablename:'menu',selectcls:'info',
		url:js.getajaxurl('data','menu','system',{'type':type}),
		tree:true,title:'菜单',bodyStyle:'height:'+(viewheight-135)+'px;overflow:auto',
		columns:[{
			text:'菜单名称',dataIndex:'name',align:'left'
		},{
			text:'编号',dataIndex:'num'
		}]
	};
	
	var gcans = {
		tablename:'group',sort:'sort',dir:'asc',title:'组',
		columns:[{
			text:'组名',dataIndex:'name',sortable:true
		},{
			text:'排序号',dataIndex:'sort',sortable:true
		}]
	};
	
	var viewcan1,viewcan2;
	
	if(type=='um' || type=='view'){
		viewcan1 = ucans;
		viewcan2 = mcans;
	}
	if(type=='mu'){
		viewcan1 = mcans;
		viewcan2 = ucans;
	}
	if(type=='gm'){
		viewcan1 = gcans;
		viewcan2 = mcans;
	}
	if(type=='mg'){
		viewcan1 = mcans;
		viewcan2 = gcans;
	}

	
	
	if(type=='view'){
		$('#viessban_{rand}').hide();
	}
	
	var bool = false,changeid=0;
	
	var a = $('#view1_{rand}').bootstable(js.apply(viewcan1,{
		itemclick:function(d){
			
			getextent(d)
		}
	}));	
	var b = $('#view2_{rand}').bootstable(js.apply(viewcan2,{
		checked:true
	}));
	$('#title1_{rand}').html(viewcan1.title);
	$('#title2_{rand}').html(viewcan2.title);
	
	function getextent(d){
		setmsg('读取中...');
		if(bool)return;
		$('#title2_{rand}').html(viewcan1.title+'['+d.name+']对应'+viewcan2.title+'');
		btn(false);
		var mid		= d.id;
		changeid 	= mid;
		$.post(js.getajaxurl('getextent','extent','system'),{mid:mid,type:type}, function(da){
			bool= false;
			setmsg('');
			var o = b.getcheckobj();
			for(var i=0;i<o.length;i++){
				o[i].checked=false;
				if(da.indexOf('['+o[i].value+']')>=0)o[i].checked=true;
			}
		});
	}
	
	function setmsg(txt,col){
		js.setmsg(txt,col, 'msgview_{rand}');
	}
	
	function btn(bo){
		get('save_{rand}').disabled = bo;
	}
	
	var c = {
		save:function(o1){
			if(type=='view' || bool || changeid==0)return false;
			var data={type:type,mid:changeid};
			data.checkaid	= b.getchecked();
			var url	= js.getajaxurl('save','extent','system');
			bool	= true;
			setmsg('保存中...');
			btn(true);
			$.post(url,data,function(da){
				if(da!='success'){
					setmsg(da, 'red');
				}else{
					setmsg('保存成功', 'green');
				}
				bool	= false;
			});
		}
	}
	js.initbtn(c);
});
</script>

<div id="viessban_{rand}" style="margin-bottom:10px">
	<button class="btn btn-primary" disabled id="save_{rand}" click="save" type="button"><i class="icon-save"></i> 保存设置</button>&nbsp; <span id="msgview_{rand}"></span>
</div>
<table width="100%">
<tr valign="top">
	<td width="50%">
		<div class="panel panel-info">
			<div class="panel-heading"><h3 class="panel-title" id="title1_{rand}">人员</h3></div>
			<div id="view1_{rand}"></div>
		</div>
	</td>
	<td width="10"><div style="width:10px;overflow:hidden"></div></td>
	<td width="50%">
		<div class="panel panel-success">
			<div class="panel-heading"><h3 class="panel-title" id="title2_{rand}">菜单</h3></div>
			<div id="view2_{rand}"></div>
		</div>
	</td>
</tr>
</table>
<div class="blank10"></div>
