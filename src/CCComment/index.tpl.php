<h1>Comment</h1>
<h2>All comments</h2>
<?php if($comments != null):?>
<ul>
<?php foreach($comments as $val):?>
<li><?=$val['id']?>. Belongs to blogid: <?=$val['idContent']?>, by <?=$val['owner']?>, <?=$val['created']?> 
	<a href='<?=create_url("comment/edit/{$val['id']}")?>'>edit</a> 
	<a href='<?=create_url("comment/delete/{$val['id']}")?>'>delete</a>
</li>
<?php endforeach; ?>
</ul>
<?php else:?>
  <p>No comments exists.</p>
<?php endif;?>