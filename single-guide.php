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

            <section id="guide-main-content" class="guide-page-content wpb_column vc_column_container col-md-12 vc_col-sm-12">

              <h2 id="intro-text" class="category-header text-header">Welcome to the OPSI Meta-Toolkit</h2>
              <p class="browse-page-content">
                Toolkits are a great way to share innovative methods and practices. A plethora of free innovation toolkits, playbooks and guides exist to help people identify, develop and practice necessary skills and apply new ways of reaching an outcome. We built this “Meta-Toolkit” to help you find the ones best suited to you and your situation. <a href="#how-it-works">Learn more</a>
              </p>

            </section>



            <hr id="browse-section-rule">

            <section id="another-section" class="browse-page-content category-row wpb_column vc_column_container col-md-12 vc_col-sm-12">

              <?php the_content(); ?>

            </section>







          </article>
      <?php // comments_template(); ?>
      <?php endwhile; ?>





  <?php wp_reset_query(); ?>


<?php get_footer(); ?>
