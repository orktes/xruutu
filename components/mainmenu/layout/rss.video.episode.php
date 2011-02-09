<item>
<title><?php echo $videoEpisode->title; ?></title>
<description><?php echo $videoEpisode->program_episode_description_text; ?></description>
<link>http://localhost:777/?r=rtmp://streamh1.nelonen.fi/hot/<?php $osat=explode(".",$videoEpisode->video_filename); echo $osat[1]; ?>:<?php echo $videoEpisode->video_filename; ?></link>
</item>