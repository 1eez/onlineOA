<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params};
	var id = params.id,mid=params.mid;
	if(!id)id = 0;
	var h = $.bootsform({
		window:false,rand:'{rand}',tablename:'flow_element',
		url:publicsave('{mode}','{dir}'),
		params:{otherfields:'mid='+mid+''},
		submitfields:'name,fields,fieldstype,dev,savewhere,sort,islu,isbt,iszs,data,iszb,attr,lens',
		requiredfields:'name,fields,fieldstype,lens',aftersaveaction:'elemensavefields',
		success:function(){
			closenowtabs();
			try{guanelementedit.reload();}catch(e){}
		},
		submitcheck:function(){
			
			
		}
	});
	h.forminit();

	var farr = zzzfieldsarr[params.table];
	js.setselectdata(h.form.fieldss,farr,'id');
	js.setselectdata(h.form.fieldstype,fieldstypearr,'value');
	if(id>0){
		var d=guanelementedit.changedata;
		h.setValues(d);
		h.form.fieldss.value=d.fields;
	}
	$(h.form.fieldss).change(function(){
		h.form.fields.value=this.value;
		var txt = this.options[this.selectedIndex].text;
		var as1 = txt.split(']');if(as1[1])h.form.name.value=as1[1];
	});
	$(h.form.fields).blur(function(){
		var val = this.value;
		val = val.replace(/[^a-zA-Z0-9+\_]/gi,'');
		this.value = strreplace(val);
	});
	$(h.form.fieldstype).change(function(){
		var val = this.value;
		
	});
});

</script>

<div align="center">
<div  style="padding:10px;width:700px">
	
	
	<form name="form_{rand}">
	
		<input name="id" value="0" type="hidden" />
		
		<table cellspacing="0" border="0" width="100%" align="center" cellpadding="0">
		<tr>
			<td  align="right" ><font color=red>*</font> 名称：</td>
			<td class="tdinput"><input name="name" class="form-control"></td>
			
		</tr>
		
		<tr>
		
			<td  align="right"  ><font color=red>*</font> 对应字段：</td>
			<td class="tdinput" colspan="3">
				<table><tr>
					<td width="220"><input name="fields" class="form-control"></td>
					<td width="220"><select name="fieldss" class="form-control"><option value="">-字段-</option></select></td>
				</tr></table>
			</td>
		</tr>
		
		<tr>
			<td  align="right" width="15%" nowrap ><font color=red>*</font> 字段类型：</td>
			<td width="35%"  class="tdinput"><select name="fieldstype" class="form-control"><option value="">-字段-</option></select></td>
			
			<td  width="15%" align="right" nowrap>默认值：</td>
			<td width="35%"  class="tdinput"><input name="dev" class="form-control"></td>
		</tr>
		
		<tr>
			<td align="right">字段分类：</td>
			<td class="tdinput"><select name="iszb" class="form-control"><option value="0">主表字段</option><option value="1">多行子表字段</option></select></td>
			<td align="right">字段长度：</td>
			<td class="tdinput"><input name="lens" value="0" maxlength="4" type="number"  onfocus="js.focusval=this.value" onblur="js.number(this)" class="form-control"></td>
		</tr>
	
		<tr>
			<td align="right">数据源：</td>
			<td class="tdinput" colspan="3"><textarea  name="data" style="height:60px" class="form-control"></textarea></td>
		</tr>
	
		<tr>
			<td align="right">属性：</td>
			<td class="tdinput" colspan="3"><textarea  name="attr" style="height:60px" class="form-control"></textarea><font color=#888888>如果只读填写：readonly</font></td>
		</tr>
		
		<tr>
			<td align="right">保存条件：</td>
			<td class="tdinput" colspan="3"><textarea  name="savewhere" style="height:60px" class="form-control"></textarea><font color=#888888>如截止时间比较大于开始：gt|{startdt}|提示，多个,分开。符号说明gt大于，egt大于等于，lt小于，elt小于等于，eg等于，neg不等于，{now}当前时间，{date}当前日期</font></td>
		</tr>
		
		<tr>
			<td align="right">排序号：</td>
			<td class="tdinput"><input name="sort" value="0" maxlength="3" type="number"  onfocus="js.focusval=this.value" onblur="js.number(this)" class="form-control"></td>
		</tr>
	
		
		<tr>
			<td  align="right" ></td>
			<td class="tdinput" colspan="3">
				<label><input name="islu" value="1" checked type="checkbox"> 录入列?</label>&nbsp; &nbsp; 
				<label><input name="isbt" value="1" checked type="checkbox"> 是否必填</label>&nbsp; &nbsp; 
				<label><input name="iszs" value="1" checked type="checkbox"> 展示列</label>&nbsp; &nbsp; 
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
		<b>字段类型</b>：<br>
		1、系统选项下拉框，数据源添加，【流程模块→数据选项】下对应的编号。<br>
		2、下拉框：数据源填写，如：男,女，用,分开，也可以自定义数据源，写webmain/flow/input/mode_对应模块编号Action.php下方法返回数据源，自定义数据源方法abc，写在对应页面上如下：<br>
<pre>
public function abc(){
	$rows[] = array(
		'value' => 1,
		'name' => '第一个下拉框',
	);
	return $rows;
}
</pre>		
		3、编号，数据源填写编号规则，Ymd代表年月日，如：HTYmd，生成的编号为HT201610120001<br>
		</div>
</div>
</div>
