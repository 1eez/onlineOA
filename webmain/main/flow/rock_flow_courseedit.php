<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params};
	var id = params.id;
	if(!id)id = 0;var setid=params.setid;
	var h = $.bootsform({
		window:false,rand:'{rand}',tablename:'flow_course',
		url:publicsave('{mode}','{dir}'),
		params:{otherfields:'optdt={now}'},
		submitfields:'setid,name,num,checktype,checktypeid,checktypename,checkfields,sort,whereid,explain,status,courseact,checkshu',
		requiredfields:'name',
		success:function(){
			closenowtabs();
			try{guanflowcourselist.reload();}catch(e){}
		},
		load:function(a){
			js.setselectdata(h.form.whereid,a.wherelist,'id');
		},
		loadafter:function(a){
			c.changetype(0);
			if(a.data){
				
			}
		},
		submitcheck:function(d){
			if(d.checktype=='user'&&d.checktypeid=='')return '请选择人员';
			if(d.checktype=='rank'&&d.checktypename=='')return '请输入职位';
			return '';
		}
	});
	h.forminit();
	h.load(js.getajaxurl('loaddatacourse','{mode}','{dir}',{id:id,setid:setid}));
	var c = {
		getdist:function(o1, lx){
			var cans = {
				nameobj:h.form.checktypename,
				idobj:h.form.checktypeid,
				value:h.form.checktypeid.value,
				type:'usercheck',
				title:'选择人员'
			};
			js.getuser(cans);
		},
		clears:function(){
			h.form.checktypename.value='';
			h.form.checktypeid.value='';
		},
		changetype:function(lx){
			var v=h.form.checktype.value;
			$('#checktext_{rand}').html('');
			$('#checkname_{rand}').hide();
			if(lx==1){
				h.form.checktypename.value='';
				h.form.checktypeid.value='';
			}
			if(v=='rank'){
				$('#checktext_{rand}').html('请输入职位：');
				$('#checkname_{rand}').show();
			}
			if(v=='user'){
				$('#checktext_{rand}').html('请选择人员：');
				$('#checkname_{rand}').show();
			}
		},
		reloadhweil:function(){
			h.form.whereid.length = 1;
			h.load(js.getajaxurl('loaddatacourse','{mode}','{dir}',{id:id,setid:setid}));
		}
	};
	js.initbtn(c);
	
	if(id==0)h.form.setid.value=setid;
	
	$(h.form.checktype).change(function(){
		c.changetype(1);
	});
	backsheowe{rand}=function(s1,s2){
		h.setValue('where',s1);
		h.setValue('explain',s2);
	}
});

</script>

<div align="center">
<div  style="padding:10px;width:700px">
	
	
	<form name="form_{rand}">
	
		<input name="id" value="0" type="hidden" />
		<input name="setid" value="0" type="hidden" />
		
		<table cellspacing="0" border="0" width="100%" align="center" cellpadding="0">
		<tr>
			<td  align="right"  width="15%"><font color=red>*</font> 步骤名称：</td>
			<td class="tdinput"  width="35%"><input name="name" class="form-control"></td>
			<td  align="right"   width="15%">编号：</td>
			<td class="tdinput" width="35%"><input name="num" class="form-control"></td>
		</tr>
		
		<tr>
			<td  align="right" nowrap >审核人员类型：</td>
			<td class="tdinput"><select class="form-control" name="checktype"><option value="">-类型-</option><option value="super">直属上级</option><option value="rank">职位</option><option value="user">指定人员</option><option value="dept">部门负责人</option><option value="auto">自定义(写代码上)</option><option value="apply">申请人</option><option value="opt">操作人</option><option value="change">由上步指定</option></select></td>
			
			<td align="right" id="checktext_{rand}" nowrap></td>
			<td class="tdinput" id="checkname_{rand}" style="display:none">
				<div class="input-group" style="width:100%">
					<input class="form-control"  name="checktypename" >
					<input type="hidden" name="checktypeid" >
					<span class="input-group-btn">
						<button class="btn btn-default" click="clears" type="button">×</button>
						<button class="btn btn-default" click="getdist,1" type="button"><i class="icon-search"></i></button>
					</span>
				</div>
				
			</td>
		</tr>
		

		
		<tr style="display:none">
			<td  align="right" ><font color=red>*</font> 选择审核人员：</td>
			<td class="tdinput" colspan="3">
				<div class="input-group">
					<input readonly class="form-control"  name="recename" >
					<input type="hidden" name="receid" >
					<span class="input-group-btn">
						<button class="btn btn-default" click="getdist,1" type="button"><i class="icon-search"></i></button>
					</span>
				</div>
			</td>
			
		</tr>
		
		<tr>
			<td  align="right" >审核条件：</td>
			<td class="tdinput"><select class="form-control" name="whereid"><option value="0">无条件</option></select></td>
			<td colspan="2"><a click="reloadhweil" href="javascript:;">[刷新]</a></td>
		</tr>
		<tr>
			<td  align="right" ></td>
			<td colspan="3" style="padding-bottom:10px"><font color=#888888>在【流程模块条件】上添加，满足此条件才需要此步骤</font></td>
		</tr>

		
		<tr>
			<td  align="right" >审核动作：</td>
			<td class="tdinput" colspan="3"><input name="courseact" class="form-control"><div style="padding-top:0px" class="tishi">默认是：通过,不通过。多个,分开</div></td>
		</tr>
		
		<tr>
			<td  align="right" >审核处理表单：</td>
			<td class="tdinput" colspan="3"><input name="checkfields" class="form-control"><div style="padding-top:0px" class="tishi">需要处理表单元素必须在【表单元素管理】上，输入字段名，多个用, 分开</div></td>
		</tr>
		<tr>
			<td  align="right" >说明：</td>
			<td class="tdinput" colspan="3"><textarea  name="explain" style="height:60px" class="form-control"></textarea></td>
		</tr>
		
		
		<tr>
			<td align="right">排序号：</td>
			<td class="tdinput"><input name="sort" value="0" maxlength="3" type="number"  onfocus="js.focusval=this.value" onblur="js.number(this)" class="form-control"></td>
			
			<td  align="right" nowrap >审核人数：</td>
			<td class="tdinput"><select class="form-control" name="checkshu"><option value="0">需全部审核</option><option value="1" selected>至少一人</option><option value="2">至少2人</option></select></td>
			
			
		</tr>
		
		<tr>
			<td  align="right" ></td>
			<td class="tdinput" colspan="3">
				<label><input name="status" value="1" checked type="checkbox"> 启用</label>&nbsp; &nbsp; 
			</td>
		</tr>
		
		
		<tr>
			<td  align="right"></td>
			<td style="padding:15px 0px" colspan="3" align="left"><button disabled class="btn btn-success" id="save_{rand}" type="button"><i class="icon-save"></i>&nbsp;保存</button>&nbsp; <span id="msgview_{rand}"></span>
		</td>
		</tr>
		
		</table>
		</form>
		
		<div class="tishi" align="left">
		<b>审核人员类型</b>：<br>1、自定义(写代码上)，需要定义一个编号如：abc，写在webmain/model/flow/对应模块编号Model.php下，重写方法flowcheckname($num){}。如下代码<br>
<pre>
protected function flowcheckname($num){
	$sid = ''; //审核人Id
	$sna = ''; //审核人
	if($num=='abc'){
		$sid = 1;
		$sna = '管理员';
	}
	return array($sid, $sna);
}
</pre>
		</div>
</div>
</div>
