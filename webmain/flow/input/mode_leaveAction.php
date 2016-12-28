<?php
class mode_leaveClassAction extends inputAction{

	protected function savebefore($table, $arr, $id, $addbo){
		$msg 	= m('kaoqin')->leavepan($arr['uid'], $arr['qjkind'], $arr['stime'], $arr['etime'], $arr['totals'], $id);
		return $msg;
	}
	
	public function totalAjax()
	{
		$start	= $this->post('stime');
		$end	= $this->post('etime');
		//$date	= c('date', true);
		//$sj		= $date->datediff('H', $start, $end);
		$sj 	= m('kaoqin')->getsbtime($this->adminid,$start, $end);
		$sj 	= ceil($sj);
		$this->returnjson(array($sj, ''));
	}
	

	
	//统计剩余时间
	public function getshentime()
	{
		$mid = (int)$this->get('mid');
		$kqm = m('kaoqin');
		$njs = $kqm->getqjsytime($this->adminid, '年假', '', $mid);
		$tx  = $kqm->getqjsytime($this->adminid, '调休', '', $mid);
		$str = '年假('.$njs.'小时)，可调休('.$tx.'小时)';
		return $str;
	}
}	
			