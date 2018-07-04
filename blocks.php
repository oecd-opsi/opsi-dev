<?php
  if ( ! defined( 'ABSPATH' ) ) die('no direct access'); // Exit if accessed directly
  

  if (have_rows('row')) {
    
    // loop through the rows of data
    while ( have_rows('row') ) {
      the_row();
      // display a sub field value
      
      if( have_rows('row_content') ) {
        ?>
        <div class="row">
          <?php
          // loop through the rows of data
          while ( have_rows('row_content') ) {
            the_row();
        
            get_template_part( '/blocks/'.get_row_layout() );
                      
          }
          ?>
        </div>
        <?php
      } else {
        // echo 'no row content';
      }
    }
    
  } else {
    // echo 'no rows';
  }
  
  
  
?>