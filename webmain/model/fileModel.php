<?php
class fileClassModel extends Model
{
	
	public function initModel()
	{
		$this->fileall = ',aac,ace,ai,ain,amr,app,arj,asf,asp,aspx,av,avi,bin,bmp,cab,cad,cat,cdr,chm,com,css,cur,dat,db,dll,dmv,doc,docx,dot,dps,dpt,dwg,dxf,emf,eps,et,ett,exe,fla,ftp,gif,hlp,htm,html,icl,ico,img,inf,ini,iso,jpeg,jpg,js,m3u,max,mdb,mde,mht,mid,midi,mov,mp3,mp4,mpeg,mpg,msi,nrg,ocx,ogg,ogm,pdf,php,png,pot,ppt,pptx,psd,pub,qt,ra,ram,rar,rm,rmvb,rtf,swf,tar,tif,tiff,txt,url,vbs,vsd,vss,vst,wav,wave,wm,wma,wmd,wmf,wmv,wps,wpt,wz,xls,xlsx,xlt,xml,zip,';
		
		$this->mimitype =  array(
			'unkown' => 'application/octet-stream',
			'acx' => 'application/internet-property-stream',
			'ai' => 'application/postscript',
			'aif' => 'audio/x-aiff',
			'aifc' => 'audio/x-aiff',
			'aiff' => 'audio/x-aiff',
			'asp' => 'text/plain',
			'aspx' => 'text/plain',
			'asf' => 'video/x-ms-asf',
			'asr' => 'video/x-ms-asf',
			'asx' => 'video/x-ms-asf',
			'au' => 'audio/basic',
			'avi' => 'video/x-msvideo',
			'axs' => 'application/olescript',
			'bas' => 'text/plain',
			'bcpio' => 'application/x-bcpio',
			'bin' => 'application/octet-stream',
			'bmp' => 'image/bmp',
			'c' => 'text/plain',
			'cat' => 'application/vnd.ms-pkiseccat',
			'cdf' => 'application/x-cdf',
			'cer' => 'application/x-x509-ca-cert',
			'class' => 'application/octet-stream',
			'clp' => 'application/x-msclip',
			'cmx' => 'image/x-cmx',
			'cod' => 'image/cis-cod',
			'cpio' => 'application/x-cpio',
			'crd' => 'application/x-mscardfile',
			'crl' => 'application/pkix-crl',
			'crt' => 'application/x-x509-ca-cert',
			'csh' => 'application/x-csh',
			'css' => 'text/css',
			'dcr' => 'application/x-director',
			'der' => 'application/x-x509-ca-cert',
			'dir' => 'application/x-director',
			'dll' => 'application/x-msdownload',
			'dms' => 'application/octet-stream',
			'doc' => 'application/msword',
			'docx' => 'application/msword',
			'dot' => 'application/msword',
			'dvi' => 'application/x-dvi',
			'dxr' => 'application/x-director',
			'eps' => 'application/postscript',
			'etx' => 'text/x-setext',
			'evy' => 'application/envoy',
			'exe' => 'application/octet-stream',
			'fif' => 'application/fractals',
			'flr' => 'x-world/x-vrml',
			'flv' => 'video/x-flv',
			'gif' => 'image/gif',
			'gtar' => 'application/x-gtar',
			'gz' => 'application/x-gzip',
			'h' => 'text/plain',
			'hdf' => 'application/x-hdf',
			'hlp' => 'application/winhlp',
			'hqx' => 'application/mac-binhex40',
			'hta' => 'application/hta',
			'htc' => 'text/x-component',
			'htm' => 'text/html',
			'html' => 'text/html',
			'shtml' => 'text/html',
			'htt' => 'text/webviewhtml',
			'ico' => 'image/x-icon',
			'ief' => 'image/ief',
			'iii' => 'application/x-iphone',
			'ins' => 'application/x-internet-signup',
			'isp' => 'application/x-internet-signup',
			'jfif' => 'image/pipeg',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'js' => 'application/x-javascript',
			'latex' => 'application/x-latex',
			'lha' => 'application/octet-stream',
			'lsf' => 'video/x-la-asf',
			'lsx' => 'video/x-la-asf',
			'lzh' => 'application/octet-stream',
			'm13' => 'application/x-msmediaview',
			'm14' => 'application/x-msmediaview',
			'm3u' => 'audio/x-mpegurl',
			'man' => 'application/x-troff-man',
			'mdb' => 'application/x-msaccess',
			'me' => 'application/x-troff-me',
			'mht' => 'message/rfc822',
			'mhtml' => 'message/rfc822',
			'mid' => 'audio/mid',
			'mny' => 'application/x-msmoney',
			'mov' => 'video/quicktime',
			'movie' => 'video/x-sgi-movie',
			'mp2' => 'video/mpeg',
			'mp3' => 'audio/mpeg',
			'mpa' => 'video/mpeg',
			'mpe' => 'video/mpeg',
			'mpeg' => 'video/mpeg',
			'mpg' => 'video/mpeg',
			'mpp' => 'application/vnd.ms-project',
			'mpv2' => 'video/mpeg',
			'ms' => 'application/x-troff-ms',
			'mvb' => 'application/x-msmediaview',
			'nws' => 'message/rfc822',
			'oda' => 'application/oda',
			'p10' => 'application/pkcs10',
			'p12' => 'application/x-pkcs12',
			'p7b' => 'application/x-pkcs7-certificates',
			'p7c' => 'application/x-pkcs7-mime',
			'p7m' => 'application/x-pkcs7-mime',
			'p7r' => 'application/x-pkcs7-certreqresp',
			'p7s' => 'application/x-pkcs7-signature',
			'pbm' => 'image/x-portable-bitmap',
			'pdf' => 'application/pdf',
			'pfx' => 'application/x-pkcs12',
			'pgm' => 'image/x-portable-graymap',
			'php' => 'text/plain',
			'pko' => 'application/ynd.ms-pkipko',
			'pma' => 'application/x-perfmon',
			'pmc' => 'application/x-perfmon',
			'pml' => 'application/x-perfmon',
			'pmr' => 'application/x-perfmon',
			'pmw' => 'application/x-perfmon',
			'png' => 'image/png',
			'pnm' => 'image/x-portable-anymap',
			'pot,' => 'application/vnd.ms-powerpoint',
			'ppm' => 'image/x-portable-pixmap',
			'pps' => 'application/vnd.ms-powerpoint',
			'ppt' => 'application/vnd.ms-powerpoint',
			'pptx' => 'application/vnd.ms-powerpoint',
			'prf' => 'application/pics-rules',
			'ps' => 'application/postscript',
			'pub' => 'application/x-mspublisher',
			'qt' => 'video/quicktime',
			'ra' => 'audio/x-pn-realaudio',
			'ram' => 'audio/x-pn-realaudio',
			'ras' => 'image/x-cmu-raster',
			'rgb' => 'image/x-rgb',
			'rmi' => 'audio/mid',
			'roff' => 'application/x-troff',
			'rtf' => 'application/rtf',
			'rtx' => 'text/richtext',
			'scd' => 'application/x-msschedule',
			'sct' => 'text/scriptlet',
			'setpay' => 'application/set-payment-initiation',
			'setreg' => 'application/set-registration-initiation',
			'sh' => 'application/x-sh',
			'shar' => 'application/x-shar',
			'sit' => 'application/x-stuffit',
			'snd' => 'audio/basic',
			'spc' => 'application/x-pkcs7-certificates',
			'spl' => 'application/futuresplash',
			'src' => 'application/x-wais-source',
			'sst' => 'application/vnd.ms-pkicertstore',
			'stl' => 'application/vnd.ms-pkistl',
			'stm' => 'text/html',
			'svg' => 'image/svg+xml',
			'sv4cpio' => 'application/x-sv4cpio',
			'sv4crc' => 'application/x-sv4crc',
			'swf' => 'application/x-shockwave-flash',
			't' => 'application/x-troff',
			'tar' => 'application/x-tar',
			'tcl' => 'application/x-tcl',
			'tex' => 'application/x-tex',
			'texi' => 'application/x-texinfo',
			'texinfo' => 'application/x-texinfo',
			'tgz' => 'application/x-compressed',
			'tif' => 'image/tiff',
			'tiff' => 'image/tiff',
			'tr' => 'application/x-troff',
			'trm' => 'application/x-msterminal',
			'tsv' => 'text/tab-separated-values',
			'txt' => 'text/plain',
			'uls' => 'text/iuls',
			'ustar' => 'application/x-ustar',
			'vcf' => 'text/x-vcard',
			'vrml' => 'x-world/x-vrml',
			'wav' => 'audio/x-wav',
			'wcm' => 'application/vnd.ms-works',
			'wdb' => 'application/vnd.ms-works',
			'wks' => 'application/vnd.ms-works',
			'wmf' => 'application/x-msmetafile',
			'wmv' => 'video/x-ms-wmv',
			'wps' => 'application/vnd.ms-works',
			'wri' => 'application/x-mswrite',
			'wrl' => 'x-world/x-vrml',
			'wrz' => 'x-world/x-vrml',
			'xaf' => 'x-world/x-vrml',
			'xbm' => 'image/x-xbitmap',
			'xla' => 'application/vnd.ms-excel',
			'xlc' => 'application/vnd.ms-excel',
			'xlm' => 'application/vnd.ms-excel',
			'xls' => 'application/vnd.ms-excel',
			'xlsx' => 'application/vnd.ms-excel',
			'xlt' => 'application/vnd.ms-excel',
			'xlw' => 'application/vnd.ms-excel',
			'xof' => 'x-world/x-vrml',
			'xpm' => 'image/x-xpixmap',
			'xwd' => 'image/x-xwindowdump',
			'z' => 'application/x-compress',
			'zip' => 'application/zip',
			'rar' => 'application/zip',
		);
	}
	
