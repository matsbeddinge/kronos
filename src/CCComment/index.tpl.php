<h1>Comment</h1>
<p>Create, edit and view comments.</p>

<h2>All comments</h2>
<?php if($comments != null):?>
<ul>
<?php foreach($comments as $val):?>
<li><?=$val['id']?>, by <?=$val['owner']?> 
	<?=filter_data($val['data'], $val['filter'])?>
	<a href='<?=create_url("comment/edit/{$val['id']}")?>'>edit</a> 
	<a href='<?=create_url("comment/delete/{$val['id']}")?>'>delete</a>
	<a href='<?=create_url("page/view/{$val['id']}")?>'>view</a>
</li>
<?php endforeach; ?>
</ul>
<?php else:?>
  <p>No comments exists.</p>
<?php endif;?>

<h2>Actions</h2>
<ul>
<li><a href='<?=create_url('comment/create')?>'>Create new comment</a></li>
</ul>