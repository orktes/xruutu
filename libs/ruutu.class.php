<?php
/* Copyright Jaakko Lukkari 2011
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 */
class Ruutu {
	var $storeCookiesToSession=false;
	var $cookiesSessionVariable="ruutucookies";
	var $cookie_file="cookie.txt";
	var $serviceUrl="http://www.ruutu.fi/";
	
	function Ruutu($storeCookiesToSession=false) {		
		$this->storeCookiesToSession=$storeCookiesToSession;	
	}
	function setCookiesSessionVariable($cookiesSessionVariable) {
		$this->cookiesSessionVariable=$cookiesSessionVariable;
	}
	function getCookiesSessionVariable() {
		return $this->cookiesSessionVariable;
	}
	function setCookieFile($cookieFile) {
		$this->cookie_file=$cookieFile;
	}
	function getCookieFile($cookieFile) {
		return $this->cookie_file;
	}
	function getMedia($type, $series="__", $start=0, $end=8) {
		//http://www.ruutu.fi/ajax/media_get_nettitv_media/all/video/Yksi%2Blensi%2Byli%2BMarin%2Bpes%25C3%25A4n/latestdesc/0/8/true/__/__/__
		
		$series=str_replace(" ","%2B",$series);
		//$series=str_replace("ä","%25C3%25A4",$series);
		$loadUrl=$this->serviceUrl."ajax/media_get_nettitv_media/all/$type/$series/latestdesc/$start/$end/true/__/__/__";
		
		//echo $loadUrl;
		$data=$this->get($loadUrl);		
		return json_decode($data);
	}
	
	function getSeriesList() {
		$loadUrl=$this->serviceUrl."ajax/media_get_netti_tv_series_list/all";
		$data=$this->get($loadUrl);		
		return json_decode($data);
	}
	function search($term, $video=true, $video_episode=true, $audio=true) {
		
		$search=new stdClass();
		$search->search=$term;
		$search->groups=new stdClass();
		if($video) {
			$search->groups->video=new stdClass();
		$search->groups->video->types=array();	
		$search->groups->video->types[]="video_clip";
		}
	if($video_episode) {
		$search->groups->video_episode=new stdClass();
		$search->groups->video_episode->types=array();	
		$search->groups->video_episode->types[]="video_episode";
		}
	if($audio) {
		$search->groups->audio=new stdClass();
		$search->groups->audio->types=array();	
		$search->groups->audio->types[]="audio";
		}
		$loadUrl=$this->serviceUrl."search/search_new.php?params=".json_encode($search);
	//	echo $loadUrl;
		$data=$this->get($loadUrl);
		
		return json_decode($data);
	}
	
	function getVideoUrl($id, $type) {
	$vidid=trim($this->getVidId($this->serviceUrl."node/".$id));
	
	
		
		$data=$this->get("http://www.nelonen.fi/utils/video_config/?q=".$type."/".$vidid."&site=www.ruutu.fi&gRVBR=0" );

		return $this->get_string_between($data,"<SourceFile>","</SourceFile>");
	}
	
