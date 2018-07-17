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
                  // search box goes here
                ?>
              </div>

            </section>

            <section id="browse-options">

              <div class="entry-content"><?php // the_content(); ?></div>

            </section>










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
