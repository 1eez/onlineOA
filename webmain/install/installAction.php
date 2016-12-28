<?php
set_time_limit(0);
class installClassAction extends ActionNot{
	
	public function initAction()
	{
		if(getconfig('systype')=='demo')exit('');
	}
	
	public function defaultAction()
	{
		$this->tpltype	= 'html';
		$this->title	= TITLE.'_安装';
	}
	
	private function rmdirs($dir){
        $dir_arr = scandir($dir);
        foreach($dir_arr as $key=>$val){
            if($val == '.' || $val == '..'){
			}else{               
                unlink($dir.'/'.$val);
            }
        }
		rmdir($dir);
    }   
	
	public function delinstallAjax()
	{
		$this->delinstall();
		echo 'success';
	}
	
	private function delinstall()
	{
		$dir = ROOT_PATH.'/'.PROJECT.'/install';
		$this->rmdirs($dir);
	}
	
	public function saveAjax()
	{
		$dbtype 	= $this->post('dbtype');
		$host 		= $this->post('host');
		$user 		= $this->post('user');
		$pass 		= $this->post('pass');
		$base 		= $this->post('base');
		$perfix 	= $this->post('perfix');
		$title 		= '信呼协同办公系统';
		$qom 		= 'xinhu_';
		$url 		= $this->post('url');
		$paths 		= ''.P.'/'.P.'Config.php';
		$inpaths	= ROOT_PATH.'/'.$paths.'';
		
		$msg  		= '';
		
		if($dbtype=='mysql' && !function_exists('mysql_connect'))exit('未开启mysql扩展模块');
		if($dbtype=='mysqli' && !class_exists('mysqli'))exit('未开启mysqli扩展模块');
		@unlink($inpaths);
		$this->rock->createtxt($paths, '<?php return array();');
		if(!file_exists($inpaths))exit('无法写入文件夹'.P.'');
		
		//1
		$db1 		= import($dbtype);
		$db1->changeattr($host, $user, $pass, 'information_schema');
		$db1->connectdb();
		$msg = $db1->errormsg;
		if(!$this->isempt($msg))exit('数据库用户名/密码有误:'.$msg.'');
		
		
		//2
		$db 		= import($dbtype);
		$db->changeattr($host, $user, $pass, $base);
		$db->connectdb();
		$msg = $db->errormsg;
		if(!$this->isempt($msg)){
			$db1->query("CREATE DATABASE `$base` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		}
		
		$db->connectdb();
		$msg = $db->errormsg;
		if(!$this->isempt($msg))exit('无法创建数据库:'.$msg.'');
		
		
		$dburl 	= ROOT_PATH.'/'.PROJECT.'/install/rockxinhu.sql';
		if(!file_exists($dburl))exit('数据库sql文件不存在');
		
		$sqlss 	= file_get_contents($dburl);
		$a 		= explode(";
", $sqlss);
		for($i=0; $i<count($a)-1; $i++){
			$sql 	= $a[$i];
			$sql	= str_replace('`xinhu_', '`'.$perfix.'', $sql);
			$bo		= $db->query($sql);
			if(!$bo){
				exit('导入失败:'.$db->error().'');
			}
		}
		$db->query("delete from `".$perfix."option` where `name` is null");
		$rand	= $this->rock->jm->getRandkey();
		$asynkey= md5($this->rock->jm->getRandkey());
		$openkey= md5($this->rock->jm->getRandkey());
		$txt 	= "<?php
if(!defined('HOST'))die('not access');
//系统配置文件		
return array(
	'url'		=> '$url',		//系统URL
	'localurl'	=> '',			//本地系统URL，用于服务器上浏览地址
	'title'		=> '$title',	//系统默认标题
	'apptitle'	=> '',			//APP上或PC客户端上的标题
	'weblogo'	=> '',			//PC客户端上的logo图片
	'db_host'	=> '$host',		//数据库地址
	'db_user'	=> '$user',		//数据库用户名
	'db_pass'	=> '$pass',		//数据库密码
	'db_base'	=> '$base',		//数据库名称
	'perfix'	=> '$perfix',	//数据库表名前缀
	'qom'		=> '$qom',		//session、cookie前缀
	'highpass'	=> '',			//超级管理员密码，可用于登录任何帐号
	'db_drive'	=> '$dbtype',	//操作数据库驱动有mysql,mysqli,pdo三种
	'randkey'	=> '$rand',		//系统随机字符串密钥
	'asynkey'	=> '$asynkey',	//这是异步任务key
	'openkey'	=> '$openkey',	//对外接口openkey
	'sqllog'	=> false,		//是否记录sql日志保存upload/sqllog下
	'asynsend'	=> false,		//是否异步发送提醒消息，为true需开启服务端
	'install'	=> true			//已安装，不要去掉啊
);";
		$this->rock->createtxt($paths, $txt);
		$this->delinstall();
		c('xinhu')->getdata('xinhuinstall');//这个只是用于统计安装数而已
		echo 'success';
	}
}