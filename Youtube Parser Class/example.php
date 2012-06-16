<?php
/**
* Example to get all Youtube Id, embed code and Thumbnails from given page content
*/
require_once('youtube-parser.php');

$youtube = new ParseYoutube;
$youtube->set('source',file_get_contents('pageyoutube.html'));
$youtube->set('unique',true);

echo'<pre>';
print_r($youtube->getall());
echo'</pre>';