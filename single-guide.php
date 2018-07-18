<?php get_header('toolkits');
    // note change
    global $post;


  ?>






  <?php while ( have_posts() ) : the_post(); $postid = get_the_ID(); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <!-- Display featured image in right-aligned floating div -->


            <section id="guide-header">

              <h1 class="guide-title"><?php the_title(); ?></h1>

            </section>

            <section id="guide-main-content" class="guide-page-content wpb_column vc_column_container col-md-8 vc_col-sm-12">

              <?php the_content(); ?>

            </section>

            <section id="guide-sidebar" class="guide-page-content wpb_column vc_column_container col-md-4 vc_col-sm-12">

              <p>sidebar goes here</p>

            </section>
            



            <hr id="browse-section-rule">

            <section id="another-section" class="browse-page-content category-row wpb_column vc_column_container col-md-12 vc_col-sm-12">



            </section>







          </article>
      <?php // comments_template(); ?>
      <?php endwhile; ?>





  <?php wp_reset_query(); ?>


<?php get_footer(); ?>
