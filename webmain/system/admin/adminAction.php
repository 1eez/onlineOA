<?php
class adminClassAction extends Action
{
	public function loadadminAjax()
	{
		$id = (int)$this->get('id',0);
		$data = m('admin')->getone($id);
		if($data){
			$data['pass']='';
		}
		$arr['data'] = $data;
		
		$this->returnjson($arr);
	}

	public function beforeshow($table)
	{
		$fields = 'id,name,`user`,deptname,`type`,`num`,status,tel,workdate,ranking,superman,loginci,sex,sort,face';
		$s 		= '';
		$key 	= $this->post('key');
		if($key!=''){
			$s = m('admin')->getkeywhere($key);
		}
		return array(
			'fields'=> $fields,
			'where'	=> $s
		);
	}
	
	public function tongxlbeforeshow($table)
	{
		$fields = '`id`,`name`,`deptallname`,`ranking`,`tel`,`mobile`,`email`,`type`,`sort`,`face`';
		$s 		= 'and `status`=1';
		$key 	= $this->post('key');
		$zt 	= $this->post('zt');
		//我直属下属
		if($zt == '0'){
			$s.= ' and '.m('admin')->getdowns($this->adminid,1);
		}
		if($key!=''){
			$s .= m('admin')->getkeywhere($key);
		}
		return array(
			'fields'=> $fields,
			'where'	=> $s,
			'order'	=> 'sort'
		);
	}
	public function fieldsafters($table, $fid, $val, $id)
	{
		$fields = 'sex,ranking,tel,mobile,workdate,email,quitdt';
		if(contain($fields, $fid))m('userinfo')->update("`$fid`='$val'", $id);
	}
	

	
	public function publicbeforesave($table, $cans, $id)
	{
		$user = strtolower(str_replace(' ','',$cans['user']));
		$name = str_replace(' ','',$cans['name']);
		$num  = str_replace(' ','',$cans['num']);
		$email= str_replace(' ','',$cans['email']);
		$check= c('check');
		$mobile 	= $cans['mobile'];
		$weixinid 	= $cans['weixinid'];
		$pingyin 	= $cans['pingyin'];
		$msg  = '';	
		if(is_numeric($user))return '用户名不能是数字';
		if($check->isincn($user))return '用户名不能有中文';
		if(!isempt($email) && !$check->isemail($email))return '邮箱格式有误';
		if(!isempt($pingyin) && $check->isincn($pingyin))return '名字拼音不能有中文';
		if(!isempt($num) && $check->isincn($num))return '编号不能有中文';
		if(!isempt($mobile)){
			if(!$check->ismobile($mobile))return '手机格式有误';
		}
		if(isempt($mobile) && isempt($email))return '邮箱/手机号不能同时为空';
		if(!isempt($weixinid)){
			if(is_numeric($weixinid))return '微信号不能是数字';
			if($check->isincn($weixinid))return '微信号不能有中文';
		}
		$db  = m($table);
		
		if($msg=='' && $num!='')if($db->rows("`num`='$num' and `id`<>'$id'")>0)$msg ='编号['.$num.']已存在';
		if($msg=='')if($db->rows("`user`='$user' and `id`<>'$id'")>0)$msg ='用户名['.$user.']已存在';
		if($msg=='')if($db->rows("`name`='$name' and `id`<>'$id'")>0)$msg ='姓名['.$name.']已存在';
		$rows = array();
		if($msg == ''){
			$did  = $cans['deptid'];
			$sup  = $cans['superid'];
			$rows = $db->getpath($did, $sup);
		}
		if(isempt($pingyin))$pingyin = c('pingyin')->get($name,1);
		$rows['pingyin'] = $pingyin;
		$rows['user'] 	= $user;
		$rows['name'] 	= $name;
		$rows['email'] 	= $email;
		$arr = array('msg'=>$msg, 'rows'=>$rows);
		return $arr;
	}
	
	public function publicaftersave($table, $cans, $id)
	{
		m($table)->record(array('superman'=>$cans['name']), "`superid`='$id'");
		if(getconfig('systype')=='demo'){
			m('weixin:user')->optuserwx($id);
		}
		$this->updatess('and a.id='.$id.'');
	}
	
	public function updatedataAjax()
	{
		$a = $this->updatess();
		echo '总'.$a[0].'条记录,更新了'.$a[1].'条';
	}
	
	public function updatess($whe='')
	{
		return m('admin')->updateinfo($whe);
	}
	
	
	//批量导入
	public function saveadminplAjax()
	{
		$rows  	= c('html')->importdata('user,name,sex,ranking,deptname,mobile,email,tel','user,name');
		$oi 	= 0;
		$db 	= m('admin');
		$sort 	= (int)$db->getmou('max(`sort`)', '`id`>0');
		$dbs	= m('dept');
		$py 	= c('pingyin');
		foreach($rows as $k=>$rs){
			$user = $rs['user'];
			$name = $rs['name'];;
				
			if($db->rows("`user`='$user'")>0)continue;
			if($db->rows("`name`='$name'")>0)continue;
			$oi++;
			$arr['user'] = $user;
			$arr['name'] = $name;
			
			$arr['pingyin'] 	= $py->get($name,1);
			$arr['sex']  		= $rs['sex'];
			$arr['ranking']  	= $rs['ranking'];
			$arr['deptname']  	= $rs['deptname'];
			$arr['mobile']  	= $rs['mobile'];
			$arr['email']  		= $rs['email'];
			$arr['tel']  		= $rs['tel'];
			$arr['pass']  		= md5('123456');
			$arr['sort']  		= $sort+$oi;
			$arr['workdate']  	= $this->date;
			$arr['adddt']  		= $this->now;
			
			$deptid 	= (int)$dbs->getmou('id', "`name`='".$arr['deptname']."'");
			if($deptid==0)$arr['deptname'] = '';
			$arr['deptid'] = $deptid;
			$db->insert($arr);
		}
		if($oi>0)$this->updatess();
		backmsg('','成功导入'.$oi.'个用户');
	}
	
	//修改头像
	public function editfaceAjax()
	{
		$fid = (int)$this->post('fid');
		$uid = (int)$this->post('uid');
		echo m('admin')->changeface($uid, $fid);
	}
}