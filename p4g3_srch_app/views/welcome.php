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
$string = $fb_data['login_url'];
$findme='tabs_added';
$found = strpos($string, $findme);

$app_id = $fb_data['app_id'];
$app_uri = $fb_data['url'];

if($found !== false)
{
	$start = '5B';

	$first = strstr($string, $start);
	$second = strstr($first, '%');
 
	$findmeag='%';

	//we now need first occurance of %
	$pos = strpos($first, $findmeag);
 
	$repl =  substr_replace($first,'',$pos);

	$final = substr_replace($repl,'',0, 2);	
 
	$redirect_url = "https://facebook.com/pages/page_name/".$final."?sk=app_".$app_id."";
	echo "<script>top.location.href=\"".$redirect_url."\"</script>";

}
else
{
	$this->load->view('partial/header_canvas');
 	
	echo "<h1>".$this->lang->line('common_welcome_tab_app')."</h1>";
	echo "<p>".$this->lang->line('common_welcome_message')."</p>";
	echo "<form name=\"contact\" method=\"post\" id=\"add_to_page_form\" style=\"display:none;\"
	 action=\"https://www.facebook.com/dialog/pagetab?app_id=".$app_id."&display=page&redirect_uri=".$app_uri."\"
	  target=\"_top\">
	 <input type=\"hidden\" name=\"added\" value=\"Added\"> 
	 <input type=\"submit\" id=\"welcome\" name=\"submit\" value=\"Add To Your Page\">
	 </form>
	 <input type=\"submit\" id=\"login_link\" value=\"Go To App\" style=\"display:none;\"/>
	 </div>";
?>


<div class="wrapper">
<div class ="texter">
<a href="https://facebook.com/ibrius" target="_blank"><?php echo $this->lang->line('common_developed_by');?> Ibrius</a>
<a href="#" class="fright" style="margin-left:10px;" id="PrivPolicyLink"><?php echo $this->lang->line('common_privacy_policy');?></a><a href="#" class="fright">|</a>
<a href="#" class="fright" style="margin-right:10px;" id="TermsOfUseLink"><?php echo $this->lang->line('common_terms_of_use');?></a>
</div></div>

<table>
  <tr>
    <td style="width:345px">
      <div class="hidden" id="TermsOfUse">
 <h3>Terms Of Use</h3>
    
     </div>
   </td>
   <td style="width:345px">
     <div class="hidden" id="PrivPolicy">
 <h3>Privacy Policy</h3>
 
     </div>
   </td>
 </tr>
</table>

<script>
    $('#PrivPolicyLink').click(function() {
  $('#PrivPolicy').slideToggle('slow');
    // Animation complete.
  });
     $('#TermsOfUseLink').click(function() {
  $('#TermsOfUse').slideToggle('slow');
    // Animation complete.
  });
</script>

<div id="fb-root"></div>
<script src="https://connect.facebook.net/en_US/all.js"></script>
<script>
    FB.init({
      appId      : '<?php echo $app_id; ?>',
      channel    : '//www.ibrius.com/channel.html',
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });


  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));

 FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
    $('#login_link').hide();
    $('#add_to_page_form').show();
  } else if (response.status === 'not_authorized') {
    $('#login_link').show();
    $('#add_to_page_form').hide();
  } else {
    $('#login_link').show();
    $('#add_to_page_form').hide();
  }
 });
 
$('#login_link').click(function() {
 FB.login(function(response) {
   if (response.authResponse) {
     $('#login_link').hide();
     $('#add_to_page_form').show();
   } else {
     console.log('User cancelled login or did not fully authorize.');
   }
 });
});
</script>

<?php $this->load->view('partial/footercanvas');
}