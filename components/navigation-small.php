<?php
/*
 * * Events:
 * For set the clear version nav ->   app.components.navigationSmall.getHeight();
 *
 * USAGE:
 * render_component("navigation-small");
 */
	$searchComponentID = "search-".uniqid();
  $languageSelectorID = "langSelector-".uniqid();
  $lang = \Roots\Sage\Utils\wpml_current_lang();
?>

<div id="navigationDivSmall">
  <a class="brand" href="<?= esc_url(home_url('/')); ?>"></a>
  <button class="collapse-button"></button>
  <div class="menu-container">
  	<?php if (has_nav_menu( 'primary_navigation')) : wp_nav_menu(array( 'theme_location'=> 'primary_navigation', 'menu_class' => 'navigation-bar')); endif; ?>
  	<?php render_component("language-selector", array("id"=>$languageSelectorID, "smallVersion"=>true)); ?>
    <button class="<?php echo ICL_LANGUAGE_CODE; ?> language-button"><?php echo $lang['tag']; ?></button>
  </div>
</div>
<?php render_component("search", array("smallVersion"=>true,"id"=>$searchComponentID)); ?>
<script>
  $('document').ready(function() {
    app.components.navigationSmall.init("<?php echo $searchComponentID; ?>","<?php echo $languageSelectorID; ?>");
  });
</script>