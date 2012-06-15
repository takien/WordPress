<?php
/*
Plugin Name: Easy Attachments
Description: Manage attachments in easy way,
Author: takien
Version: 1.0
Author URI: http://takien.com/
*/

if(!class_exists('EasyAttachments')){

	class EasyAttachments {
	
	    var $post_type     = 'attachment';
		var $post_parent    = '';
		var $post_mime_type = 'image';
		var $post_status    = null;
		var $numberposts    = -1;
		var $order          = 'ASC';
		
		function __construct(){
			add_theme_support($this->add_theme_support());
		}
		
		function add_theme_support($feature=''){
			return $feature;
		}
		function set($what,$value){
			$this->$what = $value;
		}
		
		function get_attachment($args=''){
			$defaults = array(
				'order'          => $this->order,
				'post_type'      => $this->post_type,
				'post_parent'    => $this->post_parent,
				'post_mime_type' => $this->post_mime_type,
				'post_status'    => $this->post_status,
				'numberposts'    => $this->numberposts,
				'exclude'		 => get_post_thumbnail_id()
			);
			$args        = wp_parse_args( $args, $defaults );
			$attachments = get_posts($args);

			if ($attachments){
				$return = Array();
				foreach($attachments as $key=>$val){
					$return[$key] = $val;
					$return[$key]->thumbnail = wp_get_attachment_image_src($return[$key]->ID,'thumbnail');
					$return[$key]->medium    = wp_get_attachment_image_src($return[$key]->ID,'medium');
					$return[$key]->full      = wp_get_attachment_image_src($return[$key]->ID,'full');
				}
				return $return;
			}
		}
	}
}
/**
* usage example
* 
$eattach = new EasyAttachments;
$eattach->add_theme_support('post-thumbnails');
echo'<pre>';
$args = Array('post_parent'=>get_the_ID());
print_r($eattach->get_attachment($args));
echo'</pre>';
*/