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
$c = (empty($_GET['c']) || $_GET['c'] == '#hidden') ? null : $_GET['c'];
$b = (empty($_GET['b'])) ? null : (int)$_GET['b'];
$a = (empty($_GET['a'])) ? null : (int)$_GET['a'];

$sysconfig = parse_ini_file(CONFIG_PATH . 'config.ini');

if(!empty($a) && ((!empty($b) && !empty($c)) || $c == '#root')){
	if(!$articles->setWorkContainer($c)){
		show_error($articles->last_error);
	} elseif(!($article = $articles->getArticle($b, $a, true, true, true, true))) {
		show_error($articles->last_error);
	} elseif($c !== '#root' && !($category = $articles->getCategory($b, false))) {
		show_error($articles->last_error);
	} else {
		if(!empty($category)) $article['cat_data'] = $category;
		$containers = $articles->getContainers();

		$com_text = '';
		/* If user posting a comment */
		if(!empty($_POST['comtext']) && $article['comments'] == 'yes') {
			if (isset($sysconfig['article-guest']) and !LOGGED_IN){
				show_error(__('You are not logined!'));
			} else {
				if(!$articles->addComment($b, $a, $_POST['comtext'])){
					show_error($articles->last_error);
					$com_text = $_POST['comtext'];
				}
			}
			$_GET['page'] = 0;
		}
		/* If admin deleting comment */
		if(isset($_POST['cdelete']) && $system->checkForRight('ARTICLES-MODERATOR')) {
			if(!$articles->deleteComment($b, $a, $_POST['cdelete'])){
				show_error($articles->last_error);
			}
		}
		$article['text'] = trim($article['text']);

		/* Let's view selected article */
		if($c !== '#root') {
			$title = '<a class="winheader" class="winheader" href="?module=' . $module . '">' . __('Sections') . '</a> -&gt; ' . '<a class="winheader" class="winheader" href="?module=' . $module . '&amp;c=' . str_replace('#', '%23', $c) . '">' . $containers[$c] . '</a> -&gt; <a class="winheader" class="winheader" href="?module=' . $module . '&amp;c=' . str_replace('#', '%23', $c) . '&amp;b=' . $b . '">' . ((strlen($category['title'])>30) ? substr($category['title'], 0, 30) . '...' : $category['title']) . '</a> -&gt; ' . ((strlen($article['title']) > 20) ? substr($article['title'], 0, 20) . '...' : $article['title']);
		} else {
			$title = '<a class="winheader" class="winheader" href="?module=' . $module . '">' . __('Sections') . '</a> -&gt; ' . '<a class="winheader" class="winheader" href="?module=' . $module . '&amp;c=' . str_replace('#', '%23', $c) . '">' . $containers[$c] . '</a> -&gt; ' . ((strlen($article['title']) > 20) ? substr($article['title'], 0, 20) . '...' : $article['title']);
		}
		$system->config['pagename'] = $article['title'];
		if(!empty($article['keywords'])) {
			$system->addInfoToHead('<meta name="Keywords" content="' . $article['keywords'] . '">' . "\n");
		}
		if(!empty($article['sef_desc'])) {
			$system->addInfoToHead('<meta name="Description" content="' . $article['sef_desc'] . '">' . "\n");
		}
		show_window($title, rcms_parse_module_template('art-article.tpl', $article).get_rate($module.$c.$b.$a));

		/* If comments are enabled in this article, show form */
		if($article['comments'] == 'yes') {
			if (!(isset($sysconfig['article-guest']) and !LOGGED_IN)) {
				show_window(__('Post comment'), rcms_parse_module_template('comment-post.tpl', array('text'=>$com_text)), 'center');
			} else {
				show_window(__('Post comment'), __('You are not logined!'), 'center');
			}
		}

		/* May be show some comments :) */
		if($scomments = array_reverse($articles->getComments($b, $a), true)){
			foreach ($scomments as $id => $comment) $comments[] = $comment + array('id' => $id);
			$cnt = sizeof($comments);
			if(!empty($system->config['perpage'])) {
				$pages = ceil($cnt/$system->config['perpage']);
				if(!empty($_GET['page']) && ((int) $_GET['page']) > 0) $page = ((int) $_GET['page'])-1; else $page = 0;
				$start = $page * $system->config['perpage'];
				$total = $system->config['perpage'];
			} else {
				$pages = 1;
				$page = 0;
				$start = 0;
				$total = $cnt;
			}

			$result = '';
			$result .= '<div align="right">' . rcms_pagination($cnt, $system->config['perpage'], $page + 1, '?module=' . $module . '&amp;c=' . str_replace('#', '%23', $c) . '&amp;b=' . $b . '&amp;a=' . $a) . '</div>';
			for ($id = $start; $id < $total+$start; $id++){
				$comment = &$comments[$id];
				if(!empty($comment)) $result .= rcms_parse_module_template('comment.tpl', $comment);
			}
			$result .= '<div align="left">' . rcms_pagination($cnt, $system->config['perpage'], $page + 1, '?module=' . $module . '&amp;c=' . str_replace('#', '%23', $c) . '&amp;b=' . $b . '&amp;a=' . $a) . '</div>';
			show_window(__('Comments'), $result);
		}
	}
} elseif (!empty($c) && (!empty($_GET['from']) || !empty($_GET['until']))){
	if(!$articles->setWorkContainer($c)){
		show_error($articles->last_error);
	} elseif(($articles_list = $articles->getStat('time')) === false) {
		show_error($articles->last_error);
	} else {
		$containers = $articles->getContainers();
		$from = @$_GET['from'];
		$until = @$_GET['until'];
		$result = '';
		$system->config['pagename'] = __('Search results');
		foreach($articles_list as $id => $time) {
			$id = explode('.', $id);
			if((!$from || $time >= $from) && (!$until || $time <= $until)){
				if((($cat_data = $articles->getCategory($id[0], false)) !== false || $c == '#root') && ($article = $articles->getArticle($id[0], $id[1], true, true, false, false)) !== false){
					$result .= rcms_parse_module_template('art-article.tpl', $article + array('showtitle' => true,
					'linktext' => (($article['text_nonempty']) ? __('Open article') : __('Comments')) . ' (' . $article['comcnt'] . '/' . $article['views'] . ')',
					'linkurl' => '?module=' . $module . '&amp;c=' . str_replace('#', '%23', $c) . '&amp;b=' . $article['catid'] . '&amp;a=' . $article['id'],
					'cat_data' => @$cat_data));
				}
			}
		}
		$title = '<a class="winheader" class="winheader" href="?module=' . $module . '">' . __('Sections') . '</a> -&gt; ' . '<a class="winheader" class="winheader" href="?module=' . $module . '&amp;c=' . str_replace('#', '%23', $c) . '">' . $containers[$c] . '</a> -&gt; ' . __('Search results');
		show_window($title, $result);
	}
} elseif (!empty($_GET['from']) || !empty($_GET['until'])){
	$result = '';
	foreach ($articles->getContainers(0) as $c => $null){
		if(!$articles->setWorkContainer($c)){
			show_error($articles->last_error);
		} elseif(($articles_list = $articles->getStat('time')) === false) {
			show_error($articles->last_error);
		} else {
			$containers = $articles->getContainers();
			$from = @$_GET['from'];
			$until = @$_GET['until'];
			$system->config['pagename'] = __('Search results');
			foreach($articles_list as $id => $time) {
				$id = explode('.', $id);
				if((!$from || $time >= $from) && (!$until || $time <= $until)){
					if((($cat_data = $articles->getCategory($id[0], false)) !== false || $c == '#root') && ($article = $articles->getArticle($id[0], $id[1], true, true, false, false)) !== false){
						$result .= rcms_parse_module_template('art-article.tpl', $article + array('showtitle' => true,
						'linktext' => (($article['text_nonempty']) ? __('Open article') : __('Comments')) . ' (' . $article['comcnt'] . '/' . $article['views'] . ')',
						'linkurl' => '?module=' . $module . '&amp;c=' . str_replace('#', '%23', $c) . '&amp;b=' . $article['catid'] . '&amp;a=' . $article['id'],
						'cat_data' => @$cat_data));
					}
				}
			}
		}
	}
	$title = '<a class="winheader" class="winheader" href="?module=' . $module . '">' . __('Sections') . '</a> -&gt; ' . __('Search results');
	show_window($title, $result);
} elseif (!empty($c) && (!empty($b) || $c == '#root')){
	if(!$articles->setWorkContainer($c)){
		show_error($articles->last_error);
	} elseif(($contents = $articles->getArticles($b, true, true, false)) === false) {
		show_error($articles->last_error);
	} elseif($c !== '#root' && !($category = $articles->getCategory($b, false))) {
		show_error($articles->last_error);
	} else {
		$containers = $articles->getContainers();
		$result = '';
		if($c !== '#root') {
			$system->config['pagename'] = ((strlen($category['title'])>30) ? substr($category['title'], 0, 30) . '...' : $category['title']);
		} else {
			$system->config['pagename'] = $containers[$c];
		}
		$contents = array_reverse($contents);
		if(!empty($system->config['perpage'])) {
			$pages = ceil(sizeof($contents)/$system->config['perpage']);
			if(!empty($_GET['page']) && ((int) $_GET['page']) > 0) $page = ((int) $_GET['page'])-1; else $page = 0;
			$start = $page * $system->config['perpage'];
			$total = $system->config['perpage'];
		} else {
			$pages = 1;
			$page = 0;
			$start = 0;
			$total = sizeof($contents);
		}
		$result .= '<div align="right">' . rcms_pagination(sizeof($contents), $system->config['perpage'], $page+1, '?module=' . $module . '&amp;c=' . str_replace('#', '%23', $c) . '&amp;b=' . $b) . '</div>';
		for ($a = $start; $a < $total+$start; $a++){
			$article = &$contents[$a];
			if(!empty($article)){
				if($c !== '#root') {
					$result .= rcms_parse_module_template('art-article.tpl', $article + array('showtitle' => true,
					'linktext' => (($article['text_nonempty']) ? __('Open article') : __('Comments')) . ' (' . $article['comcnt'] . '/' . $article['views'] . ')',
					'linkurl' => '?module=' . $module . '&amp;c=' . str_replace('#', '%23', $c) . '&amp;b=' . $b . '&amp;a=' . $article['id'],
					'cat_data' => $category));
				} else {
					$result .= rcms_parse_module_template('art-article.tpl', $article + array('showtitle' => true,
					'linktext' => (($article['text_nonempty']) ? __('Open article') : __('Comments')) . ' (' . $article['comcnt'] . '/' . $article['views'] . ')',
					'linkurl' => '?module=' . $module . '&amp;c=' . str_replace('#', '%23', $c) . '&amp;a=' . $article['id']));
				}
			}
		}
		if($c !== '#root') {
			$title = '<a class="winheader" class="winheader" href="?module=' . $module . '">' . __('Sections') . '</a> -&gt; ' . '<a class="winheader" class="winheader" href="?module=' . $module . '&amp;c=' . str_replace('#', '%23', $c) . '">' . $containers[$c] . '</a> -&gt; ' . ((strlen($category['title'])>30) ? substr($category['title'], 0, 30) . '...' : $category['title']);
		} else {
			$title = '<a class="winheader" class="winheader" href="?module=' . $module . '">' . __('Sections') . '</a> -&gt; ' . $containers[$c];
		}
		show_window($title, $result);
	}
} elseif (!empty($c)){
	if(!$articles->setWorkContainer($c)){
		show_error($articles->last_error);
	} else {
		if(($categories = $articles->getCategories(false, true, true)) === false ){
			show_error($articles->last_error);
		} else {
			$containers = $articles->getContainers();
			$result = '';
			foreach($categories as $category) {
				$result .= rcms_parse_module_template('art-category.tpl', $category + array('link' => '?module=' . $module . '&amp;c=' . str_replace('#', '%23', $c) . '&amp;b=' . $category['id'])).get_rate($module.$c.$category['id']);
			}
			show_window('<a class="winheader" class="winheader" href="?module=' . $module . '">' . __('Sections') . '</a> -&gt; ' . $containers[$c], $result);
			$system->config['pagename'] = $containers[$c];
		}
	}
} else {
	$result = '';
	foreach ($articles->getContainers() as $c_id => $c_title){
		$result .= rcms_parse_module_template('art-container.tpl', array('title' => $c_title, 'link' => '?module=articles&amp;c=' . str_replace('#', '%23', $c_id)));
	}
	show_window(__('Sections'), $result);
	$system->config['pagename'] = __('Sections');
}
?>