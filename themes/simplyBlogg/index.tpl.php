<!doctype html>
<html lang='en'>
<head>
  <meta charset='utf-8'/>
  <title><?=$title?></title>
	<link rel='stylesheet' href='<?=theme_url($stylesheet)?>'/>
	<?php if(isset($inline_style)): ?><style><?=$inline_style?></style><?php endif; ?>
</head>
<body>

<div id='outer-wrap-header'>
<div id='inner-wrap-header'>
<div id='header'>
<div id='login-menu'><?=login_menu()?></div>
<a href='<?=create_url("blog")?>'><img id="logo" src="<?=logo($logo)?>" width="<?=$logo_width?>" height="<?=$logo_height?>" alt="Kronos" /></a>
</div>
</div>
</div>

<?php if(region_has_content('navbar')): ?>
<div id='outer-wrap-navbar'>
<div id='inner-wrap-navbar'>
<div id='navbar'><?=render_views('navbar')?></div>
</div>
</div>
<?php endif; ?>


<?php if(region_has_content('flash')): ?>
<div id='outer-wrap-flash'>
<div id='inner-wrap-flash'>
<div id='flash'><?=render_views('flash')?></div>
</div>
</div>
<?php endif; ?>


<div id='outer-wrap-main'>
<div id='inner-wrap-main'>
<div id='primary'><?=get_messages_from_session()?><?=@$main?><?=render_views('primary')?><?=render_views()?></div>
<div id='sidebar'><?=render_views('sidebar')?></div>
</div>
</div>


<div id='outer-wrap-footer'>
<div id='inner-wrap-footer'>
<div id='footer'><?=render_views('footer')?><?=$footer?><?=get_debug()?></div>
</div>
</div>

</body>
</html>