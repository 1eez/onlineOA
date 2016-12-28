<?php
class flow_userClassModel extends flowModel
{
	
	/**
	*	用户显示展示
	*/
	protected function flowbillwhere($uid, $lx)
	{
		$where 	= 'and `status`=1';
		$key	= $this->rock->post('key');
		
		if(!isempt($key))$where.= m('admin')->getkeywhere($key);
	
		return array(
			'where' => $where,
			'fields'=> '`name`,`id`,`id` as uid,`deptallname`,`ranking`,`tel`,`mobile`,`email`',
			'order' => 'sort'
		);
	}
	
	//替换
	public function flowrsreplace($rs, $lx=0)
	{
		if($lx==2){
			if(!isempt($rs['mobile']))$rs['mobile']='<a href="tel:'.$rs['mobile'].'">'.$rs['mobile'].'</a>';
			if(!isempt($rs['tel']))$rs['tel']='<a href="tel:'.$rs['tel'].'">'.$rs['tel'].'</a>';
		}
		return $rs;
	}
}