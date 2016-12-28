<?php
class viewClassAction extends Action
{
	public function loaddataAjax()
	{
		$id = (int)$this->get('id');
		$setid	= (int)$this->get('mid');
		$arr['data'] 		= m('flow_extent')->getone($id);
		$arr['wherelist'] 	= m('flow_where')->getall('setid='.$setid.'','id,name','sort');
		echo json_encode($arr);
	}
	
	public function afterstroesss($table,$rows)
	{
		foreach($rows as $k=>$rs){
			$rows[$k]['modename'] = $this->db->getmou('[Q]flow_set','name',$rs['modeid']);
			$rows[$k]['whereid']  = $this->db->getmou('[Q]flow_where','name',$rs['whereid']);
		}
		return array(
			'rows'=>$rows,
			'modearr' => m('mode')->getmodearr()
		);
	}
}