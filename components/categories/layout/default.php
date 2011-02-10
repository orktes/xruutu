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

<channel>
<title></title>

<?php 
if(isset($_REQUEST['series'])) {
	$redirect=$XRUUTUURL."index.php?option=browse&amp;series=". urlencode($_REQUEST['series'])."&amp;end=0";
} else if($_REQUEST['term']) {
	$redirect=$XRUUTUURL."index.php?option=search&amp;term=". urlencode($_REQUEST['term']);
} else {
	$redirect=$XRUUTUURL."index.php?option=mainmenu";
	
}
?>

<item>
<title>Kaikki mediat</title>
<link><?php echo $redirect; ?></link>
</item>

<item>
<title>Vain jaksot</title>
<link><?php echo $redirect; ?>&amp;allowVideo=0&amp;allowAudio=0</link>
</item>

<item>
<title>Vain klipit</title>
<link><?php echo $redirect; ?>&amp;allowVideoEpisode=0&amp;allowAudio=0</link>
</item>

<item>
<title>Vain äänitteet</title>
<link><?php echo $redirect; ?>&amp;allowVideoEpisode=0&amp;allowVideo=0</link>
</item>

</channel>
</rss>



