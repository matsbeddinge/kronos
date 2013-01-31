<?php if($contents != null):?>
  <?php foreach($contents as $val):?>
    <article class="cloud">
			<?php if($hasRoleAdmin || CKronos::Instance()->user['acronym'] == $val['owner']): ?>
				<p class='smaller-text silent' style="float:right;">
					<a href='<?=create_url("content/edit/{$val['id']}")?>'>edit</a> 
					<a href='<?=create_url("content/delete/{$val['id']}")?>'>delete</a>
				</p>
			<?php endif;?>
			<h2><?=esc($val['title'])?></h2>
			<h4>By <?=$val['owner']?></h4>
			<p><?=filter_data($val['data'], $val['filter'])?></p>
			<p class='smaller-text'><em>Posted on <?=$val['created']?></em></p>
			<p>
				<a href='<?=create_url("blog/comments/{$val['id']}")?>'>
				<?php if($val['counts'] == 0): ?>
					No comments >>
				<?php elseif($val['counts'] == 1): ?>
					<?=$val['counts']?> comment >>
				<?php else: ?>
					<?=$val['counts']?> comments >>
				<?php endif;?>
				</a>
			</p>
			
		</article>
	<?php endforeach; ?>
		
<?php else:?>
	<article class="cloud">
		<p>No blog posts exists.</p>
	</article>
<?php endif;?>