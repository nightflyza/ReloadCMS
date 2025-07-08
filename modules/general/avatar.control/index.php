<?
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
if ((isset($_POST['upload_avatar'])) AND ($_POST['upload_avatar']=="true"))
{
       upload_avatar();
}
$config_ext = parse_ini_file(CONFIG_PATH . 'avatars.ini');
$avatars_enabled=parse_ini_file(CONFIG_PATH . 'disable.ini');
 if(LOGGED_IN){
  if(!isset($avatars_enabled['avatar.control'])) {
show_window(__('Your current avatar'),show_avatar($system->user['username']),'center');
show_window(__('Update your avatar'),show_avatar_requirements().'<br>'.avatar_upload_box(),'center'); }}
?>
