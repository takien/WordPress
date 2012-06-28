<?php
/**
* Bootstrap Tab Content
* Add Bootstrap tab on WordPress posts/page using shortcode.
* Example usage
	[tabs]
		[tabcontent title="Title tab 1"]
			content tab 1
		[/tabcontent]
		[tabcontent title="Title tab 2"]
			content tab 2
		[/tabcontent]
	[/tabs]
*
* 
* In this version you must add manually Twitter bootstrap tabs library (CSS and JS)
* See here http://twitter.github.com/bootstrap/components.html#navs
* @author: takien
* @version: 1.0
* @url: http://takien.com
*/
add_shortcode('tabs',  'tabs_shortcode');
add_shortcode('tabcontent',  'tabcontent_shortcode');
function tabs_shortcode( $atts, $content = null ) {
	$unique = mt_rand();
	extract( shortcode_atts( array(
      'direction' => ''
      ), $atts ) );
	$regex = '\\[(\\[?)(tabcontent)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
	preg_match_all("/$regex/is",$content,$match);
	//echo '<pre>'.
	//print_r($match,1).'</pre>';
	$content = $match[0];
	
   $return =  '<div class="tabbable '.$direction.'" style="margin-bottom: 18px;">';
		$i = -1;
		$return .= '<ul class="nav nav-tabs">';
		foreach($content as $c){ $i++;
			$unique_id = 'tab_tab_'.$unique.'_'.$i;
			preg_match('/\[tabcontent ([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)/',$c,$matchattr);
			$attr = shortcode_parse_atts($matchattr[1]);
			$return .= '<li '.(($i==0) ? 'class="active"' : '').'><a href="#'.$unique_id.'" data-toggle="tab">'.$attr['title'].'</a></li>';
			$content[$i] = str_replace('[tabcontent ','[tabcontent '.(($i==0) ? 'class="active"' : '').' id="'.$unique_id.'" ',$content[$i]);
		}
		$return .= '</ul>';
		$return .= '<div class="tab-content">';
		foreach($content as $c){
			$return .= do_shortcode($c);
		}
		$return .= '</div>';
   $return .= '</div>';
   return $return;
}

function tabcontent_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
      'title' => '',
	  'id'    =>'',
	  'class' =>''
      ), $atts ) );
	$return = '<div class="tab-pane '.$class.'" id="'.$id.'">';
	$return .= do_shortcode($content);
	$return .= '</div>';
	return $return;
}