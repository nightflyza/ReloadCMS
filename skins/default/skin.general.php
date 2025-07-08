<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$system->config['language']?>" lang="<?=$system->config['language']?>">
<head>                                                        
    <title><?rcms_show_element('title')?></title>
    <?rcms_show_element('meta')?>
    <link rel="stylesheet" href="<?=CUR_SKIN_PATH?>style.css" type="text/css" />
</head>
<body>
<div id="header-root">
    <div id="header-title">
        <img src="<?=CUR_SKIN_PATH?>logo.png" alt="<?=$system->config['title']?>"/>
    </div>
    <div id="header-navbox">
        <?rcms_show_element('navigation', '<a href="{link}" target="{target}" class="header-navbox">{title}</a> ')?>
    </div>
</div>
<div id="layout-root">
    <div id="layout-center">
        <?rcms_show_element('menu_point', 'up_center@window')?>
        <?rcms_show_element('main_point', $module . '@window')?>
        <?rcms_show_element('menu_point', 'down_center@window')?>
    </div>
    <div id="layout-left">
        <?rcms_show_element('menu_point', 'left@window')?>
    </div>
    <div id="layout-right">
        <?rcms_show_element('menu_point', 'right@window')?>
    	<div id="copyright">
        	<a href="http://validator.w3.org/check?uri=referer"><img src="./skins/button-xhtml.png" alt="Valid XHTML 1.0!" /></a>
        	<a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="./skins/button-css.png" alt="Valid CSS!" /></a>
        	<a href="http://php.net"><img src="./skins/button-php.gif" alt="PHP powered" /></a>
        	<img src="./skins/button-rss.png" alt="RSS Aggregation" /><br />
        	<?rcms_show_element('copyright')?>
    	</div>
    </div>
</div>
</body>
</html>