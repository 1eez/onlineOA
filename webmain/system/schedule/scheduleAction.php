<?php
class scheduleClassAction extends Action
{
	public function loadscheduleAjax()
	{
		$month	= $this->request('month');
		$startdt= ''.$month.'-01';
		$endddt	= c('date')->getenddt($month);
		$arr 	= m('schedule')->getlistdata($this->adminid, $startdt, $endddt);
		$this->returnjson($arr);
	}
	
	public function schedulebefore($table)
	{
		$s 		= 'and `uid`='.$this->adminid.'';
		$dt 	= $this->post('dt1');
		$key 	= $this->post('key');
		if($dt!='')$s.=" and `startdt` like '$dt%'";
		if($key!='')$s.=" and `title` like '%$key%'";
		return $s;
	}
	
	public function scheduleafter($table, $rows)
	{
		foreach($rows as $k=>$rs){
			$rate = $rs['rate'];
			if($rate=='w')$rate='每周'.$rs['rateval'].'';
			if($rate=='d')$rate='每天';
			if($rate=='m')$rate='每月'.$rs['rateval'].'号';
			$rows[$k]['rate'] = $rate;
		}
		return array('rows'=>$rows);
	}
	
	
	public function schedulemybefore($table)
	{
		return array(
			'where' => ' and id=0',
			'fields'=> 'id'
		);
	}
	
	
	public function schedulemyafter($table, $rows)
	{
		$dtobj 		= c('date');
		$startdt	= $this->post('startdt', $this->date);
		$enddt		= $this->post('enddt');
		if($enddt=='')$enddt = $dtobj->adddate($startdt,'d',10);
		$jg 		= $dtobj->datediff('d',$startdt, $enddt);
		if($jg>60){
			$jg 	= 60;
			$enddt 	= $enddt = $dtobj->adddate($startdt,'d',60);
		}
		
		$rows 		= m('schedule')->getlistdata($this->adminid, $startdt, $enddt);
		$barr 		= array();
		$dt 		= $startdt;
		for($i=0; $i<=$jg; $i++){
			if($i>0)$dt = $dtobj->adddate($dt,'d',1);
			$w 		= $dtobj->cnweek($dt);
			$status	= 1;
			if($w=='六'||$w=='日')$status	= 0;
			$str 	= '';
			if(isset($rows[$dt]))foreach($rows[$dt] as $k=>$rs){
				$str.=''.($k+1).'.['.substr($rs['time'],11,5).']'.$rs['title'].'<br>';
			}
			$sbarr	= array(
				'dt' => $dt,
				'week'	 => '星期'.$w,
				'status' => $status,
				'cont'	 => $str
			);
			$barr[] = $sbarr;
		}
		$arr['startdt'] = $startdt;
		$arr['enddt'] 	= $enddt;
		$arr['rows'] 	= $barr;
		$arr['totalCount'] 	= $jg+1;
		
		return $arr;
	}
}