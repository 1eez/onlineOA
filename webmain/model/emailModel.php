<?php
class emailClassModel extends Model
{
	public function initModel()
	{
		$this->settable('email_cog');
	}
	/**
	*	系统邮件发送邮件
	*	$to_uid 发送给。。。
	*	$rows	内容
	*/
	public function sendmail($title, $body, $to_uid, $rows=array(), $zjsend=0)
	{
		$setrs		= m('option')->getpidarr(-1);
		if(!$setrs)return '未设置发送邮件';
		
		$serversmtp 	= $this->rock->arrvalue($setrs, 'email_sendhost');
		$emailuser  	= $this->rock->arrvalue($setrs, 'email_sysuser');
		$emailname  	= $this->rock->arrvalue($setrs, 'email_sysname');
		$emailpass  	= $this->rock->arrvalue($setrs, 'email_syspass');
		$serverport  	= $this->rock->arrvalue($setrs, 'email_sendport');
		$emailsecure  	= $this->rock->arrvalue($setrs, 'email_sendsecure');
		
		if(isempt($serversmtp) || isempt($serverport) || isempt($emailuser)|| isempt($emailpass))return '未设置发送帐号';

		$to_em	= $to_mn = $to_id 	= '';
		
		$urs	= $this->db->getall("select `email`,`name`,`id` from `[Q]admin` where `id` in($to_uid) and `email` is not null and `status`=1 order by `sort`");
		foreach($urs as $k=>$rs){
			$to_em.=','.$rs['email'];
			$to_mn.=','.$rs['name'];
			$to_id.=','.$rs['id'];
		}	
		
		if(isempt($to_em))return '没有接收人';
		
		$to_em	= substr($to_em, 1);
		$to_mn	= substr($to_mn, 1);
		$to_id	= substr($to_id, 1);
		
		$body	= $this->rock->reparr($body, $rows);
		$title	= $this->rock->reparr($title, $rows);
			
		$body	= str_replace("\n", '<br>', $body);
		
		$msg 	= 'ok';
		
		if(!getconfig('asynsend') || $zjsend==1){
			$bo 	= $this->sendddddd(array(
				'emailpass' 	=> $emailpass,
				'serversmtp' 	=> $serversmtp,
				'serverport' 	=> $serverport,
				'emailsecure' 	=> $emailsecure,
				'emailuser' 	=> $emailuser,
				'emailname' 	=> $emailname,
				'receemail' 	=> $to_em,
				'recename' 		=> $to_mn,
				'title' 		=> $title,
				'body' 			=> $body,
			), true);
			if(!$bo)$msg = '发送失败';
		}else{
			//异步发送邮件
			$uarr['title'] 		= $title;
			$uarr['body'] 		= $body;
			$uarr['receid'] 	= $to_id;
			$uarr['recename'] 	= $to_mn;
			$uarr['receemail'] 	= $to_em;
			$uarr['optdt'] 		= $this->rock->now();
			$uarr['optid'] 		= $this->adminid;
			$uarr['optname'] 	= $this->adminname;
			$uarr['status'] 	= 0;
			$sid 	= m('email_cont')->insert($uarr);
			m('reim')->asynurl('asynrun','sendemail', array(
				'id' 	=> $sid,
				'stype' => 0
			));
		}
		return $msg;
	}
	
	private function sendddddd($arr, $jbs)
	{
		extract($arr);
		$pass	= $emailpass;
		if($jbs)$pass	= $this->rock->jm->uncrypt($pass);
		$mail	= c('mailer');
		$mail->setHost($serversmtp, $serverport, $this->rock->repempt($emailsecure));
		$mail->setUser($emailuser, $pass);
		$mail->setFrom($emailuser, $emailname);
		$mail->addAddress($receemail, $recename);
		$mail->sendMail($title, $body);
		$bo		= $mail->isSuccess();
		return $bo;
	}
	
	/**
	*	测试发送邮件
	*/
	public function sendmail_test()
	{
		return $this->sendmail('测试邮件帐号','这只是一个测试邮件帐号，不要紧张！<br>来自：'.TITLE.'<br>发送人：'.$this->adminname.'<br>网址：'.URL.'<br>发送时间：'.$this->rock->now().'', $this->adminid, array(),1);
	}
	
	/**
	*	异步发送邮件
	*/
	public function sendemailcont($id)
	{
		$rs 	= m('email_cont')->getone($id);
		if(!$rs)return;
		$stype	= (int)$this->rock->get('stype');
		if($stype == 0){
			$msg 	= $this->sendmail($rs['title'],$rs['body'], $rs['receid'], array(), 1);
		}else{
			$msg 	= $this->sendemailout($rs['optid'],$rs['title'],$rs['body'], $rs['receemail'], $rs['recename'], 1);
		}
		$status = '2';
		if($msg=='ok')$status = '1';
		$uarr['status'] = $status;
		$uarr['senddt'] = $this->rock->now();
		m('email_cont')->update($uarr, $id);
	}
	
	
	/**
	*	用户自己外发发送
	*/
	public function sendemailout($sendid, $title, $body, $to_em, $to_mn, $zjsend=0)
	{
		$setrs			= m('option')->getpidarr(-1);
		if(!$setrs)return '未设置发送邮件';
		$serversmtp 	= $this->rock->arrvalue($setrs, 'email_sendhost');
		$serverport  	= $this->rock->arrvalue($setrs, 'email_sendport');
		$emailsecure  	= $this->rock->arrvalue($setrs, 'email_sendsecure');
		$myuser 		= m('admin')->getone($sendid,'name,email,emailpass');
		if(!$myuser)return '发送人不存在';

		$emailuser  	= $this->rock->arrvalue($myuser, 'email');
		$emailname  	= $this->rock->arrvalue($myuser, 'name');
		$emailpass  	= $this->rock->arrvalue($myuser, 'emailpass');
		
		if(isempt($serversmtp) || isempt($serverport) || isempt($emailuser)|| isempt($emailpass))return '用户未设置邮件帐号密码';
		
		$msg 	= 'ok';
		if(!getconfig('asynsend') || $zjsend==1){
			$bo 	= $this->sendddddd(array(
				'emailpass' 	=> $emailpass,
				'serversmtp' 	=> $serversmtp,
				'serverport' 	=> $serverport,
				'emailsecure' 	=> $emailsecure,
				'emailuser' 	=> $emailuser,
				'emailname' 	=> $emailname,
				'receemail' 	=> $to_em,
				'recename' 		=> $to_mn,
				'title' 		=> $title,
				'body' 			=> $body,
			), false);
			if(!$bo)$msg = '发送失败';
		}else{
			//异步发送邮件
			$uarr['title'] 		= $title;
			$uarr['body'] 		= $body;
			$uarr['receid'] 	= '';
			$uarr['recename'] 	= $to_mn;
			$uarr['receemail'] 	= $to_em;
			$uarr['optdt'] 		= $this->rock->now();
			$uarr['optid'] 		= $this->adminid;
			$uarr['optname'] 	= $this->adminname;
			$uarr['status'] 	= 0;
			$sid 	= m('email_cont')->insert($uarr);
			m('reim')->asynurl('asynrun','sendemail', array(
				'id' 	=> $sid,
				'stype' => 1
			));
		}
		return $msg;
	}
}