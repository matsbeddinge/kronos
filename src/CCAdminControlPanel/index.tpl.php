<?php if($hasRoleAdmin): ?>

<h1>Admin Control Panel</h1>
<h2>Users</h2>
<table style="font-size:small">
<thead><th>id</th><th>acronym</th><th>name</th><th>email</th><th>created</th><th>updated</th><th></th></thead>
<tbody>
<?php foreach($users as $user):?>
<tr>
<td><?=$user['id']?></td>
<td><?=$user['acronym']?></td>
<td><?=$user['name']?></td>
<td><?=$user['email']?></td>
<td><?=$user['created']?></td>
<td><?=$user['updated']?></td>
<td>
	<a href="<?=create_url('admin','edit',$user['id'])?>"><img src="<?=create_url('themes/core/edit.png')?>" alt="edit"></a>
	<a href="<?=create_url('admin','delete',$user['id'])?>"><img src="<?=create_url('themes/core/delete.png')?>" alt="delete"></a>
</td>
</tr>
<?php endforeach;?>
</tbody>
</table>
<?php if($allow_create_user) : ?>
<p><a href='<?=$create_user_url?>' title='Create a new user account'>Create user</a></p>
<?php endif; ?>

<h2>Blog posts</h2>
<p><a href='<?=create_url("content/index/post")?>' title=''>List all blog posts</a><br>
<a href='<?=create_url("comment/index")?>' title=''>List all blog comments</a></p>

<h2>Pages</h2>
<p><a href='<?=create_url("content/index/page")?>' title=''>List all pages</a><br>

<?php else: ?>
<div class='alert'>You are not authorized to access this page.</div>
<?php endif; ?>