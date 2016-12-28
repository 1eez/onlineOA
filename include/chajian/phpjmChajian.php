<?php 
class phpjmChajian extends Chajian{
	
	public function encode($filename)
	{ 
		if(!$this->isopt($filename))return false;
		$contents 	= file_get_contents($filename); // 判断文件是否已经被编码处理 
		$contents 	= php_strip_whitespace($filename);  	
	
		$headerPos 	= strpos($contents,'<?php'); 
		$footerPos 	= strrpos($contents,'?>'); 
		$contents 	= substr($contents, $headerPos + 5); 
		$encode 	= base64_encode(gzdeflate($contents)); // 开始编码 
		$encode 	= '<?php'."\neval(gzinflate(base64_decode("."'".$encode."'".")));";  
		return @file_put_contents($filename, $encode); 
	}
	
	private function isopt($file)
	{
		$bo 	= false;
		if(!file_exists($file))return $bo;
		$type	=	strtolower(substr(strrchr($file,'.'),1)); 
		if('php' == $type && is_file($file) && is_writable($file))$bo = true;
		return $bo;
	}
	
	/**
	*	格式化
	*/
	public function strip($file)
	{
		if(!$this->isopt($file))return false;
		$contents = php_strip_whitespace($file); 
		return @file_put_contents($file, $contents);
	}
}