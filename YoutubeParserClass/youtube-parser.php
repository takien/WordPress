<?php
/*
* YoutubeParser() PHP class
* @author: takien
* @version: 1.0
* @date: June 16, 2012
* URL: http://takien.com/864/php-how-to-parse-youtube-url-to-get-video-id-thumbnail-image-or-embed-code.php
*
* @param string $source content source to be parsed, eg: a string or page contains youtube links or videos.
* @param boolean $unique whether the return should be unique (duplicate result will be removed)
* @param boolean $suggested whether show suggested video after finished playing
* @param boolean $https whether use https or http, default false ( http )
* @param string $width width of embeded video, default 420
* @param string $height height of embeded video, default 315
* @param boolean $privacy whether to use 'privacy enhanced mode or not', 
* if true then the returned Youtube domain would be youtube-nocookie.com
*/
class YoutubeParser{
	var $source    = '';
	var $unique    = false;
	var $suggested = false;
	var $https     = false;
	var $privacy   = false;
	var $width     = 420;
	var $height    = 315;
	
	function __construct(){
	}
	
	function set($key,$val){
		return $this->$key = $val;
	}
	function getall(){
		$return = Array();
		$domain = 'http'.($this->https?'s':'').'://www.youtube'.($this->privacy?'-nocookie':'').'.com';
		$size   = 'width="'.$this->width.'" height="'.$this->height.'"';
		
		preg_match_all('/(youtu.be\/|\/watch\?v=|\/embed\/)([a-z0-9\-_]+)/i',$this->source,$matches);
		if(isset($matches[2])){
			if($this->unique){
				$matches[2] = array_values(array_unique($matches[2]));
			}
			foreach($matches[2] as $key=>$id) {
				$return[$key]['id']       = $id;
				$return[$key]['embed']    = '<iframe '.$size.' src="'.$domain.'/embed/'.$id.($this->suggested?'':'?rel=0').'" frameborder="0" allowfullscreen></iframe>';
				$return[$key]['embedold'] = '<object '.$size.'>
				<param name="movie" value="'.$domain.'/v/'.$id.'?version=3'.($this->suggested?'':'&amp;rel=0').'"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="allowscriptaccess" value="always"></param>
				<embed src="'.$domain.'/v/'.$id.'?version=3'.($this->suggested?'':'&amp;rel=0').'" type="application/x-shockwave-flash" '.$size.' allowscriptaccess="always" allowfullscreen="true"></embed>
				</object>';
				$return[$key]['thumb']    = 'http://i4.ytimg.com/vi/'.$id.'/default.jpg';
				$return[$key]['hqthumb']  = 'http://i4.ytimg.com/vi/'.$id.'/hqdefault.jpg';
			}
		}
		return $return;
	}
}