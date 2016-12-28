<?php
/**
	curl
*/
class curlChajian extends Chajian{
	
	private function strurl($url)
	{
		$url = str_replace('&#47;', '/', $url);
		return $url;
	}
	
	private function getdatastr($data)
	{
		$cont = '';
		if(is_array($data)){
			foreach($data as $k=>$v)$cont.='&'.$k.'='.$v.'';
			if($cont!='')$cont=substr($cont,1);
		}else{
			$cont 	= $data;
		}
		return $cont;
	}
	
	public function getfilecont($url)
	{
		$url 	 = $this->strurl($url);
		@$result = file_get_contents($url);
		return $result;
	}
	
	public function postfilecont($url, $data=array())
	{
		$url  	= $this->strurl($url);
		$cont 	= $this->getdatastr($data);
		$len 	= strlen($cont);
		$opts 	= array(  
			'http'	=>	array(  
				'method'	=>	'POST',  
				'header' 	=>
                "Content-type: application/x-www-form-urlencoded\r\n" .
                "Content-length: $len\r\n", 
				'content' => $cont,  
			)  
		 );  
		$cxContext 	= stream_context_create($opts);  
		@$sFile 		= file_get_contents($url, false, $cxContext);  
		return $sFile;
	}
	
	public function getcurl($url)
	{
		if(!function_exists('curl_init')){
			return $this->getfilecont($url);
		}
		$url= $this->strurl($url);
		$ishttps = 0;
		if(substr($url,0, 5)=='https')$ishttps=1;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		if($ishttps==1){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	
	public function postcurl($url, $data=array(), $lx=0)
	{
		if(!function_exists('curl_init')){
			return $this->postfilecont($url, $data);
		}
		$url	= $this->strurl($url);
		$cont 	= $data;
		if($lx==0)$cont = $this->getdatastr($data);
		$ishttps = 0;
		if(substr($url,0, 5)=='https')$ishttps=1;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $cont);
		if($ishttps==1){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
		$output = curl_exec($ch);
		$curl_errno = curl_errno($ch);
		curl_close($ch);
		return $output;
	}
}                                                                                                                                                            