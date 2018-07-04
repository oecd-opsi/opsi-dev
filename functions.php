<?php
  
  add_theme_support( 'post-thumbnails' ); 
  
  add_action( 'after_setup_theme', 'nitro_theme_setup' );
  function nitro_theme_setup() {
    add_image_size( 'slider', 1920, 872, true );
    add_image_size( 'blog', 848, 288, true );
    add_image_size( 'blog_thumb', 270, 160, true );
    add_image_size( 'tiny', 46, 46, true );
    load_theme_textdomain( 'opsi', get_template_directory() . '/languages' );
    add_theme_support( 'html5', array( 'search-form' ) );
  }
add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}
  
  add_filter( 'jpeg_quality', create_function( '', 'return 85;' ) );
  add_filter('acf-image-crop/image-quality', 85);
  add_filter('widget_text', 'do_shortcode');
  
  
  /*-----------------------------------------------------------------------------------*/
  /*	Widgets
  /*-----------------------------------------------------------------------------------*/

  require_once('widgets/archives-accordion.php');
  require_once('widgets/blogposts.php');

  
  
  /*-----------------------------------------------------------------------------------*/
  /*	Sidebars
  /*-----------------------------------------------------------------------------------*/

  //Register Sidebars
  if ( function_exists('register_sidebar') ) {
  
  function nitro_register_sidebars() {
            
    register_sidebar(array(
      'name' => 'Sidebar',
      'id' => 'sidebar',
      'description' => 'Widgets in this area will be shown in right sidebar position.',
      'before_widget' => '<aside id="%1$s" class="widget sidebar-box sidebar-right %2$s">',
      'after_widget' => '</div></aside>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2><div class="widget_content collapse-xs">',
    ));        
    register_sidebar(array(
      'name' => 'Blog',
      'id' => 'blog',
      'description' => 'Widgets in this area will be shown in right sidebar position on blog only.',
      'before_widget' => '<aside id="%1$s" class="widget sidebar-box sidebar-right %2$s">',
      'after_widget' => '</div></aside>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2><div class="widget_content collapse-xs">',
    ));
            
    register_sidebar(array(
      'name' => 'Single Blog',
      'id' => 'singleblog',
      'description' => 'Widgets in this area will be shown in right sidebar position on single blog entry only.',
      'before_widget' => '<aside id="%1$s" class="widget sidebar-box sidebar-right %2$s">',
      'after_widget' => '</div></aside>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2><div class="widget_content collapse-xs">',
    ));        
    register_sidebar(array(
      'name' => 'Buddypress',
      'id' => 'buddypress',
      'description' => 'Widgets in this area will be shown in right sidebar position on Buddypress pages only.',
      'before_widget' => '<aside id="%1$s" class="widget sidebar-box sidebar-right buddypress_aside %2$s">',
      'after_widget' => '</div></aside>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2><div class="widget_content collapse-xs">',
    ));
    
   
   }
   
   
   add_action( 'widgets_init', 'nitro_register_sidebars' );
  }

  register_nav_menu( 'primary', 'Primary Menu' );
  register_nav_menu( 'mobile', 'Mobile Extra Menu' );

  
  add_filter( 'wp_nav_menu_items', 'mobile_custom_menu_item', 10, 2 );
  function mobile_custom_menu_item ( $items, $args ) {
      if ($args->theme_location == 'mobile') {
          $items = '<li><a href="#" class="search_mobile"><i class="fa fa-search" aria-hidden="true"></i></a></li>'.$items;
      }
      return $items;
  }

  
  if( function_exists('acf_add_options_page') ) {
	
    $option_page = acf_add_options_page(array(
      'page_title' 	=> 'Theme General Settings',
      'menu_title' 	=> 'Theme Settings',
      'menu_slug' 	=> 'theme-general-settings',
      'capability' 	=> 'edit_posts',
      'redirect' 	=> false
    ));
	
  }
  
  function bd_fetch_all_user_fields($user_id = 0) {
    if ($user_id == 0) {
      $user_id = bp_displayed_user_id();
    }
    if (!$user_id) {
      return false;
    }
    
    $result = array();
    $current_user_id = bp_loggedin_user_id();
    
    if ( bp_has_profile('user_id='. $user_id) ) {
      while ( bp_profile_groups() ) {
        bp_the_profile_group();

        if ( bp_profile_group_has_fields() ) {

   
          // bp_the_profile_group_name();
          while ( bp_profile_fields() ) { 

            bp_the_profile_field();
   
            if ( bp_field_has_data() ) {
              
              $hidden_fields = bp_xprofile_get_hidden_fields_for_user($user_id, $current_user_id);
              $field_id = bp_get_the_profile_field_name();
              
              if(!in_array($field_id, $hidden_fields)){
                $args = array(
                'field' => $field_id, // Field ID or name.
                'user_id' => $user_id // Default -- It is profile owner id
                );
                $data = bp_get_profile_field_data($args);
                
                if (!is_array($data) && strip_tags($data) != '') {
                  $result[''.bp_get_the_profile_field_name().''] = bp_get_the_profile_field_value();
                }
              }

            }
          }
        }
      }
      
      return $result;
    } else {
 
      return false;
 
    }
  }
  
  function loadcss() {
    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_register_style('bootstrap_theme', get_template_directory_uri() . '/css/bootstrap-theme.min.css');
    wp_register_style('font_awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
    wp_register_style('genstyle', get_template_directory_uri() . '/style.css', array(), uniqid(), 'screen');
    wp_register_style('google-font','https://fonts.googleapis.com/css?family=Open+Sans:400,700,300,800', array(), false, 'screen');
    
    wp_enqueue_style( 'bootstrap' );
    wp_enqueue_style( 'bootstrap_theme' );
    wp_enqueue_style( 'font_awesome' );

    wp_enqueue_style( 'genstyle' );
    wp_enqueue_style( 'google-font' );
    
    // fancybox
    wp_register_style('fancybox_css', get_template_directory_uri() . '/css/jquery.fancybox.min.css', array(), false, 'screen');   
    wp_enqueue_style( 'fancybox_css' );

    
  }
  
  function loadjs() {
    wp_enqueue_script('jquery');
    
    wp_register_script('bootstrap_script', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ));
    wp_enqueue_script('bootstrap_script');
    
    wp_register_script('matchHeight_script', get_template_directory_uri() . '/js/jquery.matchHeight-min.js', array( 'jquery' ));
    wp_enqueue_script('matchHeight_script');
    
    // fancybox

    wp_register_script('fancybox_js', get_template_directory_uri() . '/js/jquery.fancybox.min.js', array( 'jquery' ));
    wp_enqueue_script('fancybox_js');

    
    // map
    // wp_register_script('gmap', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=falses');
    // wp_enqueue_script('gmap');
    
    // custom
    wp_register_script('custom_script', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), uniqid());
    wp_enqueue_script('custom_script');
    
  }
  
  add_action("wp_enqueue_scripts", "loadcss", 13); 
  add_action("wp_enqueue_scripts", "loadjs", 14); 
  
  
  // add ie (internet explorer) body class
  function ie_body_class($c) {
    global $is_IE;
    if ($is_IE == true) {
      $c[] = 'is_ie';
    }
    
    $user_agent = getenv("HTTP_USER_AGENT");
    
    if(strpos($user_agent, "Win") !== FALSE) {
      $c[] = "is_win";
    }
    elseif(strpos($user_agent, "Mac") !== FALSE) {
      $c[] = "is_mac";
    }
    
    return $c;
  }
  add_filter('body_class', 'ie_body_class');
  

  
  /*  MENU */
  
class My_Custom_Nav_Walker extends Walker_Nav_Menu {

   function start_lvl(&$output, $depth = 0, $args = array()) {
      $output .= "\n<div class=\"dropdown-menu\">\n<div class=\"container\">\n<ul class=\"dropdown-menu-inner\">\n";
   }
   
   public function end_lvl( &$output, $depth = 0, $args = array() ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat( $t, $depth );
        $output .= "$indent</ul></div></div>{$n}";
    }

   function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
       $item_html = '';
       parent::start_el($item_html, $item, $depth, $args);

       if ( $item->is_dropdown && $depth === 0 ) {
           $item_html = str_replace( '<a', '<a class="dropdown-toggle disabled" data-toggle="dropdown"', $item_html );
           $item_html = str_replace( '</a>', ' <b class="caret"></b></a> <span class="glyphicon glyphicon-chevron-down droptoggle"></span><span class="glyphicon glyphicon-chevron-up droptoggle"></span>', $item_html );
       }
       
       if ($item->description != '' && in_array('htmlmenu', $item->classes)) {
        $item_html = str_replace('</a>', '<span class="description">'.str_replace('\n', '<br />', __($item->description, 'pax')).'</span></a>', $item_html);
      }

       $output .= $item_html;
    }

    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
        if ( $element->current )
        $element->classes[] = 'active';

        $element->is_dropdown = !empty( $children_elements[$element->ID] );

        if ( $element->is_dropdown ) {
            if ( $depth === 0 ) {
                $element->classes[] = 'dropdown';
            } elseif ( $depth === 1 ) {
                // Extra level of dropdown menu, 
                // as seen in http://twitter.github.com/bootstrap/components.html#dropdowns
                $element->classes[] = 'dropdown-submenu';
            }
        }

    parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}

