<?php get_header('toolkits');
    // note change
    global $post;


  ?>


  <div class="col-sm-12">

  <?php while ( have_posts() ) : the_post(); $postid = get_the_ID();

    $userid = get_the_author_meta('ID');
    $job = xprofile_get_field_data( 'Job Title', $userid);
    $name = xprofile_get_field_data( 'Name', $userid);

  ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <section id="top-section">
      <div id="image-section" class="col-md-4 col-sm-4 col-xs-12">
        <div class="tookit-image <?php echo (!has_post_thumbnail() ? 'noimg' : ''); ?>">
          <?php
           if ( has_post_thumbnail()) {
            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large');
            $img_info =  wp_get_attachment_metadata( get_post_thumbnail_id(get_the_ID()) );

            echo '
            <a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" class="featuredimglink fancybox" >';
            echo get_the_post_thumbnail(get_the_ID(), 'blog');
            echo '</a>';

            if ($img_info['image_meta']['caption'] != '') {
              echo '<p>'. $img_info['image_meta']['caption'] .'</p>';
            }
           }
          ?>
        </div>
      </div>

      <div id="intro-section" class="col-md-7 col-sm-7 col-xs-12">

        <h1 class="toolkit-title">
          <?php the_title(); ?>
        </h1>

        <h6 class="toolkit-url">
          URL for toolkit
        </h6>

        <p class="toolkit-description">
          Description
        </p>


        <div class="row">
          <div class="meta-column col-md-3 col-sm-3 col-xs-6">
            <p>Author</p>
            <p>Discipline or practice</p>
          </div>
          <div class="meta-column col-md-3 col-sm-3 col-xs-6">
            <p>Type</p>
            <p>Features</p>
          </div>
        </div>
      </div>

      <div id="save-and-share" class="col-md-1 col-sm-1 col-xs-12">

        <p>Up-vote</p>

        <?php echo (get_field('hide_social_sharing') === true ? '' : wpfai_social()); ?>

        <p>Save for later</p>

      </div>

    </section>

    <section id="details-section" class="col-md-12 col-sm-12 col-xs-12">
      <h2>About this resource</h2>
      <div class="row">
        <div class="meta-column col-md-3 col-sm-3 col-xs-6">
          <p>Things</p>
        </div>
        <div class="meta-column col-md-3 col-sm-3 col-xs-6">
          <p>Things</p>
        </div>
        <div class="meta-column col-md-3 col-sm-3 col-xs-6">
          <p>Things</p>
        </div>
        <div class="meta-column col-md-3 col-sm-3 col-xs-6">
          <p>Things</p>
        </div>
      </div>
    </section>

  </article>

  <section id="feedback-section" class="col-md-12 col-sm-12 col-xs-12">

      <h2>Innovation community reviews</h2>
      <?php
      $args = array (
          'status' => 'approve',
          'number' => '2'
          );
          $comments = get_comments( $args );
          if ( !empty( $comments ) ) :
          echo '<div class="row">';
          foreach( $comments as $comment ) :
          echo '<div class="meta-column col-md-6 col-sm-6 col-xs-12"><h5>' . $comment->comment_text . '</h5> <p><a href="' . comment_author_url() . '</a></p>' . $comment->comment_author . '</h5></div>';
          endforeach;
          echo '</div>';
          endif;
       ?>
     </div>

  </section>

  <section id="referral-section" class="col-md-12 col-sm-12 col-xs-12">
    <div class="row">
      <div class="meta-column col-md-6 col-sm-6 col-xs-12">
        <div id="cases-referral-block" class="referral-block">
          <h5>See cases of Behavioral Science used by others in the network</h5>
          <p><a href="#">Go to case studies</a></p>
        </div>
      </div>
      <div class="meta-column col-md-6 col-sm-6 col-xs-12">
        <div id="cases-referral-block" class="referral-block">
          <h5>Find experts and advisers who can assist me with this</h5>
          <p><a href="#">Go to advice</a></p>
        </div>
      </div>
    </div>
  </section>


  <section id="all-comments">
    <?php comments_template(); ?>
    <?php endwhile; ?>
  </section>

</div>

<?php wp_reset_query(); ?>
<?php get_footer(); ?>