	private function open_page($url,$f=1,$c=2,$r=0,$a=0,$cf=0,$pd=""){
		global $oldheader;
		$url = str_replace("http://","",$url);
		if (preg_match("#/#","$url")){
			$page = $url;
			$url = @explode("/",$url);
			$url = $url[0];
			$page = str_replace($url,"",$page);
			if (!$page || $page == ""){
				$page = "/";
			}
			$ip = gethostbyname($url);
		}else{
			$ip = gethostbyname($url);
			$page = "/";
		}
		$open = fsockopen($ip, 80, $errno, $errstr, 60);
		if ($pd){
			$send = "POST $page HTTP/1.0\r\n";
		}else{
			$send = "GET $page HTTP/1.0\r\n";
		}
		$send .= "Host: $url\r\n";
		if ($r){
			$send .= "Referer: $r\r\n";
		}else{
			if (isset($_SERVER['HTTP_REFERER'])){
				$send .= "Referer: {$_SERVER['HTTP_REFERER']}\r\n";
			}
		}
		if ($cf){
			if (@file_exists($cf)||$this->storeCookiesToSession){
				if($this->storeCookiesToSession) {
					session_start();
					if(isset($_SESSION[$this->cookiesSessionVariable])){
						$cookie=urldecode($_SESSION[$this->cookiesSessionVariable]);
					}
				} else {
					$cookie = urldecode(@file_get_contents($cf));
				}

				if ($cookie){
					$send .= "Cookie: $cookie\r\n";

				}
			}
		}
		$send .= "Accept-Language: en-us, en;q=0.50\r\n";
		if ($a){
			$send .= "User-Agent: $a\r\n";
		}else if(isset($_SERVER['HTTP_USER_AGENT'])){
			$send .= "User-Agent: {$_SERVER['HTTP_USER_AGENT']}\r\n";
		} else {
			$send .= "User-Agent: Mozilla/5.0 (X11; U; Linux i686; fi-FI; rv:1.9.2.13) Gecko/20101206 Ubuntu/10.04 (lucid) Firefox/3.6.13\r\n";
		}
		if ($pd){
			$send .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$send .= "Content-Length: " .strlen($pd) ."\r\n\r\n";
			$send .= $pd;
		}else{
			$send .= "Connection: Close\r\n\r\n";
		}
		fputs($open, $send);
		$results="";
		while (!feof($open)) {
			$results .= fgets($open, 4096);
		}
		fclose($open);
		$results = @explode("\r\n\r\n",$results,2);
		$header = $results[0];
		if ($cf){
			if (preg_match("/Set\-Cookie\: /i","$header")){
				$cookie = @explode("Set-Cookie: ",$header,2);


				$cookie = $cookie[1];

				$cookie = explode("\r",$cookie);

				$cookie = $cookie[0];

				$cookie = str_replace("path=/","",$cookie);

				if(!$this->storeCookiesToSession) {
					$add = fopen($cf,'w');
					fwrite($add,$cookie,strlen($cookie));
					fclose($add);
				} else {
					session_start();
					$_SESSION[$this->cookiesSessionVariable]=$cookie;
				}


			}
		}
		if ($oldheader){
			$header = "$oldheader<br /><br />\n$header";
		}
		$header = str_replace("\n","<br />",$header);
		if ($results[1]){
			$body = $results[1];
		}else{
			$body = "";
		}
		if ($c === 2){
			if ($body){
				$results = $body;
			}else{
				$results = $header;
			}
		}
		if ($c === 1){
			$results = $header;
		}
		if ($c === 3){
			$results = "$header$body";
		}
		if ($f){
			if (preg_match("/Location\:/","$header")){
				$url = @explode("Location: ",$header);
				$url = $url[1];
				$url = @explode("\r",$url);
				$url = $url[0];
				$oldheader = str_replace("\r\n\r\n","",$header);
				$l = "&#76&#111&#99&#97&#116&#105&#111&#110&#58";
				$oldheader = str_replace("Location:",$l,$oldheader);
				return open_page($url,$f,$c,$r,$a,$cf,$pd);
			}else{
				return $results;
			}
		}else{
			return $results;
		}
	}

	private function get($url) {
		
		
		$f = 1;
		$c = 2;
		$r = NULL;
		$a = NULL;
		$cf = $this->cookie_file;
		$pd = NULL;

		$data = $this->open_page($url,$f,$c,$r,$a,$cf,$pd);

		//echo $url."\n";
		//	echo $data;
	
		return $data;
	}
	
	private function get_string_between($string, $start, $end){

		$string = " ". $string;

		$ini = strpos($string,$start);

		if ($ini == 0) return "";

		$ini += strlen($start);

		$len = strpos($string, $end, $ini) - $ini;

		return substr($string, $ini, $len);

	}
	private function getVidId($url) {
	
	
		$f = 0;
		$c = 2;
		$r = NULL;
		$a = NULL;
		$cf = $this->cookie_file;
		$pd = NULL;

		$data = $this->open_page($url,$f,$c,$r,$a,$cf,$pd);
		if (preg_match("/Location\:/","$data")){
				$url2 = @explode("Location: ",$data);
				$url2 = $url2[1];
				$url2 = @explode("\r",$url2);
				$url2 = $url2[0];
		}

		$pieces = @explode("&vid=",$url2);
	
return $pieces[1];

		
	}
	
	
	
}