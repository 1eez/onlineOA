<?php if(!defined('HOST'))die('not access');?>
<script>
$(document).ready(function(){
	var c={};
	
	var fm		= 'form_{rand}';
	c.save=function()
	{
		var faces 	= get('facePost').value;
		var data	= {facePost:faces};
		form('submitbtn',fm).disabled=true;
		js.msg('wait','修改中...');
		$.post(js.getajaxurl('saveface','geren','system'),data,function(da){
			if(da=='success'){
				js.msg('success','修改成功');
			}else{
				if(da=='')da='修改失败';
				js.msg('msg',da);
			}
			form('submitbtn',fm).disabled=false;
			get('myface').src = faces;
		})
	}

	c.yongyt=function()
	{
		showface(iframecrop.scr.path);
		return false;
	}

	c.claertx=function()
	{
		get('faceimg').src='images/white.gif';
		get('facePost').value='';
		return false;
	}
	
	js.initbtn(c);
});
var cropwidth = 100;
var cropheight= 100;

function showface(img)
{
	var face	= img.replace(/\.\.\//gi, '');
	get('faceimg').src=face;
	get('facePost').value=face;
}
</script>
<div align="center" style="padding:20px">
	
	
	<form name="form_{rand}">
		
		
	<input value="" type="hidden" id="facePost">
		<table cellspacing="0" align="center" cellpadding="0">
		
		<tr>
		<td align="left">
			<table cellspacing="0" cellpadding="0">
			<tr>
				<td><img id="faceimg" src="images/white.gif" style="border:1px #cccccc solid;" width="100" height="100"></td>
				<td width="15"></td>
				<td valign="bottom">
               	 	<input class="btn btn-success" name="submitbtn" click="save" value="保存修改" type="button">&nbsp; 
                	<input class="btn btn-default" click="claertx" value="清空头像" type="button">&nbsp; 
                	<a href="javascript:" click="yongyt" onclick="return false">[用原图]</a>
                </td>
			</tr>
			</table>

		</td>
		</tr>
			
		<tr>
		<td height="10"></td>
		</tr>
		
		<tr>
			<td >
			<iframe width="500" height="350" frameborder="0" id="ifrautoface" name="iframecrop" scrolling="no" marginheight="0" marginwidth="0" src="mode/cropimg/crop.php?imgurl=" ></iframe>  
			</td>
		</tr>
		


		
		</table>	
		
		
		
		
		
	</form>
	
</div>
