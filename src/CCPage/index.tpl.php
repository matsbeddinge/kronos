<?php if($content['id']):?>
<article class="cloud">
<h1><?=esc($content['title'])?></h1>
<p><?=$content->GetFilteredData()?></p>
<?php if($hasRoleAdmin): ?>
<p class='smaller-text silent'>
<a href='<?=create_url("content/edit/{$content['id']}")?>'>edit</a>
</p>
</article>
<?php endif;?>
<?php else:?>
  <p>404: No such page exists.</p>
<?php endif;?>
