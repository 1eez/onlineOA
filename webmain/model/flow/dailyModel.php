<?php
class flow_dailyClassModel extends flowModel
{
	public function initModel()
	{
		$this->typearr = explode(',','日报,周报,月报,年报');
	}
	
	protected function flowchangedata()
	{
		$this->rs['typess'] 	= $this->typearr[$this->rs['type']];
	}
	
	public function flowrsreplace($rs)
	{
		$rs['content'] 		= str_replace("\n",'<br>', $rs['content']);
		$rs['plan'] 		= str_replace("\n",'<br>', $rs['plan']);
		$rs['type'] 		= $this->typearr[$rs['type']];
		if($rs['mark']=='0')$rs['mark'] = '';
		return $rs;
	}
	
	protected function flowaddlog($a)
	{
		if($a['name'] == '日报评分'){
			$fenshu	 = (int)$this->rock->post('fenshu','0');
			$this->push($this->rs['uid'], '工作日报', ''.$this->adminname.'评分你[{dt}]的{typess},分数('.$fenshu.')','工作日报评分');
			$this->update(array(
				'mark' => $fenshu
			), $this->id);
		}
	}
	
	protected function flowdatalog($arr)
	{
		$ispingfen	= 0;
		$barr 		= m('admin')->getsuperman($this->uid); //获取我的上级主管
		if($barr){
			$hes 	= $barr[0];
			if(contain(','.$hes.',',','.$this->adminid.','))$ispingfen = 1; //是否可以评分
		}
		$arr['ispingfen'] 	= $ispingfen;
		$arr['mark'] 		= $this->rs['mark'];
		return $arr;
	}
	
	protected function flowgetoptmenu($opt)
	{
		if($this->uid==$this->adminid)return false;
		$to = m('log')->isread($this->mtable, $this->id);
		return $to<=0;
	}
	
	protected function flowoptmenu($ors, $crs)
	{
		$table 	= $this->mtable;
		$mid	= $this->id;
		$uid	= $this->adminid;
		$lx 	= $ors['num'];
		$log 	= m('log');
		if($lx=='yd'){
			$log->addread($table, $mid, $uid);
		}
		if($lx=='allyd'){
			$ydid  = $log->getread($table, $uid);	
			$where = m('view')->viewwhere($this->modeid, $uid);
			$where = "((1=1 $where) or (`uid`='$uid') )";
			$where = "`id` not in($ydid) and $where";
			
			$rows 	= m($table)->getrows($where,'id');
			foreach($rows as $k=>$rs)$log->addread($table, $rs['id'], $uid);
		}
	}
	
	
	protected function flowprintrows($rows)
	{
		foreach($rows as $k=>$rs){
			$rows[$k]['plan_style']		= 'text-align:left';
			$rows[$k]['content']		= str_replace("\n",'<br>', $rs['content']);
			$rows[$k]['plan']			= str_replace("\n",'<br>', $rs['plan']);
			$rows[$k]['type']			= $this->typearr[$rs['type']];
		}
		return $rows;
	}
	
	protected function flowbillwhere($uid, $lx)
	{
		$type 	= $this->rock->post('type');
		$key 	= $this->rock->post('key');
		$dt 	= $this->rock->post('dt');
		$where 		= 'and uid='.$uid.'';
		
		//全部下属
		if($lx == 'undall' || $lx == 'undwd'){
			$where  = 'and '.m('admin')->getdownwheres('uid', $uid, 0); //全部下属
			if($lx == 'undwd'){
				$ydid  	= m('log')->getread('daily', $uid); 
				$where.=' and id not in('.$ydid.')';
			}
		}

		if(!isempt($type))$where.=" and `type`='$type'";
		if(!isempt($dt))$where.=" and `dt` like '$dt%'";
		if(!isempt($key))$where.=" and (`content` like '%$key%' or `optname` like '%$key%')";
		
		return array(
			'where' => $where,
			'order' => 'optdt desc'
		);
	}
	
}