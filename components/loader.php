<?php
/* Show a loader animation. By default the loader is hidden.
 *
 * param type string optional: white or blank.
 *
 * USAGE:
 * render_component("loader");
 * render_component("loader", array("size" => "big")); // optional
 */
?>


<div class="loader <?php if (isset($this->size))  { echo $this->size; } ?>">
	<div class="image"></div>
</div>
