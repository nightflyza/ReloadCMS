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

if(!LOGGED_IN){
	show_error(__('Guests cannot post articles'));
} else {
	$articles = new articles();
	if(!$system->checkForRight('ARTICLES-EDITOR')) $c = '#hidden';
	else $c = (empty($_POST['c'])) ? null : $_POST['c'];
	$b = (empty($_POST['b'])) ? null : $_POST['b'];

	if(!empty($_POST['save'])) {
		if(!$articles->setWorkContainer($c) || !$articles->saveArticle($b, 0, $_POST['title'], $_POST['source'], $_POST['keywords'], $_POST['sef_desc'], $_POST['description'], $_POST['text'], $_POST['mode'], $_POST['comments'])){
			show_error($articles->last_error);
		} elseif ($system->checkForRight('ARTICLES-EDITOR')){
			$frm = new InputForm ('admin.php?show=module&id=articles.articles', 'post', __('Edit it'));
			$frm->hidden('c', $c);
			$frm->hidden('b', $b);
			$frm->hidden('a', $_SESSION['art_id']);
			$frm->addrow(__('Article added'));
			show_window('', $frm->show(true));
		} else {
			show_error(__('Article added'));
		}
	}

	if(!empty($c)){
		if($articles->setWorkContainer($c)){
			if($c !== '#root' && $c !== '#hidden' && ($categories_list = $articles->getCategories(true, false)) === false){
				show_error($articles->last_error);
			} else {
				$frm = new InputForm ('', 'post', __('Submit'), '', '', '', 'artadd');
				$frm->hidden('save', '1');
				$frm->hidden('c', $c);
				if($c !== '#root' && $c !== '#hidden') $frm->addrow(__('Select category'), $frm->select_tag('b', $categories_list), 'top');
				$frm->addrow(__('Title'), $frm->text_box('title', ''), 'top');
				$frm->addrow(__('Author/source'), $frm->text_box('source', ''), 'top');
				$frm->addrow(__('Keywords'), $frm->text_box('keywords', ''), 'top');
				$frm->addrow(__('Description for search engines'), $frm->text_box('sef_desc', ''), 'top');
				$frm->addrow('', rcms_show_bbcode_panel('artadd.description'));
				$frm->addrow(__('Short description'), $frm->textarea('description', '', 70, 5), 'top');
				$frm->addrow('', rcms_show_bbcode_panel('artadd.text'));
				$frm->addrow(__('Text'), $frm->textarea('text', '', 70, 25), 'top');
				$frm->addrow(__('Mode'), $frm->radio_button('mode', array('html' => __('HTML'), 'text' => __('Text'), 'htmlbb' => __('bbCodes') . '+' . __('HTML')), 'text'), 'top');
				$frm->addrow(__('Allow comments'), $frm->radio_button('comments', array('yes' => __('Allow'), 'no' => __('Disallow')), 'yes'), 'top');
				$result = $frm->show(true);
			}
		} else show_error($articles->last_error);
	} else {
		$frm = new InputForm ('', 'post', __('Submit'));
		$frm->addrow(__('Select section'), $frm->select_tag('c', $articles->getContainers(2)), 'top');
		$result = $frm->show(true);
	}

	show_window(__('Post article'), $result, 'center');
	$system->config['pagename'] = __('Post article');
}
?>