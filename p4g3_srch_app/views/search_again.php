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

<?php echo form_open('tab/search', array('id'=>'search_now')); 

	$month = time() - (60*60*24*30); 
	$year = time() - (12*(60*60*24*30));
	$twoyear = time() - (24*(60*60*24*30)); 
	$tri = time() - (3*(60*60*24*30));
	$six = time() - (6*(60*60*24*30));
	$now = time();
	
  	echo "<input type=\"hidden\" name=\"has_donate\" value=".$has_donate." /><input type=\"hidden\" name=\"name\" value=".$name." /><input type=\"hidden\" name=\"id\" id=\"page_id\" value=".$id." />";
  	if(isset($string)){echo "<textarea name=\"string\" id=\"search\" style=\"height:22px;padding-top:7px;\" maxlength=\"250\" >".$string."</textarea> ";}
  	else {echo "<input type=\"text\" name=\"string\" value=\"\" id=\"search\" maxlength=\"250\" /> ";}
  	
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
  	</select>

  	<select name=\"method\">
  	<option value=\"exact\">Match exact phrase or word</option>
  	 
  	</select>"; ?>
  	
<?php echo form_close();
 
	echo "<br>".$msgs;
			
	if(array_key_exists('next', $paging) && !empty($paging['next']) && isset($msgs))
	{
		echo "<div class=\"inpt\">";
		echo "<input type=\"hidden\" id=\"nxt_val\" value=\"".$paging['next']." \"><div id=\"nextr\"
		 style=\"font-size:14px;text-decoration:underline;cursor:pointer;\">Show older posts</div>";
			//echo "<div id=\"nextr\">Next</div>";
		echo "</div>";
			
	}
	else if (!empty($paging['next']) && !isset($msgs))
	{
		 
		echo "<br><br><div class=\"inpt\">";
		echo "<b>Your query did not return any recent posts.</b>";
		echo " Toggle preferences for better results or ";
		echo "<input type=\"hidden\" id=\"nxt_val\" value=\"".$paging['next']." \">
		 <div id=\"nextr\"
		 style=\"font-size:14px;text-decoration:underline;cursor:pointer;display:inline;\"> search older posts</div>";
		 
		echo "</div>";
	}
?>
	
	<div id="more">
	 
	 				 
	<?php if(!isset($msgs) && empty($paging['next'])){echo "<h3>Your query did not return any results. Toggle preferences for better results. </h3>";} ?>
	<div id="donate" style="float:right;margin-top:-20px;">
	 <?php
			if ($has_donate == '1') { 
			//$name = str_replace(" ", "", $name);
			echo "<a href=\"https://www.facebook.com/".$name."/app_415675701824636\" target=\"_blank\"
			 style=\"font-size:14px;text-decoration:underline;cursor:pointer;color:#003399;\" >Donate to this page</a>"; } ?></div>
	</div>
</div>


<script>
$("body").on("click", "#nextr", function() {
 
 var string = "<?php echo $string; ?>";
 var nextr = $('#nxt_val').val(); 
 var page_id = "<?php echo $id; ?>"; 
 console.log(nextr);
 console.log(page_id);
 $.post('<?php echo base_url(); ?>index.php/tab/paging', {nextr: nextr, string: string, page_id: page_id},
        function(result) {
           console.log(result);
           
           $('.inpt').remove();
          
            $(document.createElement('div')).addClass('inpt').appendTo('#search_fm');
           if(result.nextr !== null) {
              $('.inpt').append('<input type="hidden" id="nxt_val" value="' + result.nextr + '" ><a href="#" id="nextr" >Older Posts</a>');
           } else {
              $('.inpt').append('<input type="hidden" id="nxt_val" value="' + result.nextr + '" ><span >Sorry, no more posts found.</a>');
           }
          // $(result.res).each(function ( index, rest) {
   	   $('#more').append(result.res); 
   	  // });
   		 
           }, 'json');
           $('#nextr').unbind('click');
           return false;
           });
         
</script>         
  
<div id="loading_top" style="display:none; position:absolute; height:20px; width:100%; top:100px; left:0px; text-align:center;">
   <p style="display:inline-block; margin:0px auto;"><img src="<?php echo base_url(); ?>images/loading.gif"/></p>
</div>
<div id="loading" style="display:none; position:absolute; height:20px; width:100%; bottom:20px; left:0px; text-align:center;">
   <p style="display:inline-block; margin:0px auto;"><img src="<?php echo base_url(); ?>images/loading.gif"/></p>
</div>
<script>
$(document).ajaxStart(function() {
   $('#loading').show(); console.log('started');
});
$(document).ajaxStop(function() {
   $('#loading').hide();
});
$('#search_now').submit(function() {
      $('#loading_top').show()
   });
</script>
</body>
</html>