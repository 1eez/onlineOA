<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var gid = 0;
	var a = $('#veiw_{rand}').bootstable({
		tablename:'im_group',celleditor:false,url:publicstore('{mode}','{dir}'),storeafteraction:'groupafter',keywhere:'and type<>2',defaultorder:'type,sort',modenum:'huihua',
		columns:[{
			text:'头像',dataIndex:'face',renderer:function(v, d){
				return '<img src="images/group.png" height="24" width="24">';
			}
		},{
			text:'名称',dataIndex:'name',editor:true
		},{
			text:'排序号',dataIndex:'sort',editor:true
		},{
			text:'人员数',dataIndex:'utotal'
		},{
			text:'ID',dataIndex:'id'	
		}],
		itemclick:function(){
			btn(false);
		},
		itemdblclick:function(ad,oi,e){
			$('#downshow_{rand}').html('<b>['+ad.name+']</b>下的人员');
			gid=ad.id;
			at.setparams({gid:gid},true);
		}
	});
	
	var at = $('#veiwuser_{rand}').bootstable({
		tablename:'admin',sort:'sort',dir:'asc',
		url:publicstore('{mode}','{dir}'),
		autoLoad:false,storebeforeaction:'groupusershow',
		columns:[{
			text:'用户名',dataIndex:'user',sortable:true
		},{
			text:'姓名',dataIndex:'name',sortable:true
		},{
			text:'部门',dataIndex:'deptname',sortable:true
		},{
			text:'操作',dataIndex:'opt',renderer:function(v,d){
				return '<a href="javascript:" onclick="return deluserr{rand}('+d.id+')"><i class="icon-trash"> 删</a>';
			}
		}],
		load:function(){
			get('add_{rand}').disabled=false;
		}
	});
	
	var c = {
		del:function(){
			a.del({check:function(lx){if(lx=='yes')btn(true)}});
		},
		clickwin:function(o1,lx){
			var h = $.bootsform({
				title:'会话',height:400,width:400,
				tablename:'im_group',isedit:lx,
				url:js.getajaxurl('publicsave','imgroup','main'),
				params:{int_filestype:'sort,type'},
				submitfields:'name,sort,type,explain',
				items:[{
					labelText:'名称',name:'name',required:true
				},{
					labelText:'序号',name:'sort',type:'number',value:'0'
				},{
					labelText:'说明',name:'explain',type:'textarea',height:'60'
				}],
				success:function(){
					a.reload();
				}
			});
			if(lx==1){
				h.setValues(a.changedata);
			}
			h.getField('name').focus();
		},
		refresh:function(){
			a.reload();
		},
		addguser:function(){
			var cans = {
				type:'usercheck',
				title:'选择人员',
				callback:function(sna,sid){
					c.savedist(sid);
				}
			};
			js.getuser(cans);
			return false;
		},
		savedist:function(sid){
			if(sid != ''){
				js.msg('wait','保存中...');
				js.ajax(js.getajaxurl('saveuser','{mode}','{dir}'),{sid:sid,gid:gid},function(){
					js.msg('success','保存成功');
					at.reload();
				},'post');
			}
		},
		delusers:function(uid){
			js.msg('wait','删除中...');
			js.ajax(js.getajaxurl('deluser','{mode}','{dir}'),{sid:uid,gid:gid},function(){
				js.msg('success','删除成功');
				at.reload();
			},'post');
		}
	};
	
	function btn(bo){
		get('del_{rand}').disabled = bo;
		get('edit_{rand}').disabled = bo;
	}
	
	js.initbtn(c);
	
	deluserr{rand}=function(uid){
		js.confirm('确定要删除对应会话下的人员吗？',function(lx){
			if(lx=='yes'){
				c.delusers(uid);
			}
		});
	}
});
</script>

<table width="100%">
<tr valign="top">
<td width="45%">
	
	
	<div>
	<ul class="floats">
		<li class="floats50">
			<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增</button>
		</li>
		<li class="floats50" style="text-align:right">
			<button class="btn btn-danger" id="del_{rand}" click="del" disabled type="button"><i class="icon-trash"></i> 删除</button> &nbsp; 
			<button class="btn btn-info" id="edit_{rand}" click="clickwin,1" disabled type="button"><i class="icon-edit"></i> 编辑 </button>
		</li>
	</ul>
	</div>
	<div class="blank10"></div>
	<div id="veiw_{rand}"></div>
	<div class="tishi">双击查看对应人员</div>
</td>
<td width="10"></td>
<td>
	
	<div>
	<ul class="floats">
		<li class="floats50">
			<span id="downshow_{rand}">&nbsp;</span>
		</li>
		<li class="floats50" style="text-align:right">
			<button class="btn btn-primary" click="addguser,0" id="add_{rand}" disabled type="button"><i class="icon-plus"></i> 添加对应人员</button>
		</li>
	</ul>
	</div>
	<div class="blank10"></div>
	<div id="veiwuser_{rand}"></div>	
	
</td>
</tr>
</table>
