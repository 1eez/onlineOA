<?php
class adminClassModel extends Model
{
	private $_getjoinstr = array();
	
	public function gjoin($joinid, $glx='ud', $blx='bxl')
	{
		$uid 	= $did = '0';
		if($this->rock->isempt($joinid))return '';
		if($this->rock->contain($joinid, 'all'))return 'all';
		$narr 	= explode(',', $joinid);
		$dwhe	= array();
		foreach($narr as $sid){
			$lx 	= substr($sid, 0, 1);
			$ssid 	= str_replace(array('u','d','U','D'), array('','','',''), $sid);
			if($lx == 'd' || $glx=='d'){
				$did.=','.$ssid.'';
				$dwhe[] = "instr(`deptpath`, '[$ssid]')>0";
			}else{
				$uid.=','.$ssid.'';
			}
		}
		$where = '';
		if($did != '0'){
			$where = join(' or ', $dwhe);
			if($uid!='0')$where.=" or `id` in($uid)";
		}else{
			if($uid!='0')$where ="`id` in($uid)";
		}
		if($blx == 'where')return $where;
		$guid = '';
		if($where!=''){
			$rows = $this->getall("`status`=1 and ($where)", '`id`');
			foreach($rows as $k=>$rs)$guid.=','.$rs['id'].'';
			if($guid !='')$guid = substr($guid, 1);
		}
		return $guid;
	}
	
	/**
		判断某个id是不是在里面
	*/
	public function containjoin($joinid, $myid=0, $glx='ud')
	{
		$bo 	= false;
		$wh 	= $this->gjoin($joinid, $glx, 'where');
		if($wh == 'all')$bo = true;
		if(!$bo && $wh != ''){
			if($this->rows("`id`='$myid' and ($wh)")>0)$bo = true;
		}
		return $bo;
	}
	
	public function getjoinstr($fids, $us, $lx=0, $slx=0)
	{
		$s 		= '';
		if(is_numeric($us)){
			$key= 'a'.$fids.''.$us.'_'.$lx.'';
			if(isset($this->_getjoinstr[$key]))return $this->_getjoinstr[$key];
			$us	= $this->getone($us,'id,`name`,`deptid`,`deptpath`');
		}
		if(!$us)return '';
		$uid	= $us['id'];
		$key 	= 'a'.$fids.''.$uid.'_'.$lx.'';
		if(isset($this->_getjoinstr[$key]))return $this->_getjoinstr[$key];
		if($slx==0)$tj[]	= "ifnull($fids,'')=''";
		$tj[]	= $this->rock->dbinstr($fids, 'all');
		$tj[]	= $this->rock->dbinstr($fids, 'u'.$uid);
		if($us){
			$dep = explode(',', $us['deptpath']);
			foreach($dep as $deps){
				$_deps 	= str_replace(array('[',']'), array('',''), $deps);
				$tj[]	= $this->rock->dbinstr($fids, 'd'.$_deps);
			}
		}
		$s	= join(' or ', $tj);
		if($s != '' && $lx==0)$s = ' and ('.$s.')';
		$this->_getjoinstr[$key] = $s;
		return $s;
	}
	
	/**
	*	获取对应部门负责人
	*/
	public function getdeptheadman($id, $lx=0)
	{
		$drs 	= $this->db->getone('[Q]dept','id='.$id.'');
		if(!$drs)return false;
		$cuid 	= $drs['headid'];
		$name 	= $drs['headman'];
		if(isempt($cuid)){
			if($lx==0){
				$lbar = $this->getdeptheadman($drs['pid'], 1);
				if($lbar){
					$cuid 	= $lbar[0];
					$name 	= $lbar[1];
				}
			}
		}
		if(isempt($cuid))return false;
		return array($cuid, $name);
	}
	
