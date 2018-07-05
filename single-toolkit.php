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

    <section id="top-section" class="toolkit-section">
      <div id="image-section" class="col-md-4 col-sm-4 col-xs-12">
        <div class="toolkit-image <?php echo (!has_post_thumbnail() ? 'noimg' : ''); ?>">
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

      <div id="intro-section" class="col-md-7 col-sm-7 col-xs-12 toolkit-section">

        <h1 class="toolkit-title">
          <?php the_title(); ?>
        </h1>

        <h6 class="toolkit-url">
          <a href="<?php the_field('url'); ?>"><?php the_field('url'); ?></a>
        </h6>

        <p class="toolkit-description">
          <?php the_field('description'); ?>
        </p>


        <div class="row">
          <div class="meta-column col-md-6 col-sm-6 col-xs-12">
            <h5>Publisher</h5>
            <?php
            $publishers = get_field('publisher');
            if( $publishers ): ?>
            	<?php foreach( $publishers as $publisher ): ?>
            		<p>
            		<a href="<?php echo get_term_link( $publisher ); ?>"><?php echo $publisher->name; ?></a>
                </p>
            	<?php endforeach; ?>
            <?php endif; ?>

            <h5>Discipline or practice</h5>
            <?php
            $disciplines = get_field('discipline-or-practice');
            if( $disciplines ): ?>
            	<?php foreach( $disciplines as $discipline ): ?>
            		<p>
            		<a href="<?php echo get_term_link( $discipline ); ?>"><?php echo $discipline->name; ?></a>
                </p>
            	<?php endforeach; ?>
            <?php endif; ?>

          </div>
          <div class="meta-column col-md-6 col-sm-6 col-xs-12">

            <h5>Formats</h5>
            <?php
            $formats = get_field('format');
            if( $formats ): ?>
            	<?php foreach( $formats as $format ): ?>
            		<p>
            		<a href="<?php echo get_term_link( $format ); ?>"><?php echo $format->name; ?></a>
                </p>
            	<?php endforeach; ?>
            <?php endif; ?>

            <h5>License</h5>
            <?php
            $licenses = get_field('license');
            if( $licenses ): ?>
            	<?php foreach( $licenses as $license ): ?>
            		<p>
            		<a href="<?php echo get_term_link( $license ); ?>"><?php echo $license->name; ?></a>
                </p>
            	<?php endforeach; ?>
            <?php endif; ?>

          </div>
        </div>
      </div>

      <div id="save-and-share" class="col-md-1 col-sm-1 col-xs-12">
        <?php echo (get_field('hide_social_sharing') === true ? '' : wpfai_social()); ?>
      </div>

    </section>

    <section id="details-section" class="toolkit-section col-md-12 col-sm-12 col-xs-12">
      <h2>About this resource</h2>
      <div class="row">
        <div class="meta-column col-md-3 col-sm-3 col-xs-6">
          <h5>Type</h5>
          <?php
          $types = get_field('toolkit-type');
          if( $types ): ?>
            <?php foreach( $types as $type ): ?>
              <p>
              <a href="<?php echo get_term_link( $type ); ?>"><?php echo $type->name; ?></a>
              </p>
            <?php endforeach; ?>
          <?php endif; ?>

        </div>
        <div class="meta-column col-md-3 col-sm-3 col-xs-6">
          <h5>Features</h5>
          <?php
          $features = get_field('toolkit-features');
          if( $features ): ?>
            <?php foreach( $features as $feature ): ?>
              <p>
              <a href="<?php echo get_term_link( $feature ); ?>"><?php echo $feature->name; ?></a>
              </p>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class="meta-column col-md-3 col-sm-3 col-xs-6">
          <h5>Date Published</h5>
          <p><a href="#">2016</a></p>
          <h5>Country of Origin</h5>
          <p><a href="#">United Kingdom</a></p>
        </div>
        <div class="meta-column col-md-3 col-sm-3 col-xs-6">
          <h5>Source files</h5>
          <p>          <a href="<?php the_field('source-file'); ?>"><?php the_field('source-file'); ?></a>
</p>
        </div>
      </div>
    </section>

  </article>

  <!-- <section id="feedback-section" class="toolkit-section col-md-12 col-sm-12 col-xs-12"> -->

      <?php
      // $args = array (
      //     'status' => 'approve',
      //     'number' => '2'
      //     );
      //     $comments = get_comments( $args );
      //     if ( !empty( $comments ) ) :
      //     echo '<div class="row">';
      //     foreach( $comments as $comment ) :
      //     echo '<div class="meta-column col-md-6 col-sm-6 col-xs-12"><h5>' . $comment->comment_text . '</h5> <p><a href="' . comment_author_url() . '</a></p>' . $comment->comment_author . '</h5></div>';
      //     endforeach;
      //     echo '</div>';
      //     endif;
       ?>

  <!-- </section> -->

  <section id="referral-section" class="toolkit-section col-md-12 col-sm-12 col-xs-12">
    <div class="row">
      <div class="meta-column col-md-6 col-sm-6 col-xs-12">
        <div id="cases-referral-block" class="referral-block">
          <h5>See cases from others in the OECD network</h5>
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

  <section id="similar-resources-section" class="toolkit-section col-md-12 col-sm-12 col-xs-12">
    <h2>Similar resources</h2>
    <div class="row">
      <div class="related-toolkits-column col-md-6 col-sm-6 col-xs-12">
        <div class="related-toolkit-image col-md-4 col-sm-4 col-xs-6">
          <div class="sample-image-box">&nbsp;</div>
        </div>
        <div class="related-toolkit-meta col-md-8 col-sm-8 col-xs-6">
          <h5><a href="#">BETA Guide to developing behavioural interventions for randomised controlled trials</a></h5>
          <h4>Australian Government Department of the Prime Minister and Cabinet</h4>
          <p>
            BETA’s approach to developing behavioural interventions for randomised controlled trials (RCTs). It pulls together behavioural and RCT expertise from around the world, in an easy to use guide for those looking to develop behavioural interventions for RCTs in government.
          </p>
        </div>
      </div>
      <div class="related-toolkits-column col-md-6 col-sm-6 col-xs-12">
        <div class="related-toolkit-image col-md-4 col-sm-4 col-xs-12">
          <div class="sample-image-box">&nbsp;</div>
        </div>
        <div class="related-toolkit-meta col-md-8 col-sm-8 col-xs-12">
          <h5><a href="#">EAST: Four Simple Ways to Apply Behavioural Insights</a></h5>
          <h4>UK Behavioral Insights Team</h4>
          <p>
            If you want to encourage a behaviour, make it Easy, Attractive, Social and Timely (EAST). These four simple principles, based on the Behavioural Insights Team’s own work and the wider academic literature, form the heart of the new framework for applying behavioural insights.
          </p>
        </div>
      </div>
    </div>
  </section>


  <section id="all-comments" class="toolkit-section">
    <h2>Feedback from the OECD network</h2>

    <?php comments_template(); ?>
    <?php endwhile; ?>
  </section>

</div>

<?php wp_reset_query(); ?>
<?php get_footer(); ?>
