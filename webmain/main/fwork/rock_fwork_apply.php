<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	
	var c={
		showdata:function(a){
			var hhu = parseInt(viewwidth/290);
			var j=0,lx,d,s1,i,l=0,len;
			var strarr = [];for(i=0;i<hhu;i++)strarr[i]='';
			for(lx in a){
				d=a[lx];s1='';j++;len=d.length;
				s1 ='<div align="left" style="margin:20px;width:230px" class="list-group">';
				s1+='<div class="list-group-item  list-group-item-success"><i class="icon-plus"></i> '+lx+'('+len+')</div>';
				for(i=0;i<len;i++){
					s1+='<a onclick="openinput(\''+d[i].name+'\',\''+d[i].num+'\',0)" class="list-group-item">'+d[i].name+'</a>';
				}
				s1+='</div>';
				strarr[l]+=s1;
				l++;
				if(l==hhu)l=0;
			}
			var s='<table><tr valign="top">';
			for(i=0;i<hhu;i++)s+='<td>'+strarr[i]+'</td>';
			s+='</tr></table>';
			$('#view_{rand}').html(s);
		}
	}
	
	js.ajax(js.getajaxurl('getmodearr','{mode}','{dir}'),{},function(a){
		c.showdata(a.rows);
	},'get,json');
});
</script>

<div id="view_{rand}"></div>
