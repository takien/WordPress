<?php
/**
 * Displaying WordPress archive by specific year or month
 * @author takien
 * @url http://takien.com/1092/display-wordpress-archive-lists-by-specific-year-or-month.php
 * @version 1.0
 */
 

/* function where */ 

function takien_archive_where($where,$args){
	$year		= isset($args['year']) 		? $args['year'] 	: '';
	$month		= isset($args['month']) 	? $args['month'] 	: '';
	$monthname	= isset($args['monthname']) ? $args['monthname']: '';
	$day		= isset($args['day']) 		? $args['day'] 		: '';
	$dayname	= isset($args['dayname']) 	? $args['dayname'] 	: '';

	if($year){
		$where .= " AND YEAR(post_date) = '$year' ";
		$where .= $month ? " AND MONTH(post_date) = '$month' " : '';
		$where .= $day ? " AND DAY(post_date) = '$day' " : '';
	}
	if($month){
		$where .= " AND MONTH(post_date) = '$month' ";
		$where .= $day ? " AND DAY(post_date) = '$day' " : '';
	}
	if($monthname){
		$where .= " AND MONTHNAME(post_date) = '$monthname' ";
		$where .= $day ? " AND DAY(post_date) = '$day' " : '';
	}
	if($day){
		$where .= " AND DAY(post_date) = '$day' ";
	}
	if($dayname){
		$where .= " AND DAYNAME(post_date) = '$dayname' ";
	}
	return $where;
}


//This is example to display archive list on year 2010.
//call the filter early before any output, the best place is in functions.php
add_filter( 'getarchives_where','takien_archive_where',10,2);

/* place the following code at where output to be displayed.*/

//display the archive list monthly based, on year 2010
//set the arguments
$args = array(
    'type'            => 'monthly',
    'echo'            => 0,
    'year'       => '2010'
);

//render the output

echo '<h2>Monthly archive 2010</h2>';
echo '<ul>'.wp_get_archives($args).'</ul>';

//display the archive list daily based, on February 2011
$args = array(
    'type'            => 'daily',
    'echo'            => 0,
    'year'       => '2011',
    'month'     => '12'
);

echo '<h2>Daily archive December, 2011</h2>';
echo '<ul>'.wp_get_archives($args).'</ul>';

//set the arguments
$args = array(
    'type'    => 'daily',
    'echo'    => 0,
    'month'   => '1'
);

echo '<h2>Daily archive January, all years</h2>';
echo '<ul>'.wp_get_archives($args).'</ul>';