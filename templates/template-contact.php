<?php
/**
 * Template Name: Contact Form Page
 */

global $sitepress;
$advertising = get_field('advertising');
$brand       = get_field('brand_opportunities');
$publisher   = get_field('publisher_opportunities');
$work        = get_field('working_at_undertone');
$press       = get_field('press_and_media_questions');
$notSure     = get_field('not_sure');

?>

<div class="contact-page row">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<form class="contact-form" autocomplete="off">
					<div class="form-section">
						<p class="main-title">Hi, Let's Chat</p>
						<p class="form-note">NOTE: If you are a consumer looking for more information on an ad that you were served by Undertone, <a href="<?php echo $sitepress->language_url(ICL_LANGUAGE_CODE); ?>opt-out-tool">click here</a>.</p>
					</div>
					<div class="form-section step-1">
						<p class="secondary-title before-inputs">Tell us about yourself:</p>
						<div class="form-group">
							<p class="form-sentence">
								<span>My name is </span>
								<span class="response-container">
									<input type="text" name="firstname" class="step form-control">
									<span class="response-required">*</span>
									<span class="response-caption">(first name)</span>									
								</span>
								<span> </span>
								<span class="response-container">
									<input type="text" name="lastname" class="step form-control">
									<span class="response-required">*</span>
									<span class="response-caption">(last name)</span>									
								</span>
								<span>.</span>
								<span> I'm the</span>
								<span class="response-container">
									<input type="text" name="title" class="step form-control">
									<span class="response-required">*</span>
									<span class="response-caption">(title)</span>									
								</span>
								<span> at </span>
								<span class="response-container">
									<input type="text" name="company" class="step form-control">
									<span class="response-required">*</span>
									<span class="response-caption">(company)</span>									
								</span>
								<span>.</span>
							</p>
							<p class="form-sentence">
								<span>Email me at </span>
								<span class="response-container">
									<input type="text" name="email" class="step form-control">
									<span class="response-required">*</span>
									<span class="response-caption bigger">(@)</span>									
								</span>
								<span> and/or call me at </span>
								<span class="response-container">
									<input type="text" name="phone" class="step form-control">
									<span class="response-required">*</span>
									<span class="response-caption bigger">(#)</span>								
								</span>
								<span>.</span>
							</p>
						</div>
						<!--<div class="next-step next-step-2 disabled"></div>-->						
					</div>
					<div class="form-section disabled-section step-2">
						<p class="secondary-title">Select the topic(s) you are interested in: <span class="response-required">*</span></p>
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-4 interest disabled" data-theme="Advertising">			
								<div class="wrapper">
									<div class="option-container">
										<img src="<?php echo $advertising ?>" alt="Advertising" class="option img-responsive">
									</div>
									<div class="circle-highlight"></div>
									<p class="theme">Advertising</p>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4 interest disabled" data-theme="Brand Opportunities">			
								<div class="wrapper">
									<div class="option-container">
										<img src="<?php echo $brand ?>" alt="Brand opportunities" class="option img-responsive">
									</div>
									<div class="circle-highlight"></div>
									<p class="theme">Brand Opportunities</p>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4 interest disabled" data-theme="Publisher Opportunities">
								<div class="wrapper">
									<div class="option-container">
										<img src="<?php echo $publisher ?>" alt="Publisher opportunities" class="option img-responsive">
									</div>
									<div class="circle-highlight"></div>
									<p class="theme">Publisher Opportunities</p>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4 interest disabled" data-theme="Working at Undertone">			
								<div class="wrapper">
									<div class="option-container">
										<img src="<?php echo $work ?>" alt="Working at Undertone" class="option img-responsive">
									</div>
									<div class="circle-highlight"></div>
									<p class="theme">Working at Undertone</p>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4 interest disabled" data-theme="Press and Media Questions">
								<div class="wrapper">
									<div class="option-container">
										<img src="<?php echo $press ?>" alt="Press and media questions" class="option img-responsive">
									</div>
									<div class="circle-highlight"></div>
									<p class="theme">Press + Media Questions</p>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4 interest disabled" data-theme="...I'm not sure">
								<div class="wrapper">
									<div class="option-container">
										<img src="<?php echo $notSure ?>" alt="..I'm not sure" class="option img-responsive">
									</div>
									<div class="circle-highlight"></div>
									<p class="theme">...I'm not sure</p> 
								</div>                               
							</div>                             
						</div> 
						<!--<div class="next-step next-step-3 disabled"></div>-->	                            
					</div>                                
					<div class="form-section disabled-section step-3">                                
						<p class="secondary-title">Last but not least:</p>
						<div class="form-group">
							<p class="form-sentence">
								<span class="heard-about">I heard about Undertone from </span>
								<span class="response-container">
									<input tabindex="-1" type="text" name="heard" class="step form-control disabled" disabled>	
									<span class="response-required">*</span>
								</span>
							</p>
							<div class="message-container">
								<p class="message-intro">Your message:</p>
								<textarea tabindex="-1" name="message" class="message disabled" rows="5" disabled></textarea>
								<span class="response-required">*</span>
							</div>
		      				<!-- <div class="checkbox-container">
								<input type="checkbox" class="newsletter" name="newsletter" disabled> 
								<p class="legend">Sign-Up for our Updates</p>
							</div> -->
							<div class="col-xs-12 col-sm-12" style="text-align: center;">
								<br>
								<div id="recaptcha1" class="recaptcha"></div>
							</div>
					      	<input type="submit" tabindex="-1" class="submit-contact btn btn-gray btn-default disabled" value="Submit">
						</div>						
					</div>
				</form>
				<div class="hbspt-form-contact"></div>
			</div>
		</div>
	</div>
</div>
<!-- <div class="modal fade" id="contact-success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Message Sent</h4>
			</div>
			<div class="modal-body">
				<div class="control-group row">
					<div class="col-xs-12 col-sm-12 sucess-message-form">
						<h3 style="text-align: center;">Thank you! Your information has been submitted.</h3>
						<p class="final-message"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> -->

<!-- New Form -->
<div style="display: none;">
<form id="salesForce-Contact" action="<?php the_permalink(); ?>" method="POST">

<input type=hidden name="oid" value="00D300000000bzX">
<input type=hidden name="retURL" value="http://">
<input  id="lead_source" name="lead_source" type="hidden" value="Contact Us Form" />

<!-- Debug 
<input type="hidden" name="debug" value=1>
<input type="hidden" name="debugEmail" value="jcampanioni@undertone.com"> -->

<label for="first_name">First Name</label><input id="first_name" maxlength="40" name="first_name" size="20" type="text" class="sfinput" /><br>

<label for="last_name">Last Name</label><input id="last_name" maxlength="80" name="last_name" size="20" type="text" class="sfinput" /><br>

<label for="title">Title</label><input id="title" maxlength="40" name="title" size="20" type="text" class="sfinput" /><br>

<label for="company">Company</label><input id="company" maxlength="40" name="company" size="20" type="text" class="sfinput" /><br>

<label for="email">Email</label><input id="email" maxlength="80" name="email" size="20" type="text" class="sfinput" /><br>

<label for="phone">Phone</label><input id="phone" maxlength="40" name="phone" size="20" type="text" class="sfinput" /><br>

Tell us what you are interested in:<select id="00N1300000B4uTV" multiple="multiple" name="00N1300000B4uTV" title="Tell us what you are interested in" class="sfinput"><option value="Advertising">Advertising</option>
<option value="Brand Opportunities">Brand Opportunities</option>
<option value="Publisher Opportunities">Publisher Opportunities</option>
<option value="Working at Undertone">Working at Undertone</option>
<option value="Press and Media Questions">Press and Media Questions</option>
<option value="...I&#39;m not sure">...I&#39;m not sure</option>
</select><br>

I heard about Undertone from:<input id="00N1300000B4qA5" maxlength="255" name="00N1300000B4qA5" size="20" type="text" class="sfinput" /><br>

Your message:<textarea id="00N1300000B4uTa" name="00N1300000B4uTa" rows="3" type="text" wrap="soft" class="sfinput"></textarea><br>

<input id="g-recaptcha-response-real" type=hidden name="g-recaptcha-response" value="">

<input type="hidden" name="formType" value="contact">

<input type="submit" name="Send">

</form>
</div>

<script>
	$(document).ready(function(){

		// Custom Code
		// $('#00N1300000B4uTV option[value="Brand Opportunities"]').attr('selected','selected');		
		
		<?php if (ICL_LANGUAGE_CODE == 'de') { ?>
			app.templates.contact.init('#salesForce-Contact', "<?php echo ICL_LANGUAGE_CODE; ?>");
			// hbspt.forms.create({
		 //      portalId: '388551',
		 //      formId: '9cf5070a-f31a-4d57-915b-3b3b870a6fb5',
		 //      target: '.hbspt-form-footer-complete'
		 //    });
		<?php }else if(ICL_LANGUAGE_CODE == 'en_uk'){ ?>
			app.templates.contact.init('#salesForce-Contact', "<?php echo ICL_LANGUAGE_CODE; ?>");
			// hbspt.forms.create({
		 //      portalId: '388551',
		 //      formId: 'cfe5b6da-8dbd-4a52-a3a2-36f8a428571c',
		 //      target: '.hbspt-form-footer-complete'
		 //    });  
		<?php }else{ ?> //USA FORM
			app.templates.contact.init('#salesForce-Contact', "<?php echo ICL_LANGUAGE_CODE; ?>");
			// hbspt.forms.create({ 
			//     portalId: '388551',
			//     formId: '95289d3d-9fd2-41f0-a9f9-5a90917a65ed',
			//     target: '.hbspt-form-contact'
			// }); 
		<?php } ?>

	});
</script>
