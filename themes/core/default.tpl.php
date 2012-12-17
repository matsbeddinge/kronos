<!doctype html>
<html lang="sv">
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>
	<link rel="stylesheet" href="<?=$stylesheet?>">
</head>
<body>
	<div id="wrapper_header">
	<div id="header">
		<div id='login-menu'>
			<?=login_menu()?>
		</div>
		<a href='<?=base_url()?>'><img id="logo" src="<?=theme_url('logga.png')?>" alt="Kronos" /></a>
		<?=main_menu()?>
	</div>
	</div>
	<div id="wrapper">
	<div id="main" role="main">
		<?=get_messages_from_session()?>
		<?=@$main?>
		<?=render_views()?>
		
	</div>
	</div>
	<div id="wrapper_footer">
	<div id="footer">
		<?=$footer?>
		<?=get_debug()?>
	</div>
	</div>
</body>
</html>