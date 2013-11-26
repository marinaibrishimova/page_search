<?php
/**
Copyright 2013 Marina Ibrishimova | Contact: marina@ibrius.net

This file is part of Page Search.

    Page Search is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Page Search is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with Page Search.  If not, see <http://www.gnu.org/licenses/>.
**/

function print_nice_r($arr) 
{
	?><pre><?
	print_r($arr);
	?></pre><?
}

function objectToArray($obj) 
{
	if (is_object($obj)) $obj = get_object_vars($obj);
	if (is_array($obj)) return array_map(__FUNCTION__, $obj);
	else return $obj;	
}
	
function searchDeeper($array, $string, $key, $id, $name, $desc, $page_id)
{
    	if(is_object($array)) $array = (array)$array;
 
    	$result = array();
    	foreach ($array as $k => $value) { 
        	if(is_array($value) || is_object($value))
        	{
            		$r = searchDeeper($value, $string, $key, $id, $name, $desc, $page_id);
            		if(!is_null($r))
                	array_push($result,$r);
        	
        	}
    	}
    
    	if(array_key_exists($id, $array))
   	{
    		$post = strstr($array[$id], '_');
       		$post = ltrim($post, "_");
       		$page = strstr($array[$id], '_', true);
         
    		if(!empty($page))
    		{
    	
    			if($page_id != $page)
    			{
    				$source = "<br>
    				<a href=\"https://www.facebook.com/".$page."\" target=\"_blank\" title=\"Read, like, or comment on this post.\" >Read Post</a><br><br>";
    			}
    			else
    			{ 
    				$source = "<br>
    				<a href=\"https://www.facebook.com/".$page."/posts/".$post."\" target=\"_blank\" title=\"Read, like, or comment on this post.\" >Read Post</a>
    				<br><br>";
    			} 
    	
    			if(array_key_exists($key, $array) && stripos($array[$key], $string) !== false)
    			{
    				$fin = $array[$key] . $source;
       				$result[] = $fin;
       			}
       			if(array_key_exists($name, $array) && stripos($array[$name], $string) !== false)
       			{
          			$finr = $array[$name] . $source; 
       	  			$result[] = $finr;
        		}  
        		if(array_key_exists($desc, $array) && stripos($array[$desc], $string) !== false)
        		{ 
          			$finst = $array[$desc] . $source;
       	  			$result[] = $finst;   
       			} 
        }
    }
    
	if(count($result) > 0){

        	$result_plain = array();
        	foreach ($result as $k => $value)
        	{ 
            		if(is_array($value))
                	$result_plain = array_merge($result_plain,$value);
            		else
                	array_push($result_plain,$value);
        	}
        return $result_plain;
    }
    return NULL;
}

function search_deep($results, $string, $trial, $page_id)
{
	 
        $all_posts  = file_get_contents($results);	 
    	$all_posts = json_decode($all_posts);	 
    	$all_posts = objectToArray($all_posts);

    	$msgs = array(); 
    	$deeper = "yes";
    	$msgs['result'] = searchDeeper($all_posts, $string, "message", "id", "name", "description", $page_id);
    		  
    	if(!is_null($msgs['result']) || $trial === 4)
    	{		
    		 $msgs['paging'] = $all_posts['paging']; 	
    		 return $msgs;
	}
	else if (!is_null($all_posts['paging']['next']))
	{		
		 $trial = $trial + 1;
		 return search_deep($all_posts['paging']['next'], $string, $trial, $page_id);
	}
			
	return NULL;			 
}

function ascraper($website, $string)
{
	//future sec measures below, lots of work for now
	//if(filter_var($website, FILTER_VALIDATE_URL))
    	//{
		//get home page and hope it contains all links  
		$home = file_get_contents($website);

		//put home page in dom tree and grab all As
		$doc = new DOMDocument();
		$doc->loadHTML($home);
		$doc->validateOnParse = true;
		$aaa = $doc->getElementsByTagName('a');
		$content_val = '';
		$contents = '';
		$result = array();
		 
		//assuming the home page contains all links to all other pages
		foreach ($aaa as $a)
		{
			$a_href = $a->getAttribute('href');
    			 
    			//if(filter_var($a_href, FILTER_VALIDATE_URL) && !empty($a_href) && imap_base64($a_href))
    			//{
    				//assuming every link has the same relative path 
    				$page = file_get_contents($a_href);
    				$dom = new DOMDocument();
				$dom->loadHTML($page);
				$dom->validateOnParse = true;
			
    				$content = $dom->getElementsByTagName('p');
    				foreach ($content as $c)
    				{
    					$content_val = nl2br($c->textContent);
    					if(stripos($content_val, $string) !== false)
					{ 
    						$source = "<br>
    				<a href=\"".$a_href."\" target=\"_blank\" title=\"Read this post.\" >Read Page</a>
    				<br><br>";
    						$contents = $content_val . $source;
    						array_push($result,$contents);
    						return $result;
    					}	
 				}
    			//} 
		}

		return false;
	/* }
	else
	{
		return false;
	}*/
}