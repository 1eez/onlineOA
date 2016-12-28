<?php
class mode_emailmClassAction extends inputAction{
	

	protected function savebefore($table, $arr, $id, $addbo){
		$barr['sendid'] 	= $this->adminid;
		$barr['sendname'] 	= $this->adminname;
		$barr['senddt'] 	= $this->now;
		$isfile				= 0;
		if($this->post('fileid') != '')$isfile = '1';
		$barr['isfile']		= $isfile;
		return array('rows'=>$barr);
	}
	
	
	protected function saveafter($table, $arr, $id, $addbo)
	{
		$isturn = (int)$arr['isturn'];
		if($isturn==1){
			$this->flow->savesubmid($arr['receid'], $id, 0,0);
			$this->flow->savesubmid($arr['ccid'], $id, 1,0);
			$this->flow->savesubmid($arr['sendid'], $id, 2,1);
		}
	}
	
	
	
	//邮件回复的
	public function emailhuifuAjax()
	{
		$mid 	= (int)$this->post('mid');
		$cont 	= $this->post('cont');
		$flow 	= m('flow')->initflow('emailm', $mid);
		echo $flow->huifu($cont);
	}
}	
			