<?php
if (post_password_required()) {
  return;
}
?>
    <?php if (have_comments()) { ?>
      <div class="row">
          <div class="col-xs-12">
            <section id="comments" class="comments">
              <h3>Comments</h3>
              <ol class="comment-list">
                <?php wp_list_comments(array('style' => 'ol', 'short_ping' => true)); ?>
              </ol>
            <?php } ?>
            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) { ?>
              <nav>
                <ul class="pager">
                  <?php if (get_previous_comments_link()) : ?>
                    <li class="previous"><?php previous_comments_link(__('&larr; Older comments', 'sage')); ?></li>
                  <?php endif; ?>
                  <?php if (get_next_comments_link()) : ?>
                    <li class="next"><?php next_comments_link(__('Newer comments &rarr;', 'sage')); ?></li>
                  <?php endif; ?>
                </ul>
              </nav>
          </section>
        </div>
      </div>

    <?php } ?>
    <?php if (!comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments')) : ?>
      <div class="alert alert-warning">
        <?php _e('Comments are closed.', 'sage'); ?>
      </div>
    <?php endif; ?>

    <?php

    $comments_args = array(
      'fields' => apply_filters(
        'comment_form_default_fields', array(
          'author' =>'<p class="comment-form-author">' . '<input id="author"  name="author" type="text" value="' .esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />'.
          '<label for="author">' . __( 'Name (required)' ) . '</label> ' .( $req ? '' : '' )  .'</p>',
          'email'  => '<p class="comment-form-email">' . '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .'" size="30"' . $aria_req . ' />'  .'<label for="email">' . __( 'Email (required)' ) . '</label> ' .( $req ? '' : '' ).'</p>',
          'url'    => '<p class="comment-form-url">' .
          '<input id="url" name="url"  type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /> ' .
          '<label for="url">' . __( 'Website', 'domainreference' ) . '</label>' .'</p>'
        )
      ),
      'label_submit'      => __( 'Submit' ),
      'comment_field' => '<p class="comment-form-comment">' .
        '<label for="comment">' . __( '' ) . '</label>' .
        '<textarea id="comment" name="comment"  cols="45" rows="8" aria-required="true"></textarea>' .
        '</p>',
        'comment_notes_after' => '',
        'comment_notes_before' => '',
        'title_reply' => 'Leave a Comment'
    );

    comment_form($comments_args);
    ?>