// Allow HTML descriptions in WordPress Menu
remove_filter( 'nav_menu_description', 'strip_tags' );
add_filter( 'wp_setup_nav_menu_item', 'nitro_wp_setup_nav_menu_item' );
function nitro_wp_setup_nav_menu_item( $menu_item ) {
    if (in_array('htmlmenu', $menu_item->classes)) {
      $menu_item->description = apply_filters( 'nav_menu_description', $menu_item->post_content );
    }
     return $menu_item;
}

 

  //Gets post cat slug and looks for single-[cat slug].php and applies it
  add_filter('single_template', 'getsinglebyslug');
  function getsinglebyslug ($the_template) {
    global $post;
    foreach( (array) get_the_category() as $cat ) {
      if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") ) {
        return TEMPLATEPATH . "/single-{$cat->slug}.php";
      } 
    }
    return $the_template;
  }
  
  
  
  // remove queries
  function _remove_script_version( $src ){
    $parts = explode( '.js?', $src );
    if (!empty($parts) && isset($parts[1]) && strpos($parts[0], 'maps') === FALSE) {
      return $parts[0].'.js';
    } else {
      return $src;
    }
  }
  add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
  
  function _remove_style_version( $src ){
    $parts = explode( '.css?', $src );
    if (!empty($parts[1]) && strpos($parts[0], 'google') === FALSE) {
      return $parts[0].'.css';
    } else {
      return $src;
    }
  }
  
  add_filter( 'style_loader_src', '_remove_style_version', 15, 1 );

  
  // Breadcrumbs
function custom_breadcrumbs() {
       
    // Settings
    $separator          = '';
    $breadcrums_id      = 'breadcrumb';
    $breadcrums_class   = 'breadcrumb';
    $home_title         = '<i class="fa fa-home" aria-hidden="true"></i>';
    $prefix             = '';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="'. __('Home', 'opsi') .'">' . $home_title . '</a></li>';
        
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $category_val = array_values($category);
                $last_category = end($category_val);
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
           
    }
       
}




 
// Add the posts and pages columns filter. They can both use the same function.
add_filter('manage_posts_columns', 'nitro_add_post_admin_thumbnail_column', 2);
add_filter('manage_pages_columns', 'nitro_add_post_admin_thumbnail_column', 2);
 
// Add the column
function nitro_add_post_admin_thumbnail_column($nitro_columns){
	$nitro_columns['nitro_thumb'] = __('Featured Image');
	return $nitro_columns;
}
 
// Let's manage Post and Page Admin Panel Columns
add_action('manage_posts_custom_column', 'nitro_show_post_thumbnail_column', 5, 2);
add_action('manage_pages_custom_column', 'nitro_show_post_thumbnail_column', 5, 2);
 
// Here we are grabbing featured-thumbnail size post thumbnail and displaying it
function nitro_show_post_thumbnail_column($nitro_columns, $nitro_id){
	switch($nitro_columns){
		case 'nitro_thumb':
		if( function_exists('the_post_thumbnail') )
			echo the_post_thumbnail( array(120,120) );
		else
			echo 'hmm... your theme doesn\'t support featured image...';
		break;
	}
}


/* Change Excerpt length */
function nitro_excerpt($limit) {
    return wp_trim_words(get_the_excerpt(), $limit, '');
}




// init custom post type
add_action( 'init', 'opsi_post_type');
/**  
* Create Projects Post Type
*/
function opsi_post_type() {

  $labels = array(
    'name'                => _x( 'Projects', 'Post Type General Name', 'opsi' ),
    'singular_name'       => _x( 'Project', 'Post Type Singular Name', 'opsi' ),
    'menu_name'           => __( 'Projects', 'opsi' ),
    'name_admin_bar'      => __( 'Projects', 'opsi' ),
    'parent_item_colon'   => __( 'Parent Project:', 'opsi' ),
    'all_items'           => __( 'Projects', 'opsi' ),
    'add_new_item'        => __( 'Add New Project', 'opsi' ),
    'add_new'             => __( 'Add Project', 'opsi' ),
    'new_item'            => __( 'New Project', 'opsi' ),
    'edit_item'           => __( 'Edit Project', 'opsi' ),
    'update_item'         => __( 'Update Project', 'opsi' ),
    'view_item'           => __( 'View Project', 'opsi' ),
    'search_items'        => __( 'Search Project', 'opsi' ),
    'not_found'           => __( 'Not found', 'opsi' ),
    'not_found_in_trash'  => __( 'Not found in Trash', 'opsi' ),
  );
  $args = array(
    'label'               => __( 'Project', 'opsi' ),
    'description'         => __( 'Project entries', 'opsi' ),
    'labels'              => $labels,
    'supports'            => array( 'title', 'author', 'editor', 'thumbnail', 'excerpt', 'trackbacks', 'comments', 'custom-fields', 'revisions', 'post-formats'),
    'hierarchical'        => true,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'menu_position'       => 5,
    'menu_icon'           => 'dashicons-portfolio',
    'show_in_admin_bar'   => true,
    'show_in_nav_menus'   => true,
    'can_export'          => true,
    'has_archive'         => true,		
    'exclude_from_search' => true,
    'publicly_queryable'  => true,
    'rewrite'             => array('with_front' => false),
    'capability_type'     => 'post'
  );
  register_post_type( 'project', $args );

}


class mtekk_post_parents
{
	protected $version = '0.2.0';
	protected $full_name = 'Post Parents';
	protected $short_name = 'Post Parents';
	protected $access_level = 'manage_options';
	protected $identifier = 'mtekk_post_parents';
	protected $unique_prefix = 'mpp';
	protected $plugin_basename = 'post-parents/post_parents.php';
	/**
	 * mlba_video
	 * 
	 * Class default constructor
	 */
	function __construct()
	{
		//We set the plugin basename here, could manually set it, but this is for demonstration purposes
		$this->plugin_basename = plugin_basename(__FILE__);
		add_action('add_meta_boxes', array($this, 'meta_boxes'));
	}
	/**
	 * Function that fires on the add_meta_boxes action
	 */
	function meta_boxes()
	{
		global $wp_post_types, $wp_taxonomies;
		//Loop through all of the post types in the array
		foreach($wp_post_types as $post_type)
		{
			if($post_type->name == 'project')
			{
				//Add our post parent metabox
				add_meta_box('postparentdiv', __('Parent', 'mtekk-post-parents'), array($this,'parent_meta_box'), $post_type->name, 'side', 'default');
			}
		}
	}
	/**
	 * This function outputs the post parent metabox
	 * 
	 * @param WP_Post $post The post object for the post being edited
	 */
	function parent_meta_box($post)
	{
		//If we use the parent_id we can sneak in with WP's styling and post save routines
		wp_dropdown_pages(array(
      'post_type' => 'project',
			'name' => 'parent_id',
			'id' => 'parent_id',
			'echo' => 1,
			'show_option_none' => __( '&mdash; Select &mdash;' ),
			'option_none_value' => '0',
			'exclude' => $post->ID,
			'selected' => $post->post_parent)
		);
	}
}
$mtekk_post_parents = new mtekk_post_parents();


if ( ! function_exists( 'project_category' ) ) {

// Register Custom Taxonomy
function project_category() {

	$labels = array(
		'name'                       => _x( 'Categories', 'Taxonomy General Name', 'opsi' ),
		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'opsi' ),
		'menu_name'                  => __( 'Categories', 'opsi' ),
		'all_items'                  => __( 'All Items', 'opsi' ),
		'parent_item'                => __( 'Parent Item', 'opsi' ),
		'parent_item_colon'          => __( 'Parent Item:', 'opsi' ),
		'new_item_name'              => __( 'New Item Name', 'opsi' ),
		'add_new_item'               => __( 'Add New Item', 'opsi' ),
		'edit_item'                  => __( 'Edit Item', 'opsi' ),
		'update_item'                => __( 'Update Item', 'opsi' ),
		'view_item'                  => __( 'View Item', 'opsi' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'opsi' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'opsi' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'opsi' ),
		'popular_items'              => __( 'Popular Items', 'opsi' ),
		'search_items'               => __( 'Search Items', 'opsi' ),
		'not_found'                  => __( 'Not Found', 'opsi' ),
		'no_terms'                   => __( 'No items', 'opsi' ),
		'items_list'                 => __( 'Items list', 'opsi' ),
		'items_list_navigation'      => __( 'Items list navigation', 'opsi' ),
	);
	$rewrite = array(
		'slug'                       => 'project-category',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'project_category', array( 'project' ), $args );

}
add_action( 'init', 'project_category', 0 );

}



if ( ! function_exists( 'project_tag' ) ) {

// Register Custom Taxonomy
function project_tag() {

	$labels = array(
		'name'                       => _x( 'Tags', 'Taxonomy General Name', 'opsi' ),
		'singular_name'              => _x( 'Tags', 'Taxonomy Singular Name', 'opsi' ),
		'menu_name'                  => __( 'Tags', 'opsi' ),
		'all_items'                  => __( 'All Items', 'opsi' ),
		'parent_item'                => __( 'Parent Item', 'opsi' ),
		'parent_item_colon'          => __( 'Parent Item:', 'opsi' ),
		'new_item_name'              => __( 'New Item Name', 'opsi' ),
		'add_new_item'               => __( 'Add New Item', 'opsi' ),
		'edit_item'                  => __( 'Edit Item', 'opsi' ),
		'update_item'                => __( 'Update Item', 'opsi' ),
		'view_item'                  => __( 'View Item', 'opsi' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'opsi' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'opsi' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'opsi' ),
		'popular_items'              => __( 'Popular Items', 'opsi' ),
		'search_items'               => __( 'Search Items', 'opsi' ),
		'not_found'                  => __( 'Not Found', 'opsi' ),
		'no_terms'                   => __( 'No items', 'opsi' ),
		'items_list'                 => __( 'Items list', 'opsi' ),
		'items_list_navigation'      => __( 'Items list navigation', 'opsi' ),
	);
	$rewrite = array(
		'slug'                       => 'project-tag',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'project_tag', array( 'project' ), $args );

}
add_action( 'init', 'project_tag', 0 );

}



add_action('print_media_templates', 'opsi_print_media_templates');

