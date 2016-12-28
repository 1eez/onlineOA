<?php 
class fileChajian extends Chajian
{
	
	public $path;		//文件路径
	public $name;		//文件名称
	public $ext;		//扩展名
	
	/**
		文件信息
	*/
	public function fileinfo($path)
	{
		if($this->filebool($path)){
			$arr=pathinfo($path);
			$this->name = $arr['basename'];
			$this->path = $arr['dirname'];
			$this->ext  = $arr['extension'];
		}
	}
	
	/**
		删除文件
	*/
	public function delfile($file)
	{
		$bool = false;
		if($this->filebool($file)){
			$bool = unlink($file);
		}
		return $bool;
	}
	
	/**
		重命名
	*/
	public function rename($oldf,$newf)
	{
		$bool = false;
		if($this->filebool($oldf)){
			$bool = rename($oldf,$newf);
		}
		return $bool;
	}
	
	/**
		判断文件是否存在
	*/
	public function filebool($path)
	{
		return file_exists($path);
	}
	
	/**
		创建文件
		@pamars	$path	文件路径
		@pamars $cont	内容
	*/
	public function caretefile($path,$cont)
	{
	}
	
	public function createdir($path, $oi=1)
	{
		$zpath	= explode('/', $path);
		$len    = count($zpath);
		$mkdir	= '';
		for($i=0; $i<$len-$oi; $i++){
			if(!$this->isempt($zpath[$i])){
				$mkdir.='/'.$zpath[$i].'';
				$wzdir = ROOT_PATH.''.$mkdir;
				if(!is_dir($wzdir)){
					mkdir($wzdir);
				}
			}
		}
	}
	
	/**
	*	获取某个目录下所有文件
	*/
	public function getfilerows($path)
	{
		$rows	= array();
		if(!is_dir($path))return $rows;
		@$d 	= opendir($path);
		$nyunf	= array('.', '..');
		while( false !== ($file = readdir($d))){
			if(!in_array($file, $nyunf)){
				$filess = $path.'/'.$file;
				if(is_file($filess)){
					$editdt = filectime($filess);//上次修改时间
					$lastdt = filemtime($filess);//最后修改的时间
					$rows[] = array(
						'filename' 	=> $file,
						'editdt' 	=> date('Y-m-d H:i:s', $editdt),
						'lastdt' 	=> date('Y-m-d H:i:s', $lastdt),
					);
				}
			}
		}
		return $rows;
	}
}                                                                                                                                                            