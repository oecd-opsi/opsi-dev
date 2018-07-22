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
            $img_info =  wp_get_attachment_metadata( get_post_thumbnail_id(get_the_ID()), 'medium' );

            echo '
            <a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" class="featuredimglink fancybox" >';
            echo get_the_post_thumbnail(get_the_ID(), 'medium');
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
          <a href="<?php the_field('url'); ?>"><?php the_title(); ?></a>
        </h1>

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

            <h5>Link to toolkit</h5>
            <p><a href="<?php the_field('url'); ?>"><?php the_field('url'); ?></a></p>



            <h5>Source files</h5>
            <?php

            $file1 = get_field('source-file-1');

            if( $file1 ):
            	// vars
            	$url = $file1['url'];
            	$title = $file1['title'];
            	 ?>
            	<p><a href="<?php echo $url; ?>" title="<?php echo $title; ?>">
            		<?php echo $title; ?>
            	</a></p>

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
          <h5>Country of Origin</h5>
          <?php
          $countries = get_field('country-territory');
          if( $countries ): ?>
            <?php foreach( $countries as $country ): ?>
              <p>
              <a href="<?php echo get_term_link( $country ); ?>"><?php echo $country->name; ?></a>
              </p>
            <?php endforeach; ?>
          <?php endif; ?>

          <h5>Date Published</h5>
              <p>
              <?php the_field('last-updated'); ?>
              </p>



        </div>
        <div class="meta-column col-md-3 col-sm-3 col-xs-6">
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

          <h5>Formats</h5>
          <?php
              $formats = get_field('format');
              if( $formats ): ?>
                <?php foreach( $formats as $format ): ?>
                  <p>
                  <?php echo $format->name; ?>
                  </p>
                <?php endforeach; ?>
          <?php endif; ?>
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
          <p><a href="/our-work/case-studies/">Go to case studies</a></p>
        </div>
      </div>
      <div class="meta-column col-md-6 col-sm-6 col-xs-12">
        <div id="cases-referral-block" class="referral-block">
          <h5>Find experts and advisers who can assist me with this</h5>
          <p><a href="/about-observatory-of-public-sector-innovation/about-our-in-country-contacts/">Go to advice</a></p>
        </div>
      </div>
    </div>
  </section>

  <section id="similar-resources-section" class="toolkit-section col-md-12 col-sm-12 col-xs-12">
    <h2>Similar resources</h2>

    <?php

    // end of filters




            // the query
           $args = array('post_type' => 'post');
           $args['search_filter_id'] = 1414;
           $the_query = new WP_Query( 'discipline-or-practice=strategic-design&post_type=toolkit' ); ?>

            <?php if ( $the_query->have_posts() ) : ?>
            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

            <div class="related-toolkits-column col-md-6 col-sm-6 col-xs-12">

              <div class="related-toolkit-image col-md-4 col-sm-4 col-xs-6">
                <div class="sample-image-box">
                  <a href="
                  <?php echo the_permalink() ?>" class="toolkit-list-image">
                  <?php echo get_the_post_thumbnail(get_the_ID(), 'medium'); ?>
                  </a>
                </div>
              </div>

              <div class="related-toolkit-meta col-md-8 col-sm-8 col-xs-6">
                <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                  <?php
                  $publishers = get_field('publisher');
                  if( $publishers ): ?>
                    <?php foreach( $publishers as $publisher ): ?>
                      <h4>
                      <?php echo $publisher->name; ?>
                    </h4>
                    <?php endforeach; ?>
                  <?php endif; ?>
                <p><?php the_field('description'); ?></p>
              </div>
            </div> <!-- result item -->


            <?php endwhile; ?>
            <!-- end of the loop -->

            <!-- pagination here -->

            <?php wp_reset_postdata(); ?>

            <?php else : ?>
            <p>We're working on adding more toolkits in this discipline or practice.</p>
            <?php endif; ?>



    <!-- <div class="row">
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
    </div> -->


  </section>


  <section id="all-comments" class="toolkit-section">
    <h2>Feedback from the OECD network</h2>

    <?php comments_template(); ?>
    <?php endwhile; ?>
  </section>

</div>

<?php wp_reset_query(); ?>
<?php get_footer(); ?>
