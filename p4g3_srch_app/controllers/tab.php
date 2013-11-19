<?php
/**
Copyright 2013 Marina Ibrishimova | Contact: marina@ibrius.net

This file is part of Page Search.

    Page Search is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version. Cause I'm cool like that.

    Page Search is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE ESPECIALLY 
    THE FRONT END STUFF BUT THIS STUFF AS WELL. See the GNU Affero 
    General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with Page Search.  If not, see <http://www.gnu.org/licenses/>.
**/
class Tab extends CI_controller
{
	function __construct()
	{
		parent::__construct('tab');	  
	}
	function index()
	{
		$fb_data = $this->session->userdata('fb_data');		
				
		$data = array(
			'fb_data' => $fb_data,
			);
 		
		$signed_request = $fb_data['signedRequest'];				
		$page = $signed_request['page'];
		$page_id = $data['id'] = $page['id'];
		$liked = $page['liked'];		
		$data['fb_id']= $fb_data['uid'];
		$page_name = 'test';	
	
		if($page_id)
		{	
		    $data['has_donate'] = ''; 
		    $data['name'] = '';
 
			$this->load->view('create', $data); 			        				 
		}
		else
		{
			$error = $this->lang->line('common_error_general');
			$data = array(
					'error' => $error,
					'page_id' => $page_id,
					);
			$this->load->view('tab_error', $data);
		}		
	 
	}
	
 
	function search() 
	{
  
		$page_id = htmlentities($this->input->post('id'), ENT_QUOTES, 'UTF-8');
		$string = htmlentities($this->input->post('string'), ENT_QUOTES, 'UTF-8');
		$exactime = htmlentities($this->input->post('exactime'), ENT_QUOTES, 'UTF-8');
		$limit = htmlentities($this->input->post('limit'), ENT_QUOTES, 'UTF-8');
		$data['method'] = htmlentities($this->input->post('method'), ENT_QUOTES, 'UTF-8');
		$data['has_donate'] = htmlentities($this->input->post('has_donate'), ENT_QUOTES, 'UTF-8'); 
		$data['name'] = htmlentities($this->input->post('name'), ENT_QUOTES, 'UTF-8');
	
		if($page_id)
		{
		       
		        $fb_config = $this->config->item('fb_config');
		        $app_id = $fb_config['appId'];
			$app_secret = $fb_config['secret'];
		
    			$app_token_url = "https://graph.facebook.com/oauth/access_token?"
        		. "client_id=" . $app_id
        		. "&client_secret=" . $app_secret 
       			 . "&grant_type=client_credentials";

			$app_token = file_get_contents($app_token_url);
			
        		if($app_token)
        		{
        			$params = null;
    				parse_str($app_token, $params);
    			 
    				if($limit === '200')
    				{
		        		$respon = "https://graph.facebook.com/".$page_id."/feed?access_token=".$params['access_token']."&limit=50&".$exactime."&fields=id,name,message,description,comments";
		        		$comments = '0';
		        	}
		        	else
		        	{
		        		$respon = "https://graph.facebook.com/".$page_id."/feed?access_token=".$params['access_token']."&limit=50&".$exactime."&fields=id,name,message,description";
		        		$comments = '0';
		        	}
    		        
 		        	$msgs = search_deep($respon, $string, 1, $page_id);

				$data['msgs'] = implode($msgs['result']);
    				$data['string'] = $string;
				$data['id'] = $page_id;
   	    	        	$data['is_admin'] = $admin; 
				$data['paging'] = $msgs['paging'];
				$data['exactime'] = $exactime;
			 
				$this->load->view("search_again", $data);
			}
			else
			{
				$error = "Unable to fetch results at this point. ";
				$data = array(
					'error' => $error,
					);
 				$this->load->view('tab_error', $data);
			}
		 	  
		}
		else
		{
			$error = $this->lang->line('common_error_general');
			$data = array(
					'error' => $error,
					);
 			$this->load->view('tab_error', $data);
		}
	}
	
	function paging()
	{
          	 
          	$string = htmlentities($this->input->post('string'), ENT_QUOTES, 'UTF-8');
 	  		$page_id = htmlentities($this->input->post('page_id'), ENT_QUOTES, 'UTF-8');
 	  		$respon = filter_var($this->input->post('nextr'), FILTER_SANITIZE_URL);
          	 		 
          	$br = search_deep($respon, $string, 1, $page_id);
          	$msgs['res'] = implode($br['result']);	
          	$msgs['nextr'] = $br['paging']['next'];
          	echo json_encode($msgs);       		 
	}
 	
}		