<nav class="filter-nav row">

    <div class="dropdown-container">

      <div class="nested-dropdown-container">
        <div class="dropdown formats">
          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false" data-default-text="all formats">
            All Formats
          </button>
          <ul class="dropdown-menu" data-simplebar-direction="vertical">
          </ul>
        </div>
      </div>
      
      <div class="nested-dropdown-container">
        <div class="dropdown verticals">
          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false" data-default-text="all verticals">
            All Verticals
          </button>
          <ul class="dropdown-menu" data-simplebar-direction="vertical">
          </ul>
        </div>
      </div>

    </div>

    <div class="dropdown-container">

      <div class="nested-dropdown-container">
        <div class="dropdown features">
          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false" data-default-text="all features">
            All Features
          </button>
          <ul class="dropdown-menu" data-simplebar-direction="vertical">
          </ul>
        </div>
      </div>
      
      <div class="nested-dropdown-container">
        <div class="dropdown devices">
          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false" data-default-text="all devices">
            All Devices
          </button>
          <ul class="dropdown-menu" data-simplebar-direction="vertical">
          </ul>
        </div>
      </div>

    </div>

    <br/ class="hidden-md hidden-lg">

    <span class="reset">Reset</span>

    <!-- Filter View START -->
    <div class="filter-view">
      <span class="ico reset">
        <!-- <span class="dashicons dashicons-image-rotate"></span> -->
        <img src="<?php bloginfo('template_directory'); ?>/patch/images/reset.svg" alt="" border="0">
      </span>
      <span class="ico tile">
        <!-- <span class="dashicons dashicons-grid-view"></span> -->
        <img src="<?php bloginfo('template_directory'); ?>/patch/images/grid.svg" alt="" border="0">
      </span>
      <span class="ico list">
        <!-- <span class="dashicons dashicons-list-view"></span> -->
        <img src="<?php bloginfo('template_directory'); ?>/patch/images/list.svg" alt="" border="0">
      </span>
      <span class="ico favorite">
        <!-- <span class="dashicons dashicons-star-filled"></span> -->
        <img src="<?php bloginfo('template_directory'); ?>/patch/images/featured.svg" alt="" border="0">
      </span>      
    </div>    
    <!-- Filter View END -->

    <script class="menu-entry-template" type="text/x-handlebars-template">
      {{#each this}}
      <li><a href="#" data-id="{{id}}" title="{{{name}}}">{{{name}}}</a></li>
      {{/each}}
    </script>
    <div class="loading-overlay"></div>
</nav>
