<?php
class flow_sealaplClassModel extends flowModel
{
	//读取印章保管人来审批
	protected function flowcheckname($num)
	{
		if($num=='bgque'){
			$sealrs = m('seal')->getone('`id`='.$this->rs['sealid'].'');
			if($sealrs)return array($sealrs['bgid'], $sealrs['bgname']);
		}
	}
	
	//展示是替换一下
	public function flowrsreplace($rs)
	{
		$str= '<font color=#888888>否</font>';
		if($rs['isout']==1)$str= '<font color=green>是</font>';
		$rs['isout'] = $str;
		return $rs;
	}
	
	protected function flowbillwhere($uid, $lx)
	{
		$key  	= $this->rock->post('key');
		$where 	= '';
		if($key!='')$where = m('admin')->getkeywhere($key, 'b.', "or a.`sealname` like '%$key%'");
		$table 	= '`[Q]sealapl` a left join `[Q]admin` b on a.uid=b.id';
		return array(
			'where' => $where,
			'table'	=> $table,
			'fields'=> 'a.*,b.deptname,b.name',
			'order' => 'a.`optdt` desc'
		);
	}
}