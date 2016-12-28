<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params};
	var id = params.id,mid=params.mid;
	if(!id)id = 0;
	var h = $.bootsform({
		window:false,rand:'{rand}',tablename:'flow_extent',
		url:publicsave('{mode}','{dir}'),
		submitfields:'recename,receid,modeid,type,whereid,wherestr,explain,status',
		requiredfields:'recename,type,modeid',
		success:function(){
			closenowtabs();
			try{guanflowviewlist.reload();}catch(e){}
			
		},
		load:function(a){
			js.setselectdata(h.form.whereid,a.wherelist,'id');
		},
		loadafter:function(a){
			if(a.data){
				h.form.wherestr.value=jm.base64decode(a.data.wherestr);
			}
		},
		submitcheck:function(d){
			if(d.type!='1' && d.wherestr=='' && d.whereid=='0')return '必须设置输入相应条件';
			return {wherestr:jm.base64encode(d.wherestr)}
		}
	});
	h.forminit();
	h.load(js.getajaxurl('loaddata','{mode}','{dir}',{id:id,mid:mid}));
	h.setValue('modeid',mid);
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
			h.form.recename.focus();
		},
		hanrenss:function(o,lx){
			if(lx==0)h.form.wherestr.value='{receid}';
			if(lx==1)h.form.wherestr.value='{allsuper}';
			if(lx==2)h.form.wherestr.value='{super}';
			if(lx==3)h.form.wherestr.value='all';
		}
		,
		reloadhweil:function(){
			h.form.whereid.length = 1;
			h.load(js.getajaxurl('loaddata','{mode}','{dir}',{id:id,mid:mid}));
		}
	};
	js.initbtn(c);
});

</script>

<div align="center">
<div  style="padding:10px;width:700px">
	
	
	<form name="form_{rand}">
	
		<input name="id" value="0" type="hidden" />
		<input name="modeid" value="0" type="hidden" />
		
		<table cellspacing="0" border="0" width="100%" align="center" cellpadding="0">
		
		<tr>
			<td align="right" ><font color=red>*</font> 针对对象：</td>
			<td class="tdinput" colspan="3">
				<div class="input-group" style="width:100%">
					<input readonly  class="form-control"  name="recename" >
					<input type="hidden" name="receid" >
					<span class="input-group-btn">
						<button class="btn btn-default" click="allqt" type="button">全体人员</button>
						<button class="btn btn-default" click="getdist,1" type="button"><i class="icon-search"></i></button>
					</span>
				</div>
			</td>
			
		</tr>
		
		<tr>
			<td  align="right" width="15%" ><font color=red>*</font> 类型可：</td>
			<td class="tdinput" width="35%" ><select name="type" class="form-control"><option value="0">查看</option><option value="1">添加</option><option value="2">编辑</option><option value="3">删除</option></select></td>
			<td  align="right"  width="15%"></td>
			<td class="tdinput" width="35%" ></td>
		</tr>
		
		<tr>
			<td  align="right" >选择条件：</td>
			<td class="tdinput"><select class="form-control" name="whereid"><option value="0">无条件</option></select></td>
			<td colspan="2"><a click="reloadhweil" href="javascript:;">[刷新]</a></td>
		</tr>
		<tr>
			<td  align="right" ></td>
			<td colspan="3" style="padding-bottom:10px"><font color=#888888>在【流程模块条件】上添加，满足此条件才需要此步骤</font></td>
		</tr>
		
		<tr>
			<td  align="right" >相应条件：</td>
			<td class="tdinput" colspan="3"><textarea placeholder="由对应模块上主表字段，如:optid={uid}，操作人是当前用户" name="wherestr" style="height:60px" class="form-control"></textarea><br>如:<a click="hanrenss,0" href="javascript:;">[receid中包含我]</a>,<a click="hanrenss,1" href="javascript:;">[所有下属人员]</a>,<a click="hanrenss,2" href="javascript:;">[直属下属人员]</a>,<a click="hanrenss,3" href="javascript:;">[所有数据]</a></td>
		</tr>
		
		<tr>
			<td  align="right" >条件说明：</td>
			<td class="tdinput" colspan="3"><textarea  name="explain" style="height:60px" class="form-control"></textarea></td>
		</tr>
		
		<tr>
			<td  align="right" ></td>
			<td class="tdinput" colspan="3">
				<label><input name="status" value="1" checked type="checkbox"> 启用?</label>&nbsp; &nbsp; 
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
