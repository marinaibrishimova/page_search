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
//require_once ("secured_area.php");
class Welcome extends CI_controller
{
	function __construct()
	{
		parent::__construct('welcome');	  
	}
	function index()
	{
		$fb_data = $this->session->userdata('fb_data');
		$data = array('fb_data' => $fb_data,);		
		if($fb_data)
		{
		 	$this->load->view('welcome', $data);
		}	
		else
		{	$data['error'] = $this->lang->line('common_error_general');
			$this->load->view('tab_error', $data);
		}		
	}				
}		