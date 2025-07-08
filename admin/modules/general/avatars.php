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

if(!empty($_POST['nconfig'])) write_ini_file($_POST['nconfig'], CONFIG_PATH . 'avatars.ini');

$system->config = parse_ini_file(CONFIG_PATH . 'avatars.ini');
$config = &$system->config;

// Interface generation
$frm =new InputForm ('', 'post', __('Submit'));
$frm->addbreak(__('Avatars configuration'));
$frm->addrow(__('Max height'), $frm->text_box("nconfig[avatars_h]", @$config['avatars_h']));
$frm->addrow(__('Max width'), $frm->text_box("nconfig[avatars_w]", @$config['avatars_w']));
$frm->addrow(__('Max size'), $frm->text_box("nconfig[avatars_size]", @$config['avatars_size']));
$frm->show();
?>