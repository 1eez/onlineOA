function initbodys(){
	$.getScript('js/rmb.js');
	form('applydt').readOnly=true;
	form('moneycn').readOnly=true;
	$(form('money')).blur(function(){
		cchangtongss();
	});
	$(form('moneycn')).click(function(){
		cchangtongss();
	});
	
	if(mid=='0'){
		js.ajax(geturlact('getlast'),{},function(d){
			if(d){
				form('paytype').value=d.paytype;
				form('cardid').value=d.cardid;
				if(form('openbank'))form('openbank').value=d.openbank;
				form('fullname').value=d.fullname;
			}
		},'get,json');
	}
}
function changesubmit(){
	var jg = parseFloat(form('money').value);
	if(jg<=0)return '还款金额不能小于0';
}
function changesubmitbefore(){
	cchangtongss();
}
function cchangtongss(){
	var to = parseFloat(form('money').value)
	form('money').value=js.float(to)+'';
	form('moneycn').value=AmountInWords(to);
}
