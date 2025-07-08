<?php
////////////////////////////////////////////////////////////////////////////////
//   Copyright (C) ReloadCMS Development Team                                 //
//   http://reloadcms.sf.net                                                  //
//                                                                            //
//   This program is distributed in the hope that it will be useful,          //
//   but WITHOUT ANY WARRANTY, without even the implied warranty of           //
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                     //
//                                                                            //
//   This product released under GNU General Public License v2                //
////////////////////////////////////////////////////////////////////////////////
$MODULES[$category][0] = __('Gallery');
if($system->checkForRight('GALLERY')){
	$MODULES[$category][1]['images'] = __('Images management');
	$MODULES[$category][1]['index'] = __('Indexes management');
	$MODULES[$category][1]['upload'] = __('Upload images');
}
?>