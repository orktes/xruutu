<?php 

/* Copyright Jaakko Lukkari 2011 
 *  
 * This program is free software; you can redistribute it and/or modify 
 * it under the terms of the GNU General Public License as published by 
 * the Free Software Foundation; either version 2 of the License, or 
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License 
 * for more details.
 * 
 * You should have received a copy of the GNU General Public License along 
 * with this program; if not, write to the Free Software Foundation, Inc., 
 * 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 */
defined( 'parentFile' ) or die( 'No direct access! Olet väärässä paikassa!' ); 

global $XRUUTUDIR, $XRUUTUURL;

header("Content-Type: application/rss+xml");
echo  "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
?>
<rss version="2.0"  xmlns:media="http://purl.org/dc/elements/1.1/"  xmlns:dc="http://purl.org/dc/elements/1.1/">

<onEnter>	
	/* start rtmpgw */
	ret = getURL("<?php echo $XRUUTUURL; ?>index.php?option=rtmpgw&amp;task=start");
</onEnter>

<onExit>
	/* stop rtmpgw */
	ret = getURL("<?php echo $XRUUTUURL; ?>index.php?option=rtmpgw&amp;task=stop");
</onExit>

<mediaDisplay name=threePartsView
	sideColorLeft="0:0:0"
        sideLeftWidthPC="18"
	sideRightWidthPC="10"
	sideColorRight="0:0:0"
	headerXPC="14"
	headerYPC="3"
	headerWidthPC="95"
	itemImageXPC="21"
	itemImageYPC="18"
	itemXPC="34"
	itemYPC="18"
	itemWidthPC="46"
	menuXPC="5"
	menuWidthPC="15"
	capXPC="82"
	capYPC="17"
	capHeightPC="10"
	headerCapXPC="90"
	headerCapYPC="10"
	headerCapWidthPC="0"
        showDefaultInfo=yes
	backgroundColor="0:0:0"
	itemBackgroundColor="0:0:0"
	infoYPC="85"
	popupXPC="7"
	popupWidthPC="15"
	popupBorderColor="0:0:0"
	idleImageXPC=45
	idleImageYPC=42
	idleImageWidthPC=10
	idleImageHeightPC=16
  >
	<idleImage> image/POPUP_LOADING_01.jpg </idleImage>
        <idleImage> image/POPUP_LOADING_02.jpg </idleImage>
        <idleImage> image/POPUP_LOADING_03.jpg </idleImage>
        <idleImage> image/POPUP_LOADING_04.jpg </idleImage>
        <idleImage> image/POPUP_LOADING_05.jpg </idleImage>
        <idleImage> image/POPUP_LOADING_06.jpg </idleImage>
</mediaDisplay>


<channel>
<title></title>
<?php 
$i=0;
foreach($this->menuitems as $item) {
$i++;
?>
<item>
<title><?php echo $item->name; ?></title>
<?php if($item->type=="normal") { ?>
<link><?php echo $XRUUTUURL; ?>index.php?option=<?php echo $item->component; ?></link>                    
<?php } else if($item->type=="search") { ?>
<link>rss_command://search</link> 
<search url="<?php echo $XRUUTUURL; ?>index.php?option=<?php echo $item->component; ?>&amp;term=%s" /> 
<?php } ?>
<media:thumbnail url="<?php echo $XRUUTUDIR; ?>images/mainmenuicons/<?php echo $item->image; ?>" />    
<image><?php echo $XRUUTUDIR; ?>images/mainmenuicons/<?php echo $item->image; ?></image>    
<imageover><?php echo $XRUUTUDIR; ?>images/mainmenuicons/<?php echo $item->imageover; ?></imageover> 
<itemid><?php echo $i; ?></itemid>
</item>
<?php } ?>


</channel>
</rss>



