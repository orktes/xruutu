<item>
<title><![CDATA[<?php echo $item->title; ?>]]></title>
<description><![CDATA[<?php echo $item->teaser; ?>]]></description>
<date><?php echo $item->modified; ?></date>

<link><?php echo $XRUUTUURL; ?>index.php?search&amp;task=play&amp;id=<?php echo $item->nid; ?></link>
<enclosure type="video/flv"  url="<?php echo $XRUUTUURL; ?>index.php?search&amp;task=play&amp;id=<?php echo $item->nid; ?>" />
</item>