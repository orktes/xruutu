<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('libs/ruutu.class.php');


$ruutu = new Ruutu();

$vastaus = $ruutu->search("maria");

foreach($vastaus->video_episode as $video) {
//print_r($video);

echo $video->title ." - ". $ruutu->getVideoUrl($video->nid, "video_episode")."<br />";



//echo $ruutu->getRTMPUrl($video->nid);
}