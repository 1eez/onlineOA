<?php if(!defined('HOST'))die('not access');?>
<script>
$(document).ready(function(){
	var valchange = ''+adminstyle;
	var c={
		save:function(){
			adminstyle = valchange;
			js.ajax(js.getajaxurl('changestyle','geren','system'),{style:valchange},function(s){
				js.msg('success','保存成功');
			});
		},
		init:function(){
			$("input[name='_stylechange']:eq("+valchange+")")[0].checked=true;
		}
	};
	js.initbtn(c);
	$("input[name='_stylechange']").click(function(){
		var val = this.value;
		valchange=val;
		get('mainstylecss').href='webmain/css/style'+val+'.css?'+Math.random()+'';
	});
	c.init();
});
</script>
<div align="left" style="padding:50px">
	<table>
		<tr>
			<td align="center" style="padding:15px"><label><div style="width:60px;height:60px;overflow:hidden; background-color:#1ABC9C"></div><input type="radio" name="_stylechange" value="0"></label></td>
			<td align="center" style="padding:15px"><label><div style="width:60px;height:60px;overflow:hidden; background-color:#1389D3"></div><input type="radio" name="_stylechange" value="1"></label></td>
			<td align="center" style="padding:15px"><label><div style="width:60px;height:60px;overflow:hidden; background-color:#E95420"></div><input type="radio" name="_stylechange" value="2"></label></td>
		</tr>
		
		<tr>
			<td align="center" style="padding:15px"><label><div style="width:60px;height:60px;overflow:hidden; background-color:#996699"></div><input type="radio" name="_stylechange" value="3"></label></td>
			<td align="center" style="padding:15px"><label><div style="width:60px;height:60px;overflow:hidden; background-color:#2C3E50"></div><input type="radio" name="_stylechange" value="4"></label></td>
			<td align="center" style="padding:15px"><label><div style="width:60px;height:60px;overflow:hidden; background-color:#CC0033"></div><input type="radio" name="_stylechange" value="5"></label></td>
		</tr>
		
		<tr>
			<td><input class="btn btn-success" click="save" name="submitbtn" value="保存修改" type="button"></td>
		</tr>
	</table>
	
</div>
