<?php get_header('toolkits');
    // note change
    global $post;


  ?>






  <?php while ( have_posts() ) : the_post(); $postid = get_the_ID(); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <!-- Display featured image in right-aligned floating div -->


            <section id="landing-header-section">

              <h1 class="landing-title"><?php the_title(); ?></h1>
              <h4 class="landing-subtitle">A compendium of toolkits for public sector innovation and transformation, curated by OPSI and our partners around the world</h4>

            </section>


            <section id="browse-options" class="browse-page-content category-row wpb_column vc_column_container col-md-12 vc_col-sm-12">

              <h2 id="explore-topics" class="category-header links-header">Explore topics</h2>
              <div id="explore-box" class="category-row wpb_column vc_column_container vc_col-sm-12">

                <div class="col-md-4 col-sm-4 topic-column">
                  <a href="/guide/design/">
                    <div class="category-option">
                      <span class="category-text">Design</span>
                    </div>
                  </a>
                  <a href="/guide/social-innovation/">
                    <div class="category-option">
                      <span class="category-text">Social Innovation</span>
                    </div>
                  </a>
                  <a href="/guide/open-government/">
                    <div class="category-option">
                      <span class="category-text">Open Government</span>
                    </div>
                  </a>
                  <a href="/guide/public-policy/">
                    <div class="category-option">
                      <span class="category-text">Public Policy</span>
                    </div>
                  </a>
                  <a href="/guide/service-design/">
                    <div class="category-option">
                      <span class="category-text">Service Design</span>
                    </div>
                  </a>
                </div>

                <div class="col-md-4 col-sm-4 topic-column">
                  <a href="/guide/digital-transformation/">
                    <div class="category-option">
                      <span class="category-text">Digital &amp; Technology Transformation</span>
                    </div>
                  </a>
                  <a href="/guide/strategic-design/">
                    <div class="category-option">
                      <span class="category-text">Strategic Design</span>
                    </div>
                  </a>
                  <a href="/guide/organisational-design/">
                    <div class="category-option">
                      <span class="category-text">Organisational Design</span>
                    </div>
                  </a>
                  <a href="/guide/behavioural-insights/">
                    <div class="category-option">
                      <span class="category-text">Behavioural Insights</span>
                    </div>
                  </a>
                  <a href="/guide/systems-change/">
                    <div class="category-option">
                      <span class="category-text">Systems Change</span>
                    </div>
                  </a>
                </div>

                <div class="col-md-4 col-sm-4 topic-column">
                  <a href="/guide/international-development/">
                    <div class="category-option">
                      <span class="category-text">International Development</span>
                    </div>
                  </a>
                  <a href="/guide/facilitation-and-codesign/">
                    <div class="category-option">
                      <span class="category-text">Process Facilitation &amp; Co-Design</span>
                    </div>
                  </a>
                  <a href="/guide/product-design/">
                    <div class="category-option">
                      <span class="category-text">Product Design</span>
                    </div>
                  </a>
                  <a href="/guide/futures-and-foresight/">
                    <div class="category-option">
                      <span class="category-text">Futures &amp; Foresight</span>
                    </div>
                  </a>
                </div>

              </div>



              <div id="take-action-box" class="action-boxes category-row wpb_column vc_column_container col-md-6 vc_col-sm-12">

                <h2 id="take-action" class="category-header links-header">Take action</h2>

                <a href="/guide/design-new-strategy/">
                  <div class="category-option">
                    <span class="category-text">Design a new strategy</span>
                  </div>
                </a>
                <a href="/guide/clarify-or-understand/">
                  <div class="category-option">
                    <span class="category-text">Clarify a problem or understand a situation</span>
                  </div>
                </a>
                <a href="/guide/improve-existing-process/">
                  <div class="category-option">
                    <span class="category-text">Improve, create, or redesign an existing process or program</span>
                  </div>
                </a>
                <a href="/guide/new-team-or-partnership/">
                  <div class="category-option">
                    <span class="category-text">Create a new team or partnership</span>
                  </div>
                </a>
              </div>



              <div id="connect-box" class="action-boxes category-row wpb_column vc_column_container col-md-6 vc_col-sm-12">

                <h2 id="connect" class="category-header links-header">Connect</h2>

                <a href="/guide/facilitate-collaboration/">
                  <div class="category-option">
                    <span class="category-text">Facilitate collaboration within and outside of my organisation</span>
                  </div>
                </a>
                <a href="/guide/connect-with-others/">
                  <div class="category-option">
                    <span class="category-text">Connect with others who want to share practices and cases</span>
                  </div>
                </a>
                <a href="/guide/discover-other-governments/">
                  <div class="category-option">
                    <span class="category-text">Discover what is working for other governments</span>
                  </div>
                </a>
                <a href="/guide/experts-and-advisors/">
                  <div class="category-option">
                    <span class="category-text">Find experts or advisors who can assist me</span>
                  </div>
                </a>
              </div>

              <div id="search-section">
                <p>&nbsp;</p>
                <h2 id="search-header" class="category-header links-header">Search keywords</h2>

                <div id="search-field-box" class="category-row wpb_column vc_column_container vc_col-sm-12">

                  <div class="search-field">
                    &nbsp;
                    <?php
                      echo do_shortcode('[searchandfilter id="1902"]');
                    ?>
                  </div>

              </div>


            </section>





            <hr id="browse-section-rule">

            <section id="more-info-section" class="browse-page-content category-row wpb_column vc_column_container col-md-12 vc_col-sm-12">

              <?php the_content(); ?>

            </section>







          </article>
      <?php // comments_template(); ?>
      <?php endwhile; ?>





  <?php wp_reset_query(); ?>


<?php get_footer(); ?>
