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

if(!empty($_POST['support_req']) && (LOGGED_IN || rcms_is_valid_email(@$_POST['support_mail']))) {
    if(LOGGED_IN) $_POST['support_mail'] = $system->user['email'];
    guestbook_post_msg($system->user['username'], $system->user['nickname'], $_POST['support_mail'] . "\n" . $_POST['support_req'], DF_PATH . 'support.dat');
    show_window('', __('Message sent'), 'center');
}

$result = '<form method="post" action="" name="form1">';
if(!LOGGED_IN) $result .= __('E-mail') . ' <input type="text" name="support_mail" value"" /><br />';
$result .= '<textarea name="support_req" cols="70" rows="7"></textarea><p align="center"><input type="submit" value="' . __('Submit') . '" /></p></form>';

show_window(__('Feedback request'), $result, 'center');
$system->config['pagename'] = __('Feedback');
?>