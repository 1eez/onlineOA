<?php 
/**
*	【文档】记事接口
*	createname：雨中磐石
*	homeurl：http://xh829.com/
*	Copyright (c) 2016 rainrock (xh829.com)
*	Date:2016-08-12
*/
class scheduleClassAction extends apiAction
{
	public function getlistAction()
	{
		$startdt 	= $this->post('startdt');
		$enddt 		= $this->post('enddt');
		$arr 		= m('schedule')->getlistdata($this->adminid, $startdt, $enddt);
		$this->showreturn($arr);
	}
}