<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$system->config['language']?>" lang="<?=$system->config['language']?>">
<head>                                                        
    <title><?rcms_show_element('title')?></title>
    <?rcms_show_element('meta')?>
    <link rel="stylesheet" href="<?=CUR_SKIN_PATH?>style.css" type="text/css" />
</head>
<body>
<center>
<table width="90%" border="0" cellpadding="2" cellspacing="2" class="mtbl">
  <tbody>
    <tr>
      <td  colspan="3" rowspan="1" align="left"><img src="<?=CUR_SKIN_PATH?>logo.png" alt="<?=$system->config['title']?>"/></td>
    </tr>
    <tr>
<td colspan="3" rowspan="1" bgcolor="#7bbeef" class="mbg" height="38" align="center"><?rcms_show_element('navigation', '<a href="{link}" target="{target}" id="{id}">&nbsp;&nbsp;{title}&nbsp;&nbsp;</a>')?></td>
    </tr>
    <tr>
      <td width="80%" valign="top">
       <?rcms_show_element('menu_point', 'up_center@window')?>
        <?rcms_show_element('main_point', $module . '@window')?>
        <?rcms_show_element('menu_point', 'down_center@window')?>
      </td>
      <td width="4px"" class="vspacer"></td>
      <td width="20%" valign="top">
      <?rcms_show_element('menu_point', 'left@window')?>
      <?rcms_show_element('menu_point', 'right@window')?>
      </td>
    </tr>
    <tr>
      <td  colspan="3" rowspan="1"  align="left" class="lowerspacer">
     	<?rcms_show_element('copyright')?>
     	<br>   
     	<img src="./skins/button-rss.png" alt="RSS Aggregation" />
     	<a href="http://php.net"><img src="./skins/button-php.gif" alt="PHP powered" /></a><br>
 <?php    	
  // Page gentime end
  $mtime = explode(' ', microtime());
  $totaltime = $mtime[0] + $mtime[1] - $starttime;
  print(__('Generation time:').round($totaltime,2));
 ?>
      </td>
    </tr>
  </tbody>
</table>
</center>
</body>
</html>