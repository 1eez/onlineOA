<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params}
	var atype=params.atype,chengsuid='';
	var a = $('#view_{rand}').bootstable({
		tablename:'customer',params:{'atype':atype},fanye:true,modenum:'customer',celleditor:false,checked:atype=='my',
		columns:[{
			text:'',dataIndex:'caozuo'
		},{
			text:'类型',dataIndex:'type'
		},{
			text:'名称',dataIndex:'name'
		},{
			text:'单位名称',dataIndex:'unitname'
		},{
			text:'来源',dataIndex:'laiyuan'
		},{
			text:'拥有者',dataIndex:'optname'
		},{
			text:'电话',dataIndex:'tel'
		},{
			text:'状态',dataIndex:'status',sortable:true
		},{
			text:'供应商',dataIndex:'isgys',type:'checkbox',editor:true,sortable:true
		},{
			text:'共享给',dataIndex:'shate'
		},{
			text:'待收',dataIndex:'moneyd'
		},{
			text:'创建人',dataIndex:'createname'
		}],
		itemclick:function(){
			btn(false);
		},
		beforeload:function(){
			btn(true);
		}
	});
	
	function btn(bo){
		get('xiang_{rand}').disabled = bo;
	}
	
	var c = {
		del:function(){
			a.del();
		},
		reload:function(){
			a.reload();
		},
		view:function(){
			var d=a.changedata;
			openxiangs('客户','customer',d.id);
		},
		changlx:function(o1,lx){
			$("button[id^='state{rand}']").removeClass('active');
			$('#state{rand}_'+lx+'').addClass('active');
			var as = ['all','qy','ting','stat'];
			a.setparams({'atype':atype+'_'+as[lx]},true);
		},
		daochu:function(){
			a.exceldown(nowtabs.name);
		},
		clickwin:function(o1,lx){
			var id=0;
			if(lx==1)id=a.changeid;
			openinput('客户', 'customer',id);
		},
		move:function(){
			var s= a.getchecked();
			if(s==''){js.msg('msg','没有选择记录');return;}
			chengsuid=s;
			js.confirm('是否客户转移给其他人，并客户下的合同和待收付款单和销售机会同时转移？', function(jg){
				if(jg=='yes')c.moveto();
			});
		},
		movetoss:function(sna,toid){
			js.ajax(js.getajaxurl('movecust','{mode}','{dir}'),{'toid':toid,'sid':chengsuid},function(s){
				a.reload();
			},'post',false,'转移给:'+sna+'...,转移成功');
		},
		moveto:function(sid){
			var cans = {
				type:'user',
				title:'转移给...',
				callback:function(sna,sid){
					if(sid)c.movetoss(sna,sid);
				}
			}
			setTimeout(function(){js.getuser(cans);},10);
		},
		search:function(){
			var s=get('key_{rand}').value;
			a.setparams({key:s},true);
		},
		daoru:function(){
			custmanagesss = a;
			addtabs({num:'customeraddpl',url:'main,customer,addpl',name:'导入客户'});
		}
	};
	js.initbtn(c);
	
	if(atype!='my'){
		$('#move_{rand}').remove();
		$('#btnbnts_{rand}').remove();
		$('#drubtn_{rand}').remove();
	}
});
</script>
<div>
	<table width="100%">
	<tr>
	<td id="btnbnts_{rand}" style="padding-right:10px" >
		<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增</button>
	</td>
	<td>
		<input class="form-control" style="width:180px" id="key_{rand}"   placeholder="名称/拥有者">
	</td>
	<td style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button> 
	</td>
	<td style="padding-left:10px">
		<button class="btn btn-default" click="daochu,1" type="button">导出</button> 
	</td>
	<td  width="90%" style="padding-left:10px">
		
		<div id="stewwews{rand}" class="btn-group">
		<button class="btn btn-default active" id="state{rand}_0" click="changlx,0" type="button">全部状态</button>
		<button class="btn btn-default" id="state{rand}_1" click="changlx,1" type="button">启用的</button>
		<button class="btn btn-default" id="state{rand}_2" click="changlx,2" type="button">停用的</button>
		<button class="btn btn-default" id="state{rand}_3" click="changlx,3" type="button">标☆的</button>
		</div>	
	</td>
	
	
	<td align="right" nowrap>
		<button class="btn btn-default" id="move_{rand}" click="move" type="button">客户转移</button> &nbsp; 
		<button class="btn btn-default" id="xiang_{rand}" click="view" disabled type="button">详情</button><span id="drubtn_{rand}">&nbsp; 
		<button class="btn btn-default" click="daoru" type="button">导入</button></span>
	</td>
	</tr>
	</table>
	
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
