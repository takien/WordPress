<?php
/**
* Extract caption from content
* @author takien
* @version 1.0
* @updated June 20,2012
* use shortcode regex from WordPress
*/

function extract_caption_from_content($content=''){
$regex = '\\[(\\[?)(caption)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)'; 
preg_match("/$regex/i",$content,$match);
	return strip_tags($match[5]);
}
/*example usage*/
echo extract_caption_from_content(get_the_content());
?>