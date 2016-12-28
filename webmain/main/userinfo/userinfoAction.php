<?php
class userinfoClassAction extends Action
{
	public function userinfobefore($table)
	{
		$table = '`[Q]admin` a left join `[Q]userinfo` b on a.id=b.id';
		$s 		= '';
		$key 	= $this->post('key');
		if($key!=''){
			$s = " and (a.`name` like '%$key%' or a.`user` like '%$key%' or a.`ranking` like '%$key%' or a.`deptname` like '%$key%') ";
		}
		return array(
			'table' => $table,
			'where'	=> $s,
			'fields'=> 'a.name,a.deptname,a.id,a.status,a.ranking,b.id as ids,b.dkip,b.dkmac,b.iskq,b.isdwdk'
		);
	}
	
	public function userinfoafter($table, $rows)
	{
		$db = m($table);
		foreach($rows as $k=>$rs){
			if(isempt($rs['ids'])){
				$db->insert(array(
					'id' 		=> $rs['id'],
					'name' 		=> $rs['name'],
					'deptname' 	=> $rs['deptname'],
					'ranking' 	=> $rs['ranking']
				));
			}
		}
		return array('rows'=>$rows);
	}
	
	public function fieldsafters($table, $fid, $val, $id)
	{
		$fields = 'sex,ranking,tel,mobile,workdate,email,quitdt';
		if(contain($fields, $fid)){
			if($fid=='quitdt'){
				$dbs = m($table);
				if(isempt($val)){
					$dbs->update('`state`=0', "`id`='$id' and `state`=5");
				}else{
					$dbs->update('`state`=5', "`id`='$id'");
				}
			}
			m('admin')->update(array($fid=>$val), $id);
		}
	}

	
	public function userinfobeforegeren()
	{
		return ' and id='.$this->adminid.'';
	}
}