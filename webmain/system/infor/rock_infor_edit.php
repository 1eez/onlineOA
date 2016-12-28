<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params};
	var id = params.id;
	if(!id)id = 0;
	var h = $.bootsform({
		window:false,rand:'{rand}',tablename:'infor',
		url:publicsave('{mode}','{dir}'),
		params:{int_filestype:'isshow,sort',otherfields:'optdt={now},optid={adminid},optname={admin}'},
		submitfields:'title,typename,content,sort,isshow,zuozhe,indate,num,receid,recename',
		requiredfields:'title,typename',
		success:function(){
			closenowtabs();
			try{guaninforlist.reload();}catch(e){}
		},
		load:function(a, o){
			js.setselectdata(o.form.typename, a.infortype);
			if(a.data){
				editorobj.html(a.data.content);
			}
		},
		submitcheck:function(d){
			return {content:editorobj.html()};
		}
	});
	h.forminit();
	
	h.load(js.getajaxurl('loaddata','{mode}','{dir}',{id:id}));
	
	$('#fileid_{rand}').rockupload({mtype:'infor',mid:id});
	
	var editorobj=js.initedit('content_{rand}');
	var c = {
		clickdt:function(o1, lx){
			$(o1).rockdatepicker({initshow:true,view:'datetime',inputid:'dt'+lx+'_{rand}'});
		},
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
		}
	};
	js.initbtn(c);
});
</script>

<div align="center">
<div  style="padding:10px;width:750px">
	
	
	<form name="form_{rand}">
	
		<input name="id" value="0" type="hidden" />
		<input name="setid" value="0" type="hidden" />
		
		<table cellspacing="0" border="0" width="100%" align="center" cellpadding="0">
		<tr>
			<td  align="right" ><font color=red>*</font> 名称：</td>
			<td class="tdinput" colspan=3><input name="title" class="form-control"></td>
		</tr>
		
		<tr>
			<td width="18%" align="right" nowrap><font color=red>*</font> 信息类型：</td>
			<td width="32%" class="tdinput" ><select  class="form-control" name="typename"><option value="">-选择类型-</option></select></td>
			<td width="18%" align="right" nowrap>信息编号：</td>
			<td width="32%" class="tdinput"><input name="num" maxlength="20" class="form-control"></td>
		</tr>
		
		

		
		<tr>
			<td  align="right" >发布给：</td>
			<td class="tdinput" colspan="3">
				<div class="input-group">
					<input readonly class="form-control"  name="recename" >
					<input type="hidden" name="receid" >
					<span class="input-group-btn">
						<button class="btn btn-default" click="allqt" type="button">全体人员</button>
						<button class="btn btn-default" click="removes" type="button"><i class="icon-remove"></i></button>
						<button class="btn btn-default" click="getdist,1" type="button"><i class="icon-search"></i></button>
					</span>
				</div>
			</td>
			
		</tr>

	
		
		<tr>
			<td align="right"><div style="width:120px">信息内容：</div></td>
			<td class="tdinput" colspan="3"><textarea  name="content" id="content_{rand}" style="height:230px;" class="form-control"></textarea></td>
		</tr>
		
		<tr>
			<td  align="right" ></td>
			<td class="tdinput"><label><input name="isshow" value="1" type="checkbox"> 显示到首页</label></td>
			<td align="right">排序号：</td>
			<td class="tdinput"><input name="sort" value="0" maxlength="3" type="number"  onfocus="js.focusval=this.value" onblur="js.number(this)" class="form-control"></td>
		</tr>
		
		<tr>
			<td align="right">相关文件：</td>
			<td class="tdinput" id="fileid_{rand}" colspan="3"></td>
		</tr>
		
		<tr>
			<td  align="right" nowrap>发布者：</td>
			<td class="tdinput">
				<input name="zuozhe" class="form-control">
			</td>
			
			<td align="right" nowrap>时间：</td>
			<td class="tdinput">
				<div class="input-group">
					<input readonly class="form-control" id="dt1_{rand}" name="indate" >
					<span class="input-group-btn">
						<button class="btn btn-default" click="clickdt,1" type="button"><i class="icon-calendar"></i></button>
					</span>
				</div>
			</td>
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
