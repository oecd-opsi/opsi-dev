<?php get_header();
    // note change
    global $post;


    // $layout = get_post_meta($post->ID, 'layout', true);


  ?>


  <section id="top-section">
    <div id="image-section" class="col-md-5 col-sm-5 col-xs-12">
      <div class="tookit-image">
        <!-- this is where the photo goes -->
        <p>Placeholder content instead of image</p>
      </div>
    </div>
    <div id="intro-section" class="col-md-6 col-sm-6 col-xs-12">
      <h1 class="toolkit-title">Title</h1>
      <h6>URL</h6>
      <p>Description</p>
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
      <p>Share</p>
      <p>Save for later</p>
    </div>
  </section>



  <?php wp_reset_query(); ?>


<?php get_footer(); ?>
