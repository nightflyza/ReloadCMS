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

$gallery = new gallery();
$images = $gallery->getFullImagesList();
if(!empty($images)){
    $i = rand(0, sizeof($images) - 1);
    $id = 0;
    foreach ($images as $filename){
        if ($id == $i){
            show_window(__('Random image'), '<a href="?module=gallery&amp;id=' . $filename . '">' . $gallery->getThumbnail($filename) . '</a>', 'center'); 
            break;
        }
        $id++;
    }
}
?>