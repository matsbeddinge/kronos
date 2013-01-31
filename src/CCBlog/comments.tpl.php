<article>
	<section class="cloud">
		<?php if($hasRoleAdmin || CKronos::Instance()->user['acronym'] == $content['owner']): ?>
			<p class='smaller-text silent' style="float:right;">
				<a href='<?=create_url("content/edit/{$content['id']}")?>'>edit</a> 
				<a href='<?=create_url("content/delete/{$content['id']}")?>'>delete</a>
			</p>
		<?php endif;?>
		<h2><?=esc($content['title'])?></h2>
		<h4>By <?=$content['owner']?></h4>
		<p><?=filter_data($content['data'], $content['filter'])?></p>
		<p class='smaller-text'><em>Posted on <?=$content['created']?></em></p>
	</section>

	<h3 class="one-col-indent">
		<?php if($content['counts'] == 0): ?>
			There are no comments to "<?=esc($content['title'])?>" yet. 
		<?php elseif($content['counts'] == 1): ?>
			There are	<?=$content['counts']?> comment to "<?=esc($content['title'])?>".
		<?php else: ?>
			There are	<?=$content['counts']?> comments to "<?=esc($content['title'])?>".
		<?php endif;?>
	</h3>
	
	<?php foreach($comments as $val):?>
		<section class="cloud one-col-indent">
		<?php if($hasRoleAdmin || CKronos::Instance()->user['acronym'] == $val['owner']): ?>
			<p class='smaller-text silent' style="float:right;">
			<a href='<?=create_url("comment/edit/{$val['id']}")?>'>edit</a> 
			<a href='<?=create_url("comment/delete/{$val['id']}")?>'>delete</a>
			</p>
		<?php endif;?>
		<h4><img class='gravatar' src='<?=get_blog_gravatar($val['email'], 44)?>' alt=''> <?=$val['owner']?> says:</h4>
		<p><?=filter_data($val['data'], $val['filter'])?></p>
		<p class='smaller-text'><em><?=$val['created']?></em></p>
		</section>
	<?php endforeach; ?>
	

	<h3 class="one-col-indent"><a href='<?=create_url("comment/create/{$content['id']}")?>'>Make a comment >></a></h3>
	
</article>