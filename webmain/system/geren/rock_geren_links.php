<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var arr={};
	$.get(js.getajaxurl('getlinks','geren','system'),function(str){
		var a=js.decode(str);
		for(var i=0;i<a.length;i++){
			if(!arr[a[i].type])arr[a[i].type]=[];
			arr[a[i].type].push(a[i]);
		}
		showlista();
	});
	
	function showlista(){
		var s='',d,i,icon,oi=0;
		for(var c in arr){
			d = arr[c];
			if(oi>0)s+='<div style="margin:10px 0px" class="blank1"></div>';
			s+='<div><h4>'+c+'('+d.length+')</h4></div>';
			s+='<div class="divlisssa"><ul>';
			for(i=0;i<d.length;i++){
				icon=d[i].icon;
				if(isempt(icon))icon='images/ieicons.png';
				s+='<li><a href="'+d[i].url+'" target="_blank"><img src="'+icon+'" align="absmiddle" height="20" width="20">'+d[i].name+'</a></li>';
			}
			s+='</ul></div>';
			oi++;
		}
		$('#view_{rand}').html(s);
	}
});
</script>
<style>
.divlisssa li{float:left;padding:5px;text-align:left;width:20%}
.divlisssa ul,.divlisssa{display:inline-block;width:100%}
</style>


<div style="padding:10px 30px" id="view_{rand}"></div>
