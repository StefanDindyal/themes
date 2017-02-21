<div class="single-post-template <?php echo get_post_type(); ?>">
  <?php 
    $postType = get_post_type();

    if($postType != 'press_release_type') {
      global $postID;
      // check if the module field id exists
      if( get_field('post_hero_module') ):
        $postID = get_field('post_hero_module');
        get_template_part('single', 'module');
      else :
        //no module id
      endif;
    }

    $hubspotCode = get_field('hubspot_code');
  ?>
  <div class="container">
    <?php while (have_posts()) : the_post(); ?>
    <article <?php post_class('post-element'); ?>>
      <div class="row">
        <div class="col-xs-12">
          <header>
            <?php 
            if( get_field('post_hero_module') ){ ?>
               <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php }else { ?>
               <h1 class="entry-title extra-margin"><?php the_title(); ?></h1>
            <?php } ?>
           
            <?php 
              if($postType != 'press_release_type' && $postType != 'research_post') {
                get_template_part('templates/entry-meta');
              }
            ?>
            <?php render_component("social-sharing", array(
              "fb"   => "http://www.facebook.com/sharer/sharer.php?u=".urlencode(get_the_permalink())."&t=".get_the_title(),
              "tw"   => "https://twitter.com/share?url=".get_the_permalink()."&via=ACCESSUNDERTONE&text=".get_the_title(),
              "li"   => "http://www.linkedin.com/shareArticle?mini=true&url=".get_the_permalink()."&title=".get_the_title()."&summary=".get_the_title()."&source=UNDERTONE",
              "mail" => "mailto:?subject=".get_the_title()."&body=".urlencode(get_the_permalink())
            )); ?>
          </header>
          <div class="entry-content">
            <?php if($postType === 'research_post'){
              get_template_part('templates/research_type_content');
            } else { 
              the_content();
            } ?> 
          </div>
        </div>
      </div>
      
      <?php /** AUTHOR OF THE POST **/
      if($postType == 'post') { ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="author-info">
            <div class="col-sm-2 col-xs-3">
              <p class="text-center">
                <?= get_avatar( get_the_author_email(), 'medium' ); ?>
              </p>
            </div>
            <div class="col-sm-10 col-xs-9">
              <p class="byline author vcard"><a href="<?= get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn">By <?= get_the_author_meta('first_name'); ?> <?= get_the_author_meta('last_name'); ?></a></p>
              <p class="bio-description"><?= get_the_author_meta('description'); ?></p>
              <?php if(get_field('twitter_user_name', 'user_'.get_the_author_meta('ID'))) { ?>
              <a class="twitter_user" target="_blank" href="https://twitter.com/<?php echo get_field('twitter_user_name', 'user_'.get_the_author_meta('ID')); ?>"><em>Follow @<?php echo get_field('twitter_user_name', 'user_'.get_the_author_meta('ID')); ?></em></a>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>

      <?php /** RECOMENDED POSTS **/
      $parent = '';
      if($postType == 'research_post'){
        $parent = get_page_by_title( 'Research');
      }else if($postType == 'post'){
        $parent = get_page_by_title('Blog');
      }
      ?>   
      <div class="row">
        <div class="col-xs-12">
          <div class="recomended-posts">
            <?php if( have_rows('recomended_posts',$parent) ) { ?> <h3>Recommended</h3> <?php } ?>
            <ul class="row list-unstyled">
              <?php 
                if( have_rows('recomended_posts',$parent) ):
                  while ( have_rows('recomended_posts',$parent) ) : the_row();
                    $postID = get_sub_field('recomended_post',$parent);
                    $postDescription = get_sub_field('tile_description',$parent);
                  ?>
                     <?php 
                          $imageURL = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'single-post-thumbnail' );
                          $imageURL = $imageURL[0];
                      ?>
                      <li class="col-xs-12 col-sm-4" style="background-image: url('<?php echo  $imageURL; ?>')">
                        <div class="grid-wrapper">                          
                          <span class="divider"></span>
                          <h3 class="post-title"> <?php echo get_the_title($postID); ?></h3> 
                          <section class="grid-information">
                            <p class="copy"><?php echo $postDescription; ?></p>
                            <a href="<?php echo get_permalink($postID); ?>" class="btn btn-default">Read more</a>
                          </section>
                        </div>   
                      </li> 
                  <?php
                  endwhile;
                endif;
              ?>
            </ul>
          </div>
        </div>
      </div>

      <?php /** COMMENT FORM **/
      comments_template('/templates/comments.php', true); ?>

      <?php /** RESEARCH MODAL FORM **/
      if($postType == 'research_post') { 
        get_template_part('templates/research_form');
      } ?>

    </article>
    <?php endwhile; ?>
  </div>
</div>
<script>
  $(document).ready(function() {
    app.templates.postSingle.init("<?php echo $postType; ?>","#reportForm", "#hsForm_<?php echo $hubspotCode; ?>");
    <?php if($postType == 'research_post' && $hubspotCode !== '') { ?>
    hbspt.forms.create({ 
      target: '.hbspt-form',
      portalId: '388551',
      formId: '<?php echo $hubspotCode; ?>'
    });
    <?php } ?>
  });
</script>
