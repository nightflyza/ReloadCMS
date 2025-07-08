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
list($module, $c) = explode('@', $module);
if($articles->setWorkContainer($c)){
    if(($list = $articles->getLimitedStat('time', $system->config['num_of_latest'], true)) !== false){
        foreach($list as $id => $time) {
            $id = explode('.', $id);
            if(($article = $articles->getArticle($id[0], $id[1], true, true, false, false)) !== false){
                $feed->addItem($article['title'] . ' [' . $article['author_name'] . ']',
                    htmlspecialchars($article['desc']),
                    $system->url . '/?module=' . $module . '&amp;c=' . $c . '&amp;b=' . $id[0] . '&amp;a=' . $id[1],
                    $article['time']);
            }
        }
    }
}
?>