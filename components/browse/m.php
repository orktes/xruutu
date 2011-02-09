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
require_once($XRUUTUDIR.'libs/mvc/m.php');
class BrowseXRuutuModel extends XRuutuModel {
	
	function getMedia() {
		$ruutu=$this->getRuutu();
		
		$media = new stdClass();
		$series="__";
		
		if(isset($_REQUEST['series'])) {
			$series=$_REQUEST['series'];
		}
		
		$media->video_episode=$ruutu->getMedia("video_episode", $series)->video_episode;
		$media->video=$ruutu->getMedia("video", $series)->video;
		$media->audio=$ruutu->getMedia("audio", $series)->audio;
		
		return $media;
	}
	
}
