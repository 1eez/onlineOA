<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params};
	var id = params.id,pid=params.pid;
	if(!id)id = 0;
	if(!pid)pid = '0';
	var h = $.bootsform({
		window:false,rand:'{rand}',tablename:'im_group',
		url:publicsave('{mode}','{dir}'),beforesaveaction:'beforesave',
		params:{int_filestype:'sort,yylx',otherfields:'type=2'},
		submitfields:'sort,name,recename,iconfont,iconcolor,receid,url,face,valid,num,pid,yylx',
		requiredfields:'name',
		success:function(){
			closenowtabs();
			try{listyingyongobj.reload();}catch(e){}
		},
		load:function(a, o){
			if(a.data){
				get('yingyong{rand}').src=a.data.face;
			}
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
				title:'选择人员'
			};
			js.getuser(cans);
		},
		allqt:function(){
			h.form.recename.value='全体人员';
			h.form.receid.value='all';
		},
		removes:function(){
			h.form.recename.value='';
			h.form.receid.value='';
		},
		changeface:function(){
			get('yingyong{rand}').src=this.value;
		}
	};
	js.initbtn(c);	
	h.setValue('pid',pid);
	$(h.form.face).change(c.changeface);
});
</script>

<div align="left">
<div  style="padding:10px;width:450px">
	
	
	<form name="form_{rand}">
	
		<input name="id" value="0" type="hidden" />
		<input name="setid" value="0" type="hidden" />
		
		<table cellspacing="0" border="0" width="100%" align="center" cellpadding="0">
		
		<tr>
			
			<td class="tdinput"  colspan="2">
				<div align="center"><img id="yingyong{rand}" src="images/noface.png" height="60" width="60"></div>
			</td>
		</tr>
		
		<tr>
			<td  align="right">编号：</td>
			<td class="tdinput"><input name="num" placeholder="一般跟模块的编号一致" class="form-control"></td>
		</tr>
		
		<tr>
			<td  align="right" width="120" nowrap><font color=red>*</font> 名称：</td>
			<td class="tdinput"><input name="name" class="form-control"></td>
		</tr>
		
		<tr>
			<td  align="right" >链接地址：</td>
			<td class="tdinput"><select name="url" class="form-control"><option value="auto">自动</option><option value="buin">内部页面</option></select></td>
		</tr>
		
		<tr>
			<td  align="right" >应用类型：</td>
			<td class="tdinput"><select name="yylx" class="form-control"><option value="0">全部</option><option value="1">仅桌面版显示</option><option value="2">仅手机端显示</option></select></td>
		</tr>
		
		<tr>
			<td  align="right" >图标地址：</td>
			<td class="tdinput"><input name="face" class="form-control"></td>
		</tr>
		<tr>
			<td  align="right" >字体图标：</td>
			<td class="tdinput"><input name="iconfont" class="form-control"></td>
		</tr>
		<tr>
			<td  align="right" >字体图标颜色：</td>
			<td class="tdinput"><input name="iconcolor" class="form-control"></td>
		</tr>
		<tr>
			<td  align="right" >可用人员：</td>
			<td class="tdinput">
				<div class="input-group">
					<input readonly class="form-control"  name="recename" >
					<input type="hidden" name="receid" >
					<span class="input-group-btn">
						<button class="btn btn-default" click="removes" type="button"><i class="icon-remove"></i></button>
						<button class="btn btn-default" click="getdist,1" type="button"><i class="icon-search"></i></button>
					</span>
				</div>
			</td>
			
		</tr>

		
		<tr>
			<td align="right">说明：</td>
			<td class="tdinput" colspan="3"><textarea  name="explain" style="height:80px;" class="form-control"></textarea></td>
		</tr>
		
		<tr>
			<td align="right">上级ID：</td>
			<td class="tdinput"><input name="pid" value="0" maxlength="3" type="number"  onfocus="js.focusval=this.value" onblur="js.number(this)" class="form-control"></td>
		</tr>
		
		<tr>
			<td align="right">排序号：</td>
			<td class="tdinput"><input name="sort" value="0" maxlength="3" type="number"  onfocus="js.focusval=this.value" onblur="js.number(this)" class="form-control"></td>
		</tr>
	
		<tr>
			<td align="right"></td>
			<td class="tdinput"><label><input type="checkbox" name="valid" value="1">启用</label></td>
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