	/**
	*	获取某个人的上级主管或者领导
	*	返回 array(id,$name)
	*/
	public function getsuperman($uid)
	{
		$b 		= array();
		$urs 	= $this->getone($uid,'`superid`,`superman`,`deptid`');
		if(!$urs)return $b;
		$cuid 	= $urs['superid'];
		$name 	= $urs['superman'];
		if(isempt($cuid)){
			$deptid  = (int)$urs['deptid'];
			if($deptid > 0){
				$drs = $this->getdeptheadman($deptid);
				if($drs){
					$cuid = $drs[0];
					$name = $drs[1];
				}
			}
		}
		if(!isempt($cuid)){
			$b = array($cuid, $name);
		}
		return $b;
	}
	
	public function getjoinstrs($fids, $us, $slx=0, $lx=0)
	{
		return $this->getjoinstr($fids, $us, $lx, $slx);
	}
	
	/**
		获取人员上级主管id
	*/
	public function getup($uid)
	{
		$one 	= $this->getone($uid, 'superid,deptid');
		$rows 	= $this->getpath($one['deptid'], $one['superid']);
		$s		= $rows['superpath'];
		$s		= str_replace('[', '', $s);
		$s		= str_replace(']', '', $s);
		return $s;
	}
	
	public function getpath($did, $sup)
	{
		$deptpath 	= $this->db->getpval('[Q]dept', 'pid', 'id', $did, '],[');
		$deptallname= $this->db->getpval('[Q]dept', 'pid', 'name', $did, '/');
		$deptname	= $this->db->getmou('[Q]dept', 'name', "`id`='$did'");
		$supername	= '';
		
		$superpath	= '';
		if(!$this->rock->isempt($sup)){
			$sua = explode(',', $sup);
			foreach($sua as $suas){
				$sss1 	= $this->db->getpval('[Q]admin', 'superid', 'id' ,$suas, '],[');
				if($sss1 != '')$superpath.=',['.$sss1.']';
				$sss2	= $this->db->getmou('[Q]admin', 'name', "`id`='$suas'");
				if(!$this->rock->isempt($sss2))$supername.=','.$sss2;
			}
			if($superpath!='')$superpath=substr($superpath,1);
			if($supername!='')$supername=substr($supername,1);
		}
		$rows['deptpath'] 	= $this->rock->strformat('[?0]', $deptpath);
		$rows['superpath'] 	= $superpath;
		$rows['deptname'] 	= $deptname;
		$rows['superman'] 	= $supername;
		$rows['deptallname']= $deptallname;
		
		return $rows;
	}
	
	/**
	*	获取下级人员id
	*	$lx 0 全部下级，1直属下级
	*	return 所有人员ID
	*/
	public function getdown($uid, $lx=0)
	{
		$where = $this->getdowns($uid, $lx);
		$rows = $this->getall($where, 'id');
		$s	  = '';
		foreach($rows as $k=>$rs)$s.=','.$rs['id'];
		if($s != '')$s = substr($s, 1);
		return $s;
	}
	
	/**
	*	获取下级人员id
	*	$lx 0 全部下级，1直属下级
	*	return 字符串条件
	*/
	public function getdowns($uid, $lx=0)
	{
		$where = "instr(superpath,'[$uid]')>0";
		if($lx==1)$where=$this->rock->dbinstr('superid', $uid);
		return $where;
	}
	
	/**
	*	获取下属人员Id条件记录,如我下属任务
	*	返回如( distid in(1) or uid in(2) )
	*/
	public function getdownwhere($fid, $uid, $lx=0)
	{
		$bstr = $this->getdown($uid, $lx);
		$where= '1=2';
		if($bstr=='')return $where;
		$bas  = explode(',', $bstr);
		$barr = array();
		foreach($bas as $bid){
			$barr[] = ''.$fid.' in('.$bid.')';
		}
		$where = join(' or ', $barr);
		$where = '('.$where.')';
		return $where;
	}
	
