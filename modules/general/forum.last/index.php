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
$forum = new forum();
$i = 2;
$topics = $forum->getFreshTopics($system->config['num_of_latest']);
if($topics !== false){
	$result = '';
	foreach ($topics as $topic_id) {
		$topic = $forum->getTopicData($topic_id);
		$result .= '<tr><td class="row' . $i . '">';
		$result .= '<a href="?module=forum&amp;action=topic&amp;id=' . $topic_id . '"><abbr title="[' . $topic['author_nick'] . '/' . rcms_format_time('H:i:s d.m.Y', $topic['date']) . ']">' . $topic['title'] . '</abbr></a> (' . $topic['replies'] . ')';
		$result .= ' <a href="?module=forum&amp;action=topic&amp;id=' . $topic_id . '&amp;pid=' . (@$topic['last_reply_id'] + 2) . '#' . (@$topic['last_reply_id'] + 2) . '"><abbr title="[' . $topic['last_reply_author'] . '/' . rcms_format_time('H:i:s d.m.Y', $topic['last_reply']) . ']">&gt;&gt;</abbr></a></td></tr>';
		$i++;
		if($i > 3) $i = 2;
	}
	if(!empty($result)){
		show_window(__('Forum updates'), '<table cellspacing="0" cellpadding="0" border="0" width="100%">' . $result . '</table>');
	}
}
?>
