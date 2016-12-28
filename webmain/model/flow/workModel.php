<?php
class flow_workClassModel extends flowModel
{

	public function initModel()
	{
		$this->statearr		 = c('array')->strtoarray('待执行|blue,已完成|green,执行中|#ff6600,终止|#888888');
	}
	
	public function flowrsreplace($rs, $slx=0){
		
		$zts 		= $rs['state'];
		$zt 		= $this->statearr[$zts];
		$str 		= '<font color="'.$zt[1].'">'.$zt[0].'</font>';
		if($slx==1){
			$projectid 	= (int)$rs['projectid'];
			$rs['projectid'] = '';
			if($projectid>0){
				$prs 		= $this->db->getone('[Q]project', $projectid);
				if($prs){
					$rs['projectid']=''.$prs['title'].'('.$prs['progress'].'%)';
				}
			}
		}
		if(!isempt($rs['enddt']) && ($zts==0 || $zts==2)){
			if(strtotime($rs['enddt'])<time())$str.='<font color=red>(已超期)</font>';
		}
		$rs['state']= $str;
		if($rs['score']==0)$rs['score']='';
		if($rs['mark']==0)$rs['mark']='';
		return $rs;
	}
	
	protected function flowchangedata(){
		$this->rs['stateid'] = $this->rs['state'];
	}
	
	
	protected function flowdatalog($arr)
	{
		$isaddlog	= 0;
		$uid 		= $this->adminid;
		$ispingfen	= 0;
		$distid 	= ','.$this->rs['distid'].',';
		$zt 		= $this->rs['stateid'];
		if($this->contain($distid, ','.$this->adminid.',') && ($zt==0||$zt==2)){
			$isaddlog = 1;
		}
		
		$arr['isaddlog'] = $isaddlog; //是否可以添加日志记录
		$arr['state'] 	 = $this->rs['stateid'];
		
		//判断是否可以督导评分
		$where  = $this->ddwhere($uid);
		if($this->rows("`id`='$this->id' and `state`=1 and `status`=1 and `mark`=0 $where")==1){
			$ispingfen		= 1;
		}
		$arr['ispingfen'] 	= $ispingfen; //是否可以评分
		$arr['score'] 		= $this->rs['score'];
		return $arr;
	}
	
	protected function flowsubmit($na, $sm)
	{
		$this->push($this->rs['distid'], '任务', '[{type}]{title}');
	}
	
	protected function flowaddlog($a)
	{
		if($a['name']=='进度报告'){
			$state 	= $a['status'];
			$arr['state'] = $state;
			$cont = ''.$this->adminname.'添加[{type}.{title}]的任务进度,说明:'.$a['explain'].'';
			if($state=='1')$cont='[{type}.{title}]任务'.$this->adminname.'已完成';
			$this->push($this->rs['optid'], '任务', $cont);
			$this->update($arr, $this->id);
		}
		if($a['name']=='指派给'){
			$cname 	 = $this->rock->post('changename');
			$cnameid = $this->rock->post('changenameid');
			$state = '0';
			$arr['state'] 	= $state;
			$arr['distid'] 	= $cnameid;
			$arr['dist'] 	= $cname;
			$this->update($arr, $this->id);
			$this->push($cnameid, '任务', ''.$this->adminname.'指派任务[{type}.{title}]给你');
		}
		if($a['name'] == '任务评分'){
			$fenshu	 = (int)$this->rock->post('fenshu','0');
			$this->push($this->rs['distid'], '任务', ''.$this->adminname.'评分[{type}.{title}],分数('.$fenshu.')','任务评分');
			$this->update(array(
				'mark' => $fenshu
			), $this->id);
		}
	}
	
	private function ddwhere($uid)
	{
		$downid = m('admin')->getdown($uid, 1);
		$where  = 'and `ddid`='.$uid.'';
		if($downid!='')$where  = 'and (('.$uid.' in(`ddid`)) or (ifnull(`ddid`,\'0\')=\'0\' and `distid` in('.$downid.')) or (ifnull(`ddid`,\'0\')=\'0\' and `optid`='.$uid.'))';
		return $where;
	}
	
	protected function flowbillwhere($uid, $lx)
	{
		$where 	= 'and '.$this->rock->dbinstr('distid', $uid);
		if($lx=='def' || $lx=='wwc'){
			$where.=' and state in(0,2)';
		}
		if($lx=='myall'){
			
		}
		if($lx=='all'){
			$where = '';
		}
		if($lx=='ywc'){
			$where.=' and state=1';
		}
		
		if($lx=='wcj'){
			$where = 'and optid='.$uid.'';
		}
		if($lx=='xxrw'){
			$where = 'and 1=2';
		}
		if($lx=='down'){
			$where  = 'and '.m('admin')->getdownwhere('`distid`', $uid, 1);
		}
		if($lx=='dd'){
			$where  = $this->ddwhere($uid);
		}
		
		$key 	= $this->rock->post('key');
		$zt 	= $this->rock->post('zt');
		$projcetid 	= (int)$this->rock->post('projcetid');
		if($projcetid>0)$where.=' and `projectid`='.$projcetid.'';
		if($zt!='')$where.=' and `state`='.$zt.'';
		if(!isempt($key)){
			$where.=" and (`title` like '%$key%' or `type` like '%$key%' or `dist` like '$key%' or `grade` like '%$key%' or `projectid` in (select `id` from `[Q]project` where `title` like '%$key%'))";
		}
		
		return array(
			'where' => 'and `status`=1 '.$where,
			'fields'=> 'id,type,grade,dist,startdt,title,enddt,`status`,state,optname,projectid,score,mark,ddname',
			'order' => '`optdt` desc'
		);
	}
}