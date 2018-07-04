jQuery(document).ready(function(){
  
  if (jQuery('body.logged-in .mc4wp-checkbox.mc4wp-checkbox-wp-comment-form').length > 0) {
    jQuery('body.logged-in .mc4wp-checkbox.mc4wp-checkbox-wp-comment-form input[type="checkbox"]').attr('checked', false); // Unchecks it for logged in users
  }
  if (jQuery(".input-options.datebox-selects>select:first-of-type").length > 0) {
    jQuery(".input-options.datebox-selects>select:first-of-type").val(1);
  }
  if (jQuery(".opsi_date_month").length > 0) {
    jQuery('.opsi_date_month, .opsi_date_year').on('change', function() {
      
      var opsi_date_field_wrap = jQuery(this).parents('.opsi_date_field_wrap');
      opsi_date_field_wrap.children('.opsi_date_field_value').val(opsi_date_field_wrap.children('.opsi_date_month').val()+'/'+opsi_date_field_wrap.children('.opsi_date_year').val());
      
    });
  }
  
  if (jQuery(".field_type_multiselectbox_opsi select").length > 0) {
    jQuery(".field_type_multiselectbox_opsi select").select2({
      tags: true
    });
  }
  
  if (jQuery('#groups-list-options #alphabetical-groups').length > 0) {
    jQuery('#groups-list-options #alphabetical-groups').text('A-Z');
  }
  
  if (jQuery('#groups-list-options #newest-groups').length > 0) {
    jQuery('#groups-list-options #newest-groups').text('New');
  }
  
  jQuery('li.archive-accordion-year').click(function() {
			// Change CSS of current year
      jQuery('li.archive-accordion-year').not(this).find('.fa').removeClass('fa-chevron-up').addClass('fa-chevron-down');
			jQuery('li.archive-accordion-year').not(this).children('ul').slideUp(250);
			jQuery(this).find('.fa').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
			jQuery(this).children('ul').slideToggle(250);
		
	});
  
  
  jQuery('article table').addClass('table table-striped table-hover table-responsive');
  jQuery('article table thead tr td').attr('data-sortable', 'true');
  
  var attrs = { };

  if (jQuery("article table thead tr td").length > 0) {
    jQuery.each(jQuery("article table thead tr td")[0].attributes, function(idx, attr) {
        attrs[attr.nodeName] = attr.nodeValue;
    });
  }


  jQuery("article table thead tr td").replaceWith(function () {
      return jQuery("<th />", attrs).append(jQuery(this).contents());
  });
  
  toggleCollapse();
  function toggleCollapse() {
    if (jQuery(window).width() < 768) {
      jQuery('.layout_header h2').on('click', function(e) {
        e.preventDefault();
        jQuery(this).toggleClass('open');
        jQuery(this).closest('.layout_posts_block').find('.collapse-xs').toggleClass('in');
        return false;
      });
      jQuery('.sidewrap h2.widget-title').on('click', function(e) {
        e.preventDefault();
        jQuery(this).toggleClass('open');
        jQuery(this).closest('aside').find('.collapse-xs').toggleClass('in');
        return false;
      });
      jQuery('.search_mobile').on('click', function(e) {
        e.preventDefault();
        jQuery('.mobile_search_form').toggleClass('in');
        return false;
      });
    }
  }
  
  jQuery('.droptoggle').on('click', function(e) {
    e.preventDefault();
    
    jQuery(this).closest('li').addClass('clicked');
    jQuery('#primary-menu li:not(.clicked)').removeClass('open');
    jQuery(this).closest('li').toggleClass('open').removeClass('clicked');
    
    return false;
  });
  
  jQuery('.primarymenu li').hover(
    function() {
      jQuery( this ).addClass('parentactive');
    }, function() {
      jQuery( this ).removeClass('parentactive');
    }
  );
  
  
  jQuery(function () {
    setTimeout(function() {
      jQuery('select.goog-te-combo > option:first-child').text('English');
    }, 1000);
  });
  
  
  var ie_version  =  getIEVersion();
  // var is_ie10     = ie_version.major == 10;
    
  //build a selector that targets all links ending in an image extension
  var thumbnails = 'a[href$=".gif"],a[href$=".jpg"],a[href$=".jpeg"],a[href$=".png"],a[href$=".GIF"],a[href$=".JPG"],a[href$=".JPEG"],a[href$=".PNG"]';

  //add "fancybox" class to those (this step could be skipped if you want) and group them under a same "rel" to enable previous/next buttons once in Fancybox
  jQuery(thumbnails).addClass("fancybox");
  
  jQuery(".fancybox").fancybox({
		openEffect	: 'none',
		closeEffect	: 'none',
    helpers : {
      title : {
        type : 'inside'
      },
      overlay: {
        locked: false
      }
    }
	});
  
  jQuery('.layout_accordion .panel-title a').on('click', function() {
    var panelgroup = jQuery(this).closest('.panel-group');
    
    setTimeout(function(){
      panelgroup.find('div.panel').each(function() {
        if (jQuery(this).find('.panel-collapse').hasClass('in')) {
          jQuery(this).find('.panel-title a').addClass('open');
        } else {
          jQuery(this).find('.panel-title a').removeClass('open');
        }
      });
    }, 400);
  });
  
  jQuery('.social-wrap a').attr('target', '_blank');
  jQuery('.blank').attr('target', '_blank');

  function getIEVersion(){
    var agent = navigator.userAgent;
    var reg = /MSIE\s?(\d+)(?:\.(\d+))?/i;
    var matches = agent.match(reg);
    if (matches != null) {
        return { major: matches[1], minor: matches[2] };
    }
    return { major: "-1", minor: "-1" };
  }
  
  // Open youtube links in a new window
  
  jQuery(".container a[href^='http://www.youtube.com']").attr("target","_blank");
  jQuery(".container a[href^='https://www.youtube.com']").attr("target","_blank");
  
  
  
  // full_width_image START
  
  fwi_resize();
  
  jQuery( window ).resize(function() {
    fwi_resize();
    toggleCollapse();
  });
  
  function fwi_resize() {
    
    var windowh = jQuery( window ).height();
    
    jQuery('.percenth').each(function(){
            
      if (jQuery(this).hasClass('height25')) {
        jQuery(this).height(windowh * 0.25);
        jQuery(this).parent().find('.overlay_color').css({'height': '300%'});
      }      
      if (jQuery(this).hasClass('height50')) {
        jQuery(this).height(windowh * 0.5);
        jQuery(this).parent().find('.overlay_color').css({'height': '250%'});
      }      
      if (jQuery(this).hasClass('height75')) {
        jQuery(this).height(windowh * 0.75);
        jQuery(this).parent().find('.overlay_color').css({'height': '250%'});
      }      
      if (jQuery(this).hasClass('height100')) {
        jQuery(this).height(windowh);
        jQuery(this).parent().find('.overlay_color').css({'height': '250%'});
      }
      
      var overheight = jQuery(this).parent().find('.overlay_color').height();
        
      jQuery(this).parent().find('.overlay_color').css({'margin-top': -(overheight / 3) + 'px'});
      
    });
  }
  
  // full_width_image END
  
  
  jQuery(function() {
    jQuery('.row .pb_title').matchHeight();
    jQuery('.row .post_col').matchHeight();
  });
  
  
  
  jQuery('a').on('click', function(e) {
    var attr = jQuery(this).attr('data-scroll-to');
    if (typeof attr !== typeof undefined && attr !== false && jQuery('#'+attr).length > 0) {
      e.preventDefault();
      jQuery('html, body').animate({
          scrollTop: (jQuery('#'+attr).offset().top - 150)
      }, 1000);
      return false;
    }
  });  

  
});