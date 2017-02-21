<?php
/* Page Blocker overlay.
 *
 * Events:
 * app.components.pageBlocker.block();
 * app.components.pageBlocker.unblock();
 * app.components.pageBlocker.self();
 * app.components.pageBlocker.init();

 *
 * USAGE:
 * render_component("page-blocker");
 */
?>

<div class="page-blocker"></div>
<script>
	$(document).ready(function() {
		app.components.pageBlocker.init();
	});
</script>