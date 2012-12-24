<?php
/**
* Easy get WordPress attachments image
* @author : contact@takien.com
* @version: 0.3
* @update : Dec 25, 2012
*/

if(!class_exists('EasyAttachments')){
	class EasyAttachments {
	    var $post_type      = 'attachment';
		var $post_parent    = '';
		var $post_mime_type = 'image';
		var $post_status    = null;
		var $numberposts    = -1;
		var $order          = 'ASC';
		var $orderby        = 'post_date';
		
		function __construct(){
			
		}
		
		function add_theme_support($feature=''){
			return $feature;
		}
		function set($what,$value){
			$this->$what = $value;
		}
		
		private function get_attachment($args=''){
			$defaults = array(
				'order'          => $this->order,
				'orderby'        => $this->orderby,
				'post_type'      => $this->post_type,
				'post_parent'    => $this->post_parent,
				'post_mime_type' => $this->post_mime_type,
				'post_status'    => $this->post_status,
				'numberposts'    => $this->numberposts,
				'exclude'        => get_post_thumbnail_id()
			);
			$args        = wp_parse_args( $args, $defaults );
			$attachments = get_posts($args);

			if ($attachments){
				$return = Array();
				foreach($attachments as $key=>$val){
					$return[$key] = $val;
					$return[$key]->thumbnail = wp_get_attachment_image_src($return[$key]->ID,'thumbnail');
					$return[$key]->medium    = wp_get_attachment_image_src($return[$key]->ID,'medium');
					$return[$key]->large     = wp_get_attachment_image_src($return[$key]->ID,'large');
					$return[$key]->full      = wp_get_attachment_image_src($return[$key]->ID,'full');
				}
				return $return;
			}
		}
		
		//extract caption
		private function extract_caption($content){
			$return = $matches = Array();
			$regex = '\\[(\\[?)(caption)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
			preg_match_all("/$regex/i",$content,$matches);
			
			foreach($matches[0] as $k => $match){
				$caption = $match;
				$caption = str_replace('"]','" ]',$caption);
				$return[$k] = shortcode_parse_atts($caption);
			}
			return $return;
		}
		
		//get caption
		private function get_caption($id='',$size='thumbnail'){
			$return     = $images = Array();
			$id         = $id ? $id : get_the_ID();
			$captions   = false;
			$content    = get_the_content($id);
			$captions   = $this->extract_caption($content);
			
			foreach($captions as $k=>$caption){
				$image                     = $caption['src'];
				$images[$k]['thumbnail']   = preg_replace('/\-\d{3}x\d{3}\./i','-'.get_option('thumbnail_size_w').'x'.get_option('thumbnail_size_h').'.',$image);
				$images[$k]['medium']      = preg_replace('/\-\d{3}x\d{3}\./i','-'.get_option('medium_size_w').'x'.get_option('medium_size_h').'.',$image);
				$images[$k]['large']       = preg_replace('/\-\d{3}x\d{3}\./i','-'.get_option('large_size_w').'x'.get_option('large_size_h').'.',$image);
				$images[$k]['full']        = preg_replace('/\-\d{3}x\d{3}\./i','.',$image);
				
				$images[$k]['parent']      = $id;
				$desc 	                   = isset($caption['caption']) ? explode('//',$caption['caption']) : Array('');
				$images[$k]['author']	   = end($desc);
				$images[$k]['description'] = $desc[0];
			}
			
			if($size == 'all'){
				$return = $images;
			}
			else {
				$return['src'] 	= $images[0][$size];
				$return['desc'] = $images[0]['description'];
			}
			return $return;
		}
		//get img src 
		private function get_img_src($content){
			preg_match('/<img\s*(.*?)\s*src=["\']?([^"\']+)/i', $content, $matches);
			if(isset($matches[2])) {
				return $matches[2];
			}
		}
		//output
		function output($size='thumbnail',$postid='',$featured=false) {
			$postid = $postid ? $postid : get_the_ID();
			$return = false;
			$content = get_the_content($postid);
			/*feat*/
			if($featured AND has_post_thumbnail()){
				$att = wp_get_attachment_image_src(get_post_thumbnail_id($postid),$size);
				$return['src'] = $att[0];
			}
			/*caption*/
			else if(preg_match('/\[caption/i',$content)){
				$return = $this->get_caption($postid,$size);
			}
			/*img src*/
			else if(preg_match('/<img /i',$content)){
				
				$return['src'] = $this->get_img_src($content);
				
			}
			else {
				$attachs = $this->get_attachment(Array('post_parent'=> $postid));
				if(!$attachs) return false;
				foreach ($attachs as $k => $attach){
					$images[$k]['thumbnail'] = $attach->thumbnail[0];
					$images[$k]['medium']    = $attach->medium[0];
					$images[$k]['large']     = $attach->large[0];
					$images[$k]['full']      = $attach->full[0];
					$images[$k]['parent']    = $attach->post_parent;
					
					$desc 	= explode('//',$attach->post_content);
					$images[$k]['author']	= end($desc);
					$images[$k]['description'] = $desc[0];
				}
				
				if($size == 'all'){
					$return = $images;
				}
				else {
					$return['src'] 	= $images[0][$size];
					$return['desc'] = $images[0]['description'];
				}
				
			
			}
			return $return;
		}
	}
}

function easy_get_image($size='thumbnail',$postid='',$featured=false) {
	$return = new EasyAttachments;
	$return = $return->output($size,$postid,$featured);
	return $return;
}

/*deprecated*/
function post_image($size='thumbnail',$postid='',$featured=false){
	return easy_get_image($size,$postid,$featured);
}