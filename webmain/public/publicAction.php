<?php 
class publicClassAction extends ActionNot{
	

	public function testAction()
	{
		$this->display = false;
		echo c('zip')->unzip('abc.zip','./');
		//$rows 	= m('emailm')->receemail(1);
		
		//print_r($rows);
		
		
		echo ''.$this->now.'<br>';
	}
	
	
}