function opsi_print_media_templates() {
?>
<script type="text/html" id="tmpl-custom-gallery-setting">
    <label class="setting">
      <span><?php _e('Caption'); ?></span>
      <select data-setting="caption">
        <option value="no">No</option>
        <option value="yes">Yes</option>
      </select>
    </label>
</script>

<script>

    jQuery(document).ready(function()
    {
        _.extend(wp.media.galleryDefaults, {
        caption: 'no',
        });

        wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
        template: function(view){
          return wp.media.template('gallery-settings')(view)
               + wp.media.template('custom-gallery-setting')(view);
        },
        // this is function copies from WP core /wp-includes/js/media-views.js?ver=4.6.1
        update: function( key ) {
          var value = this.model.get( key ),
            $setting = this.$('[data-setting="' + key + '"]'),
            $buttons, $value;

          // Bail if we didn't find a matching setting.
          if ( ! $setting.length ) {
            return;
          }

          // Attempt to determine how the setting is rendered and update
          // the selected value.

          // Handle dropdowns.
          if ( $setting.is('select') ) {
            $value = $setting.find('[value="' + value + '"]');

            if ( $value.length ) {
              $setting.find('option').prop( 'selected', false );
              $value.prop( 'selected', true );
            } else {
              // If we can't find the desired value, record what *is* selected.
              this.model.set( key, $setting.find(':selected').val() );
            }

          // Handle button groups.
          } else if ( $setting.hasClass('button-group') ) {
            $buttons = $setting.find('button').removeClass('active');
            $buttons.filter( '[value="' + value + '"]' ).addClass('active');

          // Handle text inputs and textareas.
          } else if ( $setting.is('input[type="text"], textarea') ) {
            if ( ! $setting.is(':focus') ) {
              $setting.val( value );
            }
          // Handle checkboxes.
          } else if ( $setting.is('input[type="checkbox"]') ) {
            $setting.prop( 'checked', !! value && 'false' !== value );
          }
          // HERE the only modification I made
          else {
            $setting.val( value ); // treat any other input type same as text inputs
          }
          // end of that modification
        },
        });
    });

</script>
<?php
}

function nitro_gallery_shortcode_filter( $output = '', $atts, $instance ) {
	$return = $output; // fallback

	// retrieve content of your own gallery function
	$my_result = nitro_gallery_shortcode( $atts );

	// boolean false = empty, see http://php.net/empty
	if( !empty( $my_result ) ) {
		$return = $my_result;
	}

	return $return;
}

add_filter( 'post_gallery', 'nitro_gallery_shortcode_filter', 10, 3 );


function nitro_gallery_shortcode( $attr ) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) ) {
			$attr['orderby'] = 'post__in';
		}
		$attr['include'] = $attr['ids'];
	}

	/**
	 * Filters the default gallery shortcode output.
	 *
	 * If the filtered output isn't empty, it will be used instead of generating
	 * the default gallery template.
	 *
	 * @since 2.5.0
	 * @since 4.2.0 The `$instance` parameter was added.
	 *
	 * @see gallery_shortcode()
	 *
	 * @param string $output   The gallery output. Default empty.
	 * @param array  $attr     Attributes of the gallery shortcode.
	 * @param int    $instance Unique numeric ID of this gallery shortcode instance.
	 */
	$output = '';
  $galid = uniqid();

	$html5 = current_theme_supports( 'html5', 'gallery' );
	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => $html5 ? 'figure'     : 'dl',
		'icontag'    => $html5 ? 'div'        : 'dt',
		'captiontag' => $html5 ? 'figcaption' : 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		'link'       => '',
		'caption'    => 'no'
	), $attr, 'gallery' );

	$id = intval( $atts['id'] );

	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	}

	if ( empty( $attachments ) ) {
		return '';
	}

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
		}
		return $output;
	}

	$itemtag = tag_escape( $atts['itemtag'] );
	$captiontag = tag_escape( $atts['captiontag'] );
	$caption    = tag_escape( $atts['caption'] );
	$icontag = tag_escape( $atts['icontag'] );
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) ) {
		$itemtag = 'dl';
	}
	if ( ! isset( $valid_tags[ $captiontag ] ) ) {
		$captiontag = 'dd';
	}
	if ( ! isset( $valid_tags[ $icontag ] ) ) {
		$icontag = 'dt';
	}

	$columns = intval( $atts['columns'] );
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = '';

	/**
	 * Filters whether to print default gallery styles.
	 *
	 * @since 3.1.0
	 *
	 * @param bool $print Whether to print default gallery styles.
	 *                    Defaults to false if the theme supports HTML5 galleries.
	 *                    Otherwise, defaults to true.
	 */
	if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
			/* see gallery_shortcode() in wp-includes/media.php */
		</style>\n\t\t";
	}

	$size_class = sanitize_html_class( $atts['size'] );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

	/**
	 * Filters the default gallery shortcode CSS styles.
	 *
	 * @since 2.5.0
	 *
	 * @param string $gallery_style Default CSS styles and opening HTML div container
	 *                              for the gallery shortcode output.
	 */
	$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {

		$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
		if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
			$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
		} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
			$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
		} else {
			$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
		}
    
    
    
		$image_meta  = wp_get_attachment_metadata( $id );
    
    
    $image_output = str_replace("<a", "<a data-fancybox='". $galid ."' data-caption='". wptexturize($attachment->post_excerpt) ."' ", $image_output);

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
		}
		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$image_output
			</{$icontag}>";
      
    
		if ( $captiontag && trim($attachment->post_excerpt) && $caption != 'no' ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
			$output .= '<br style="clear: both" />';
		}
	}

	if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
		$output .= "
			<br style='clear: both' />";
	}

	$output .= "
		</div>\n";

	return $output;
}


/****************************/
/*        BUDDYPRESS        */

function redirect2profile(){
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if($_SERVER['REQUEST_URI'] == '/profile/' && is_plugin_active('buddypress/bp-loader.php') && is_user_logged_in()){
		global $current_user;
		wp_safe_redirect( get_bloginfo('url') . '/members/'. $current_user->user_login . '/profile/'); 
		exit();
	}
  // hide theme my login profile edit page
  if($_SERVER['REQUEST_URI'] == '/your-profile/' && is_plugin_active('buddypress/bp-loader.php') && is_user_logged_in()){
		global $current_user;
		wp_safe_redirect( get_bloginfo('url') . '/members/'. $current_user->user_login . '/profile/edit/'); 
		exit();
	}
  // redirect to login page if user is not logged in and tries to access the tml profile edit page
  if($_SERVER['REQUEST_URI'] == '/your-profile/' && is_plugin_active('buddypress/bp-loader.php') && !is_user_logged_in()){
		global $current_user;
		wp_safe_redirect( get_permalink(get_page_by_path('register')));
		exit();
	}
 }
add_action('init', 'redirect2profile');


function nitro_bp_core_avatar_class($classes) {
  
  $classes .= ' img-circle';
  
  return $classes;
}
add_filter( 'bp_core_avatar_class', 'nitro_bp_core_avatar_class');

// nav menu hooks
add_filter('wp_nav_menu_objects', 'bp_menu_items_tweak', 10, 2);

function bp_menu_items_tweak($items, $args) {
  
  if (($args->theme_location == 'mobile' || $args->theme_location == 'primary') && is_user_logged_in()) {
    $user = wp_get_current_user();
    
    $notifications_count = bp_notifications_get_unread_notification_count( $user->ID );
    
    foreach($items as $item) {
      // replace with bell icon and add bubble
      if (in_array('bp-notifications-nav', $item->classes)) {
        $item->title = '<i class="fa fa-bell" aria-hidden="true"></i><span class="button__badge '. ($notifications_count > 0 ? 'active' : 'default') .'">'. $notifications_count .'</span>';
      }
      // replace with avatar icon & name
      if (in_array('bp-user-nav', $item->classes)) {
        global $bp;
        $item->title = '<span class="hidden-xs">'.bp_core_get_user_displayname($user->ID) .'</span> '. bp_get_displayed_user_avatar( array('item_id' => $user->ID, 'type'=>'thumb') ) . ($args->theme_location == 'mobile' ? '<b class="caret"></b>' : '');
        $item->url = bp_loggedin_user_domain();
      }
    }
  }
  
  return $items;
}

function opsi_tml_action_url( $url, $action, $instance ) {
	if ( 'register' == $action )
		$url = get_permalink(get_page_by_path('register'));
	return $url;
}
add_filter( 'tml_action_url', 'opsi_tml_action_url', 10, 3 );



function nitro_user_can_create_groups( $can_create, $restricted=false ){
    // maybe we don't want to override if it's restricted?
    if ( ! $restricted ){
        // get the logged in user's ID
        $user_ID = get_current_user_id();
        // some logic to determine if the current user can create a group
        if ( user_can_create_group( $user_ID ) ){
            // we will return this allowing them to create groups
            $can_create = true;
        } else {
          $can_create = false;
        }
    }
    return $can_create;
}
add_filter( 'bp_user_can_create_groups', 'nitro_user_can_create_groups', 10, 2 );

function user_can_create_group($userid) {
  
  if (current_user_can('administrator')) {
    return true;
  }
  
  if( current_user_can('bd_create_group')){
    return true;
  }
  
  return false;
}

add_action('load-users.php',function() {

if(isset($_GET['action']) && isset($_GET['bp_gid']) && isset($_GET['users'])) {
    $group_id = $_GET['bp_gid'];
    $users = $_GET['users'];
    foreach ($users as $user_id) {
        groups_join_group( $group_id, $user_id );
    }
}
    //Add some Javascript to handle the form submission
    add_action('admin_footer',function(){ ?>
    <script>
        jQuery("select[name='action']").append(jQuery('<option value="groupadd">Add to BP Group</option>'));
        jQuery("#doaction").click(function(e){
            if(jQuery("select[name='action'] :selected").val()=="groupadd") { e.preventDefault();
                gid=prompt("Please enter a BuddyPres Group ID","1");
                jQuery(".wrap form").append('<input type="hidden" name="bp_gid" value="'+gid+'" />').submit();
            }
        });
    </script>
    <?php
    });
});

