<?php
set_time_limit(1800);
class beifenClassAction extends Action
{
	
	public function chushuaAjax()
	{
		$myext		= $this->getsession('adminallmenuid');
		if(getconfig('systype')=='demo')exit('演示请勿操作');
		if($myext!='-1'){
			echo '只有管理员才可以用';
		}else{
			$tables		= explode(',', 'daily,file,flow_log,im_history,im_mess,im_messzt,infor,items,log,logintoken,meet,reads,sjoin,work,todo,flow_bill,goodss,goods,kqanay,kqdkjl,kqinfo,location,official,schedule,project,wx_agent,wx_chat,wx_dept,wx_user,userinfo,userract,hrpositive,word,hrredund,hrsalary,customer,custsale,custract,custfina,assetm,book,bookborrow,carm,carmrese,email_cont,emailm,emails');
			$alltabls 	= $this->db->getalltable();
			foreach($tables as $tabs){
				$_tabs 	= ''.PREFIX.''.$tabs.'';
				if(in_array($_tabs, $alltabls)){
					$sql1 = "delete from `$_tabs`";
					$sql2 = "alter table `$_tabs` AUTO_INCREMENT=1";
					$this->db->query($sql1, false);
					$this->db->query($sql2, false);
				}
			}
			echo 'ok';
		}
	}
	
	public function beifenAjax()
	{
		m('beifen')->start();
		echo 'ok';
	}
	
	public function getdataAjax()
	{
		if(getconfig('systype')=='demo')exit('演示请勿操作');
		$carr = c('file')->getfilerows('upload/data');
		$rows = array();
		foreach($carr as $k=>$fils){
			if($fils['filename']!='index.html'){
				$fils['filename'] = md5($fils['filename']);
				$fils['xu'] 	  = $k;
				$rows[] = $fils;
			}
			if($k>100)break;
		}
		if($rows)$rows = c('array')->order($rows, 'editdt');
		$arr['rows'] = $rows;
		$this->returnjson($arr);
	}
	public function getdatssssAjax()
	{
		if(getconfig('systype')=='demo')exit('演示请勿操作');
		$xu   = (int)$this->post('xu');
		$carr = c('file')->getfilerows('upload/data');
		$rows = array();
		if(isset($carr[$xu])){
			$file = $carr[$xu]['filename'];
			$data = m('beifen')->getbfdata($file);
			foreach($data as $tab=>$datas){
				$rows[] = array(
					'id' 		=> $tab,
					'fields' 	=> count($datas['fields']),
					'total' 	=> count($datas['data']),
				);
			}
		}
		$arr['rows'] = $rows;
		$this->returnjson($arr);
	}
	
	/**
	*	还原数据操作
	*/
	public function huifdataAjax()
	{
		if(getconfig('systype')=='demo')exit('演示请勿操作');
		$xu   = (int)$this->post('xu');
		$carr = c('file')->getfilerows('upload/data');
		$sida = explode(',', $this->post('sid'));
		$rows = array();
		if(isset($carr[$xu])){
			$file = $carr[$xu]['filename'];
			$data = m('beifen')->getbfdata($file);
			if($data){
				$alltabls 	= $this->db->getalltable();
				foreach($sida as $tab){
					if(!isset($data[$tab]))continue;
					if(!in_array($tab, $alltabls))continue; //表不存在
					$dataall 	= $data[$tab]['data'];
					if(count($dataall)<=0)continue;
					
					$allfields 	= $this->db->getallfields($tab);
					$fistdata	= $dataall[0];
					$xufarr		= array();
					foreach($fistdata as $f=>$v){
						if(in_array($f, $allfields)){
							$xufarr[] = $f;
						}
					}
					$uparr	= array();
					foreach($dataall as $k=>$rs){
						$str1 	= '';
						$upa	= array();
						foreach($xufarr as $f){
							$upa[$f] = $rs[$f];
						}
						$uparr[] = $upa;
					}
					
					$sql1 	= "delete from `$tab`";
					$sql2 	= "alter table `$tab` AUTO_INCREMENT=1";
					$bo 	= $this->db->query($sql1, false);
					$bo 	= $this->db->query($sql2, false);
					foreach($uparr as $k=>$upas){
						$bo = $this->db->record($tab, $upas);
					}
				}
			}
		}
		echo 'ok';
	}
}