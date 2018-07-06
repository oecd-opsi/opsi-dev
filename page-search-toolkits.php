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

        // the query
        $args = array('post_type' => 'post');
        $args['search_filter_id'] = 1414;


        $the_query = new WP_Query( $args ); ?>

        <?php if ( $the_query->have_posts() ) : ?>

        <!-- pagination here -->

        <!-- the loop -->
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <h2><?php the_title(); ?></h2>
        <?php endwhile; ?>
        <!-- end of the loop -->

        <!-- pagination here -->

        <?php wp_reset_postdata(); ?>

        <?php else : ?>
        <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
        <?php endif; ?>


          </article>
      <?php // comments_template(); ?>
      <?php endwhile; ?>




    </div>

  <?php wp_reset_query(); ?>


<?php get_footer(); ?>
