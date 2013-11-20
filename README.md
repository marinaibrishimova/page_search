Copy, right? 2013 Marina Ibrishimova | Contact: marina@ibrius.net

This file is part of Page Search.

    Page Search is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any version, really. Cause I'm cool like that.

    Page Search is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE ESPECIALLY 
    THE FRONT END.  See the GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with Page Search.  If not, see <http://www.gnu.org/licenses/>.


INSTRUCTIONS:

To get started, you'll need to create an app on Facebook 

After this, you'll need to modify the following 2 files:

	1.	p4g3_srch_app/config/config.php -> specify base url
	2.	p4g3_srch_app/config/facebook.php -> add your FB app credentials

That's it! You can optionally move p4g3_srch_app & p4g3_srch_sys above the web root for bonus security but then you'll need to change the path to these 2 folders in public/index.php 

Note: This works well for pages with a small number of posts and it does not break for pages with tons of posts but since it only searches for a match within a particular timeframe, the user is required to keep pressing the Older Posts button until it either finds a match or it doesn't, in which case it will say so.   

Also note: Currently there's no fancy "Did you mean" spellchecker but that could easily be modified by slapping a levenshtein() while searching recursively. 

The key controllers are: 

p4g3_srch_app/controllers/welcome.php   ---  canvas - default landing page

p4g3_srch_app/controllers/tab.php       ---  tab - everything that goes after installing app to page

Key models:

this app doesn't talk to a database so no need for models, ye

Key view files:

p4g3_srch_app/views/welcome.php 	--- landing canvas view
p4g3_srch_app/views/create.php 		--- landing tab view

Key helper:

p4g3_srch_app/helpers/facebook_helper.php --- where all search functions are at

DEMO:
https://apps.facebook.com/post-finder
https://www.facebook.com/ibrius/app_384295561652134
