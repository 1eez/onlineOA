<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params}
	var atype=params.atype;
	var a = $('#view_{rand}').bootstable({
		tablename:'project',params:{'atype':atype},fanye:true,modenum:'project',modename:'项目',
		url:publicstore('{mode}','{dir}'),celleditor:true,
		storeafteraction:'projectafter',storebeforeaction:'projectbefore',
		columns:[{
			text:'操作',dataIndex:'caozuo'
		},{
			text:'名称',dataIndex:'title',align:'left'
		},{
			text:'类型',dataIndex:'type'
		},{
			text:'负责人',dataIndex:'fuze'
		},{
			text:'执行人',dataIndex:'runuser'
		},{
			text:'开始时间',dataIndex:'startdt'
		},{
			text:'截止时间',dataIndex:'enddt'
		},{
			text:'状态',dataIndex:'state'
		},{
			text:'任务数',dataIndex:'worklist',tooltip:'任务数：未完成/总任务数',renderer:function(v,d,i){
				return ''+v+'&nbsp;<a href="javascript:;" onclick="viespere{rand}('+i+')">查看</a>';
			}
		},{
			text:'进度',dataIndex:'progress',renderer:function(v){
				return '<div class="progress" style="margin:0;width:120px;"><div class="progress-bar progress-bar-success" style="width:'+v+'%;color:#000000;">'+v+'%</div></div>';
			}
		},{
			text:'创建人',dataIndex:'optname'
		}],
		itemdblclick:function(){
			c.view();
		},
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
			openxiangs('项目','project',d.id);
		},
		search:function(){
			a.setparams({key:get('key_{rand}').value},true);
		},
		daochu:function(){
			a.exceldown(nowtabs.name);
		},
		clickwin:function(o1,lx){
			var id=0;
			if(lx==1)id=a.changeid;
			openinput('项目', 'project',id);
		},
		changlx:function(o1,lx){
			$("button[id^='state{rand}']").removeClass('active');
			$('#state{rand}_'+lx+'').addClass('active');
			a.setparams({zt:lx},true);
		}
	};
	js.initbtn(c);
	
	if(atype=='wwc'){
		$('#wense_{rand}').remove();
		$('#btngroup{rand}').hide();
	}
	
	if(atype!='my' && atype!='mycj')$('#wense_{rand}').remove();
	
	viespere{rand}=function(id){
		var d = a.getData(id);
		var bo = addtabs({name:'项目['+d.title+']的任务',url:'main,work,list,atype=all,projcetid='+d.id+'',num:'projcetidwork'+d.id+''});
	}
});
</script>
<div>
	<table width="100%">
	<tr>
	<td id="wense_{rand}" style="padding-right:10px">
		<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 创建项目</button>
	</td>
	<td>
		<input class="form-control" style="width:180px" id="key_{rand}"   placeholder="名称/负责人">
	</td>
	<td style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button> 
	</td>
	
	<td  width="90%" style="padding-left:10px">
		
		<div class="btn-group" id="btngroup{rand}">
		<button class="btn btn-default active" id="state{rand}_" click="changlx," type="button">全部项目</button>
		<button class="btn btn-default" id="state{rand}_0" click="changlx,0" type="button">待执行</button>
		<button class="btn btn-default" id="state{rand}_1" click="changlx,1" type="button">已完成</button>
		<button class="btn btn-default" id="state{rand}_2" click="changlx,2" type="button">执行中</button>
		<button class="btn btn-default" id="state{rand}_2" click="changlx,3" type="button">终止</button>
		</div>	
	</td>
	
	
	<td align="right" nowrap>
		<button class="btn btn-default" id="xiang_{rand}" click="view" disabled type="button">详情</button> &nbsp; 
		<button class="btn btn-default" click="daochu,1" type="button">导出</button> 
	</td>
	</tr>
	</table>
	
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
