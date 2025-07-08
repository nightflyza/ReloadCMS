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
$articles = new articles();
$c_y =  rcms_format_time('Y', mktime());
$s_y =  $c_y;
$c_m =  rcms_format_time('n', mktime());
$s_m =  $c_m;

if(!empty($_POST['cal-year']) && $_POST['cal-year'] >= $c_y - 2 && $_POST['cal-year'] <= $c_y){
	$s_y = $_POST['cal-year'];
}

if(!empty($_POST['cal-month']) && $_POST['cal-month'] >= 1 && $_POST['cal-month'] <= 12){
	$s_m = $_POST['cal-month'];
}

$cal = new calendar($s_m, $s_y);
foreach ($articles->getContainers(0) as $container => $null){
	$articles->setWorkContainer($container);
	if(($list = $articles->getStat('time'))){
		foreach($list as $id => $time) {
			$id = explode('.', $id);
			if(rcms_format_time('n', $time) == $s_m){
				$cal->assignEvent(rcms_format_time('d', $time), '?module=articles&amp;from=' . mktime(0, 0, 0, $s_m, rcms_format_time('d', $time), $s_y) . '&amp;until=' . mktime(23, 59, 59, rcms_format_time('n', mktime()), rcms_format_time('d', $time), $s_y));
			}
		}
	}
}
$cal->highlightDay(rcms_format_time('d', mktime()));

$date_pick = '<form action="" method="post" style="text-align: center"><select name="cal-month">';
foreach (array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December') as $num => $month){
	$date_pick .= '<option value="' . ($num + 1) . '"' . (($num == $s_m - 1) ? ' selected="selected"' : '') . '>' . $lang['datetime'][$month] . '</option>';
}
$date_pick .= '</select>';

$date_pick .= '<select name="cal-year">';
for($y = $c_y - 2; $y <= $c_y; $y++){
	$date_pick .= '<option value="' . $y . '"' . (($y == $s_y) ? ' selected="selected"' : '') . '>' . $y . '</option>';
}
$date_pick .= '</select><input value="OK" type="submit" /></form>';

show_window(__('Articles calendar'), $cal->returnCalendar() . $date_pick);
?>
