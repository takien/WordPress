<?php 
/**
* WordPress media upload inline.
* @author : contact@takien.com
* @version: 0.1
* @update : March 16, 2014
*/

add_action('admin_head','inline_wp_media_upload_head');

function inline_wp_media_upload_head () {
	global $post_type;
	
	$only_in_post_type = Array('post','page'); //example only, please specify your own post_type here.
	
	if(!in_array($post_type, $only_in_post_type)) {
		return;
	}
	?>
	<style>
	#titlediv {
		margin-bottom:0
	}
	#media-modal-placement {
		position:relative;
	}
	.media-modal-backdrop {
		display:none
	}
	
	.media-modal {
		position:inherit;
		top:auto;
		left:auto;
		right:auto;
		bottom:auto;
		width:100%;
		height:350px;
	}
	.media-modal-content {
		-webkit-box-shadow: none;
		-moz-box-shadow: none;
		box-shadow: none;
	}
	.media-frame-title {
		display:none
	}
	.media-frame-title,
	.media-frame-content,
	.media-frame-router	{
		left:0;
		position:inherit
	}
	.media-frame-menu {
		width:100%;
		position:inherit;
		z-index:auto
	}
	.media-menu {
		position:inherit;
		padding-top:0;
		top:0;
		left:0;
		right:0;
		bottom:auto;
	}
	.media-menu .separator {
		display:none
	}
	.media-menu > a {
		float:left;
		padding:8px;
	}
	.uploader-inline-content .upload-ui {
		margin:0
	}
	.uploader-inline-content {
		top:0
	}
	
	/* title on admin bar, comment these rows if you don't want to move title to admin bar*/
	#title-on-admin-bar {
		float:left;
		padding-left:50px;
		min-width:200px;
	}
	#title-on-admin-bar a {
		display:inline-block !important;
		color:#fafafa
	}
	#title-on-admin-bar h2 {
		text-align:center;
		color:#cacaca;
		font-weight:bold;
	}
	</style>
	<script>
		jQuery(document).ready(function($) {
			
			/* this will autoload modal on page load*/
			var options = {
						frame:    'post',
						state:    'gallery',
						title:    wp.media.view.l10n.addMedia,
						multiple: true
					};
			wp.media.editor.open( 'content', options );
			
			/* make container after #titlediv */
			$('#titlediv').after('<div id="media-modal-placement" />');
			$('#__wp-uploader-id-2').appendTo($('#media-modal-placement'));
			
			/* title on admin bar, comment these last two rows if you don't want to move title to admin bar*/
			$('#wp-admin-bar-root-default').after('<div id="title-on-admin-bar" />');
			$('.wrap>h2').first().appendTo('#title-on-admin-bar');
		});
		
	</script>
	<?php 
}