	public function getmime($lx)
	{
		if(!isset($this->mimitype[$lx]))$lx = 'unkown';
		return $this->mimitype[$lx];
	}
	
	public function getfile($mtype, $mid)
	{
		$rows	= $this->getall("`mtype`='$mtype' and `mid`='$mid' order by `id`",'id,filename,filesizecn,filesize,fileext,optname');
		return $rows;
	}
	
	public function addfile($fileid, $mtype, $mid)
	{
		if(!$this->isempt($fileid)){
			$this->update("`mtype`='$mtype',`mid`='$mid'", "`id` in($fileid) and `mid`=0");
		}
	}
	
	public function getstr($mtype, $mid, $lx=0)
	{
		$filearr 	= $this->getfile($mtype, $mid);
		$fstr		= '';
		foreach($filearr as $k=>$rs){
			if($k>0)$fstr.='<br>';
			$str = $this->rock->jm->strrocktoken(array('a'=>'down','id'=>$rs['id']));
			$url = ''.URL.'?rocktoken='.$str.'';
			$str = 'href="'.$url.'" target="_blank"';
			if($lx==1)$str='href="javascript:" onclick="return js.downshow('.$rs['id'].')"';
			$flx   = $rs['fileext'];
			if(!$this->contain($this->fileall,','.$flx.','))$flx='wz';
			$str1  = '';
			if(!isempt($rs['optname']))$str1=','.$rs['optname'].'';
			$fstr .='<img src="'.URL.'web/images/fileicons/'.$flx.'.gif" align="absmiddle" height=16 width=16> <a '.$str.' style="color:blue"><u>'.$rs['filename'].'</u></a> ('.$rs['filesizecn'].''.$str1.')';
		}
		return $fstr;
	}
	
