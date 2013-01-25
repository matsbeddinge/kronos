<?php if($comment['created']): ?>
<h1>Edit Comment</h1>
<?php else: ?>
<h1>Create Comment</h1>
<?php endif; ?>

<?=$form->GetHTML(array('class'=>'content-edit'))?>

<p class='smaller-text'><em>
<?php if($comment['created']): ?>
This comment were created by <?=$comment['owner']?> at <?=$comment['created']?>.
<?php endif; ?>

<?php if(isset($comment['updated'])):?>
  Last updated at <?=$comment['updated']?>.
<?php endif; ?>
</em></p>
