<?php
class menuClassAction extends Action
{

	public function dataAjax()
	{
		$this->rows		= array();
		$type 			= $this->get('type');
		$where 			= '';
		//权限那来的
		if($type != ''){
			$where		= 'and `status`=1 and `ispir`=1';
			if($type=='view')$where = 'and `status`=1';
		}else{
			$this->updatepirss();
		}
		$this->alldata 	= $this->db->getall('select *,(select count(1)from `[Q]menu` where `pid`=a.id '.$where.')stotal from `[Q]menu` a where 1=1 '.$where.' order by `sort`');
		$this->getmenu(0, 1);
		echo json_encode(array(
			'totalCount'=> 0,
			'rows'		=> $this->rows
		));
	}
	
	private function getmenu($pid, $oi)
	{
		foreach($this->alldata as $k=>$rs){
			if($pid==$rs['pid']){
				$rs['level']	= $oi;
				$this->rows[] 	= $rs;
				$this->getmenu($rs['id'], $oi+1);
			}
		}
	}
	
	//下级需要验证，那上级也必须验证的
	private function updatepirss()
	{
		$rows 	= $this->db->getall('select `pid` from `[Q]menu` where `pid`>0 and `ispir`=1 group by `pid`');
		$sid 	= '0';
		foreach($rows as $k=>$rs)$sid.=','.$rs['pid'].'';
		if($sid!='')m('menu')->update('`ispir`=1', "`id` in($sid)");
	}
}