function bp_get_roles() {
  if ( ! function_exists( 'get_editable_roles' ) ) {
    require_once ABSPATH . 'wp-admin/includes/user.php';
  }
  $roles = array();
  $get_editable_roles = get_editable_roles();
  foreach ($get_editable_roles as $key => $value) {
    if (strpos($key, 'bd_') !== false) {
      $roles[$key] = $value;
    }
  }
  
  return $roles;
}


if ( class_exists('BP_Group_Extension') ) : // Recommended, to prevent problems during upgrade or when Groups are disabled

    class BP_Group_Role_Access_Plugin_Extension extends BP_Group_Extension {

        var $visibility = 'private';
        var $format_notification_function;
        var $enable_edit_item = true;
        var $admin_metabox_context = 'side'; // The context of your admin metabox. See add_meta_box()
        var $admin_metabox_priority = 'default'; // The priority of your admin metabox. See add_meta_box()

        function __construct() {
            $bp = buddypress();

            $this->name = __('Role Access' , 'opsi');
            $this->slug = 'role_access';

            /* For internal identification */
            $this->id = 'group_role_access';
            $this->format_notification_function = 'bp_group_role_access_format_notifications';
            $this->create_step_position = 22;
            
        }

        /**
         * The content of the BP group documents tab of the group creation process
         *
         */
        function create_screen($group_id = null) {
            $bp = buddypress();
            if ( !bp_is_group_creation_step($this->slug) ) {
                return false;
            }
            $this->edit_create_markup($bp->groups->new_group_id);
            wp_nonce_field('groups_create_save_' . $this->slug);
        }

        /**
         * The routine run after the user clicks Continue from the creation step
         */
        function create_screen_save($group_id = null) {
            $bp = buddypress();

            check_admin_referer('groups_create_save_' . $this->slug);

            do_action('bp_group_role_access_group_create_save');
            $success = false;


            //Update permissions
            $valid_permissions = array('members' , 'mods_only');
            if ( isset($_POST['bp_group_role_access']) && !empty($_POST['bp_group_role_access']) && is_array($_POST['bp_group_role_access']) ) {
                $success = groups_update_groupmeta($bp->groups->new_group_id , 'group_role_access' , $_POST['bp_group_role_access']);
            }


            /* To post an error/success message to the screen, use the following */
            if ( !$success )
                bp_core_add_message(__('There was an error saving, please try again' , 'buddypress') , 'error');
            else
                bp_core_add_message(__('Settings Saved.' , 'buddypress'));
            do_action('bp_group_role_access_group_after_create_save');
        }

        /**
         * The content of the Group Role Access page of the group admin
         */
        function edit_screen($group_id = null) {
            $bp = buddypress();
            if ( !bp_is_group_admin_screen($this->slug) ) {
                return false;
            }
            //useful ur for submits & links
            $action_link = get_bloginfo('url') . '/' . bp_get_groups_root_slug() . '/' . $bp->current_item . '/' . $bp->current_action . '/' . $this->slug;
            $this->edit_create_markup($bp->groups->current_group->id);
            
            do_action('bp_group_role_access_group_admin_edit');
            ?>
            &nbsp;<p>
                <input type="submit" value="<?php _e('Save Changes' , 'buddypress') ?>" id="save" name="save" />
                <input type="hidden" name="setRoles" value="" />
            </p>
            <?php
            wp_nonce_field('groups_edit_save_' . $this->slug);
        }

        function edit_create_markup($gid) {
            $bp = buddypress();

            $group_role_access = groups_get_groupmeta($gid, 'group_role_access', true);
            if (empty($group_role_access) || !$group_role_access) {
              $group_role_access = array();
            }
            
            // get user data
            $userdata = get_userdata(bp_loggedin_user_id());
            $bp_group_role_access = groups_get_groupmeta($gid, 'group_role_access', true);
            if ($bp_group_role_access) {
              $intersect = array_intersect($userdata->roles, $bp_group_role_access);
            } else {
              $intersect = array();
            }
            
            //only show the roles persmissions if the site admin allows this to be changed at group-level
            ?>
            <p>
              <?php _e( 'By default all groups are open to all member roles.', 'opsi' ); ?><br />
              <?php _e( 'Which roles should be <b>DENIED</b> access to the group page?', 'opsi' ); ?>
            </p>
            <?php 
              $bp_get_roles = bp_get_roles();              
              if (!empty($bp_get_roles)) { ?>
                <div class="checkbox">
                  <?php foreach($bp_get_roles as $key => $value) { 
                  
                    if (in_array($key, $intersect)) { continue; }
                  
                  ?>
                    <label for="group_role_access_<?php echo $key; ?>" style="display: block; <?php echo (in_array($key, $group_role_access) ? 'opacity: 0.6; ' : '' ); ?>"><input type="checkbox" name="group_role_access[]" id="group_role_access_<?php echo $key; ?>" value="<?php echo $key; ?>" <?php echo (in_array($key, $group_role_access) ? 'checked' : '' ); ?> /> <?php echo $value['name']; ?></label>
                  <?php } ?>
                </div>
            
              <?php } else { ?>
                <div class="alert alert-warning">
                <?php _e('No suitable roles were found', 'opsi'); ?>
                </div>
                <?php
              }
        }

        /**
         * The routine run after the user clicks Save from your admin tab
         */
        function edit_screen_save($group_id = null) {
            $bp = buddypress();
            do_action('bp_group_role_access_group_admin_save');
            $message = '';
            $type = '';

            
            if ( (!isset($_POST['save'])) && (!isset($_POST['setRoles'])) ) {
                return false;
            }

            check_admin_referer('groups_edit_save_' . $this->slug);
            // $message .= '<pre>'.print_r($_POST, true).'</pre>';
            // $message .= '<pre>'.print_r($this->slug, true).'</pre>';

            //check if group upload permision has chanced
            if ( isset($_POST['group_role_access']) && is_array($_POST['group_role_access']) ) {
                if ( true == groups_update_groupmeta($bp->groups->current_group->id , 'group_role_access' , $_POST['group_role_access']) ) {
                    if ( $message != '' ) {
                        $message .= '.     ';
                    }
                    groups_edit_group_settings($bp->groups->current_group->id, true, 'private');
                    $message .= __('Role Access Permissions changed successfully.' , 'opsi') . ' ';
                    $message .= __('The group was set to private.' , 'opsi') . '.';
                }
            }
            if ( !isset($_POST['group_role_access']) && $this->slug == 'role_access') {
              groups_delete_groupmeta( $bp->groups->current_group->id, 'group_role_access' );
              $message .= __('Role Access Permissions changed successfully.' , 'opsi') . ' ';
            }
            


            /* Post an error/success message to the screen */

            if ( '' == $message )
                bp_core_add_message(__('No changes were made. Either error or you didn\'t change anything' , 'opsi') , 'error');
            else
                bp_core_add_message($message , $type);

            do_action('bp_group_role_access_group_admin_after_save');
            bp_core_redirect(bp_get_group_permalink($bp->groups->current_group) . 'admin/' . $this->slug);
        }

        /**
         * @version 1, 25/4/2013
         * @since version 0.5
         * @author Stergatu
         */
        function display($group_id = null) {
            // do_action('bp_group_role_access_display');
            // add_action('bp_template_content_header' , 'bp_group_role_access_display_header');
            // add_action('bp_template_title' , 'bp_group_role_access_display_title');
            // bp_group_role_access_display();
        }

        /**
         * Add a metabox to the admin Edit group screen
         *
         */
        function admin_screen($group_id = null) {
            $this->edit_create_markup($group_id);
        }

        /**
         * The routine run after the group is saved on the Dashboard group admin screen
         * @param type $group_id
         */
        function admin_screen_save($group_id = null) {
            // Grab your data out of the $_POST global and save as necessary
            //Update permissions

            if ( isset($_POST['group_role_access']) && is_array($_POST['group_role_access']) ) {
              groups_update_groupmeta($group_id , 'group_role_access' , $_POST['group_role_access']);
            }
        }

        function widget_display() {
            ?>
            <div class="info-group">
                <h4><?php echo esc_attr($this->name) ?></h4>
                <p>
                    Not yet implemented
                </p>
            </div>
            <?php
        }

    }

    bp_register_group_extension('BP_Group_Role_Access_Plugin_Extension');



endif; // class_exists( 'BP_Group_Extension' )


function nitro_remove_group_tabs() {  

/**
 * @since 2.6.0 Introduced the $component parameter.
 *
 * @param string $slug      The slug of the primary navigation item.
 * @param string $component The component the navigation is attached to. Defaults to 'members'.
 * @return bool Returns false on failure, True on success.
 */ 

	if ( ! bp_is_group() ) {
		return;
	}

	$slug = bp_get_current_group_slug();
        // all existing default group tabs are listed here. Uncomment or remove.
	//	bp_core_remove_subnav_item( $slug, 'members' );
		bp_core_remove_subnav_item( $slug, 'role_access' );
		// bp_core_remove_subnav_item( $slug, 'send-invites' );
	//	bp_core_remove_subnav_item( $slug, 'admin' );
	//	bp_core_remove_subnav_item( $slug, 'forum' );

}
add_action( 'bp_actions', 'nitro_remove_group_tabs' );




