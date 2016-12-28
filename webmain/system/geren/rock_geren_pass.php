<?php if(!defined('HOST'))die('not access');?>
<script>
$(document).ready(function(){
	var c={};
	c.save=function(o1)
	{
		var fm		= 'form_{rand}';
		var msgview		= 'msgview_{rand}';
		
		var opass	= form('passoldPost',fm).value;
		var pass	= form('passwordPost',fm).value;
		var pass1	= form('password1Post',fm).value;
		
		if(opass==''){
			js.setmsg('旧密码不能为空','red', msgview);
			form('passoldPost',fm).focus();
			return false;
		}

		if(pass.length <4){
			js.setmsg('新密码不能少于4个字符','red', msgview);
			form('passwordPost',fm).focus();
			return false;
		}
		if(!/[a-zA-Z]{1,}/.test(pass) || !/[0-9]{1,}/.test(pass)){
			js.setmsg('新密码必须使用字母+数字','red', msgview);
			form('passwordPost',fm).focus();
			return false;
		}

		if(opass==pass){
			js.setmsg('新密码不能和旧密码相同','red', msgview);
			form('passwordPost',fm).focus();
			return false;
		}
		
		if(pass!=pass1){
			js.setmsg('确认密码不一致','red', msgview);
			form('password1Post',fm).focus();
			return false;
		}

		var data	= js.getformdata(fm);
		form('submitbtn',fm).disabled=true;
		js.setmsg('修改中...','#ff6600', msgview);
		$.post(js.getajaxurl('editpass','geren','system'),data,function(da){
			if(da=='success'){
				js.setmsg('密码修改成功','green', msgview);
			}else{
				if(da=='')da='修改失败';
				js.setmsg(da,'red', msgview);
				form('submitbtn',fm).disabled=false;
			}
		});
	}
	
	js.initbtn(c);
});
</script>
<div style="padding:50px">
	
	
	<form name="form_{rand}">
		<table cellspacing="0" width="500"  cellpadding="0">
		<tr>
			<td width="150" align="right" height="50">旧密码：</td>
			<td><input style="width:250px" name="passoldPost" type="password" class="form-control"></td>
		</tr>
		
		<tr>
			<td align="right" height="70">新密码：</td>
			<td><input style="width:250px" name="passwordPost" type="password" class="form-control"></td>
		</tr>
		
		<tr>
			<td align="right" height="70">确认密码：</td>
			<td><input style="width:250px" name="password1Post" type="password" class="form-control"></td>
		</tr>
		
	
		
		<tr>
		<td height="80" align="right"></td>
		<td align="left"><input class="btn btn-success" click="save" name="submitbtn" value="修改" type="button">&nbsp;<span id="msgview_{rand}"></span>
		</td>
		</tr>
		
		</table>
		</form>
	
</div>
