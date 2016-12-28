<?php 
/**
	html相关插件
*/
class htmlChajian extends Chajian{
	
	public function replace($cont)
	{
		if($this->rock->isempt($cont))return '';
		//$cont	= str_replace(array('<', '>'), array('&lt;', '&gt;'), $cont);
		$cont	= str_replace(array('[B]','[/B]', '[/A]', "\n"), array('<B>','</B>', '</A>','</p><p>'), $cont);
		
		preg_match_all('/\[(.*?)\]/', $cont, $list);
		foreach($list[0] as $k=>$nrs){
			if($this->rock->contain($nrs, '[A,')){
				$url	= str_replace('[A,', '', $nrs);
				$url	= str_replace(']', '', $url);
				$cont	= str_replace($nrs, '<A href="'.$url.'" target="_blank">', $cont);
			}
			if($this->rock->contain($nrs, '[IMG,')){
				$url	= str_replace('[IMG,', '', $nrs);
				$url	= str_replace(']', '', $url);
				$a		= explode(',', $url);
				$str	= '<img src="'.$a[0].'"';
				if(isset($a[1]))$str.=' width="'.$a[1].'"';
				if(isset($a[2]))$str.=' height="'.$a[2].'"';
				$str.='>';
				$cont	= str_replace($nrs, $str, $cont);
			}
		}
		return $cont;
	}
	
	
	public function createtable($fields, $arr, $title='',$lx='')
	{
		$bcolor = '#cccccc';
		if($lx=='print'){
			$bcolor = '#000000';
			$title='';
		}
		$s 	= '<table border="0" class="createtable" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">';
		if($title != ''){
			$s .= '<tr><td colspan="2" align="center" style="border:1px '.$bcolor.' solid;padding:10px;font-size:16px;background:#D2E9FF;">'.$title.'</td></tr>';
		}
		foreach($fields as $fid=>$na){
			$val = '';
			$sty = 'padding:8px;';
			if(isset($arr[$fid]))$val = $arr[$fid];
			if(isset($arr[$fid.'_style']))$sty .= $arr[$fid.'_style'];
			$s .= '<tr><td align="right" nowrap style="border:1px '.$bcolor.' solid;padding:5px 8px;">'.$na.'</td><td  style="border:1px '.$bcolor.' solid;'.$sty.'" align="left">'.$val.'</td></tr>';
		}
		$s .='</table>';
		
		return $s;
	}
	
	/**
		创建table表格数据
		@param	string  $rows  	 下载导出数据
		@param	string  $headstr 表格表头(如：lie1,列1,left@lie2,列2,center)
		@return	string
	*/
	public function createrows($rows, $headstr='', $bor='#C9ECFF',$lx='')
	{
		if($headstr == '')$headstr	= $this->request('header');
		if($headstr	== '')return '';
		$arrh		= explode('@', $headstr);
		$thead		= count($arrh);
		$lens		= $thead-1;
		$rlen		= count($rows);
		for($i=0; $i<$thead; $i++){
			$te_str	= $arrh[$i];
			if(count(explode(',', $te_str)) < 3)$te_str.=',center';
			$head[]	= explode(',', $te_str);
		}
		$txt	 = '';
		$style	 = "padding:3px;border:1px ".$bor." solid";
		$txt	.= '<table width="100%" class="createrows" border="0" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;" >';
		$txt	.= '<tr>';
		for($h=0; $h<$thead; $h++){
			$stls= $style;
			if($lx=='noborder'){
				$stls.=';border-top:none';
				if($h==0)$stls.=';border-left:none';
				if($h==$lens)$stls.=';border-right:none';
			}
			$txt.= '<td style="'.$stls.'" bgcolor="#eeeeee" align="'.$head[$h][2].'"><b>'.$head[$h][1].'</b></td>';
		}
		$txt	.= '</tr>';
		foreach($rows as $k=>$rs){
			$txt	.= '<tr>';
			for($h=0; $h<$thead; $h++){
				$stls= $style;
				$stls.='';
				if($lx=='noborder'){
					if($h==0)$stls.=';border-left:none';
					if($h==$lens)$stls.=';border-right:none';
					if($k==$rlen-1)$stls.=';border-bottom:none';
				}
				$val 	 = isset($rs[$head[$h][0]]) ? $rs[$head[$h][0]] : '';
				$txt	.= '<td style="'.$stls.'" align="'.$head[$h][2].'">'.$val.'</td>';
			}	
			$txt	.= '</tr>';
		}
		$txt	.= '</table>';
		return $txt;
	}
	
	/**
	*	创建excel导出表格
	*/
	public function execltable($title, $headArr, $rows, $lx='')
	{
		if($lx=='')$lx='xls';
		$sty 	= 'style="white-space:nowrap;border:.5pt solid #000000;font-size:12px;"';
		$s 		= '<html><head><meta charset="utf-8"><title>'.$title.'</title></head><body>';
		$s 	   .= '<table border="0" style="border-collapse:collapse;">';
		$hlen 	= 1;
		$s1='<tr height="30"><td '.$sty.'>序号</td>';
		foreach($headArr as $na){
			$hlen++;
			$s1.='<td '.$sty.'>'.$na.'</td>';
		}
		$s1.='</tr>';
		$s.='<tr height="40"><td '.$sty.' colspan="'.$hlen.'">'.$title.'</td></tr>';
		$s.=$s1;
		foreach($rows as $k=>$rs){
			$s.='<tr height="26">';
			$s.='<td align="center" '.$sty.'>'.($k+1).'</td>';
			foreach($headArr as $kf=>$na){
				$val = '';
				if(isset($rs[$kf]))$val=$rs[$kf];
				$s.='<td '.$sty.'>'.$val.'</td>';
			}
			$s.='</tr>';
		}
		$s.='</table>';
		
		$s.='</body></html>';
		$mkdir 	= 'upload/'.date('Y-m').'';
		if(!is_dir($mkdir))mkdir($mkdir);
		
		$filename 	= ''.$title.'_'.time().'.'.$lx.'';
		$filename	= str_replace('/','',$filename);
		$url 		= ''.$mkdir.'/'.$filename.'';
		$bo 		= file_put_contents(iconv('utf-8','gb2312',$url), $s);
		return $url;
	}
	
	
	
	
	
	
	
	
	
	
	public function htmlremove($str)
	{
		$str = preg_replace("/<[^>]*>/si",'',$str);
		return $str;
	}
	
	public function substrstr($str, $start, $length=null) {  
		preg_match_all('/./us', $str, $match);  
		$chars = is_null($length)? array_slice($match[0], $start ) : array_slice($match[0], $start, $length);  
		unset($str);
		return implode('', $chars);  
	} 
	
	
	
	
	
	
	
	
	
	
	public function importdata($fields,$btfid='', $fid='')
	{
		if($fid=='')$fid='importcont';
		$rows 	= array();
		$val	= $this->rock->post($fid);
		if($val=='')return $rows;
		$arrs 	= explode("\n", $val);
		$farr 	= explode(',', $fields);
		$fars 	= explode(',', $btfid);
		foreach($arrs as $valss){
			$dars 	= explode('	', $valss);
			$barr 	= array();
			foreach($farr as $k=>$fid){
				$barr[$fid] = isset($dars[$k]) ?  $dars[$k] : '';
			}
			$bos 	= true;
			foreach($fars as $fids){
				if(isset($barr[$fids]) && isempt($barr[$fids]))$bos = false;
			}
			if($bos)$rows[] = $barr;
		}
		return $rows;
	}
}                                  