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
                  <div class="referral-box meta-column col-md-12 col-xs-12">
                    <div id="cases-referral-block" class="referral-block">
                      <h5>The OPSI community has experts in this area</h5>
                      <p><a href="/about-observatory-of-public-sector-innovation/about-our-in-country-contacts/">Connect with them</a></p>
                    </div>
                  </div>
                  <div class="referral-box meta-column col-md-12 col-xs-12">
                    <div id="cases-referral-block" class="referral-block">
                      <h5>See how other governments are doing this work</h5>
                      <p><a href="/our-work/case-studies/">Go to case studies</a></p>
                    </div>
                  </div>

                </div>

                <?php
                      $currentID = get_the_ID();

                      $disciplines = get_field('discipline-or-practice');
                      if( $disciplines ):
                       foreach( array_reverse($disciplines) as $discipline ):

                        $disciplineSlug = $discipline->name;

                        endforeach;
                      endif;


                    ?>



                    <h2>Toolkits for being <?php echo $disciplineSlug ?></h2>


            <?php


                       $args = array(
                         'post_type'   => 'toolkit',
                         'post_status' => 'publish',
                         'tax_query'   => array(
                         	array(
                         		'taxonomy' => 'discipline-or-practice',
                         		'tag_id'    => $disciplineID // current discipline or practice
                         	)
                        ),
                        'post__not_in' => array($currentID), // removes the current page from being shown
                        'posts_per_page' => 6,

                        );

                        $cssCounter = 1;


                       $the_query = new WP_Query( $args ); ?>

                        <?php if ( $the_query->have_posts() ) : ?>
                        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                        <div class="related-toolkits-column related-item-<?php echo $cssCounter ?> col-md-6 col-sm-6 col-xs-12">

                          <div class="related-toolkit-image col-md-4 col-sm-4 col-xs-6">
                            <div class="related-image-box">
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


                        <?php
                        $cssCounter++;
                        endwhile; ?>
                        <!-- end of the loop -->


                        <!-- pagination here -->

                        <?php wp_reset_postdata(); ?>

                        <?php else : ?>
                        <p>We're working on adding more toolkits in this discipline or practice.</p>
                        <?php endif; ?>




                <h4 class="view-all-link"><a href="/search-toolkits/?_sft_discipline-or-practice=<?php echo $disciplineHyphenated ?>">View all toolkits for <?php echo $disciplineUpper ?></a></h4>





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
