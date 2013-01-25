<?php if($content['id']):?>
  <h1><?=esc($content['title'])?></h1>
<p><?=$content->GetFilteredData()?></p>
<?php if($hasRoleAdmin): ?>
<p class='smaller-text silent'>
<a href='<?=create_url("content/edit/{$content['id']}")?>'>edit</a> 
<a href='<?=create_url("content/delete/{$content['id']}")?>'>delete</a> 
</p>
<?php endif;?>
<?php else:?>
  <p>404: No such page exists.</p>
<?php endif;?>

