<h1>Content</h1>

<h2>All <?=$type?>s</h2>
<?php if($contents != null):?>
<ul>
<?php foreach($contents as $val):?>
<li><?=$val['id']?>, <?=esc($val['title'])?> by <?=$val['owner']?> 
	<a href='<?=create_url("content/edit/{$val['id']}")?>'>edit</a> 
	<a href='<?=create_url("content/delete/{$val['id']}")?>'>delete</a>
<?php endforeach; ?>
</ul>
<?php else:?>
  <p>No <?=$type?> exists.</p>
<?php endif;?>

<h2>Actions</h2>
<ul>
<li><a href='<?=create_url("content/create/{$type}")?>'>Create new <?=$type?></a>
</ul>