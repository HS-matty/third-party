PHP-Nuke Addons & Modules System
================================


Since PHP-Nuke 5.0 you can add new modules, addons or plugins simply
copying the addons files into a directory. With this feature, PHP-Nuke
gains modularity and you, the webmaster, the choice to install and/or
unistall the modules you want with an easy step.

This document has two main parts, one for webmasters/users and other
for Addons developers.

Please read it carefully and remember that this system, as the whole
PHP-Nuke comes without any warranty and all you do from here is under
your own responsability and risk. Always remember to backup your
database and all your files before doing anything.


====================================
1.- Information for Webmasters/Users
====================================

We start on the "modules" directory where you can add or delete all the
modules, addons or plugins you want.

The directories names under /modules/ dir have a rule to work properly:

a) All spaces are filled with "_", so if you have a module called for example
   Web Links, your directory name need to be Web_Links
   
Modules links will be automaticaly added to the Main Menu block at the end
of your entries. The selected list method, instead of the use of LI html tag,
is:

<strong>&middot;&nbsp;</strong>Module Name<br>

This is because we want to provide HTML 4.0 Transitional compatibility, if you
want to change this, just edit mainfile.php file on the function mainblock(), but
try to stay under the HTML standards and eliminate any <LI> tag from all your
blocks, why? because on the new standard you need to use <UL> and </UL> before
and after the listed items, if you do this the box will not looks good on the
site.

If you want to maintain or test a new Addons but don't want to show a link to your
users, just login as admin and click on your addon in the Modules block. When you
copy a new addon to the /modules/ directory, it will be added automaticaly into your
database with "Inactive" status. Inactive Modules can be viewed and accesed only by
Administrators.
If you have Inactive the Modules block but you want to offer a module service, just
Active the module/addon (not the block) from administration page and provide a link like:

http://www.yoursite.com/modules.php?op=modload&name=Addon_Name&file=index

where &name=Addon_Name is the directory name under modules directory
and &file=index is the name of the main .php file (without the extension) of
your module. The rest of the URL is required.

To simplify this process, you can just provide a link with "name" variable, like:

http://www.yoursite.com/modules.php?name=Addon_Name

you can do this "only" if your file name is "index.php" and no functions inside
need to be called.

When install a new addon please be sure that the blank spaces on the directory's
name are replaced with "_", for Example: Web_Links. The directory name is
case sensitive, this mean that isn't the same web_links than Web_Links. The "_"
character is replaced automaticaly by a blank space when the addon link appears
in the Modules block. So "Web_Links" module directory name will be changed to
"Web Links".

Also, please read the addon instructions that will be included by the addon author
for installation purpouses.


=====================================
2.- Information for Addons Developers
=====================================


Making a new addon with this system is pretty easy. Developer just need to know
a few rules:

a) On each addon file please remember to add the following code as the first
   lines:
   
    if (!eregi("modules.php", $PHP_SELF)) {
	die ("You can't access this file directly...");
    }

    This is to avoid direct access to the addons files, so users need to click on
    your link, with this we assure to include the theme layout for each page.
    
b) When declare a switch() do not use the variable $op to do it. Use another
   variable name.
   
c) On the Addon directory name do not use blank spaces, instead use the character
   "_". For example if you want to create an addon called "The Web Ring", the
   directory name will be "The_Web_Ring".
   
d) Any link on the addons files need to have the following syntax:

   http://www.yoursite.com/modules.php?op=modload&name=The_Web_Ring&file=index
   
   where "modules.php?op=modload" is required as is, "&name=The_Web_Ring" is the
   directory name of the addon and "&file=index" declares the file name to access,
   without the .php extension. The extension will be added automaticaly.
   
Easy, no? Ok, if you need to link to a specified function to any file of your
addon, to the above URL just add:

    &switchname=name
    
So, if you declared a switch like:
    
    switch($func) {
	case "func-one":
	funct-one();
	break;    
    }
    
you will call it:
    
    http://www.yoursite.com/modules.php?op=modload&name=The_Web_Ring&file=index&func=func-one
    
if your function need to receive variables values, your switch will look like:
    
    switch($func) {
	case "func-one":
	funct-one($xid, $xname);
	break;    
    }
    
your link need to be:
    
    http://www.yoursite.com/modules.php?op=modload&name=The_Web_Ring&file=index&func=func-one&xid=$xid&xname=$xname

    If you need to use forms in your addon, use this method:
    
    <form action="modules.php?op=modload&name=Addon_Sample&file=index&func=function" method="post">
    ...
    </form>
    
but remember to not use reserved variables names like "name" and/or "file" and use a switch
variable different of "$op".
    
Hope that this rules are clear.
Another important note is that you need to know that modules system have
reserved variables, they are:

$name:  Used to declare the addon name
$file:  Used to declare the filename in use
$op:    Used for the modules.php switch
$index: Used to add or remove the right blocks
$modload: The call
$mod_active: Used to check modules' status

As an additional and interesting note, you can make that your addon show left
and right blocks by using the $index variable. At the begining of your file
just declare the varibale:

$index = 1;

If the value is "1" your addon will show the right blocks, if the value is "0"
will only show the left blocks, of course with the default or user selected
theme layout.

Remember that you can also use your own language translation file, called
for example lang-english.php so we can create language compatibility with
the rest of the site using the $language variable taken from config.php

Well, this was not a very big documentation but a basic one to let you start
using and/or making your addons/modules/plugins. Hope that you enjoy this new
feature of PHP-Nuke.

=============================================================================

NOTE: To stay under HTML 4.01 Transitional standard is very important that
you substitute all "&" characters in the URLs with "&amp;" tag. So, for
example, the URL:

    <a href="modules.php?op=modload&name=FAQ&file=index">

need to be written:

    <a href="modules.php?op=modload&amp;name=FAQ&amp;file=index">

without this, your pages will not validate as HTML 4.01 compatible.

=============================================================================

Have fun now!