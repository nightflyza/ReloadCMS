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
if(!empty($_POST['cleanstats'])) statistic_clean();

if($stats = statistic_get()){
    $frm = new InputForm ('', 'post', __('Clean stats'));
    $frm->addrow(__('Total hits'), $stats['totalhits']);
    $frm->addrow(__('Today hits'), $stats['todayhits']);
    $frm->addrow(__('Today hosts'), sizeof($stats['todayhosts']));
    $frm->addbreak(__('Browsers'));
    arsort($stats['ua']);
    foreach ($stats['ua'] as $agent => $count) $frm->addrow(htmlspecialchars($agent), $count);
    $frm->addbreak(__('Popular pages'));
    arsort($stats['popular']);
    array_splice($stats['popular'], 20);
    foreach ($stats['popular'] as $page => $count) $frm->addrow(htmlspecialchars($page), $count);
    $frm->addbreak(__('Today users'));
    arsort($stats['todayhosts']);
    foreach ($stats['todayhosts'] as $ip => $count) $frm->addrow($ip);
    $frm->hidden('cleanstats', '1');
    $frm->show();
} 

?>