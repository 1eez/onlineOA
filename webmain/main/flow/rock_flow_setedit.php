<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params};
	var id = params.id,arrlist;
	if(!id)id = 0;
	var h = $.bootsform({
		window:false,rand:'{rand}',tablename:'flow_set',
		url:publicsave('{mode}','{dir}'),url:publicsave('{mode}','{dir}'),
		params:{otherfields:'optdt={now}'},aftersaveaction:'flowsetsaveafter',beforesaveaction:'flowsetsavebefore',
		submitfields:'name,tables,type,num,table,sort,status,where,summary,summarx,pctx,mctx,emtx,isflow,sericnum,receid,recename,names',
		requiredfields:'name,type,num,table',
		success:function(){
			closenowtabs();
			try{guanflowsetlist.reload();}catch(e){}
		}
	});
	h.forminit();
	h.load(js.getajaxurl('loaddata','{mode}','{dir}',{id:id}));
	var c = {
		getdist:function(o1, lx){
			var cans = {
				nameobj:h.form.recename,
				idobj:h.form.receid,
				type:'deptusercheck',
				title:'选择针对人员'
			};
			js.getuser(cans);
		},
		allqt:function(){
			h.form.recename.value='全体人员';
			h.form.receid.value='all';
		}
	};
	js.initbtn(c);
});

</script>

<div align="center">
<div  style="padding:10px;width:700px">
	
	
	<form name="form_{rand}">
	
		<input name="id" value="0" type="hidden" />
		
		<table cellspacing="0" border="0" width="100%" align="center" cellpadding="0">
		<tr>
			<td  align="right" ><font color=red>*</font> 模块名称：</td>
			<td class="tdinput"><input name="name" class="form-control"></td>
			<td  align="right"  ><font color=red>*</font> 类型：</td>
			<td class="tdinput"><input name="type" class="form-control"></td>
		</tr>
		
		<tr>
			<td  align="right" width="15%" nowrap ><font color=red>*</font> 编号：</td>
			<td width="35%"  class="tdinput"><input name="num" maxlength="20" class="form-control"></td>
			
			<td  width="15%" align="right" nowrap><font color=red>*</font> 对应表：</td>
			<td width="35%"  class="tdinput"><input name="table" maxlength="20" class="form-control"></td>
		</tr>
		
		<tr>
			<td align="right">单号规则：</td>
			<td class="tdinput"><input name="sericnum" class="form-control"></td>
			<td align="right">多行子表：</td>
			<td class="tdinput"><input name="tables" maxlength="20" class="form-control"></td>
		</tr>
		<tr>
			<td align="right"></td>
			<td class="tdinput"></td>
			<td align="right">多行子表名称：</td>
			<td class="tdinput"><input name="names" class="form-control"></td>
		</tr>
		<tr>
			<td  align="right" >针对人员：</td>
			<td class="tdinput" colspan="3">
				<div class="input-group" style="width:100%">
					<input readonly class="form-control"  name="recename" >
					<input type="hidden" name="receid" >
					<span class="input-group-btn">
						<button class="btn btn-default" click="allqt" type="button">全体人员</button>
						<button class="btn btn-default" click="getdist,1" type="button"><i class="icon-search"></i></button>
					</span>
				</div>
			</td>
			
		</tr>
		
	
		
		<tr>
			<td  align="right" >相应条件：</td>
			<td class="tdinput" colspan="3"><textarea  name="where" style="height:60px" class="form-control"></textarea></td>
		</tr>
		
		<tr>
			<td  align="right" >摘要规则：</td>
			<td class="tdinput" colspan="3"><textarea  name="summary" style="height:60px" class="form-control"></textarea></td>
		</tr>
		
		<tr>
			<td  align="right" >应用上摘要显示：</td>
			<td class="tdinput" colspan="3"><textarea  name="summarx"
placeholder="title:{title}
optdt:{optdt}
cont:
" 
			style="height:100px" class="form-control"></textarea>
			<font color=#888888>title:标题，optdt:显示的时间，cont:内容信息</font>
			</td>
		</tr>
		
		<tr>
			<td  align="right" ></td>
			<td class="tdinput" colspan="3">
				<label><input name="isflow" value="1" type="checkbox"> 有流程?</label>&nbsp; &nbsp; 
				<label><input name="pctx" value="1" type="checkbox"> PC端提醒</label>&nbsp; &nbsp; 
				<label><input name="emtx" value="1" type="checkbox"> 邮件提醒</label>&nbsp; &nbsp; 
				<label><input name="mctx" value="1" type="checkbox"> 移动端提醒</label>&nbsp; &nbsp; 
				<label><input name="status" value="1" checked type="checkbox"> 启用</label>&nbsp; &nbsp; 
			</td>
		</tr>
		
		<tr>
			<td align="right">排序号：</td>
			<td class="tdinput"><input name="sort" value="0" maxlength="3" type="number"  onfocus="js.focusval=this.value" onblur="js.number(this)" class="form-control"></td>
		</tr>

		
		<tr>
			<td  align="right"></td>
			<td style="padding:15px 0px" colspan="3" align="left"><button disabled class="btn btn-success" id="save_{rand}" type="button"><i class="icon-save"></i>&nbsp;保存</button>&nbsp; <span id="msgview_{rand}"></span>
		</td>
		</tr>
		
		</table>
		</form>
	
</div>
</div>
