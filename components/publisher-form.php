<?php
/* Publisher Form Component.
 *
 * USAGE:
 * render_component("publisher-form");
 */
?>

<div class="row publisher">
	<div class="col-xs-12">
		<div class="container">
			<form class="publisher-form simple-form">				
				<div class="row">
					<div class="modal fade" id="publisher-form-success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
					</div>
					<div class="form-group col-xs-12 col-sm-12" style="height: auto;">
			  			<section class="dark-text">
			  			  	<h1 class="main-title">Contact Us</h1>
			  				<div class="copy">We partner with the best of the best. Interested in working with us? Get in touch.</div>
			          	</section>
					</div>
					<div class="form-group col-xs-12 col-sm-6">
			    		<label class="input-label">First Name</label>
			    		<input type="text" class="step form-control" name="firstName">
			    		<span class="response-required">*</span>
			  		</div>
			  		<div class="form-group col-xs-12 col-sm-6">
			    		<label class="input-label">Last Name</label>
			    		<input type="text" class="step form-control" name="lastName">
			    		<span class="response-required">*</span>
			  		</div>
			  		<div class="form-group col-xs-12 col-sm-6">
			    		<label class="input-label">Email Address</label>
			    		<input type="text" class="step form-control" name="email">
						<span class="response-required">*</span>
						<span class="response-caption bigger">(@)</span>	
			  		</div>
			  		<div class="form-group col-xs-12 col-sm-6">
			    		<label class="input-label">Phone Number</label>
			    		<input type="text" title="Example: 000-000-0000" class="step form-control" name="phoneNumber">
    					<span class="response-required">*</span>
						<span class="response-caption bigger">(#)</span>
			  		</div>
			  		<div class="form-group col-xs-12">
			  			<label class="input-label">Monthly Unique Traffic (choose one):</label>
						<label class="radio-inline">
							<input type="radio" name="montlyTraffic" value="<250,000"  checked="checked" > <span>250,000</span>
						</label>
						<label class="radio-inline">
							<input type="radio" name="montlyTraffic" value="250,000 - 500,000" > <span>250,000-500,000</span>
						</label>
						<label class="radio-inline">
							<input type="radio" name="montlyTraffic" value="500,000 - 1M" > <span>500,000-1M</span>
						</label>
						<label class="radio-inline">
							<input type="radio" name="montlyTraffic" value="1M - 5M" > <span>1M-5M</span>
						</label>
						<label class="radio-inline">
							<input type="radio" name="montlyTraffic" value="5M+" > <span>5M+</span>
						</label>
			  		</div>
			  		<div class="form-group col-xs-12">
			  			<label class="input-label">Inventory Type (choose one):</label>
						<label class="radio-inline">
							<input type="radio" name="inventoryType" value="Owned and Operated Site" checked="checked" > <span>Owned and Operated Site</span>
						</label>
						<label class="radio-inline">
							<input type="radio" name="inventoryType" value="Site Representation" > <span>Site Representation</span>
						</label>
						<label class="radio-inline">
							<input type="radio" name="inventoryType" value="Other" > <span>Other</span>
						</label>
			  		</div>
			  		<div class="form-group col-xs-12">
			  			<label class="input-label">Available Inventory (can select multiple):</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="availableInventory" value="Mobile Web"><span>Mobile Web</span>
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="availableInventory" value="Mobile App"> <span>Mobile App</span>
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="availableInventory" value="Tablet"> <span>Tablet</span>
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="availableInventory" value="Desktop"> <span>Desktop</span>
						</label>
			  		</div>
			  		<div class="col-xs-12">
						<div class="message-container">
							<p class="message-intro">How are you interested in working with us?</p>
							<textarea tabindex="-1" name="message" class="step message" rows="5"></textarea>
							<span class="response-required text-response">*</span>
						</div>
			  		</div>
			  		<div class="form-group col-xs-12 col-sm-12">
			    		<label class="input-label">Publisher URL</label>
			    		<input type="text" title="Example: http://www.google.com" class="step form-control" name="website">
    					<span class="response-required">*</span>						
			  		</div>
			  		<div class="col-xs-12 submit-input">
			  			<input class="btn btn-gray btn-default submit-publisher" type="submit" value="submit">
			  		</div>
		  		</div>
			</form>

			<div class="hbspt-form"></div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
	<?php  if (ICL_LANGUAGE_CODE == 'de') { ?>
		app.components.publisherForm.init('#hsForm_c3995fec-e2ce-40d7-8d5b-f0244492a125');
		hbspt.forms.create({ 
			portalId: '388551',
			formId: 'c3995fec-e2ce-40d7-8d5b-f0244492a125',
			target: '.hbspt-form'
		});
	<?php }else if(ICL_LANGUAGE_CODE == 'en-uk'){ ?>
		app.components.publisherForm.init('#hsForm_6b76ae0e-97f8-4b9a-acd8-698d5ae216b8');
		hbspt.forms.create({ 
			portalId: '388551',
			formId: '6b76ae0e-97f8-4b9a-acd8-698d5ae216b8',
			target: '.hbspt-form'
		}); 

	<?php }else{ ?> //USA FORM
		app.components.publisherForm.init('#hsForm_2e6bdfa0-f0d3-4d45-a9bb-1d22c3d4d129');
		hbspt.forms.create({ 
			portalId: '388551',
			formId: '2e6bdfa0-f0d3-4d45-a9bb-1d22c3d4d129',
			target: '.hbspt-form'
		});
	<?php } ?>
	});
</script>
