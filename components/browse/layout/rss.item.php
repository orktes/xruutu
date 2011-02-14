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
<link><?php echo $XRUUTUURL; ?>index.php?option=search&amp;task=play&amp;type=<?php echo $item->media_type; ?>&amp;id=<?php echo $item->nid; ?></link>
<enclosure type="video/flv"  url="<?php echo $XRUUTUURL; ?>index.php?option=search&amp;task=play&amp;type=<?php echo $item->media_type; ?>&amp;id=<?php echo $item->nid; ?>" />

</item>