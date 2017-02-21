<?php

use Roots\Sage\Config;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if lt IE 9]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>
    <div class="wrap container-fluid" role="document">
      <div class="content">
        <main class="main" role="main">
          <?php  
            $extraTopSpace = get_field("extra_top_space");
            $extraTopStyles = "";

            if($extraTopSpace){
              $extraTopSpaceColor = get_field("extra_top_space_color");

              if($extraTopSpaceColor){
                $extraTopStyles = "background-color:".$extraTopSpaceColor.";";
                echo "<div class='row extra-top-space' style='".$extraTopStyles."'></div>";
              }
            }
            $path = $_SERVER['REQUEST_URI'];
            $path = explode('/', $path);
            if(in_array("date", $path)){
               get_template_part('index');
            }else{
              include Wrapper\template_path(); 
            }
            
          ?>
        </main><!-- /.main -->
        <!--<?php if (Config\display_sidebar()) : ?>
          <aside class="sidebar" role="complementary">
            <?php include Wrapper\sidebar_path(); ?>
          </aside>
        <?php endif; ?>-->
      </div><!-- /.content -->
    </div><!-- /.wrap -->
    <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>
    <?php 
      $addHbsp = false;
      $uri = $_SERVER['REQUEST_URI'];
      if (strpos($uri,'opt-out') === false) {
          $addHbsp = true;
      }
      if($addHbsp){
    ?>
      <!-- Start of Async HubSpot Analytics Code -->
      <script type="text/javascript">
      (function(d,s,i,r) {
      if (d.getElementById(i)){return;}
      var n=d.createElement(s),e=d.getElementsByTagName(s)[0];
      n.id=i;n.src='//js.hs-analytics.net/analytics/'+(Math.ceil(new Date()/r)*r)+'/388551.js';
      e.parentNode.insertBefore(n, e);
      })(document,"script","hs-analytics",300000);
      </script>
      <!-- End of Async HubSpot Analytics Code -->
    <?php } ?>
  </body>
</html>