function opsi_bp_groups_forum_first_tab() {
  global $bp;
  // echo '<pre>'.print_r($bp->groups, true).'</pre>';
  bp_core_new_subnav_item( 
    array( 
        'name' => __('All groups', 'opsi'), 
        'slug' => 'all-groups', 
        'parent_slug' => $bp->groups->slug,
        'parent_url' => $bp->groups->slug,
        'position' => 50, 
        'screen_function' => 'false',
        'link' => bp_get_groups_directory_permalink()
        // 'link' => get_option('siteurl') . '/groups/create/step/group-details/'
    ));
    if (current_user_can('bd_create_group')) {
      bp_core_new_subnav_item( 
      array( 
          'name' => __('Create group', 'opsi'), 
          'slug' => 'create-group', 
          'parent_slug' => $bp->groups->slug,
          'parent_url' => $bp->groups->slug,
          'position' => 60, 
          'screen_function' => 'false',
          'link' => get_option('siteurl') . '/groups/create/step/group-details/'
      ));
    }
}
add_action('bp_actions', 'opsi_bp_groups_forum_first_tab');


add_action( 'bp_after_profile_field_content', 'nitro_bp_after_profile_field_content' );
function nitro_bp_after_profile_field_content() {
  
  global $wp_query, $bp;
  if (
        $bp->canonical_stack['component'] == 'profile'
    &&  (isset($bp->canonical_stack['action']) && $bp->canonical_stack['action'] == 'edit')
    &&  $bp->canonical_stack['action_variables'][0] == 'group'
    &&  $bp->canonical_stack['action_variables'][1] == 1
  
    ) {
  
    // $userdata = get_userdata( bp_loggedin_user_id() );
    $userdata = get_userdata( bp_displayed_user_id() );
    
    echo '
      <label for="email">E-mail <span class="description">'. bp_the_profile_field_required_label() .'</span></label>
      <input type="text" name="email" id="email" value="'. $userdata->user_email .'" class="regular-text">
    ';
  }
}

