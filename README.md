MSMSAA Website
--------------

These are the files used to create the website of the [Mississippi
School for Mathematics and Science Alumni Association](http://www.msmsaa.org). 
The files on the web server are in the \_site directory.  These files
use [Bootstrap](http://getbootstrap.com/) classes in order 
to create a more mobile friendly user experience.  

The template files in the \_source directory are processed using 
[Jekyll](http://jekyllrb.com/) to build the \_site 
directory.  Jekyll knows to use \_source to build \_site because of
the information in \_config.yml.  Running "jekyll build" from the 
directory containing \_config.yml builds a new set of \_site files.

Changes to the website should be made in \_source so they are not lost
in future revisions.

##To do
* Create bylaws.html
* Create Thank you page generated by newacct.html
* Create forgot-password.html
* Fix the newsletter, map, photo, and memorial directories
