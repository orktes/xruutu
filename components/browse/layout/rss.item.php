<item>
<title><![CDATA[<?php echo $item->title; ?>]]></title>
<?php if($item->media_type=="video_episode") { ?>
<season><?php echo  $item->program_episode_season; ?></season>
<episode><?php echo  $item->program_episode_number; ?></episode>
<starttime><![CDATA[<?php echo  $item->video_episode_starttime; ?>]]></starttime>
<duration><![CDATA[<?php echo  $item->video_episode_duration; ?>]]></duration>
<date><?php echo $item->DATE; ?></date>
<?php  }  
if($item->media_type=="video_episode"||$item->media_type=="video") {
?>
<description><![CDATA[<?php echo  $item->video_description_to_use; ?>]]></description>
<shortdescription><![CDATA[<?php echo  $item->video_description_teaser; ?>]]></shortdescription>
<?php  } ?>
<?php if(endsWith($item->video_filename,"mp4")) { ?>
<link>http://<?php echo $_SERVER['SERVER_ADDR']; ?>:777/?r=rtmp://streamh1.nelonen.fi/hot/<?php $osat=explode(".",$item->video_filename); echo $osat[1]; ?>:<?php echo $item->video_filename; ?></link>
<enclosure type="video/flv"  url="http://<?php echo $_SERVER['SERVER_ADDR']; ?>:777/?r=rtmp://streamh1.nelonen.fi/hot/<?php $osat=explode(".",$item->video_filename); echo $osat[1]; ?>:<?php echo $item->video_filename; ?>" />
<?php } else { ?>
<link>http://uutisvideot.nelonen.fi/<?php echo $item->video_filename; ?></link>
<enclosure type="video/flv"  url="http://uutisvideot.nelonen.fi/<?php echo $item->video_filename; ?>" />

<?php } ?>
</item>