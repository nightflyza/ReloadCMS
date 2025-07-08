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
$MODULES[$category][0] = __('Articles');
if($system->checkForRight('ARTICLES-ADMIN')) $MODULES[$category][1]['containers'] = __('Manage sections');
if($system->checkForRight('ARTICLES-ADMIN')) $MODULES[$category][1]['categories'] = __('Manage categories');
if($system->checkForRight('ARTICLES-EDITOR')) $MODULES[$category][1]['articles'] = __('Manage articles');
if($system->checkForRight('ARTICLES-EDITOR')) $MODULES[$category][1]['post'] = __('Post article');
?>