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
class SearchXRuutuModel extends XRuutuModel {

	
	function getSearchResults() {
		$ruutu=$this->getRuutu();

		$media = new stdClass();
		$term="";
		
		$allowVideo=true;
		$allowVideoEpisode=true;
		$allowAudio=true;

		if($_REQUEST['term']) {
			$term = $_REQUEST['term'];  
		}
				
		if(isset($_REQUEST['allowVideo'])) {
			$allowVideo=($_REQUEST['allowVideo']=="1");
		}
		if(isset($_REQUEST['allowVideoEpisode'])) {
			$allowVideoEpisode=($_REQUEST['allowVideoEpisode']=="1");
		}
		if(isset($_REQUEST['allowAudio'])) {
			$allowAudio=($_REQUEST['allowAudio']=="1");
		}

	 $items =array();
		$data=$ruutu->search($term, $allowVideo, $allowVideoEpisode, $allowAudio);

		if($allowVideoEpisode&&isset($data->video_episode)) {
			$media->videoEpisodeTotalCount=$data->group_video_episode_total_found;
			foreach($data->video_episode as $item) {
				$item->type="video_episode";
			}
			
			$items=array_merge($items,$data->video_episode);
		}
		if($allowVideo&&isset($data->video)) {
		$media->videoTotalCount=$data->group_video_total_found;
		foreach($data->video as $item) {
				$item->type="video";
			}
			$items=array_merge($items,$data->video);
		}
		if($allowAudio&&isset($data->audio)) {
		foreach($data->audio as $item) {
				$item->type="audio";
			}
				$media->audioTotalCount=$data->group_audio_total_found;
			$items=array_merge($items,$data->audio);
		}
		
		
		
		
		usort($items, "modifiedSort");

		$media->items = $items;
		
		return $media;
	}

}
