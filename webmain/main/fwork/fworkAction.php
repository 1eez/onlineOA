<?php
class fworkClassAction extends Action
{
	
	public function getmodearrAjax()
	{
		$rows = m('mode')->getmoderows($this->adminid,'and islu=1');
		$row  = array();
		$viewobj = m('view');
		foreach($rows as $k=>$rs){
			$lx = $rs['type'];
			if(!$viewobj->isadd($rs['id'], $this->adminid))continue;
			if(!isset($row[$lx]))$row[$lx]=array();
			$row[$lx][] = $rs;
		}
		$this->returnjson(array('rows'=>$row));
	}
	
	
	
	
	
	
	public function flowbillbefore($table)
	{
		$lx 	= $this->post('atype');
		$dt 	= $this->post('dt1');
		$key 	= $this->post('key');
		$zt 	= $this->post('zt');
		$modeid = (int)$this->post('modeid','0');
		$uid 	= $this->adminid;
		$where	= 'and a.uid='.$uid.'';
		//待办
		if($lx=='daib'){
			$where	= 'and a.`status`=0 and '.$this->rock->dbinstr('a.nowcheckid', $uid);
		}
		
		if($lx=='xia'){
			$where	= 'and '.$this->rock->dbinstr('b.superid', $uid);
		}
		
		if($lx=='jmy'){
			$where	= 'and '.$this->rock->dbinstr('a.allcheckid', $uid);
		}
		
		if($lx=='mywtg'){
			$where.=" and a.status=2";
		}
		
		if($zt!='')$where.=" and a.status='$zt'";
		if($dt!='')$where.=" and a.applydt='$dt'";
		if($modeid>0)$where.=' and a.modeid='.$modeid.'';
		if(!isempt($key))$where.=" and (b.`name` like '%$key%' or b.`deptname` like '%$key%' or a.sericnum like '$key%')";
		
		
		return array(
			'table' => '`[Q]flow_bill` a left join `[Q]admin` b on a.uid=b.id',
			'where' => " and a.isdel=0 $where",
			'fields'=> 'a.*,b.name,b.deptname',
			'order' => 'a.optdt desc'
		);
	}
	
	public function flowbillafter($table, $rows)
	{
		$rows = m('flowbill')->getbilldata($rows);
		return array(
			'rows'		=> $rows,
			'flowarr' 	=> m('mode')->getmodemyarr($this->adminid)
		);
	}
	
	
	
	public function meetqingkbefore($table)
	{
		$pid = $this->option->getval('hyname','-1', 2);
		return array(
			'where' => "and `pid`='$pid'",
			'order' => 'sort',
			'field' => 'id,name',
		);
	}
	
	public function meetqingkafter($table, $rows)
	{
		$dtobj 		= c('date');
		$startdt	= $this->post('startdt', $this->date);
		$enddt		= $this->post('enddt');
		if($enddt=='')$enddt = $dtobj->adddate($startdt,'d',7);
		$jg 		= $dtobj->datediff('d',$startdt, $enddt);
		if($jg>30)$jg = 30;
		$flow 		= m('flow:meet');
		$data 		= m('meet')->getall("`status`=1 and `type`=0 and `startdt`<='$enddt 23:59:59' and `enddt`>='$startdt' order by `startdt` asc",'hyname,title,startdt,enddt,state,joinname,optname');
		$datss 		= array();
		foreach($data as $k=>$rs){
			$rs 	= $flow->flowrsreplace($rs);
			$key 	= substr($rs['startdt'],0,10).$rs['hyname'];
			if(!isset($datss[$key]))$datss[$key] = array();
			$str 	= '['.substr($rs['startdt'],11,5).'→'.substr($rs['enddt'],11,5).']'.$rs['title'].'('.$rs['joinname'].') '.$rs['state'].'';
			$datss[$key][] = $str;
		}
		
		$columns	= $rows;
		$barr 		= array();
		$dt 		= $startdt;
		for($i=0; $i<=$jg; $i++){
			if($i>0)$dt = $dtobj->adddate($dt,'d',1);
			$w 		= $dtobj->cnweek($dt);
			$status	= 1;
			if($w=='六'||$w=='日')$status	= 0;
			$sbarr	= array(
				'dt' 		=> '星期'.$w.'<br>'.$dt.'',
				'status' 	=> $status
			);
			foreach($rows as $k=>$rs){
				$key 	= $dt.$rs['name'];
				$str 	= '';
				if(isset($datss[$key])){
					foreach($datss[$key] as $k1=>$strs){
						$str.= ''.($k1+1).'.'.$strs.'<br>';
					}
				}
				$sbarr['meet_'.$rs['id'].''] = $str;
			}
			$barr[] = $sbarr;
		}
		$arr['columns'] = $columns;
		$arr['startdt'] = $startdt;
		$arr['enddt'] 	= $enddt;
		$arr['rows'] 	= $barr;
		$arr['totalCount'] 	= $jg+1;
		
		return $arr;
	}
}