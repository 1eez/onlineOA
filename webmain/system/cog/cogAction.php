<?php
class cogClassAction extends Action
{
	public function sysinfoAjax()
	{
		$fields = array(
			'title'	=> '系统名称',
			'url'	=> '系统URL地址',
			'localurl'	=> '系统本地地址',
			'taskurl'	=> '任务地址',
			'db_drive'	=> '操作数据库驱动',
			'version'	=> '版本',
			'phpos'		=> '服务器',
			'phpver'	=> 'PHP版本',
			'mysqlver'	=> 'mysql版本',
			'SERVER_SOFTWARE'	=> 'web服务器',
			'upload_max_filesize'	=> '最大上传大小',
			'post_max_size'	=> 'POST最大',
			'memory_limit'	=> '使用最大内存',
			'curl'			=> '是否支持CURL',
			'max_execution_time'			=> 'PHP执行超时时间',
			
		);
		
		$data = array(
			'title'	=> getconfig('title'),
			'url'	=> getconfig('url'),
			'localurl'	=> getconfig('localurl'),
			'taskurl'	=> getconfig('taskurl'),
			'db_drive'	=> getconfig('db_drive'),
			'version'	=> '信呼V'.VERSION.'',
			'phpos'	=> PHP_OS,
			'phpver'	=> PHP_VERSION,
			'mysqlver'	=> $this->db->getsyscount('version'),
			'SERVER_SOFTWARE'	=> $_SERVER['SERVER_SOFTWARE'],
			'upload_max_filesize'	=> ini_get('upload_max_filesize'),
			'post_max_size'			=> ini_get('post_max_size'),
			'memory_limit'			=> ini_get('memory_limit'),
			'max_execution_time'			=> ini_get('max_execution_time').'秒',
			
		);
		if(!function_exists('curl_init')){
			$data['curl'] = '<font color=red>不支持</font>';
		}else{
			$data['curl'] = '<font color=green>支持</font>';
		}
		
		$this->returnjson(array(
			'fields' => $fields,
			'data' 	=> $data,
		));
	}
	
	public function getinfoAjax()
	{
		$arr['title'] 		= getconfig('title');
		$arr['url'] 		= getconfig('url');
		$arr['localurl'] 	= getconfig('localurl');
		$arr['apptitle'] 	= getconfig('apptitle');
		$arr['asynkey'] 	= getconfig('asynkey');
		$arr['openkey'] 	= getconfig('openkey');
		$arr['db_drive'] 	= getconfig('db_drive');
		$arr['asynsend'] 	= getconfig('asynsend') ? '1' : '0';
		$arr['sqllog'] 		= getconfig('sqllog') ? '1' : '0';
		$this->returnjson($arr);
	}
	
	public function savecongAjax()
	{
		if(getconfig('systype')=='demo')exit('演示上禁止设置');
		if($this->getsession('isadmin')!='1')exit('非管理员不能操作');
		
		$puurl 			= $this->option->getval('reimpushurlsystem',1);
		
		$_confpath		= $this->rock->strformat('?0/?1/?1Config.php', ROOT_PATH, PROJECT);
		$arr 			= require($_confpath);
		
		$title 			= $this->post('title');
		if(!isempt($title))$arr['title'] = $title;
		
		$url 			= $this->post('url');
		if(!isempt($url))$arr['url'] = $url;
		
		$apptitle 			= $this->post('apptitle');
		if(!isempt($apptitle))$arr['apptitle'] = $apptitle;
		
		$asynkey 			= $this->post('asynkey');
		if(!isempt($asynkey))$arr['asynkey'] = $asynkey;
		
		$db_drive 			= $this->post('db_drive');
		if(!isempt($db_drive)){
			if($db_drive=='mysql' && !function_exists('mysql_connect'))exit('未开启mysql扩展模块');
			if($db_drive=='mysqli' && !class_exists('mysqli'))exit('未开启mysqli扩展模块');
			if($db_drive=='pdo' && !class_exists('PDO'))exit('未开启pdo扩展模块');
			$arr['db_drive'] = $db_drive;
		}
		
		$arr['localurl'] = $this->post('localurl');
		$arr['openkey']  = $this->post('openkey');
		
		$asynsend 		 = $this->post('asynsend');
		$arr['asynsend'] = $asynsend=='1';
		
		$arr['sqllog'] 	 = $this->post('sqllog')=='1';
		
		if($asynsend == '1' && isempt($puurl))exit('未安装或开启服务端不能使用异步发送消息');
		
		$smarr['url']			= '系统URL';
		$smarr['localurl']		= '本地系统URL，用于服务器上浏览地址';
		$smarr['title']			= '系统默认标题';
		$smarr['apptitle']		= 'APP上或PC客户端上的标题';
		$smarr['weblogo']		= 'PC客户端上的logo图片';
		$smarr['db_host']		= '数据库地址';
		$smarr['db_user']		= '数据库用户名';
		$smarr['db_pass']		= '数据库密码';
		$smarr['db_base']		= '数据库名称';
		$smarr['perfix']		= '数据库表名前缀';
		$smarr['qom']			= 'session、cookie前缀';
		$smarr['highpass']		= '超级管理员密码，可用于登录任何帐号';
		$smarr['db_drive']		= '操作数据库驱动有mysql,mysqli,pdo三种';
		$smarr['randkey']		= '系统随机字符串密钥';
		$smarr['asynkey']		= '这是异步任务key';
		$smarr['openkey']		= '对外接口openkey';
		$smarr['sqllog']		= '是否记录sql日志保存upload/sqllog下';
		$smarr['asynsend']		= '是否异步发送提醒消息，为true需开启服务端';
		$smarr['install']		= '已安装，不要去掉啊';
		
		$str1 = '';
		foreach($arr as $k=>$v){
			$bz = '';
			if(isset($smarr[$k]))$bz='	//'.$smarr[$k].'';
			if(is_bool($v)){
				$v = $v ? 'true' : 'false';
			}else{
				$v = "'$v'";
			}
			$str1.= "	'$k'	=> $v,$bz\n";
		}
		
		$str = '<?php
if(!defined(\'HOST\'))die(\'not access\');
//['.$this->adminname.']在'.$this->now.'通过[系统→系统工具→系统设置]，保存修改了配置文件
return array(
'.$str1.'
);';
		@$bo = file_put_contents($_confpath, $str);
		if($bo){
			echo 'ok';
		}else{
			echo '保存失败无法写入：'.$_confpath.'';
		}
	}
	
	public function logbefore($table)
	{
		$key = $this->post('key');
		$s   = '';
		if($key != ''){
			$s = "and (`type`='$key' or `optname` like '$key%' or `remark` like '$key%' or `web`='$key' or `ip`='$key')";
		}
		return $s;
	}
	
	public function dellogAjax()
	{
		$id = $this->post('id');
		m('log')->delete('id in('.$id.')');
		backmsg();
	}
}