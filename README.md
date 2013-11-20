
Copy, right? 2013 Marina Ibrishimova | Contact: marina@ibrius.net

This file is part of Page Search.

    Page Search is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version. Cause I'm cool like that.

    Page Search is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE ESPECIALLY 
    THE FRONT END STUFF BUT THIS STUFF AS WELL.  See the GNU Affero 
    General Public License for more details.

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

