<?php get_header('toolkits');
    // note change
    global $post;


  ?>




  <div class="col-sm-12">

  <?php while ( have_posts() ) : the_post(); $postid = get_the_ID(); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <!-- Display featured image in right-aligned floating div -->

              <h1 class="entry-title"><?php the_title(); ?></h1>

              <div class="entry-content"><?php the_content(); ?></div>

              <?php
              $args = array('post_type' => 'post');
              $args['search_filter_id'] = 1414;
              $query = new WP_Query($args);
              ?>

          </article>
      <?php // comments_template(); ?>
      <?php endwhile; ?>

    </div>

  <?php wp_reset_query(); ?>


<?php get_footer(); ?>
