<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var a = $('#view_{rand}').bootstable({
		tablename:'infor',fanye:true,celleditor:true,params:{atype:'my'},modenum:'gong',
		columns:[{
			text:'类型',dataIndex:'typename',sortable:true
		},{
			text:'名称',dataIndex:'title',align:'left'
		},{
			text:'操作人',dataIndex:'optname',sortable:true
		},{
			text:'发布者',dataIndex:'zuozhe'
		},{
			text:'日期',dataIndex:'indate',sortable:true,sortable:true
		},{
			text:'发布给',dataIndex:'recename'
		},{
			text:'修改时间',dataIndex:'optdt',sortable:true,renderer:function(v){
				return v.replace(' ','<br>');
			}
		},{
			text:'',dataIndex:'opts',renderer:function(v,d){
				return '<a onclick="openxiangs(\''+d.typename+'\',\'gong\','+d.id+')">详</a>';
			}
		}]
	});
	var c = {
		getcans:function(){
			var can = {key:get('key_{rand}').value};
			return can;
		},
		search:function(o1){
			a.setparams(this.getcans(), true);
		},
		clickwin:function(){
			openinput('通知公告', 'gong');
		},
		daochu:function(){
			a.exceldown();
		},
		changlx:function(o1,lx){
			$("button[id^='state{rand}']").removeClass('active');
			$('#state{rand}_'+lx+'').addClass('active');
			var as = ['my','wfb','wexx'];
			a.setparams({'atype':as[lx]},true);
		}
	};
	
	js.initbtn(c);
});
</script>

<div>
	<table width="100%">
	<tr>
	<td id="btnbnts_{rand}" style="padding-right:10px" >
		<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增</button>
	</td>
	 <td align="left" >
		<input style="width:200px"  class="form-control" id="key_{rand}"  placeholder="类型/名称">
	 </td>
	  <td style="padding-left:10px" align="left" >
		<button class="btn btn-default" click="search" type="button">搜索</button>
	  </div>
	  <td  width="90%" style="padding-left:10px">
		
		<div id="stewwews{rand}" class="btn-group">
		<button class="btn btn-default active" id="state{rand}_0" click="changlx,0" type="button">与我相关</button>
		<button class="btn btn-default" id="state{rand}_1" click="changlx,1" type="button">我发布</button>
		<button class="btn btn-default" id="state{rand}_2" click="changlx,2" type="button">我未读</button>
		</div>	
	</td> 
	  <td> 
				<button class="btn btn-default" click="daochu,1" type="button">导出</button> 
		</td>
	</tr>
	</table>
	
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