	//返回我下属字符串条件如： instr(',1,2,3,', 字段)>0;
	public function getdownwheres($fid, $uid, $lx=0)
	{
		$bstr = $this->getdown($uid, $lx);
		$where= '1=2';
		if($bstr=='')return $where;
		$bstr = ','.$bstr.',';
		$where= "instr('$bstr', concat(',',$fid,','))>0";
		return $where;
	}
	
	
	
	
	/**
	*	获取用户信息(部门，单位，职位等)
	*/
	public function getinfor($uid)
	{
		$unitname 	= $deptname = $ranking = '';
		$name	= '';
		$face	= '';
		$deptid	= '';
		$rs		= $this->getone($uid, 'name,deptname,deptid,ranking,face');
		if($rs){
			$deptname 	= $rs['deptname'];
			$ranking 	= $rs['ranking'];
			$name 		= $rs['name'];
			$deptid 	= $rs['deptid'];
			$face 		= $this->getface($rs['face']);
			if(!$this->isempt($deptid))$unitname = $this->db->getpval('[Q]dept','pid','name', $deptid);
		}
		return array(
			'unitname' => $unitname,
			'deptname' => $deptname,
			'name' 		=> $name,
			'ranking' 	=> $ranking,
			'face' 		=> $face,
			'deptid' 	=> $deptid
		);
	}
	
	/*
		获取在线的人员Id
	*/
	public function getonline($receid, $lx=10)
	{
		$uarr 		= $this->getonlines('reim', $receid, $lx);
		$jonus		= join(',', $uarr);
		return $jonus;
	}
	
	//获取对应类型在线人员
	public function getonlines($type, $teuid='all', $lx=11, $where='')
	{
		$arrs 	= array();
		$dts 	= c('date')->adddate($this->rock->now, 'i', 0-$lx);
		$wheres		= '';
		if($teuid != 'all' && $teuid!=''){
			if($this->contain($teuid,'u') || $this->contain($teuid,'d')){
				$teuid = $this->gjoin($teuid);
				if($teuid=='')return $arrs;
			}
			$wheres=" and `uid` in($teuid)";
		}
		if($lx>0){
			$wheres .= " and `moddt`>'$dts'";
		}
		$sql 	= "select `uid` from `[Q]logintoken` where `cfrom`='$type' and `online`=1 $wheres $where group by `uid`";
		
		$rows   = $this->db->getall($sql);
		foreach($rows as $k=>$rs){
			$arrs[] = $rs['uid'];
		}
		return $arrs;
	}
	
	public function getface($face, $mr='')
	{
		if($mr=='')$mr 	= 'images/noface.png';
		if(substr($face,0,4)!='http' && !$this->isempt($face))$face = URL.''.$face.'';
		$face 			= $this->rock->repempt($face, $mr);
		return $face;
	}
	
	public function getuser($lx=0)
	{
		$rows = $this->getall("`status`=1",'id,name,deptid,deptname,deptallname,ranking,tel,face,sex,email,pingyin','sort,name');
		$py   = c('pingyin');
		foreach($rows as $k=>$rs){
			$rows[$k]['face'] = $this->getface($rs['face']);
			if($lx==1){
				if(isempt($rs['pingyin']))$rows[$k]['pingyin'] = $py->get($rs['name'],1);
			}
		}
		return $rows;
	}
	
	public function getadmininfor($rows, $suids, $fid='checkid')
	{
		$farr	= $this->db->getarr('[Q]admin', "`id` in($suids)",'`face`,`name`');
		foreach($rows as $k=>$rs){
			$face =  $name = '';
			if(isset($farr[$rs[$fid]])){
				$face = $farr[$rs[$fid]]['face'];
				$name = $farr[$rs[$fid]]['name'];
				$rows[$k]['name'] = $name;
			}	
			$rows[$k]['face'] = $this->getface($face);
		}
		return $rows;
	}
	
	public function getusinfo($uid, $fields='id')
	{
		$urs = $this->db->getone('[Q]userinfo', $uid, $fields);
		if(!$urs){
			$urs = array();
			$far = explode(',', str_replace('`','',$fields));
			foreach($far as $f)$urs[$f]='';
			$urs['id'] = $uid;
		}
		return $urs;
	}
	
	
	
	
	
	
	
	
	
