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
$this->load->view("partial/header");?>
<div id="val_errors">
<?php echo validation_errors();?>
</div>
<div id="search_fm">
<?php echo form_open('tab/search', array('id'=>'search_now'));?>
    <?php 
	$month = time() - (60*60*24*30); 
	$year = time() - (12*(60*60*24*30));
	$twoyear = time() - (24*(60*60*24*30)); 
	$tri = time() - (3*(60*60*24*30));
	$six = time() - (6*(60*60*24*30));
	$now = time();
	
  echo "<input type=\"hidden\" name=\"id\" value=".$id." /><input type=\"hidden\" name=\"name\" value=".$name." />";
  echo "<input type=\"hidden\" name=\"has_donate\" value=".$has_donate." />";
  echo "<input type=\"text\" name=\"string\" value=\"\" id=\"search\" /> ";
  echo form_submit(array(
	'value' => 'Search Timeline',
	'name' =>'save',
	'id' =>'save')); 
   
  echo "<br><select name=\"exactime\">
  <option value=\"until=now\">Recent Posts</option>
  <option value=\"since=".$month."\">Past Month</option>
  <option value=\"since=".$tri."\">Past 3 Months</option>
  <option value=\"since=".$six."\">Past 6 Months</option>
  <option value=\"since=".$year."\" >Past 12 Months</option>
  <option value=\"until=".$year."\" >1 Year Ago</option>
  <option value=\"until=".$twoyear."\" >2 Years Ago</option> 
  </select>
  
  <select name=\"limit\">
  	<option value=\"200\">Include comments</option>
  	<option value=\"100\">Exclude comments</option>
  </select>"; 
  
  if(!empty($website)){echo " <select name=\"has_website\" style=\"background:#FBEFEF;font-weight:bold;\"><option value=\"".$website."\">Search Page Website As Well</option><option value=\"\">Do Not Search Website</option></select>";}?>
  	
  	
<?php echo form_close(); ?>
<div id="loading" style="display:none; position:absolute; height:20px; width:100%; top:100px; left:0px; text-align:center;">
   <p style="display:inline-block; margin:0px auto;"><img src="<?php echo base_url(); ?>images/loading.gif"/></p>
</div>
<script>
   $('#search_now').submit(function() {
      $('#loading').show()
   });
</script>

</div>
 
<?php $this->load->view("partial/footer");