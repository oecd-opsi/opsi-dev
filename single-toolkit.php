<?php get_header('header-toolkits');
    // note change
    global $post;


  ?>

  <div class="col-sm-12">


  <?php while ( have_posts() ) : the_post(); $postid = get_the_ID();

    $userid = get_the_author_meta('ID');
    $job = xprofile_get_field_data( 'Job Title', $userid);
    $name = xprofile_get_field_data( 'Name', $userid);

  ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <!-- Display featured image in right-aligned floating div -->
              <div class="single_img_wrap <?php echo (!has_post_thumbnail() ? 'noimg' : ''); ?>">
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
                <?php echo (get_field('hide_social_sharing') === true ? '' : wpfai_social()); ?>
              </div>
              <?php if (get_field('hide_page_title') !== true) { ?>
              <h1 class="entry-title"><?php the_title(); ?></h1>
              <?php } ?>
              <?php if (get_field('subheader') !='' ) { ?>
                <h2 class="entry-subtitle"><?php echo get_field('subheader'); ?></h2>
              <?php } ?>



              <div class="single_post_meta">
                <div class="row">
                  <div class="col-sm-6">
                    <p class="text-left">
                      <i class="fa fa-calendar" aria-hidden="true"></i> <?php echo get_the_date(); ?>
                    </p>
                  </div>
                  <div class="col-sm-6">
                    <p class="text-right-not-xs single_category_list">
                      <i class="fa fa-folder-open-o" aria-hidden="true"></i> <?php echo get_the_category_list(', '); ?>
                    </p>
                  </div>
                </div>
              </div>

              <div class="entry-content"><?php the_content(); ?></div>

              <?php get_template_part( 'blocks' ); ?>

              <div class="post_tags">
                <?php echo get_the_tag_list(); ?>
              </div>
          </article>
      <?php comments_template(); ?>
      <?php endwhile; ?>

    </div>

  <?php wp_reset_query(); ?>


<?php get_footer(); ?>
