<?php
function startsWith($haystack,$needle,$case=true) {
    if($case){return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);}
    return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
}

function endsWith($haystack,$needle,$case=true) {
    if($case){return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);}
    return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
}

function dateSort($a, $b) {
	
	
	if($a->DATE==$b->DATE) {
		return 0;
	}
	
	 return (strtotime($a->DATE) > strtotime($b->DATE)) ? -1 : 1;
	
}
function modifiedSort($a, $b) {
	
	
	if($a->modified==$b->modified) {
		return 0;
	}
	
	 return (strtotime($a->modified) > strtotime($b->modified)) ? -1 : 1;
	
}
