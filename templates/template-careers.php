<?php
/**
 * Template Name: Careers Openings
 */
?>

<div class="careers-openings">
  
  <div class="information">
  <?php
  if( have_rows('modules_list') ):
      while ( have_rows('modules_list') ) : the_row();
         $postID = get_sub_field('module');
         get_template_part('single', 'module');
      endwhile;
  else :
  endif;
  ?>
  </div>

  <div class="job-description">
    <div class="row">
      <div class="col-xs-12">
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <h1 class="main-title"><span class="title"></span> (<span class="department"></span>)</h1>
              <h4 class="location"></h4>
              <?php render_component("social-sharing", array("","","","")); ?>
              <div class="description"></div>
              <div class="buttons">
                <a href="#" id="" class="btn btn-default back text-center">Back To List</a>
                <a href="#" id="" class="btn btn-default apply text-center" data-toggle="modal" data-target="#apply-job">Apply Now</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Apply Modal -->
  <div class="modal fade" id="apply-job" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <iframe class="job-source" src=""></iframe>
        </div>
      </div>
    </div>
  </div>
  
</div>