add_action( 'xprofile_updated_profile', 'nitro_xprofile_updated_profile', 10, 5 );
function nitro_xprofile_updated_profile($user_id, $posted_field_ids, $errors, $old_values, $new_values) {
  
  global $wp_query, $bp;
  if (
        $bp->canonical_stack['component'] == 'profile'
    &&  $bp->canonical_stack['action'] == 'edit'
    &&  $bp->canonical_stack['action_variables'][0] == 'group'
    &&  $bp->canonical_stack['action_variables'][1] == 1
  
    ) {
  
  
    $userdata = get_userdata($user_id);
    $user_email = $userdata->user_email;
    
    if (isset( $_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      // check if user is really updating the value
      if ($user_email != $_POST['email']) {       
          // check if email is free to use
          if (email_exists( $_POST['email'] )){
              // Email exists, do not update value.
              // Maybe output a warning.
          } else {
              $args = array(
                  'ID'         => $user_id,
                  'user_email' => esc_attr( $_POST['email'] )
              );            
          wp_update_user( $args );
         }   
      }
    }
  }
  
}


remove_filter( 'xprofile_field_options_before_save', 'bp_xprofile_sanitize_field_options' );
add_filter( 'xprofile_field_options_before_save', 'opsi_bp_xprofile_sanitize_field_options' );

function opsi_bp_xprofile_sanitize_field_options( $field_options = '' ) {
	if ( is_array( $field_options ) ) {
		return array_map( 'sanitize_textarea_field', $field_options );
	} else {
		return sanitize_text_field( $field_options );
	}
}

/**
 * Buddypress Header Type
 */
 
add_filter( 'bp_xprofile_get_field_types', 'nitro_get_field_types', 10, 1 );
function nitro_get_field_types($fields) {
    $fields = array_merge($fields, array('header' => 'nitro_bd_field_type_header'));
    $fields = array_merge($fields, array('repeater' => 'nitro_bd_field_type_repeater'));
    $fields = array_merge($fields, array('multiselectbox_opsi' => 'BP_XProfile_Field_Type_Multiselectbox_OPSI'));
    return $fields;
}
 
 
 
if (!class_exists('nitro_bd_field_type_header'))
{
    class nitro_bd_field_type_header extends BP_XProfile_Field_Type
    {
        public function __construct() {
            parent::__construct();

            $this->name = __( 'Text field with Header', 'bxcft' );

            $this->accepts_null_value = true;
            $this->supports_options = true;
            $this->supports_richtext = false;
            
            $this->set_format( '/.*?/', 'replace' );

            do_action( 'bp_xprofile_field_type_header', $this );
        }

        public function admin_field_html (array $raw_properties = array ())
        {
            global $field;

            $args = array(
                'type' => 'text'
            );

            $options = $field->get_children( true );
            if ($options) {
                foreach ($options as $o) {
                    if (strpos($o->name, 'header_') !== false) {
                        $args['header'] = str_replace('header_', '', $o->name);
                    }
                }
            }

            $html = $this->get_edit_field_html_elements(array_merge($args,$raw_properties));
        ?>
            <input <?php echo $html; ?> />
        <?php
        }

        public function edit_field_html (array $raw_properties = array ())
        {
            if ( isset( $raw_properties['user_id'] ) ) {
                unset( $raw_properties['user_id'] );
            }

            // HTML5 required attribute.
            if ( bp_get_the_profile_field_is_required() ) {
                $raw_properties['required'] = 'required';
            }

            $field = new BP_XProfile_Field(bp_get_the_profile_field_id());


            $args = array(
                'type'  => 'text',
                'value' => bp_get_the_profile_field_edit_value(),
            );
            $options = $field->get_children( true );
            if ($options) {
              $header = $options[0]->name;
            }

            $html = $this->get_edit_field_html_elements(array_merge($args,$raw_properties));

            $label = sprintf(
                '<h3>'. $header .'</h3>
                <hr />
                <label for="%s">%s%s</label>',
                    bp_get_the_profile_field_input_name(),
                    bp_get_the_profile_field_name(),
                    (bp_get_the_profile_field_is_required()) ?
                        ' ' . esc_html__( '(required)', 'buddypress' ) : ''
            );
            // Label.
            echo apply_filters('bxcft_field_label', $label, bp_get_the_profile_field_id(), bp_get_the_profile_field_type(), bp_get_the_profile_field_input_name(), bp_get_the_profile_field_name(), bp_get_the_profile_field_is_required());
            // Errors.
            do_action( bp_get_the_profile_field_errors_action() );
            // Input.
        ?>
            <input <?php echo $html; ?> />
        <?php
        }

        public function admin_new_field_html (\BP_XProfile_Field $current_field, $control_type = '')
        {
            $type = array_search( get_class( $this ), bp_xprofile_get_field_types() );
            if ( false === $type ) {
                return;
            }

            $class            = $current_field->type != $type ? 'display: none;' : '';
            $current_type_obj = bp_xprofile_create_field_type( $type );

            $options = $current_field->get_children( true );
            $header = '';
            if ( ! $options ) {
                $options = array();
                $i       = 1;
                while ( isset( $_POST[$type . '_option'][$i] ) ) {
                    $is_default_option = true;

                    $options[] = (object) array(
                        'id'                => -1,
                        'is_default_option' => $is_default_option,
                        'name'              => sanitize_textarea_field( stripslashes( $_POST[$type . '_option'][$i] ) ),
                    );

                    ++$i;
                }

                if ( ! $options ) {
                    $options[] = (object) array(
                        'id'                => -1,
                        'is_default_option' => false,
                        'name'              => '2',
                    );
                }
            } else {
              $header = $options[0]->name;
            }
            
        ?>
            <div id="<?php echo esc_attr( $type ); ?>" class="postbox bp-options-box" style="<?php echo esc_attr( $class ); ?> margin-top: 15px;">
                <h3><?php esc_html_e( 'Header text.', 'bxcft' ); ?></h3>
                <div class="inside">
                    <p>
                        <label for="<?php echo esc_attr( "{$type}_option1" ); ?>">
                            <?php esc_html_e('Header:', 'bxcft'); ?>
                        </label>
                        <input type="text" name="<?php echo esc_attr( "{$type}_option[1]" ); ?>"
                            id="<?php echo esc_attr( "{$type}_option1" ); ?>" value="<?php echo $header; ?>" />
                    </p>
                </div>
            </div>
        <?php
        }
        
        public function is_valid( $values ) {
            $this->validation_whitelist = null;
            return parent::is_valid($values);
        }

        /**
         * Modify the appearance of value. Apply autolink if enabled.
         *
         * @param  string   $value      Original value of field
         * @param  int      $field_id   Id of field
         * @return string   Value formatted
         */
        public static function display_filter($field_value, $field_id = '') {

            $new_field_value = $field_value;

            if (!empty($field_value)) {
                if (!empty($field_id)) {
                    $field = BP_XProfile_Field::get_instance($field_id);
                    if ($field) {
                        $do_autolink = apply_filters('bxcft_do_autolink',
                            $field->get_do_autolink());
                        if ($do_autolink) {
                            $query_arg = bp_core_get_component_search_query_arg( 'members' );
                            $search_url = add_query_arg( array(
                                    $query_arg => urlencode( $field_value )
                                ), bp_get_members_directory_permalink() );
                            $new_field_value = '<a href="' . esc_url( $search_url ) .
                                '" rel="nofollow">' . $new_field_value . '</a>';
                        }
                    }
                }
            }

            /**
             * bxcft_number_minmax_display_filter
             *
             * Use this filter to modify the appearance of 'Number within
             * min/max values' field value.
             * @param  $new_field_value Value of field
             * @param  $field_id Id of field.
             * @return  Filtered value of field.
             */
            return apply_filters('bxcft_number_minmax_display_filter',
                $new_field_value, $field_id);
        }
    }
}



/**********************************************/
/**********************************************/
/**********************************************/
/**********************************************/
/**********************************************/


if (!class_exists('nitro_bd_field_type_repeater'))
{
    class nitro_bd_field_type_repeater extends BP_XProfile_Field_Type
    {
        public function __construct() {
            parent::__construct();

            $this->name = __( 'Repeater', 'abp' );

            $this->accepts_null_value = true;
            $this->supports_options = true;
            $this->supports_richtext = true;

            $this->set_format( '/.*?/', 'replace' );

            do_action( 'bp_xprofile_field_type_repeater', $this );
        }

        public function admin_field_html (array $raw_properties = array ())
        {
            global $field;

            $args = array(
                'type' => 'textarea',
                'class' => 'abp-repeater',
                'rows' => '10',
                'cols' => '100'
            );
            
            $options = $field->get_children( true );
            $field_val = '';
            if ( !empty($options) ) {
              foreach ($options as $o) {
                $field_val = $o->name;
              }
            }

            $html = $this->get_edit_field_html_elements(array_merge($args, $raw_properties));
        ?>
            <textarea <?php echo $html; ?>><?php echo $field_val; ?></textarea><br />
            <small><?php echo __('Pipe (|) separated, and line seperated. Options should be comma separated.', 'opsi'); ?></small><br />
            <small><?php echo __('Example:', 'opsi'); ?></small><br />
            <small><?php echo __('field type|label|field name|options', 'opsi'); ?></small><br />
            <small><?php echo __('Availale field types: text, textarea, select, date, URL', 'opsi'); ?></small>
        <?php
        }

        public function edit_field_html (array $raw_properties = array ())
        {
            if ( isset( $raw_properties['user_id'] ) ) {
                $user_id = $raw_properties['user_id'];
                unset( $raw_properties['user_id'] );
            }

            // HTML5 required attribute.
            if ( bp_get_the_profile_field_is_required() ) {
                $raw_properties['required'] = 'required';
            }

            $field = new BP_XProfile_Field(bp_get_the_profile_field_id());


            $args = array(
                'type'  => 'textarea',
                'class' => 'abp-repeater',
                'value' => bp_get_the_profile_field_edit_value()
            );
            $options = $field->get_children( true );
            if ($options) {
              foreach ($options as $o) {
                $fields = explode("\n", $o->name);
              }
            }

            $html = $this->get_edit_field_html_elements(array_merge($args, $raw_properties));

            $label = sprintf(
                '<legend>%s%s</legend>',
                    bp_get_the_profile_field_name(),
                    (bp_get_the_profile_field_is_required()) ?
                        ' ' . esc_html__( '(required)', 'buddypress' ) : ''
            );
            // Label.
            echo apply_filters('abp_field_label', $label, bp_get_the_profile_field_id(), bp_get_the_profile_field_type(), bp_get_the_profile_field_input_name(), bp_get_the_profile_field_name(), bp_get_the_profile_field_is_required());
            // Errors.
            do_action( bp_get_the_profile_field_errors_action() );
            // Input.
            
            $option_data = maybe_unserialize(BP_XProfile_ProfileData::get_value_byid( $field->id, bp_displayed_user_id()));
        
            $i = 0;
            $odai = 0; // option data auto increase
            
            if (!empty($fields)) {
              
              $num_of_fields = count($fields);
              $groups_of_fields = count($option_data) / $num_of_fields;
              $j = 0;
              
              if ($num_of_fields > 0 && !empty($option_data)) {
                for ($j = 0; $j < $groups_of_fields; $j++) {
                  echo '
                    <div class="repeater_wrap">
                    '. ($j > 0 ? '<hr />' : '') .'
                      <fieldset>
                        <div class="text-right"><a href="#" class="delete_fieldset">&times;</a></div>
                    ';

                  foreach($fields as $field_line) {
                    $f = explode('|', $field_line);
                    
                    $f[2] = trim($f[2]);
                    
                    echo '<label for="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" class="repeater_label">'.$f[1];
                    
                    if ($f[0] == 'text') {
                      echo '<input value="'. $option_data[$odai++] .'" name="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" type="text" id="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" class="form-control" />';
                    }
                    
                    if ($f[0] == 'url') {
                      echo '<input value="'. $option_data[$odai++] .'" name="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" type="url" id="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" class="form-control" />';
                    }
                    
                    if ($f[0] == 'email') {
                      echo '<input value="'. $option_data[$odai++] .'" name="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" type="email" id="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" class="form-control" />';
                    }
                    
                    if ($f[0] == 'date') {
                      
                      $temp_date = array();
                      $temp_date = explode('/', $option_data[$odai]);
                      if (!isset($temp_date[0])) {
                        $temp_date[0] = '';
                      }
                      if (!isset($temp_date[1])) {
                        $temp_date[1] = '';
                      }
                      
                      echo '
                        <div class="opsi_date_field_wrap">';
                      echo '
                        <select class="opsi_date_month">
                          <option value="">----</option>
                          ';
                        
                          for($d=1; $d<13; $d++) {
                            echo '<option value="'. $d .'" '. ($temp_date[0] == $d ? 'selected="selected"' : '') .'>'. date('F',strtotime('01.'.$d.'.2001')) .'</option>';
                          }
                        
                      echo '  
                        </select>
                      ';
                      
                      echo '
                        <select class="opsi_date_year">
                          <option value="">----</option>
                        ';
                        
                          for($d=date('Y'); $d>1900; $d--) {
                            echo '<option value="'. $d .'" '. ($temp_date[1] == $d ? 'selected="selected"' : '') .'>'. $d .'</option>';
                          }
                        ;
                      echo '  
                        </select>
                      ';
                      
                      echo '<input value="'. $option_data[$odai++] .'" name="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" type="hidden" id="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" class="form-control opsi_date_field_value" />';
                    }
                    
                    if ($f[0] == 'textarea') {
                      echo '<textarea name="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" id="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" class="form-control">'. $option_data[$odai++] .'</textarea>';
                    }
                    
                    if ($f[0] == 'select') {
                      echo '<select name="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" id="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" class="form-control">';
                      
                      if (isset($f[3]) && !empty($f[3]))
                        foreach($f[3] as $select_option) {
                          echo '<option value="'. $select_option .'">'. $select_option .'</option>';
                        }
                      echo '</select>';
                    }
                    
                    echo '</label>';
                  }
                  
                  
                  
                  echo '
                      </fieldset>
                    </div>
                  ';
                  
                  $i++;
                }
              }
              
              echo '<div class="repeater_wrap repeater_wrap_first wrap_'. $field->id .'">
                '. ($j > 0 ? '<hr />' : '') .'
                <fieldset>
                  <div class="text-right"><a href="#" class="delete_fieldset">&times;</a></div>
                ';
              
              
              foreach($fields as $field_line) {
                $f = explode('|', $field_line);
                
                $f[2] = trim($f[2]);
                
                echo '<label for="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" class="repeater_label">'.$f[1];
                
                if ($f[0] == 'text') {
                  echo '<input name="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" type="text" id="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" class="form-control" />';
                }
                
                if ($f[0] == 'url') {
                  echo '<input name="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" type="url" id="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" class="form-control" />';
                }
                
                if ($f[0] == 'email') {
                  echo '<input name="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" type="email" id="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" class="form-control" />';
                }
                
                if ($f[0] == 'date') {
                  
                  echo '
                    <div class="opsi_date_field_wrap">';
                  echo '
                    <select class="opsi_date_month">
                      <option value="">----</option>
                      ';
                    
                      for($d=1; $d<13; $d++) {
                        echo '<option value="'. $d .'">'. date('F',strtotime('01.'.$d.'.2001')) .'</option>';
                      }
                    
                  echo '  
                    </select>
                  ';
                  
                  echo '
                    <select class="opsi_date_year">
                      <option value="">----</option>
                    ';
                    
                      for($d=date('Y'); $d>1900; $d--) {
                        echo '<option value="'. $d .'">'. $d .'</option>';
                      }
                    ;
                  echo '  
                    </select>
                  ';
                  
                  echo '
                      <input name="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" type="hidden" id="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" class="form-control opsi_date_field_value" value="" />
                    </div>
                  ';
                }
                
                if ($f[0] == 'textarea') {
                  echo '<textarea name="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" id="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" class="form-control"></textarea>';
                }
                
                if ($f[0] == 'select') {
                  echo '<select name="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" id="'. bp_get_the_profile_field_input_name() .'['. $i.'_'.$f[2] .']" class="form-control">';
                  
                  if (isset($f[3]) && !empty($f[3]))
                    foreach($f[3] as $select_option) {
                      echo '<option value="'. $select_option .'">'. $select_option .'</option>';
                    }
                  echo '</select>';
                }
                
                echo '</label>';
              }
              echo '
                </fieldset>
              </div>
              <div class="additional_fieldsets_'. $field->id .'"></div>                
              ';
              
              echo '<a href="#" id="add_'. $field->id .'" data-fid="'. $field->id .'" class="btn btn-primary add_fieldset_btn">'. __('Add', 'opsi') .' '. bp_get_the_profile_field_name() .'</a>';
              
              $i++;
              
            }
            ?>
            <span id="output-field_<?php echo $field->id; ?>"></span>
            <script>
              jQuery('document').ready(function() {
                var i = <?php echo $i - 1; ?>;
                var wrapper = jQuery('.wrap_<?php echo $field->id; ?>');
                
                jQuery('.delete_fieldset').on('click', function(e) {
                  e.preventDefault();
                  jQuery(this).closest('.repeater_wrap').remove();
                  return false;
                });
                jQuery('#add_<?php echo $field->id;?>').click(function(e) {
                  e.preventDefault();
                  jQuery('.additional_fieldsets_<?php echo $field->id; ?>').append('<div class="repeater_wrap"><?php ($j == 0 ? '<hr />' : ''); ?>'+ wrapper.html().split('field_<?php echo $field->id; ?>[<?php echo $i - 1; ?>').join('field_<?php echo $field->id; ?>['+ (i+1)) +'</div>');
                  i++;
                  
                  if (jQuery(".opsi_date_month").length > 0) {
                    jQuery('.opsi_date_month, .opsi_date_year').on('change', function() {
                      
                      var opsi_date_field_wrap = jQuery(this).parents('.opsi_date_field_wrap');
                      opsi_date_field_wrap.children('.opsi_date_field_value').val(opsi_date_field_wrap.children('.opsi_date_month').val()+'/'+opsi_date_field_wrap.children('.opsi_date_year').val());
                      
                    });
                  }
                  
                  return false;
                });
                
              });
            </script>            
        <?php
        }

        public function admin_new_field_html (\BP_XProfile_Field $current_field, $control_type = '')
        {
            $type = array_search( get_class( $this ), bp_xprofile_get_field_types() );
           
            if ( false === $type ) {
                return;
            }

            $class            = $current_field->type != $type ? 'display: none;' : '';
            $current_type_obj = bp_xprofile_create_field_type( $type );

            $options = $current_field->get_children( true );
            $field_val = '';
            if ( ! $options ) {
                $options = array();
                $i       = 1;
                while ( isset( $_POST[$type . '_option'][$i] ) ) {
                    $is_default_option = true;

                    $options[] = (object) array(
                        'id'                => -1,
                        'is_default_option' => $is_default_option,
                        'name'              => sanitize_textarea_field( stripslashes( $_POST[$type . '_option'][$i] ) ),
                    );

                    ++$i;
                }

                if ( ! $options ) {
                    $options[] = (object) array(
                        'id'                => -1,
                        'is_default_option' => false,
                        'name'              => '',
                    );
                }
            } else {
                foreach ($options as $o) {
                  $field_val = $o->name;
                }
            }
        ?>
            <div id="<?php echo esc_attr( $type ); ?>" class="postbox bp-options-box" style="<?php echo esc_attr( $class ); ?> margin-top: 15px;">
                <div class="inside">
                    <p>
                        <label for="<?php echo esc_attr( "{$type}_option1" ); ?>">
                            <?php esc_html_e('Fields:', 'abp'); ?>
                        </label><br />
                        <textarea style="width: 100%; height: 250px;" name="<?php echo esc_attr( "{$type}_option[1]" ); ?>"
                            id="<?php echo esc_attr( "{$type}_option1" ); ?>"><?php echo $field_val; ?></textarea>
                    </p>
                    <small><?php echo __('Pipe (|) separated, and line seperated. Options should be comma separated.', 'opsi'); ?></small><br />
                    <small><?php echo __('Example:', 'opsi'); ?></small><br />
                    <small><?php echo __('field type|label|field name|options', 'opsi'); ?></small><br />
                    <small><?php echo __('Availale field types: text, textarea, select, date, URL', 'opsi'); ?></small>
                </div>
            </div>
        <?php
        }

        public function is_valid( $values ) {
            $validated = false;

            // Some types of field (e.g. multi-selectbox) may have multiple values to check
            foreach ( (array) $values as $value ) {

                // Validate the $value against the type's accepted format(s).
                foreach ( $this->validation_regex as $format ) {
                    if ( 1 === preg_match( $format, $value ) ) {
                        $validated = true;
                        continue;

                    } else {
                        $validated = false;
                    }
                }
            }

            // Handle field types with accepts_null_value set if $values is an empty array
            if ( ! $validated && is_array( $values ) && empty( $values ) && $this->accepts_null_value ) {
                $validated = true;
            }

            return (bool) apply_filters( 'bp_xprofile_field_type_is_valid', $validated, $values, $this );
        }

        /**
         * Modify the appearance of value. Apply autolink if enabled.
         *
         * @param  string   $value      Original value of field
         * @param  int      $field_id   Id of field
         * @return string   Value formatted
         */
        public static function display_filter($field_value, $field_id = '') {

            $new_field_value = $field_value;

            if (!empty($field_value)) {
                if (!empty($field_id)) {
                    $field = BP_XProfile_Field::get_instance($field_id);
                    if ($field) {
                        $do_autolink = apply_filters('abp_do_autolink',
                            $field->get_do_autolink());
                        if ($do_autolink) {
                            $query_arg = bp_core_get_component_search_query_arg( 'members' );
                            $search_url = add_query_arg( array(
                                    $query_arg => urlencode( $field_value )
                                ), bp_get_members_directory_permalink() );
                            $new_field_value = '<a href="' . esc_url( $search_url ) .
                                '" rel="nofollow">' . $new_field_value . '</a>';
                        }
                    }
                }
            }

            /**
             * abp_slider_display_filter
             *
             * Use this filter to modify the appearance of 'Slider'
             * field value.
             * @param  $new_field_value Value of field
             * @param  $field_id Id of field.
             * @return  Filtered value of field.
             */
            return apply_filters('abp_repeater_display_filter',
                print_r($new_field_value, true), $field_id);
        }
    }
}


add_filter('bp_xprofile_set_field_data_pre_validate', 'nitro_bp_xprofile_set_field_data_pre_validate', 10, 3);
function nitro_bp_xprofile_set_field_data_pre_validate($value, $field, $field_type_obj) {
  if ($field_type_obj->name == 'Repeater') {       
    
    $options = $field->get_children( true );
    if ($options) {
      foreach ($options as $o) {
        $fields = explode("\n", $o->name);
      }
    }
    
    $fields_count = count($fields);
    
    if (!empty($value)) {
      $i = 0;
      $batch_data = '';
      $batch_keys = array();
      foreach($value as $k => $v) {
        
        $batch_data .= $v;
        $batch_keys[] = $k;
        
        $i++;
        
        if($fields_count == $i) {
          
          // if there is nothing in the batch, then remove the batch
          if (trim($batch_data) == '') {
            foreach($batch_keys as $bk) {
              unset($value[$bk]);
            }
          }
          
          $i = 0; // reset $i
          $batch_data = ''; // reset batch data
          $batch_keys = array(); // reset the keys
        }
      }
      
    }
  }
  
  return $value;
}

add_filter( 'bp_get_the_profile_field_value', 'nitro_bp_get_the_profile_field_value', 10, 3 );
function nitro_bp_get_the_profile_field_value($value, $type, $field_id) {

  if ($type == 'repeater') {
    $field = new BP_XProfile_Field( $field_id );
    $options = $field->get_children( true );
    if ($options) {
      foreach ($options as $o) {
        $fields = explode("\n", $o->name);
      }
    }
  
    if (!empty($fields)) {
      
      $labels = array();
      
      foreach($fields as $f) {
        $line = explode('|', $f);
        $labels[] = $line[1];
      }
    }
    
    $field_values_array = maybe_unserialize($field->data->value);
    
    
    
    if (!empty($field_values_array)) {
      $i = $j = 0;
      $value = '';
      foreach($field_values_array as $field_value) {
        
        if (trim($field_value) != '') {
          $value .= '
            <div class="repeater_field_wrap">
              <h4 class="repeater_title">'. $labels[$i] .'</h4>
              <p class="repeater_data '. sanitize_title($labels[$i]) .'">'. make_clickable($field_value) .'</p>
            </div>
          ';
        }
        
        $i++;
        $j++;
        if ($i == count( $labels ) && $j < count($field_values_array)) {
          $i = 0;
          $value .= '<hr class="repeater_batch_splitter" />';
        }
      }
    }
  }

  return $value;
  
}


add_filter( 'bp_get_the_profile_field_value', 'nitro_urls_bp_get_the_profile_field_value', 11, 3 );
function nitro_urls_bp_get_the_profile_field_value($value, $type, $field_id) {
  
  if ($type == 'repeater' && strpos($value, 'Additional URLs') !== false) {
    $value = str_replace('<h4 class="repeater_title">Additional URLs</h4>', '', $value);
    $value = str_replace('<hr class="repeater_batch_splitter" />', '', $value);
  }
  
  return $value;
}


/**
 * Multi-selectbox xprofile field type COPY for OPSI.
 *
 * @since 2.0.0
 */
class BP_XProfile_Field_Type_Multiselectbox_OPSI extends BP_XProfile_Field_Type {

	/**
	 * Constructor for the multi-selectbox field type.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		parent::__construct();

		$this->category = _x( 'Multi Fields', 'xprofile field type category', 'buddypress' );
		$this->name     = _x( 'Multi Select Box OPSI', 'xprofile field type', 'buddypress' );

		$this->supports_multiple_defaults = true;
		$this->accepts_null_value         = true;
		$this->supports_options           = true;

		// $this->set_format( '/^.+$/', 'replace' );
    $this->set_format( '/.*?/', 'replace' );

		/**
		 * Fires inside __construct() method for BP_XProfile_Field_Type_Multiselectbox_OPSI class.
		 *
		 * @since 2.0.0
		 *
		 * @param BP_XProfile_Field_Type_Multiselectbox_OPSI $this Current instance of
		 *                                                    the field type multiple select box.
		 */
		do_action( 'bp_xprofile_field_type_multiselectbox_opsi', $this );
	}

	/**
	 * Output the edit field HTML for this field type.
	 *
	 * Must be used inside the {@link bp_profile_fields()} template loop.
	 *
	 * @since 2.0.0
	 *
	 * @param array $raw_properties Optional key/value array of
	 *                              {@link http://dev.w3.org/html5/markup/select.html permitted attributes}
	 *                              that you want to add.
	 */
	public function edit_field_html( array $raw_properties = array() ) {

		// User_id is a special optional parameter that we pass to
		// {@link bp_the_profile_field_options()}.
		if ( isset( $raw_properties['user_id'] ) ) {
			$user_id = (int) $raw_properties['user_id'];
			unset( $raw_properties['user_id'] );
		} else {
			$user_id = bp_displayed_user_id();
		}
    
    $field = new BP_XProfile_Field(bp_get_the_profile_field_id());

    if ($field && $field->data) {
      $values = maybe_unserialize($field->data->value);
      $full_options = $field->get_children( true );
      $options = array();
      $compare_entries = array();
      if (!empty($full_options)) {
        foreach($full_options as $fo) {
          $options[] = $fo->name;
        }
        $compared_entries = array_diff($values, $options);
      }
    }
    
		$r = bp_parse_args( $raw_properties, array(
			'multiple' => 'multiple',
			'id'       => bp_get_the_profile_field_input_name() . '[]',
			'name'     => bp_get_the_profile_field_input_name() . '[]',
		) ); ?>


		<legend id="<?php bp_the_profile_field_input_name(); ?>-1">
			<?php bp_the_profile_field_name(); ?>
			<?php bp_the_profile_field_required_label(); ?>
		</legend>

		<?php

		/** This action is documented in bp-xprofile/bp-xprofile-classes */
		do_action( bp_get_the_profile_field_errors_action() ); ?>

		<select <?php echo $this->get_edit_field_html_elements( $r ); ?> aria-labelledby="<?php bp_the_profile_field_input_name(); ?>-1" aria-describedby="<?php bp_the_profile_field_input_name(); ?>-3">
			<?php bp_the_profile_field_options( array(
				'user_id' => $user_id
			) ); ?>
      <?php
        if (!empty($compared_entries)) {
          foreach($compared_entries as $custom_tags) {
            echo '<option value="'. $custom_tags .'" selected="selected">'. $custom_tags .'</option>';
          }
        }
      ?>
		</select>

		<?php if ( bp_get_the_profile_field_description() ) : ?>
			<p class="description" id="<?php bp_the_profile_field_input_name(); ?>-3"><?php bp_the_profile_field_description(); ?></p>
		<?php endif; ?>

		<?php if ( ! bp_get_the_profile_field_is_required() ) : ?>

			<a class="clear-value" href="javascript:clear( '<?php echo esc_js( bp_get_the_profile_field_input_name() ); ?>[]' );">
				<?php esc_html_e( 'Clear', 'buddypress' ); ?>
			</a>

		<?php endif; ?>
	<?php
	}

	/**
	 * Output the edit field options HTML for this field type.
	 *
	 * BuddyPress considers a field's "options" to be, for example, the items in a selectbox.
	 * These are stored separately in the database, and their templating is handled separately.
	 *
	 * This templating is separate from {@link BP_XProfile_Field_Type::edit_field_html()} because
	 * it's also used in the wp-admin screens when creating new fields, and for backwards compatibility.
	 *
	 * Must be used inside the {@link bp_profile_fields()} template loop.
	 *
	 * @since 2.0.0
	 *
	 * @param array $args Optional. The arguments passed to {@link bp_the_profile_field_options()}.
	 */
	public function edit_field_options_html( array $args = array() ) {
		$original_option_values = maybe_unserialize( BP_XProfile_ProfileData::get_value_byid( $this->field_obj->id, $args['user_id'] ) );

		$options = $this->field_obj->get_children();
		$html    = '';

		if ( empty( $original_option_values ) && ! empty( $_POST['field_' . $this->field_obj->id] ) ) {
			$original_option_values = sanitize_text_field( $_POST['field_' . $this->field_obj->id] );
		}

		$option_values = ( $original_option_values ) ? (array) $original_option_values : array();
		for ( $k = 0, $count = count( $options ); $k < $count; ++$k ) {
			$selected = '';

			// Check for updated posted values, but errors preventing them from
			// being saved first time.
			foreach( $option_values as $i => $option_value ) {
				if ( isset( $_POST['field_' . $this->field_obj->id] ) && $_POST['field_' . $this->field_obj->id][$i] != $option_value ) {
					if ( ! empty( $_POST['field_' . $this->field_obj->id][$i] ) ) {
						$option_values[] = sanitize_text_field( $_POST['field_' . $this->field_obj->id][$i] );
					}
				}
			}

			// Run the allowed option name through the before_save filter, so
			// we'll be sure to get a match.
			$allowed_options = xprofile_sanitize_data_value_before_save( $options[$k]->name, false, false );

			// First, check to see whether the user-entered value matches.
			if ( in_array( $allowed_options, $option_values ) ) {
				$selected = ' selected="selected"';
			}

			// Then, if the user has not provided a value, check for defaults.
			if ( ! is_array( $original_option_values ) && empty( $option_values ) && ! empty( $options[$k]->is_default_option ) ) {
				$selected = ' selected="selected"';
			}

			/**
			 * Filters the HTML output for options in a multiselect input.
			 *
			 * @since 1.5.0
			 *
			 * @param string $value    Option tag for current value being rendered.
			 * @param object $value    Current option being rendered for.
			 * @param int    $id       ID of the field object being rendered.
			 * @param string $selected Current selected value.
			 * @param string $k        Current index in the foreach loop.
			 */
			$html .= apply_filters( 'bp_get_the_profile_field_options_multiselect', '<option' . $selected . ' value="' . esc_attr( stripslashes( $options[$k]->name ) ) . '">' . esc_html( stripslashes( $options[$k]->name ) ) . '</option>', $options[$k], $this->field_obj->id, $selected, $k );
		}

		echo $html;
	}

	/**
	 * Output HTML for this field type on the wp-admin Profile Fields screen.
	 *
	 * Must be used inside the {@link bp_profile_fields()} template loop.
	 *
	 * @since 2.0.0
	 *
	 * @param array $raw_properties Optional key/value array of permitted attributes that you want to add.
	 */
	public function admin_field_html( array $raw_properties = array() ) {
		$r = bp_parse_args( $raw_properties, array(
			'multiple' => 'multiple'
		) ); ?>

		<label for="<?php bp_the_profile_field_input_name(); ?>" class="screen-reader-text"><?php
			/* translators: accessibility text */
			esc_html_e( 'Select', 'buddypress' );
		?></label>
		<select <?php echo $this->get_edit_field_html_elements( $r ); ?>>
			<?php bp_the_profile_field_options(); ?>
		</select>

		<?php
	}

	/**
	 * Output HTML for this field type's children options on the wp-admin Profile Fields,
	 * "Add Field" and "Edit Field" screens.
	 *
	 * Must be used inside the {@link bp_profile_fields()} template loop.
	 *
	 * @since 2.0.0
	 *
	 * @param BP_XProfile_Field $current_field The current profile field on the add/edit screen.
	 * @param string            $control_type  Optional. HTML input type used to render the current
	 *                                         field's child options.
	 */
	public function admin_new_field_html( BP_XProfile_Field $current_field, $control_type = '' ) {
		parent::admin_new_field_html( $current_field, 'checkbox' );
	}
  
  public function is_valid( $values ) {
      $validated = false;

      // Some types of field (e.g. multi-selectbox) may have multiple values to check
      foreach ( (array) $values as $value ) {

          // Validate the $value against the type's accepted format(s).
          foreach ( $this->validation_regex as $format ) {
              if ( 1 === preg_match( $format, $value ) ) {
                  $validated = true;
                  continue;

              } else {
                  $validated = false;
              }
          }
      }

      // Handle field types with accepts_null_value set if $values is an empty array
      if ( ! $validated && is_array( $values ) && empty( $values ) && $this->accepts_null_value ) {
          $validated = true;
      }

      return (bool) apply_filters( 'bp_xprofile_field_type_is_valid', $validated, $values, $this );
  }
}



