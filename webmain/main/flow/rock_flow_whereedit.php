<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params};
	var id = params.id;
	if(!id)id = 0;
	var h = $.bootsform({
		window:false,rand:'{rand}',tablename:'flow_where',url:publicsave('{mode}','{dir}'),
		submitfields:'setid,name,wheresstr,whereustr,wheredstr,explain,recename,receid,nrecename,nreceid,num,sort',requiredfields:'name',
		success:function(){
			closenowtabs();
			try{guanflowwherelist.reload();}catch(e){}
		},
		loadafter:function(a){
			if(a.data){
				h.form.wheresstr.value=jm.base64decode(a.data.wheresstr);
				h.form.whereustr.value=jm.base64decode(a.data.whereustr);
				h.form.wheredstr.value=jm.base64decode(a.data.wheredstr);
			}
		},
		submitcheck:function(d){
			return {
				wheresstr:jm.base64encode(d.wheresstr),
				whereustr:jm.base64encode(d.whereustr),
				wheredstr:jm.base64encode(d.wheredstr)
			};
		}
	});
	h.forminit();
	h.load(js.getajaxurl('loaddatawhere','{mode}','{dir}',{id:id}));
	var c = {
		setwhere:function(){
			js.setwhere(params.setid,'backsheowe{rand}');
		},
		clears:function(o1,lx){
			if(lx==1){
				h.setValue('recename','');
				h.setValue('receid','');
			}
			if(lx==2){
				h.setValue('nrecename','');
				h.setValue('nreceid','');
			}
		},
		getdist:function(o1, lx){
			var cans = {
				nameobj:h.form.recename,
				idobj:h.form.receid,
				type:'deptusercheck',
				title:'选择包含人员'
			};
			if(lx==2){
				var cans = {
					nameobj:h.form.nrecename,
					idobj:h.form.nreceid,
					type:'deptusercheck',
					title:'选择除外人员'
				};
			}
			cans.value=cans.idobj.value,
			js.getuser(cans);
		}
	};
	js.initbtn(c);
	if(id==0)h.form.setid.value=params.setid;
	backsheowe{rand}=function(s1,s2){
		h.setValue('wheresstr',s1);
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
			<td  align="right"  width="20%"><font color=red>*</font> 名称：</td>
			<td class="tdinput"  width="35%"><input name="name" class="form-control"></td>
			<td  align="right"   width="15%">编号：</td>
			<td class="tdinput" width="30%"><input name="num" maxlength="30" class="form-control"></td>
		</tr>
		
		

		<tr>
			<td  align="right" >主表字段条件：</td>
			<td class="tdinput" colspan="3"><textarea  name="wheresstr" style="height:60px" class="form-control"></textarea><div class="tishi" style="padding-top:0px">对应主表上字段条件,<a click="setwhere" href="javascript:;">[设置条件]</a></div></td>
		</tr>
		
		<tr>
			<td  align="right" >人员包含条件：</td>
			<td class="tdinput" colspan="3">
			<div style="width:100%" class="input-group">
				<input readonly class="form-control"  name="recename" >
				<input type="hidden" name="receid" >
				<span class="input-group-btn">
					<button class="btn btn-default" click="clears,1" type="button"><i class="icon-remove"></i></button>
					<button class="btn btn-default" click="getdist,1" type="button"><i class="icon-search"></i></button>
				</span>
			</div>
			<textarea  name="whereustr" style="height:40px" class="form-control"></textarea><div class="tishi" style="padding-top:0px">不选默认全部人员</div>
			</td>
		</tr>
		
		<tr>
			<td  align="right" >除了这些人员外：</td>
			<td class="tdinput" colspan="3">
			<div style="width:100%" class="input-group">
				<input readonly class="form-control"  name="nrecename" >
				<input type="hidden" name="nreceid" >
				<span class="input-group-btn">
					<button class="btn btn-default" click="clears,2" type="button"><i class="icon-remove"></i></button>
					<button class="btn btn-default" click="getdist,2" type="button"><i class="icon-search"></i></button>
				</span>
			</div>
			<textarea  name="wheredstr" style="height:40px" class="form-control"></textarea></div>
			</td>
		</tr>
		
		
		
		<tr>
			<td  align="right" >说明：</td>
			<td class="tdinput" colspan="3"><textarea  name="explain" style="height:60px" class="form-control"></textarea></td>
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
		<div align="left" class="tishi">也可根据编号从程序代码上自定义返回条件，文件：webmain\model\flow下对应模块编号文件</div>
</div>
</div>
