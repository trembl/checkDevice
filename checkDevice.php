<?php

/*
	checkeDevice
	------
	
	Plugin Name: checkeDevice
	Plugin URI: 
	Description: Conditional functions for detecting mobile devices, tablets and desktops. Use is_mobile(), is_tablet(), and is_desktop() and is_touch_device() and  in your template files. 
	Author: Georg Tremmel
	Version: 2.0	
	Author URI: http://www.trembl.org

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	THIS SOFTWARE AND DOCUMENTATION IS PROVIDED "AS IS," AND COPYRIGHT
	HOLDERS MAKE NO REPRESENTATIONS OR WARRANTIES, EXPRESS OR IMPLIED,
	INCLUDING BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY OR
	FITNESS FOR ANY PARTICULAR PURPOSE OR THAT THE USE OF THE SOFTWARE
	OR DOCUMENTATION WILL NOT INFRINGE ANY THIRD PARTY PATENTS,
	COPYRIGHTS, TRADEMARKS OR OTHER RIGHTS.COPYRIGHT HOLDERS WILL NOT
	BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL OR CONSEQUENTIAL
	DAMAGES ARISING OUT OF ANY USE OF THE SOFTWARE OR DOCUMENTATION.

	You should have received a copy of the GNU General Public License
	along with this program. If not, see <http://gnu.org/licenses/>.

*/

// Breakpoints for Mobiles & Tablets 
$mobileMaxWidth = 600;
$tabletMaxWidth = 1000;





// get useragent string
$useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";

// get windowWidth cookie
$windowWidth = (isset($_COOKIE['windowWidth']) && $_COOKIE['windowWidth']!="") ? $_COOKIE['windowWidth'] : 0;

// get touch cookie
$touchEnabled = (isset($_COOKIE['touchEnabled']) && $_COOKIE['touchEnabled']!="") ? $_COOKIE['touchEnabled'] : false;


function is_iphone() {
	global $useragent;
	return(preg_match('/iphone/i',$useragent));
}

function is_ipad() {
	global $useragent;
	return(preg_match('/ipad/i',$useragent));
}

function is_ipod() {
	global $useragent;
	return(preg_match('/ipod/i',$useragent));
}

function is_android() {
	global $useragent;
	return(preg_match('/android/i',$useragent));
}

function is_blackberry() {
	global $useragent;
	return(preg_match('/blackberry/i',$useragent));
}

function is_opera_mobile() {
	global $useragent;
	return(preg_match('/opera mini/i',$useragent));
}

function is_palm() {
	global $useragent;
	return(preg_match('/webOS/i', $useragent));
}

function is_symbian() {
	global $useragent;
	return(preg_match('/Series60/i', $useragent) || preg_match('/Symbian/i', $useragent));
}

function is_windows_mobile() {
	global $useragent;
	return(preg_match('/WM5/i', $useragent) || preg_match('/WindowsMobile/i', $useragent));
}
function is_lg() {
	global $useragent;
	return(preg_match('/LG/i', $useragent));
}

function is_motorola() {
	global $useragent;
	return(preg_match('/\ Droid/i', $useragent) || preg_match('/XT720/i', $useragent) || preg_match('/MOT-/i', $useragent) || preg_match('/MIB/i', $useragent));
}

function is_nokia() {
	global $useragent;
	return(preg_match('/Series60/i', $useragent) || preg_match('/Symbian/i', $useragent) || preg_match('/Nokia/i', $useragent));
}

function is_samsung() {
	global $useragent;
	return(preg_match('/Samsung/i', $useragent));
}

function is_samsung_galaxy_tab() {
	global $useragent;
	return(preg_match('/SPH-P100/i', $useragent));
}

function is_sony_ericsson() {
	global $useragent;
	return(preg_match('/SonyEricsson/i', $useragent));
}

function is_nintendo() {
	global $useragent;
	return(preg_match('/Nintendo DSi/i', $useragent) || preg_match('/Nintendo DS/i', $useragent));
}

function is_handheld() {
	return(is_iphone() || is_ipad() || is_ipod() || is_android() || is_blackberry() || is_opera_mobile() || is_palm() || is_symbian() || is_windows_mobile() || is_lg() || is_motorola() || is_nokia() || is_samsung() || is_samsung_galaxy_tab() || is_sony_ericsson() || is_nintendo());
}

function is_mobile() {
	global $windowWidth, $mobileMaxWidth, $tabletMaxWidth;
	if (is_tablet()) { return false; }  // this catches the problem where an Android device may also be a tablet device
	$mobile = (is_iphone() || is_ipod() || is_android() || is_blackberry() || is_opera_mobile() || is_palm() || is_symbian() || is_windows_mobile() || is_lg() || is_motorola() || is_nokia() || is_samsung() || is_sony_ericsson() || is_nintendo());
	
	if (($windowWidth > 0) && ($windowWidth < $mobileMaxWidth)) {
		$mobile = true;
	} elseif ($windowWidth >= $mobileMaxWidth) {
		$mobile = false;
	}
	return $mobile;
}

function is_ios() {
	return(is_iphone() || is_ipad() || is_ipod());

}

function is_tablet() {
	global $windowWidth, $mobileMaxWidth, $tabletMaxWidth;
	$tablet = (is_ipad() || is_samsung_galaxy_tab());
	if (($windowWidth >= $mobileMaxWidth) && ($windowWidth < $tabletMaxWidth)) {	// betweet tablet sizes
		$tablet = true;
	} elseif ((($windowWidth > 0) && ($windowWidth < $mobileMaxWidth)) || ($windowWidth >= $tabletMaxWidth ) ) {	// don't use else, otherwise the initial UA sting gets overwritten
		$tablet = false;
	}
	return $tablet;
}

function is_desktop() {
	return(!is_mobile() && !is_tablet());
}

function is_tablet_or_desktop() {
	return(!is_mobile());
}

function is_touch_device() {
	global $touchEnabled;
	if ($touchEnabled=="true" || (is_ios() || is_samsung_galaxy_tab()) ) {
		return true;
	} else {
		return false;
	}
}

function is_not_touch_device() {
	return !is_touch_device();
}









// add JS Cookie Setting Script, depends on jQuery
function addCookieScript() {
	wp_register_script('cookie-js', plugins_url('/cookie.js', __FILE__, array('jquery'), '1.0', false) );		// depends on jQuery
	wp_enqueue_script('cookie-js');            
}    
 
add_action('wp_enqueue_scripts', 'addCookieScript');



?>