add_filter( 'widget_title', 'nitro_my_friends_widget_title', 10, 1 );
function nitro_my_friends_widget_title($title) {
  
  if(strpos($title, bp_get_displayed_user_fullname(). '&#8217;s Friend') !== FALSE) {
      $title = str_replace(bp_get_displayed_user_fullname(). '&#8217;s', '', $title);
  }
  
  
  return $title;
}

add_filter('bp_get_the_profile_field_required_label', 'nitro_bp_get_the_profile_field_required_label');
function nitro_bp_get_the_profile_field_required_label($label) {
  
  return '*';
}

add_action('bp_profile_field_item', 'nitro_bp_profile_field_item');
function nitro_bp_profile_field_item() {
  global $profile_template;
  // $profile_template->current_field++;
  if (trim(bp_get_the_profile_field_name()) == 'Name') {
    $userdata = get_userdata( bp_displayed_user_id() );
    ?>
    <tr <?php bp_field_css_class(); ?>>

      <td class="label"><?php echo __('Email'); ?></td>

      <td class="data"><?php echo '<a href="mailto:'. $userdata->user_email .'">'. $userdata->user_email .'</a>'; ?></td>

    </tr>
    <?php
  }
}


function nitro_buddypress_profile_update( $user_id, $posted_field_ids, $errors, $old_values, $new_values ) {
  
  if ($old_values[51]['value'] == $new_values[51]['value']) {
    return;
  }
 
   $admin_email = get_option( 'admin_email' );
   $message = sprintf( __( 'Member: %1$s', 'buddypress' ), bp_core_get_user_displayname( $user_id ) ) . "\r\n\r\n"; 
   $message .= get_edit_user_link($user_id)."\r\n\r\n"; 
   $message .= sprintf( __( 'NEW Organisation type: %s' ), bp_get_profile_field_data('field=Organisation type') ). "\r\n\r\n";
   $message .= sprintf( __( 'Old Organisation type: %s' ), $old_values[51]['value'] ). "\r\n\r\n";
   wp_mail( $admin_email, sprintf( __( '%1$s Member Profile Update' ), get_option('blogname') ), $message );
}
add_action( 'xprofile_updated_profile', 'nitro_buddypress_profile_update', 10, 5 );



add_filter( 'bp_xprofile_set_field_data_pre_validate',  'nitro_xprofile_filter_pre_validate_value_by_field_type', 9, 3 );

function nitro_xprofile_filter_pre_validate_value_by_field_type( $value, $field, $field_type_obj ) {
	
  if ($field->name == 'Twitter' && filter_var($field->data->value, FILTER_VALIDATE_URL) === FALSE) {
    $value = str_replace('twitter.com', '', $value);
    $value = 'https://twitter.com/'. $value;
  }
  
	return $value;
}	