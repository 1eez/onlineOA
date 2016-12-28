<?php
class flow_emailmClassModel extends flowModel
{
	//判断是否有读取权限
	protected function flowisreadqx()
	{
		$to  = m('emails')->rows('`mid`='.$this->id.' and `uid`='.$this->adminid.'');
		return $to>0;
	}
	
	//立即发送提醒
	protected function flowsubmit($na, $sm)
	{
		if($this->rs['isturn']==1){
			$h 		= c('html');
			$cont 	= $h->htmlremove($this->rs['content']);
			$cont 	= $h->substrstr($cont,0, 50);
			$receid = $this->rs['receid'];
			if(!isempt($this->rs['ccid']))$receid.=','.$this->rs['ccid'];
			$this->push($receid, '邮件', $cont.'...', $this->rs['title']);
		}
	}
	
	//重写方法将邮件标识已读邮件了
	protected function flowdatalog($arr)
	{
		$where 	= '`mid`='.$this->id.' and `uid`='.$this->adminid.'';
		$dbs 	= m('emails');
		$dbs->update('`zt`=1', $where);
		//判断我是否可以回复
		$ishuifu = 0;
		if($this->rs['isturn']==1){
			$tos = $dbs->rows($where.' and `type` in(0,1)');
			if($tos>0)$ishuifu = 1;
		}
		return array('ishuifu' => $ishuifu);
	}
	
	private function dtssss($dt)
	{
		$cnw = c('date')->cnweek($dt);
		return date('Y年m月d日(星期'.$cnw.')H:i:s',strtotime($dt));
	}
	
	public function flowrsreplace($rs, $lx=0)
	{
		$rs['senddt'] 	= $this->dtssss($rs['senddt']);
		if($lx == 1 && $rs['hid']>0){
			$rs['oldcontent'] = $this->getoldcont($rs['hid']);
		}
		return $rs;
	}
	
	/**
	*	读取原来邮件内容
	*/
	private function getoldcont($hid)
	{
		$hid = (int)$hid;
		if($hid==0)return '';
		$hrs = $this->getone($hid);
		if(!$hrs)return '';
		$dts 	= $this->dtssss($hrs['senddt']);
		$fstr	= m('file')->getstr($this->mtable, $hrs['id'], 1);
		$s = '<div style="color:#888888;font-size:12px;margin-top:20px">------------------ 原始邮件 ------------------</div>';
		$s.= '<div style="font-size: 12px;background:#efefef;padding:8px;line-height:18px;">发件人: '.$hrs['sendname'].'<br>
			发送时间: '.$dts.'<br>
			收件人: '.$hrs['recename'].'<br>
			主题: '.$hrs['title'].'</div>';
		$s.= '<div style="margin-top:10px">'.$hrs['content'].'<br>'.$fstr.'</div>';
		$s.= $this->getoldcont($hrs['hid']);
		return $s;
	}
	
	
	protected function flowbillwhere($uid, $lx)
	{
		$where	= '1=2';
		$onwhere= '';
		$key 	= $this->rock->post('key');
		$dt 	= $this->rock->post('dt');
		$dbs 	= m('emailm');
		
		//所有邮件
		if($lx=='' || $lx=='def' || $lx=='sjx'){
			$where 		= $dbs->gettowhere($uid, 0);
		}
		
		//未读邮件
		if($lx=='wdyj'){
			$where 		= $dbs->gettowhere($uid, 1);
		}
		
		//草稿箱
		if($lx == 'cgx'){
			$where 		= $dbs->gettowhere($uid, 2);
		}
		
		//已发送
		if($lx == 'yfs'){
			$where 		= $dbs->gettowhere($uid, 3);
		}
		
		//已删除
		if($lx == 'ysc'){
			$where 		= $dbs->gettowhere($uid, 4);
		}
		
		if(!isempt($key))$where.=" and (a.`title` like '%$key%' or a.`recename` like '%$key%')";
		if(!isempt($dt))$where.=" and a.`senddt` like '$dt%'";
		
		return array(
			'where' => 'and '.$where,
			'fields'=> 'a.`id`,a.`title`,a.`sendname`,a.`recename`,a.`senddt`,a.`isfile`,b.`ishui`,b.`zt`',
			'order' => 'a.`senddt` desc',
			'table'	=> '`[Q]emailm` a left join `[Q]emails` b on a.`id`=b.`mid` '.$onwhere.''
		);
	}
	
	private function getmid($uid, $type, $isdel=0)
	{
		$rows = m('emails')->getrows('`uid`='.$uid.' and `type` in('.$type.') and `isdel`='.$isdel.'','`mid`');
		$ids  = '0';
		foreach($rows as $k=>$rs)$ids.=','.$rs['mid'].'';
		return $ids;
	}
	
	public function savesubmid($tuid, $mid, $type, $zt=0)
	{
		if(is_numeric($tuid)){
			$uids	= $tuid;
		}else{
			$uids 	= m('admin')->gjoin($tuid);
		}
		$now 		= $this->rock->now;
		if($uids!=''){
			$this->db->insert('[Q]emails','mid,uid,email,personal,type,optdt,zt',"select '$mid',id,email,name,'$type','$now','$zt' from `[Q]admin` where id in($uids)", true);
		}
	}
	
	/**
	*	邮件回复
	*	$cont 回复内容
	*/
	public function huifu($cont)
	{
		$rs 	= $this->rs;
		$rers 	= $this->gethuifuarr();
		if(!$rers)return '没有发送人';
		$cont	= str_replace("\n", '<br>', $cont);
		$arr['title'] 	 	= 'Re:'.$rs['title'].'';
		$arr['content'] 	= $cont;
		$arr['sendid'] 		= $this->adminid;
		$arr['uid'] 		= $this->adminid;
		$arr['sendname'] 	= $this->adminname;
		$arr['senddt'] 		= $this->rock->now;
		$arr['applydt'] 	= $this->rock->date;
		$arr['hid'] 		= $this->id;
		$arr['type'] 		= $rs['type'];
		$arr['receid'] 		= $rers['uid'];
		$arr['recename'] 	= $rers['personal'];
		$arr['isturn'] 		= 1;
		$arr['toemail'] 	= ''.$rers['personal'].'('.$rers['email'].')';
		$arr['optdt'] 		= $this->rock->now;
		
		
		$id 				= $this->insert($arr);
		$sarr['mid'] 		= $id;
		$sarr['uid'] 		= $rers['uid'];
		$sarr['type'] 		= 0;
		$sarr['optdt'] 		= $this->rock->now;
		$sarr['email'] 		= $rers['email'];
		$sarr['personal'] 	= $rers['personal'];
		m('emails')->insert($sarr);
		$this->savesubmid($arr['sendid'], $id, 2,1);
		
		m('emails')->update('ishui=1','`mid`='.$this->id.' and `uid`='.$this->adminid.' and `type`=0');//更新已回复
		//需要外发
		if($rs['type']==1 && !isempt($rers['email'])){
			m('email')->sendemailout($this->adminid, $arr['title'], $arr['content'], $rers['email'], $arr['recename']);
		}
		
		$this->loaddata($id, false);
		$this->submit('回复');
		
		return 'ok';
	}
	
	//获取要回复的接收人
	public function gethuifuarr()
	{
		$rs = m('emails')->getone('`mid`='.$this->id.' and `type`=2');
		return $rs;
	}
}