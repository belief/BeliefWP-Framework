##BELIEF_THEME_TEMPLATE

###General Info

This is the template Theme for Wordpress by Belief. This current theme is designed under Wordpress version 3.9.2. There are a few vendor projects included in this template, and for the most part the dependancies are listed through gulp, etc.

###Before Install:
1. Run script to replace all occurrences of "BELIEF_THEME_TEMPLATE" to "Client_name". Use underscore and Front Caps.
2. Run script to replace all occurrences of "belief_theme_slug" to "client_slug". Use underscore and all lowercase.
3.  Run script to replace all occurrences of "Belief_Theme_Classes" to "Client_Classes". Use underscore and all Front Caps.
1. Run script to replace all occurrences of "BELIEF_THEME_TITLE" to "Client Name". Use display preferences.

For Gulp:
	1. ensure npm is installed.
	2. npm install (sudo may be required)
	3. gulp

###A few frameworks to be aware of:

- http://www.billerickson.net/wordpress-metaboxes/
- 

###If Running Gulp and running into gulp-scss-lint error, change the following code:

```
#line 49:
if (error && error.code !== 65) {

#to:
if (error && error.code !== 65 && error.code !== 1 && error.code !== 2) {

```