	public function getfiles($mtype, $mid)
	{
		$rows		= $this->getall("`mtype`='$mtype' and `mid`='$mid' order by `id`");
		foreach($rows as $k=>$rs){
			$rows[$k]['status'] = 4;
		}
		return $rows;
	}
	
	public function copyfile($mtype, $mid)
	{
		$rows	= $this->getall("`mtype`='$mtype' and `mid`='$mid' order by `id`");
		$arr 	= array();
		foreach($rows as $k=>$rs){
			unset($rs['id']);
			$inuar = $rs;
			$inuar['adddt'] 	= $this->rock->now;
			$inuar['optid'] 	= $this->adminid;
			$inuar['optname'] 	= $this->adminname;
			$inuar['downci'] = '0';
			$inuar['mtype'] = '';
			$inuar['mid'] = '0';
			$this->insert($inuar);
			$inuar['id'] = $this->db->insert_id();
			$inuar['status'] = 4;
			$arr[] = $inuar;
		}
		return $arr;
	}
	
	public function delfiles($mtype, $mid)
	{
		$where = "`mtype`='$mtype' and `mid`='$mid'";
		$this->delfile('', $where);
	}
	
	public function delfile($sid='', $where='')
	{
		if($sid!='')$where = "`id` in ($sid)";
		if($where=='')return;
		$rows 	= $this->getall($where, 'filepath,thumbpath');
		foreach($rows as $k=>$rs){
			$path = $rs['filepath'];
			if(!$this->isempt($path) && file_exists($path))unlink($path);
			$path = $rs['thumbpath'];
			if(!$this->isempt($path) && file_exists($path))unlink($path);
		}
		$this->delete($where);
	}
	
	public function fileheader($filename,$ext='xls')
	{
		$mime = $this->getmime($ext);
		header('Content-type:'.$mime.'');
		header('Accept-Ranges: bytes');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
		header('Expires: 0');
		header('Content-disposition:attachment;filename='.iconv("utf-8","gb2312",str_replace(' ','',$filename)).'');
		header('Content-Transfer-Encoding: binary');
	}
	
	public function show($id)
	{
		if($id==0)exit('Sorry!');
		$rs	= $this->getone($id);
		if(!$rs)exit('504 Not find files');
		$this->update("`downci`=`downci`+1", $id);
		$filepath	= $rs['filepath'];
		$filename	= $rs['filename'];
		$filesize 	= $rs['filesize'];
		$fileext 	= $rs['fileext'];
		if($this->rock->contain($filepath,'http')){
			header('location:'.$filepath.'');
		}else{
			if(!file_exists($filepath))exit('404 Not find files');
			$this->fileheader($filename, $fileext);
			if(substr($filepath,-4)=='temp'){
				$content	= file_get_contents($filepath);
				echo base64_decode($content);
			}else{
				if($rs['filesize'] > 5*1024*1024){
					header('location:'.$filepath.'');
				}else{
					echo file_get_contents($filepath);
				}
			}
		}
	}
	
	public function download($id)
	{
		if($id==0)exit('Sorry!');
		$rs	= $this->getone($id);
		if(!$rs)exit('504 Not find files');
		$this->update("`downci`=`downci`+1", $id);
		$filepath	= $rs['filepath'];
		if(!file_exists($filepath))exit('404 Not find files');
		$filename	= $rs['filename'];
		$filesize 	= $rs['filesize'];
		if(substr($filepath,-4)=='temp'){
			Header("Content-type: application/octet-stream");
			header('Accept-Ranges: bytes');
			Header("Accept-Length: ".$filesize);
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: no-cache');
			header('Expires: 0');
			$content	= file_get_contents($filepath);
			echo base64_decode($content);
		}
	}
}