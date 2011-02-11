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
require_once($XRUUTUDIR.'libs/mvc/c.php');
class SearchXRuutuController extends XRuutuController  {
	
	function play() {
		if(isset($_REQUEST['id'])&&isset($_REQUEST['type'])) {
			$ruutu=$this->getModel()->getRuutu();
			
			$id=$_REQUEST['id'];
			$type=$_REQUEST['type'];
			
			$url= $ruutu->getVideoUrl($id, $type);
			
			if(endsWith($url, "mp4")) {
			
			header("location: http://".$_SERVER['SERVER_ADDR'].":777/?r=$url");
			} else {
			header("location: $url");
			}
		} else {
			echo "Puutteelliset parametrit";
		}
		
		
	}
	
}
