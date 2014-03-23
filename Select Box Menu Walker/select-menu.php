<?php
/**
 * SelectBox box menu walker
 * @author  : takien, tarikcayir
 * @link  : http://takien.com
 * @version : 1.1
 * 
 * use this on args:
 * 'walker'            => new SelectBox_Menu_Walker,
 * 'items_wrap'        => '<select id="%1$s" class="%2$s">%3$s</select>',
 */

class SelectBox_Menu_Walker extends Walker_Nav_Menu {
	
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;

		if($depth)
        	$indent = SelectBox_Menu_Walker::depth_space($depth);
		
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$selected = in_array('current-menu-item',$classes) ? 'selected="selected"' : '';
		$output .= '<option '.$selected.' value="'.$item->url.'">';
		$output .= $indent.$item->title;
	}

	function depth_space($space_number){
		$indent;
		$space_character = '&nbsp;&nbsp;';
		
		for ($i=1; $i <= $space_number; $i++)
			$indent .= $space_character;

		return $indent;
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</option>";
	}
}
?>
