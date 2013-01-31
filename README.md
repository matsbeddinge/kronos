Kronos - SimplyBlogg
====================

This is a MVC with a prepared theme simplyBlogg that you can use to set up your own blog site in just a few minutes by 
following below instructions:

Download from GitHub and set up on server
=========================================
1. Clone this MVC into a new empty directory on your server with following command:
git clone https://github.com/matsbeddinge/kronos.git

2. Make the application/data directory writeable with following command, (standing in the directory where you downloaded the MVC):
chmod 777 application/data (or use an ftp program like filezilla)

3. If your installation is not on the root of the server you have to edit the .htaccess file. Open the file in a texteditor and
uncomment the line RewriteBase and write the relative path for your installation, by example: RewriteBase /~mpsv11/phpmvc/kmom10/


Install your database tables
============================
4. Point your browser to your domain (root of installation) and you should get up a index page. If not please, check point 1-3 above. 
5. Click on the link module/install, and your database tables will be installed.


Set up your account and add your first page and blogpost
========================================================
6. At installation you have got your own account. You are administrator and can login with acronym:root and password:root. Do login.
7a. First of all change your profile and password by click the link admin in the upper right corner.
7b. Click on the pen symbol to edit user root.
7c. Change your profile and password and save.
7d. Logout and now login with your new acronym and password.
At installation one about-me page and one blog page with a first demo blogpost was generated.
8a. Go to the about page and click on the edit link, (you need to have logged in). Now fill in whatever information you like to give.
8b. Go to the blog page and click on the edit link on the first post, (you need to have logged in). Write your first blog post.
Welcome your done. Now it's just to continue bloging. To create new blog posts, edit or delete old blog posts you just use 
the descriptive links directly in conjunction to the posts on the site when you are logged in.


Personal adjustments and set ups
================================
It's of course nice to put your own style to your blog site. This is easy done by following below steps.

Change logotype:
- Add your logo image to directory application/themes/mySimplyBlogg/
- Open the config.php file in the directory application with a text editor. 
- Almost at the end of the file change the line 'logo' => 'logga.png' to point to your logo ie. 'logo' => 'mylogo.jpg'
- Save the config.php file (and upload to server if you worked on a local copy)

Change main title of site:
- Open the config.php file in the directory application with a text editor. 
- Almost at the end of the file change the line 'sitetitle' => 'SimlplyBlog:' write your title ie. 'sitetitle' => 'My Title:'
- Save the config.php file (and upload to server if you worked on a local copy)

Change information of footer:
- Open the config.php file in the directory application with a text editor. 
- At the end of the file change the line 'footer' => '<p>2013 &copy; SimplyBlog</p>' write your information ie. 'footer' => '<p>2013 &copy; My Name</p>'
- Save the config.php file (and upload to server if you worked on a local copy)

Change menu:
- Open the config.php file in the directory application with a text editor. 
- Find "Define menus" section containing lines like  ...'blog' => array('label'=>'My Blog', 'url'=>'blog')... 
- 'My Blog' is what's shown in the navigation bar, change this text to your preferences.
- Save the config.php file (and upload to server if you worked on a local copy)

Change colors of text and backgrounds, font family:
- Open the style.css file in the directory application/themes/mySimplyBlogg/ with a text editor. 
- Follow the instructions in the file for making your adjustments.
- Save the style.css file (and upload to server if you worked on a local copy)

Add additional page:
- Login and click admin link.
- Click -> List all pages
- Click -> Create new page
- Add the data for the new page and click create button.
- In the list "All Pages" you can see that your new page have been created. Take a note of the number your new page got.
- Open the config.php file in the directory application with a text editor. 
- Find "Define a routing table for urls" section and follow the instructions for this section.
- Find "Define menus" section and follow the instructions for this section.
- Save the config.php file (and upload to server if you worked on a local copy)



