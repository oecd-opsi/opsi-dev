<?php get_header('toolkits');
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

    <section id="top-section">
      <div id="image-section" class="col-md-4 col-sm-4 col-xs-12">
        <div class="tookit-image <?php echo (!has_post_thumbnail() ? 'noimg' : ''); ?>">
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

      <div id="intro-section" class="col-md-7 col-sm-7 col-xs-12">

        <h1 class="toolkit-title">
          <?php the_title(); ?>
        </h1>

        <h6 class="toolkit-url">
          URL for toolkit
        </h6>

        <p class="toolkit-description">
          Description
        </p>


        <div class="row">
          <div class="meta-column col-md-3 col-sm-3 col-xs-6">
            <p>Author</p>
          </div>
          <div class="meta-column col-md-3 col-sm-3 col-xs-6">
            <p>Type</p>
          </div>
        </div>
      </div>

      <div id="save-and-share" class="col-md-1 col-sm-1 col-xs-12">

        <p>Up-vote</p>

        <?php echo (get_field('hide_social_sharing') === true ? '' : wpfai_social()); ?>

        <p>Save for later</p>

      </div>

    </section>


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
