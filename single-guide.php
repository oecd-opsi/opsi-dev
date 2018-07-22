<?php get_header('toolkits');
    // note change
    global $post;


  ?>






  <?php while ( have_posts() ) : the_post(); $postid = get_the_ID(); ?>
          <article class="toolkit-guide" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <!-- Display featured image in right-aligned floating div -->


            <section id="guide-header">

              <h1 class="guide-title"><?php the_title(); ?></h1>

            </section>

            <section id="guide-main-content" class="guide-page-content wpb_column vc_column_container col-md-8 vc_col-sm-12">

              <?php the_content(); ?>

            </section>

            <section id="guide-sidebar" class="guide-page-content wpb_column vc_column_container col-md-4 vc_col-sm-12">

              <section id="referral-section" class="toolkit-section col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                  <div class="meta-column col-md-6 col-sm-6 col-xs-12">
                    <div id="cases-referral-block" class="referral-block">
                      <h5>See cases from others doing this in government</h5>
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

            </section>




            <hr id="browse-section-rule">

            <section id="another-section" class="browse-page-content category-row wpb_column vc_column_container col-md-12 vc_col-sm-12">



            </section>







          </article>
      <?php // comments_template(); ?>
      <?php endwhile; ?>





  <?php wp_reset_query(); ?>


<?php get_footer(); ?>
