<?php
class workClassModel extends Model
{
	//为完成统计的
	public function getwwctotals($uid)
	{
		$s 	= $this->rock->dbinstr('distid', $uid);
		$to	= $this->rows('`status`=1 and `state` in(0,2) and '.$s.'');
		return $to;
	}
}