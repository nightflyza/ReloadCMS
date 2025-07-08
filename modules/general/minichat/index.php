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
$config = parse_ini_file(CONFIG_PATH . 'minichat.ini');

if(!LOGGED_IN && !$config['allow_guests_view']) {
} else {
	if(!empty($_POST['mctext']) && (LOGGED_IN || $config['allow_guests_post'])) {
		$username = $system->user['username'];
		$nickname = $system->user['nickname'];
		guestbook_post_msg($username, $nickname, $_POST['mctext'], RCMS_MC_DEFAULT_FILE, 'minichat.ini');
	}

	if((!empty($_POST['mcdelete']) || @$_POST['mcdelete'] === '0') && $system->checkForRight('MINICHAT')) {
		guestbook_post_remove((int)$_POST['mcdelete'], RCMS_MC_DEFAULT_FILE, 'minichat.ini');
	}

	$result = '';
	if(LOGGED_IN || $config['allow_guests_post']) {
		$result .= rcms_parse_module_template('minichat-form.tpl', array('allow_guests_enter_name' => $config['allow_guests_enter_name']));
	}

	$list = guestbook_get_last_msgs($config['messages_to_show'], true, true, RCMS_MC_DEFAULT_FILE, 'minichat.ini');
	foreach ($list as $message_id => $message){
		$result .= rcms_parse_module_template('minichat-mesg.tpl', array('id' => $message_id) + $message);
	}

	$result = '<script type="text/javascript" src="' . RCMS_ROOT_PATH . 'minmax.js"></script><div style="overflow-x: hidden; overflow-y: auto; max-height: 450px; width: 100%">' . $result . '</div>';
	show_window(__('Minichat'), $result, 'center');
}
?>