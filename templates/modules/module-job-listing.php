<?php
/* This module is responsible for rendering the 'Job Listing' component.
 *
 * The values needed comes from Custom Fields defined within the post.
 *
 * The $postID variable comes from the Template Custom which renders the Module content.
 */
?>
<div class="row job-listing">
	<div class="content">
		<div class="col-xs-12 filter-nav filters">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-md-5 header">
						<h1 class="main-title">Open Positions</h1>
					</div>
					<div class="col-xs-12 col-md-7 options">
						<div class="dropdown department">
					      	<button data-type="all departments" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Departments</button>
				          	<ul class="dropdown-menu" data-simplebar-direction="vertical"></ul>
						</div>
						<div class="dropdown location">
					      	<button data-type="all locations" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Locations</button>
				          	<ul class="dropdown-menu" data-simplebar-direction="vertical"></ul>
						</div>
						<br/ class="hidden-md hidden-lg">
						<span class="reset">Reset</span>
					</div>								
				</div>
			</div>
		</div>
		<div class="col-xs-12 jobs loading">
			<div class="container">
				<div class="row">
					<table class="table table-striped jobs-table">
						<tbody></tbody>
					</table>
					<div class="table-nav">
						<i class="glyphicon glyphicon-menu-left prev-page"></i>
						<div class="pages"></div>
						<i class="glyphicon glyphicon-menu-right next-page"></i>	
					</div>
				</div>
			</div>
			<?php render_component("loader"); ?>
			<script class="job-template" type="text/x-handlebars-template">
			{{#each this}}
			<tr data-id="{{id}}" class="job">
				<td class="data title">{{title}}</td>
				<td class="data department">{{category}}</td>
				<td class="data location">{{location}}</td>
				<td class="hidden data description">{{{description}}}</td>
				<td class="hidden data apply">http://jobs.jobvite.com/careers/undertone/job/{{id}}</td><!-- {{apply-url}} -->
			</tr>
			{{/each}}
	  		</script>
		</div>
	</div>
</div>
<script>
    $(document).ready(function () {
        app.modules.jobListing.init(".information", ".job-description", ".apply", ".back", "#apply-job", 25);
    });
</script>