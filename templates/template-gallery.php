<?php
/**
 * Template Name: Creative Gallery
 */
?>

<div class="gallery-tpl">
  <?php get_template_part("partials/gallery-filters"); ?>

  <?php 

    //   $args = array(
    //     "post_type" => "campaign",
    //     "tax_query" => $taxQuery,
    //     "meta_query" => $metaQuery,
    //     "posts_per_page" => $ITEMS_PER_PAGE,
    //     "paged" => $page,
    //     'meta_query' => array(          
    //       array(
    //         'key' => 'top_campaign'
    //         // 'key' => 'exclude_from_gallery',
    //         // 'value'   => true,
    //         // 'compare' => 'EXISTS'
    //       )
    //     )
    //   );
    
    // $query = new \WP_Query($args);

    // while ( $query->have_posts() ) {
    //   var_dump(get_the_title());      
    // }

  ?>

  <div class="gallery-contents row">
    <div class="gallery-contents-inner"></div>
    <?php render_component("loader", array("size" => "big")); ?>
    <span class="no-results hidden">Sorry no results found for your query.</span>
  </div>
  <div class="load-trigger">
    <?php render_component("loader", array("size" => "big")); ?>
  </div>

  <script class="entry-template" type="text/x-handlebars-template">
  {{#each this}}
    <figure id="gallery-post-{{id}}" class="gallery-post {{#each launchBtn}}{{this}} {{/each}}">
      <img class="post-img img-responsive" src="{{image}}" />
      <div class="overlay"></div>
      <figcaption class="gallery-post-content">
        <div class="inner">
          <div class="act work-title">
            <h1 class="{{hideTittle}} info-it" data-perm="{{permalink}}">{{{title}}}</h1>
            <div class="{{showTittleImg}} image-tittle"  style="background-image: url('{{titleImage}}')"></div>
            <div class="product info-it" data-perm="{{permalink}}">{{format}}</div>
          </div>
          <div class="act work-types">
            {{#each feats}}
              <div class="type ico {{this}}" title="{{this}}"><img src="<?php bloginfo('template_directory'); ?>/patch/images/{{this}}.svg" width="30" alt="" border="0"/></div>
            {{/each}}            
          </div>
          <div class="act liner"></div>
          <div class="act work-actions">
            <div class="cap">
              <span class="btn-cms btn-green info-it" data-perm="{{permalink}}">View Campaign</span>
            </div>
            <div class="cap">
              {{#if demoUrl}}
                <span class="btn-cms btn-green demo-it" data-code="{{demoUrl}}">View Demo</span>
              {{/if}}
            </div>            
            <div class="cap play">
              <span class="btn-play demo-it" data-code="{{demoCode}}"><span class="dashicons dashicons-controls-play"></span></span>
            </div>
          </div>
        </div>
      </figcaption>
    </figure>
    {{!-- {{CMS Styling Template}} --}}
    <style>
      #gallery-post-{{id}} .btn-cms {
        background: -webkit-linear-gradient(20deg, {{buttonPrimaryColor}} 50%, transparent 50%);
        background: -webkit-linear-gradient(70deg, {{buttonPrimaryColor}} 50%, transparent 50%);
        background: linear-gradient(20deg, {{buttonPrimaryColor}} 50%, transparent 50%);
        background-position: right bottom;
        background-size: 400% 200%;
        color: {{buttonPrimaryColor}};
        border-color: {{buttonPrimaryColor}};
      }
      #gallery-post-{{id}} .btn-cms:hover {
        color: {{buttonSecondaryColor}};
        background-position: left bottom;
      }
      #gallery-post-{{id}} .overlay {
        background-color: {{overlayColor}};
        opacity: 0.8;
      }
    </style>
  {{/each}}
  </script>


  <script>
    $(document).ready(function () {
      app.templates.gallery.init();
    });
  </script>
</div>

<script src="<?php bloginfo('template_directory'); ?>/patch/js/gallery-v1.js" type="text/javascript" charset="utf-8"></script>
