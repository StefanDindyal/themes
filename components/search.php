<?php
/* Search Overlay Module.
 *
 * Events:
 * app.instances.SearchComponents["id"].open();
 * app.instances.SearchComponents["id"].close();
 * app.instances.SearchComponents["id"].toggle();
 *
 * USAGE:
 * render_component("search", array("smallVersion" => true, "id"=> "uniqId"));
 *
 */
  $smallVersion = ($this->smallVersion == true) ? true : false;
  $smallClass = ($smallVersion == true) ? "small" : ""; 
  $id =($this->id);
?>
<div id="<?php echo $id; ?>" class="search-component <?php echo $smallClass; ?>">
  <div class="inner">
    <button class="close-btn" onclick="app.instances.SearchComponents['<?php echo $id; ?>'].close()"></button>
    <form class="search-form">
      <input class="search-field" type="text" placeholder="" />
      <button class="search-submit" type="submit"></button>
    </form>
    <span class="label-no-results">Sorry, no results were found.</span>
    <section class="search-results">
      <span class="results-count"></span>
      <div class="inner">

      </div>
      <?php render_component("loader"); ?>
    </section>
  </div>

</div>

<script>
  $(document).ready(function() {
    var newSearch = new app.components.search("<?php echo $id; ?>","<?php echo $smallVersion; ?>");
    app.instances.SearchComponents["<?php echo $id; ?>"] = newSearch;
  });
</script>
