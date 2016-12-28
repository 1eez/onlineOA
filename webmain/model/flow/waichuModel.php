<?php
class flow_waichuClassModel extends flowModel
{
	protected function flowgetfields($lx)
	{
		$arr['location'] 		= '此时间定位打卡';
		return $arr;
	}
	
	public function flowrsreplace($rs, $lx=0)
	{
		if($lx==1){
			$s = $this->getdklocation($rs['outtime'], $rs['intime']);
			$rs['location'] = $s;
		}
		return $rs;
	}
	
	private function getdklocation($sdt,$edt)
	{
		$rows 	= $this->db->getrows('[Q]location',"`uid`='$this->uid' and `type`=0 and `optdt`>='$sdt' and `optdt`<='$edt'",'location_x,location_y,scale,label,`precision`,`optdt`,`id`');
		$s 		= '';
		foreach($rows as $k=>$rs){
			$s.=''.($k+1).'.'.$rs['label'].'('.$rs['optdt'].') <a href="javascript:;" onclick="js.locationshow('.$rs['id'].')" class="zhu">查看</a><br>';
		}
		return $s;
	}
	
	protected function flowbillwhere($uid, $lx)
	{
		$dt 	= $this->rock->date;
		$key 	= $this->rock->post('key');
		$month 	= $this->rock->post('month');
		$where 	= "a.`uid`=$uid and a.`intime`>'$dt 00:00:00' and a.`outtime`<'$dt 23:59:59'";
		if($lx=='myall'){
			$where 	= "a.`uid`=$uid";
		}
		if($lx=='all'){
			$where = '1=1';
		}
		if($key!='')$where.= m('admin')->getkeywhere($key, 'b.');
		if($month !='')$where.=" and a.`outtime` like '$month%'";
		return array(
			'where' => 'and '.$where,
			'fields'=> 'a.*,b.name,b.deptname,b.ranking',
			'table'	=> '`[Q]kqout` a left join `[Q]admin` b on a.`uid`=b.`id`',
			'order' => 'a.`id` desc'
		);
	}
}