<h1>Index Controller</h1>
<p>Welcome to Kronos index controller.</p>

<h2>Download</h2>
<p>You can download Kronos from github.</p>
<blockquote>
<code>git clone git://github.com/matsbeddinge/kronos.git</code>
</blockquote>
<p>You can review its source directly on github: <a href='https://github.com/matsbeddinge/kronos'>https://github.com/matsbeddinge/kronos</a></p>

<h2>Installation</h2>
<p>First you have to make the data-directory writable. This is the place where Kronos needs
to be able to write and create files.</p>
<blockquote>
<code>cd kronos; chmod 777 application/data</code><br>
</blockquote>

<p>Second, Kronos has some modules that need to be initialised. You can do this through a
controller. Point your browser to the following link.</p>
<blockquote>
<a href='<?=create_url('module/install')?>'>module/install</a>
</blockquote>