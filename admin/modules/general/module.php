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
$MODULES[$category][0] = __('Core controls');
if($system->checkForRight('GENERAL')) {
    $MODULES[$category][1]['config'] = __('Configuration');
    $MODULES[$category][1]['module-dis'] = __('Modules management');
    $MODULES[$category][1]['navigation'] = __('Navigation panel');
    $MODULES[$category][1]['menus'] = __('Menus management');
    $MODULES[$category][1]['ucm'] = __('User-Created-Menus');
    $MODULES[$category][1]['logging'] = __('Control logs');
    $MODULES[$category][1]['filemanager'] = __('File manager');
    $MODULES[$category][1]['statistic'] = __('Site statistics');
    $MODULES[$category][1]['search'] = __('Search configuration');
    $MODULES[$category][1]['avatars'] = __('Avatars configuration');
    $MODULES[$category][1]['smiles'] = __('Smiles configuration');
}
if($system->checkForRight('GENERAL') || $system->checkForRight('GENERAL-M')) {
    $MODULES[$category][1]['sendmail'] = __('Send e-mail');
    $MODULES[$category][1]['feedback'] = __('Feedback');
}
if($system->checkForRight('GENERAL') || $system->checkForRight('UPLOAD')) {
    $MODULES[$category][1]['uploads'] = __('Uploads management');
}
if($system->checkForRight('GENERAL')) {
    $MODULES[$category][1]['backup'] = __('Backups management');
}
?>