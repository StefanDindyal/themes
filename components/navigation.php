<?php
/*
 * * Events:
 * For set the clear version nav ->   app.components.navigation.setClearNav();
 * For set the green version nav ->   app.components.navigation.setGreenNav();
 *
 * USAGE:
 * render_component("navigation");
 */

 $searchComponentID = "search-".uniqid();
 $languageSelectorID = "langSelector-".uniqid();
 $lang = \Roots\Sage\Utils\wpml_current_lang();
?>

<div class="navigationDiv">
  <div class="background-arrow">
    <div class="left"></div>
    <div class="arrow"></div>
    <div class="right"></div>
  </div>
  <a class="brand" href="<?= esc_url(home_url('/')); ?>"></a>
  <div class="menu-container">
    <?php if (has_nav_menu( 'primary_navigation')) : wp_nav_menu(array( 'theme_location'=> 'primary_navigation', 'menu_class' => 'navigation-bar')); endif; ?>
  </div>
  <div class="right-panel  text-right">
    <ul>
      <li>
        <button class="search-button"></button>
      </li>
      <?php if(ICL_LANGUAGE_CODE == 'en'){ ?>
        <li><button class="<?php echo ICL_LANGUAGE_CODE.' '; ?>language-button">US/CAN</button></li>
      <?php } else { ?>
        <li><button class="<?php echo ICL_LANGUAGE_CODE.' '; ?>language-button"><?php echo $lang['tag']; ?></button></li>
      <?php } ?>
    </ul>
  </div>
</div>
<?php render_component("page-blocker"); ?>
<?php render_component("search", array("smallVersion"=>false,"id"=>$searchComponentID)); ?>
<?php render_component("language-selector", array("smallVersion" => false, "id"=>$languageSelectorID)); ?>

<script>
  $('document').ready(function() {
    if(app.components.navigation){
      app.components.navigation.init("<?php echo $searchComponentID;?>","<?php echo $languageSelectorID;?>");
    }
  });
</script>
