<?php
/* This component renders the social icons needed to share on social networks. 
 * 
 *
 * @param fb   -> Facebook link
 * @param tw   -> Twitter link
 * @param li   -> LinkedIn link
 * @param mail -> Mail Body    
 *
 * USAGE: <?php render_component("social-sharing",  array("fb"   => "link", 
 *														  "tw"   => "link",
 * 														  "li"   => "link",
 * 														  "mail" => "link")); ?>
 *
 *
 */

$fb    = $this->fb;
$tw    = $this->tw;
$li    = $this->li;
$mail  = $this->mail;

?>

<div class="social-sharing">
  	<ul class="nav navbar-nav">
	    <li><a class="facebook-share" target="_blank" onclick="javascript:window.open(this.href, ','_blank'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" href="<?php echo $fb ?>"><i class="icon icon-facebook"></i></a></li>
	    <li><a class="twitter-share" target="_blank" onclick="javascript:window.open(this.href, ''_blank', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" href="<?php echo $tw ?>"><i class="icon icon-twitter"></i></a></li>
	    <li><a class="linkedin-share" target="_blank" onclick="javascript:window.open(this.href, ''_blank', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" href="<?php echo $li ?>"><i class="icon icon-linkedin"></i></a></li>
	  	<li><a class="mail-share" target="_blank" onclick="javascript:window.open(this.href, ''_blank', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" href="<?php echo $mail ?>"><i class="icon icon-email"></i></a></li>
   	</ul>
</div>