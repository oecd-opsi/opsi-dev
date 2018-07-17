<?php get_header('toolkits');
    // note change
    global $post;


  ?>




  <div class="col-sm-12">


  <?php while ( have_posts() ) : the_post(); $postid = get_the_ID(); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <!-- Display featured image in right-aligned floating div -->


            <section id="search-section">

              <h1 class="entry-title"><?php the_title(); ?></h1>
              <h4 class="entry-subtitle">What do you want to accomplish?</h4>

              <div class="search-field">
                &nbsp;
                <?php
                  echo do_shortcode('[searchandfilter id="1902"]');
                ?>
              </div>

            </section>

            <section id="intro-section" class="category-row wpb_column vc_column_container col-md-12 vc_col-sm-12">

              <?php the_field('browse_content_top'); ?>

            </section>

            <section id="browse-options">

              <div class="entry-content"><?php the_field('browse_page_html'); ?></div>

            </section>

            <section id="more-info-section" class="category-row wpb_column vc_column_container col-md-12 vc_col-sm-12">

              <?php the_field('browse_content_bottom'); ?>

            </section>








          </article>
      <?php // comments_template(); ?>
      <?php endwhile; ?>




    </div>

  <?php wp_reset_query(); ?>


<?php get_footer(); ?>