	/**
	*	更新信息
	*/
	public function updateinfo($where='')
	{
		$rows	= $this->db->getall("select id,name,deptid,superid,deptpath,superpath,deptname,deptallname,superman from `[Q]admin` a where id>0 $where order by `sort`");
		$total	= $this->db->count;
		$cl		= 0;
		foreach($rows as $k=>$rs){
			$nrs	= $this->getpath($rs['deptid'], $rs['superid']);
			if($nrs['deptpath'] != $rs['deptpath'] || $nrs['deptname'] != $rs['deptname'] || $nrs['superpath'] != $rs['superpath'] || $nrs['superman'] != $rs['superman'] || $nrs['deptallname'] != $rs['deptallname']){
				$this->record($nrs, "`id`='".$rs['id']."'");
				$cl++;
			}
		}
		$this->updateuserinfo($where);
		return array($total, $cl);
	}
	public function updateuserinfo($whe='')
	{
		$db 	= m('userinfo');
		$rows	= $this->db->getall('select a.name,a.deptname,a.id,a.status,a.ranking,b.id as ids,b.name as names,b.deptname as deptnames,b.ranking as rankings,b.num as nums,a.sex,a.tel,a.mobile,a.email,a.workdate,a.quitdt,a.num from `[Q]admin` a left join `[Q]userinfo` b on a.id=b.id where a.id>0 '.$whe.' ');
		foreach($rows as $k=>$rs){
			$uparr = array(
				'id' 		=> $rs['id'],
				'name' 		=> $rs['name'],
				'deptname' 	=> $rs['deptname'],
				'ranking' 	=> $rs['ranking'],
				'sex' 		=> $rs['sex'],
				'tel' 		=> $rs['tel'],
				'mobile' 	=> $rs['mobile'],
				'email' 	=> $rs['email'],
				'workdate' 	=> $rs['workdate'],
				'quitdt' 	=> $rs['quitdt'],
				'num' 		=> $rs['num'],
			);
			if(isempt($rs['ids'])){
				$db->insert($uparr);
			}else{
				unset($uparr['id']);
				$db->update($uparr, $rs['ids']);
			}
		}
	}
	
	//返回这个月份人员
	public function monthuwhere($month)
	{
		$month	= substr($month, 0, 7);
		$start	= ''.$month.'-01';
		$enddt	= c('date')->getenddt($month);
		$s 		= $this->monthuwheres($start, $enddt);
		return $s;
	}
	public function monthuwheres($start, $enddt)
	{
		$s 		= " and (`quitdt` is null or `quitdt`>='$start') and (`workdate` is null or `workdate`<='$enddt')";
		return $s;
	}
	
	public function changeface($uid, $fid)
	{
		$frs 	= m('file')->getone($fid);
		if(!$frs)return false;
		$path 	= $frs['thumbpath'];
		if(isempt($path))$path = $frs['filepath'];
		$face	= $path;
		if(file_exists($path)){
			$face = 'upload/face/'.$uid.'.jpg';
			c('image')->conver($path, $face);
			$this->update("face='$face'", $uid);
		}
		m('file')->delfile($fid);
		return $face;
	}
	
	//根据邮箱获取人员姓名
	private $emailtoursarr = array();
	public function emailtours($email)
	{
		$key  = 'rock'.$email.'';
		if(!isset($this->emailtoursarr[$key])){
			$urs 	= $this->getone("`email`='$email'",'`id`,`name`');
			$this->emailtoursarr[$key] = $urs;
		}else{
			$urs	= $this->emailtoursarr[$key];
		}
		return $urs;
	}
	
	/**
	*	关键词搜索的
	*/
	public function getkeywhere($key, $qz='', $ots='')
	{
		$where = " and ($qz`name` like '%$key%' or $qz`user` like '%$key%' or $qz`deptallname` like '%$key%' or $qz`ranking` like '%$key%' or $qz`pingyin` like '$key%' $ots)";
		return $where;
	}
}