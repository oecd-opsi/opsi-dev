<?php get_header('toolkits');
    // note change
    global $post;


  ?>




  <div class="col-sm-12">

  <?php while ( have_posts() ) : the_post(); $postid = get_the_ID(); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <!-- Display featured image in right-aligned floating div -->

              <h1 class="entry-title"><?php the_title(); ?></h1>

              <div class="entry-content"><?php // the_content(); ?></div>


              <div id="filters-section" class="filters-section col-md-4 col-sm-4 col-xs-12">

              <?php


// add filters here


echo do_shortcode('[searchandfilter id="1414"]');
?>
</div>

<?php

// end of filters




        // the query
        $args = array('post_type' => 'post');
        $args['search_filter_id'] = 1414;


        $the_query = new WP_Query( $args ); ?>

        <?php if ( $the_query->have_posts() ) : ?>

          <div id="search-filter-results-1414" class="results-section col-md-8 col-sm-8 col-xs-12">


        <!-- pagination here -->

        <!-- the loop -->
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <h2><?php the_title(); ?></h2>

<!-- current image handling -->
<div id="image-section" class="col-md-4 col-sm-4 col-xs-12">
  <div class="toolkit-image <?php echo (!has_post_thumbnail() ? 'noimg' : ''); ?>">
    <?php
     if ( has_post_thumbnail()) {
      $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large');
      $img_info =  wp_get_attachment_metadata( get_post_thumbnail_id(get_the_ID()) );

      echo '
      <a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" class="featuredimglink fancybox" >';
      echo get_the_post_thumbnail(get_the_ID(), 'blog');
      echo '</a>';

      if ($img_info['image_meta']['caption'] != '') {
        echo '<p>'. $img_info['image_meta']['caption'] .'</p>';
      }
     }
    ?>
  </div>
</div>
<!-- end current image handling -->

<p class="toolkit-description">
  <?php the_field('description'); ?>
</p>

<!-- Discipline or practice -->
<?php
$disciplines = get_field('discipline-or-practice');
if( $disciplines ): ?>
  <?php foreach( $disciplines as $discipline ): ?>
    <p>
    <a href="<?php echo get_term_link( $discipline ); ?>"><?php echo $discipline->name; ?></a>
    </p>
  <?php endforeach; ?>
<?php endif; ?>
<!-- End Discipline or practice -->



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
