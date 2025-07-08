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

$messages = guestbook_get_msgs(0, true);
foreach ($messages as $id => $message) {
    $feed->addItem(__('Message by') . ' ' . $message['nickname'],
    htmlspecialchars($message['text']),
    $system->url . '?module=' . $module,
    $message['time']);
}
?>