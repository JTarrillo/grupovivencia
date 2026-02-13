window.matchMedia || (window.matchMedia = function() {
  var c = window.styleMedia || window.media;
  if (!c) {
     var a = document.createElement("style"),
        d = document.getElementsByTagName("script")[0],
        e = null;
     a.type = "text/css";
     a.id = "matchmediajs-test";
     d.parentNode.insertBefore(a, d);
     e = "getComputedStyle" in window && window.getComputedStyle(a, null) || a.currentStyle;
     c = {
        matchMedium: function(b) {
           b = "@media " + b + "{ #matchmediajs-test { width: 1px; } }";
           a.styleSheet ? a.styleSheet.cssText = b : a.textContent = b;
           return "1px" === e.width
        }
     }
  }
  return function(a) {
     return {
        matches: c.matchMedium(a || "all"),
        media: a || "all"
     }
  }
}());
/*!
* jQuery.utresize
* @author UnitedThemes
* @version 1.0
*
*/
(function($, sr) {
  "use strict";
  var debounce = function(func, threshold, execAsap) {
     var timeout = '';
     return function debounced() {
        var obj = this,
           args = arguments;

        function delayed() {
           if (!execAsap) {
              func.apply(obj, args);
           }
           timeout = null;
        }
        if (timeout) {
           clearTimeout(timeout);
        } else if (execAsap) {
           func.apply(obj, args);
        }
        timeout = setTimeout(delayed, threshold || 100);
     };
  };
  jQuery.fn[sr] = function(fn) {
     return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);
  };
})(jQuery, 'utresize');
(function($) {
  "use strict";
  if (!String.prototype.includes) {
     String.prototype.includes = function(search, start) {
        if (typeof start !== 'number') {
           start = 0;
        }
        if (start + search.length > this.length) {
           return false;
        } else {
           return this.indexOf(search, start) !== -1;
        }
     };
  }

  function occurrences(string, subString, allowOverlapping) {
     string += "";
     subString += "";
     if (subString.length <= 0) return (string.length + 1);
     var n = 0,
        pos = 0,
        step = allowOverlapping ? 1 : subString.length;
     while (true) {
        pos = string.indexOf(subString, pos);
        if (pos >= 0) {
           ++n;
           pos += step;
        } else break;
     }
     return n;
  }

  function findLongestWord(str) {
     var dot_count = occurrences(str, '.');
     str = str.split(".").join("");
     var strSplit = str.split(' ');
     var longestWord = 0;
     for (var i = 0; i < strSplit.length; i++) {
        if (strSplit[i].length > longestWord) {
           longestWord = strSplit[i].length;
        }
     }
     return longestWord + (dot_count / 4);
  }
  $.fn.flowtype = function(options) {
     var settings = $.extend({
           maximum: 9999,
           minimum: 1,
           maxFont: 9999,
           lineHeight: false,
           minFont: 1,
           minFontTablet: false,
           minFontMobile: false,
           fontRatio: 40,
           ratioMulti: 2.45,
           dynamicFontRatio: false,
           type: 'hero',
           loaded: '',
           check_size: false
        }, options),
        skip_next_downscale = false,
        skip_next_upscale = false,
        check_size = function($el, $parent, fontSize) {
           $el.parent().css('font-size', fontSize + 'px');
           if ($el.width() < $parent.width() && !skip_next_upscale) {
              if (fontSize < settings.maxFont) {
                 skip_next_downscale = true;
                 check_size($el, $parent, fontSize + 1)
              } else {
                 skip_next_downscale = false;
                 $el.addClass('ut-flowtyped');
                 return fontSize;
              }
           }
           if ($el.width() > $parent.width() && !skip_next_downscale) {
              if (fontSize > 12) {
                 skip_next_upscale = true;
                 check_size($el, $parent, fontSize - 1);
              } else {
                 skip_next_upscale = false;
                 $el.addClass('ut-flowtyped');
                 return fontSize;
              }
           }
           return fontSize;
        },
        changes = function(el) {
           var $el = $(el);
           $el.removeAttr('style');
           if ($el.hasClass('ut-skip-flowtype')) {
              return;
           }
           var ratio_multi = settings.ratioMulti;
           if (window.matchMedia('(min-width: 1200px)').matches) {
              ratio_multi = 1;
           } else if (window.matchMedia('(min-width: 960px)').matches) {
              ratio_multi = 2.25;
           } else if (window.matchMedia('(min-width: 640px)').matches) {
              ratio_multi = 2.35;
           }
           var factor = 1;
           if (settings.type === 'hero') {
              if (window.matchMedia('(max-width: 1440px)').matches) {
                 factor = 0.75;
              } else if (window.matchMedia('(max-width: 1680px)').matches) {
                 factor = 0.80;
              } else if (window.matchMedia('(max-width: 1920px)').matches) {
                 factor = 0.9;
              }
           }
           var _font_ratio = settings.fontRatio;
           var font_size_fill = 0;
           if (settings.type === 'title' || settings.type === 'custom') {
              if ($el.data('maxfont') >= 75) {
                 if (window.matchMedia('(max-width: 1200px)').matches) {
                    _font_ratio = 15;
                    if (settings.type === 'custom') {
                       font_size_fill = parseInt($el.data('maxfont')) / 10;
                    }
                 } else if (window.matchMedia('(max-width: 1440px)').matches) {
                    _font_ratio = 12;
                 } else if (window.matchMedia('(max-width: 1679px)').matches) {
                    _font_ratio = 10;
                 }
              } else {
                 if (window.matchMedia('(max-width: 1200px)').matches) {
                    _font_ratio = 12;
                 } else if (window.matchMedia('(max-width: 1679px)').matches) {
                    _font_ratio = 8;
                 }
              }
           }
           var min_font = settings.minFont;
           var max_font = settings.maxFont;
           if (settings.type === 'custom') {
              if ($el.is('h1')) {
                 min_font = parseInt('30');
              } else if ($el.is('h2')) {
                 min_font = parseInt('25');
              } else if ($el.is('h3')) {
                 min_font = parseInt('18px');
              } else if ($el.is('h4')) {
                 min_font = parseInt('15px');
              } else if ($el.is('h5')) {
                 min_font = parseInt('13px');
              } else if ($el.is('h6')) {
                 min_font = parseInt('13px');
              } else {
                 min_font = parseInt('14px');
              }
           }
           if (settings.minFontTablet && window.matchMedia('(max-width: 1024px)').matches) {
              min_font = settings.minFontTablet;
           }
           if (settings.minFontMobile && window.matchMedia('(max-width: 767px)').matches) {
              min_font = settings.minFontMobile;
           }
           var text = $el.find('.ut-word-rotator').length ? $el.find('.ut-word-rotator').text() : $el.text(),
              lineheight = $el.css('line-height'),
              elw = $el.parent().width(),
              width = elw > settings.maximum ? settings.maximum : elw < settings.minimum ? settings.minimum : elw,
              font_ratio = settings.dynamicFontRatio ? (findLongestWord(text.replace(/<(?:.|\n)*?>/gm, '').replace(/(\r\n\t|\n|\r\t)/gm, " ").trim()) * ratio_multi) : _font_ratio,
              fontBase = width / font_ratio,
              fontSize = fontBase > max_font ? max_font : fontBase < min_font ? min_font : fontBase;
           if (settings.dynamicFontRatio) {
              if (window.matchMedia('(min-width: 1200px)').matches) {
                 fontSize = settings.maxFont * factor;
              }
           }
           fontSize = parseInt(fontSize) + font_size_fill;
           if (settings.check_size.length) {
              fontSize = check_size($el, settings.check_size, fontSize);
           } else {
              $el.addClass('ut-flowtyped').css('font-size', fontSize + 'px');
           }
           if (settings.lineHeight && settings.lineHeight.includes("px")) {
              lineheight = settings.lineHeight.replace("px", "");
              var ratio = lineheight / settings.maxFont;
              if ($el.hasClass("element-with-custom-line-height") || $el.parent().hasClass("element-with-custom-line-height")) {
                 el.style.setProperty('line-height', (fontSize * ratio) + 'px', 'important');
              } else {
                 if (lineheight < fontSize) {
                    el.style.setProperty('line-height', fontSize + 'px', 'important');
                 }
              }
           }
           if (settings.loaded && typeof(settings.loaded) === "function") {
              settings.loaded();
           }
        };
     return this.each(function() {
        var that = this;
        $(window).utresize(function() {
           changes(that);
        });
        if ($(that).closest('.vc_row[data-vc-full-width]').length && $(window).width() >= 1440) {
           new ResizeSensor($(that).closest('.vc_row[data-vc-full-width]'), function() {
              changes(that);
           });
        } else if ($(that).closest('.vc_section[data-vc-full-width]').length && $(window).width() >= 1440) {
           new ResizeSensor($(that).closest('.vc_section[data-vc-full-width]'), function() {
              changes(that);
           });
        } else {
           changes(that);
        }
     });
  };
  if ($('.site-logo h1 a', '#header-section').length) {
     $('.site-logo h1 a', '#header-section').each(function() {
        var text_logo_original_font_size = $(this).css("font-size");
        if (text_logo_original_font_size) {
           var text_logo_max_font = text_logo_original_font_size.replace('px', '');
           $(this).flowtype({
              maxFont: text_logo_max_font,
              ratioMulti: 1.2,
              minFont: text_logo_max_font,
              minFontMobile: 12,
              check_size: $('.site-logo-wrap', '#header-section')
           });
        }
     });
  }
  if ($('.hero-description', '#ut-hero').length) {
     var hero_dt_original_font_size = $('.hero-description', '#ut-hero').css("font-size"),
        hero_dt_original_line_height = $('.hero-description', '#ut-hero').css("line-height");
     if (hero_dt_original_font_size) {
        var hero_dt_max_font = hero_dt_original_font_size.replace('px', '');
        $('.hero-description', '#ut-hero:not(.slider)').flowtype({
           maxFont: hero_dt_max_font,
           fontRatio: 24,
           minFont: 10
        });
     }
  }
  if ($('.hero-title', '#ut-hero').length) {
     var hero_title_original_font_size = $('.hero-title', '#ut-hero').css("font-size"),
        hero_title_original_line_height = $('.hero-title', '#ut-hero').css("line-height");
     if (hero_title_original_font_size) {
        var hero_title_max_font = hero_title_original_font_size.replace('px', '');
        $('.hero-title', '#ut-hero:not(.slider)').flowtype({
           maxFont: hero_title_max_font,
           dynamicFontRatio: true,
           minFont: 35,
           lineHeight: hero_title_original_line_height
        });
     }
  }
  if ($('.hero-description-bottom', '#ut-hero').length) {
     var hero_db_original_font_size = $('.hero-description-bottom', '#ut-hero').css("font-size"),
        hero_db_original_line_height = $('.hero-description-bottom', '#ut-hero').css("line-height");
     if (hero_db_original_font_size) {
        var hero_db_max_font = hero_db_original_font_size.replace('px', '');
        $('.hero-description-bottom', '#ut-hero:not(.slider)').flowtype({
           maxFont: hero_db_max_font,
           fontRatio: 24,
           minFont: 12
        });
     }
  }
  $(".page-title, .parallax-title, .section-title").each(function() {
     var $this = $(this);
     var title_original_font_size = $this.css("font-size"),
        title_original_line_height = $this.css("line-height");
     if (title_original_font_size) {
        $this.data("maxfont", title_original_font_size.replace('px', ''));
        $this.data("lineheight", title_original_line_height);
        var font_ratio = $this.data("maxfont") <= 75 ? 8 : 4;
        $this.flowtype({
           maxFont: $(this).data("maxfont"),
           lineHeight: $(this).data("lineheight"),
           fontRatio: font_ratio,
           minFont: 30,
           type: 'title',
           loaded: function() {
              $this.addClass('ut-title-loaded');
           }
        });
     }
  });
  $(".ut-custom-heading-module").each(function() {
     var title_original_font_size = $(this).css("font-size"),
        title_original_line_height = $(this).css("line-height");
     if (title_original_font_size) {
        $(this).data("maxfont", title_original_font_size.replace('px', ''));
        $(this).data("lineheight", title_original_line_height);
        var font_ratio = $(this).data("maxfont") <= 75 ? 8 : 4;
        $(this).flowtype({
           maxFont: $(this).data("maxfont"),
           lineHeight: $(this).data("lineheight"),
           fontRatio: font_ratio,
           type: 'custom',
           loaded: function() {}
        });
     }
  });
  $(".ut-information-box-title, .ut-service-column-title").each(function() {
     var title_original_font_size = $(this).css("font-size"),
        title_original_line_height = $(this).css("line-height");
     if (title_original_font_size) {
        $(this).data("maxfont", title_original_font_size.replace('px', ''));
        $(this).data("lineheight", title_original_line_height);
        $(this).flowtype({
           maxFont: $(this).data("maxfont"),
           lineHeight: $(this).data("lineheight"),
           fontRatio: 4,
           type: 'custom',
           loaded: function() {}
        });
     }
  });
  $(".ut-word-rotator").each(function() {
     if ($(this).closest('.hero-title').length) {
        return;
     }
     var title_original_font_size = $(this).css("font-size"),
        title_original_line_height = $(this).css("line-height");
     if (title_original_font_size) {
        $(this).data("maxfont", title_original_font_size.replace('px', ''));
        $(this).data("lineheight", title_original_line_height);
        var font_ratio = $(this).data("maxfont") <= 75 ? 8 : 4;
        $(this).flowtype({
           maxFont: $(this).data("maxfont"),
           lineHeight: $(this).data("lineheight"),
           fontRatio: font_ratio,
           type: 'custom',
           loaded: function() {}
        });
     }
  });
  $(".single-post .entry-title, .single-post-entry-sub-title, .ut-blog-classic-article .entry-title, .ut-blog-mixed-large-article .entry-title").each(function() {
     var title_original_font_size = $(this).css("font-size"),
        title_original_line_height = $(this).css("line-height");
     if (title_original_font_size) {
        $(this).data("maxfont", title_original_font_size.replace('px', ''));
        $(this).data("lineheight", title_original_line_height);
        var font_ratio = $(this).data("maxfont") <= 75 ? 8 : 4;
        $(this).flowtype({
           maxFont: $(this).data("maxfont"),
           fontRatio: font_ratio,
           minFont: 30,
           type: 'title',
           lineHeight: $(this).data("lineheight"),
        });
     }
  });
  if ($(".ut-parallax-quote-title").length) {
     $(".ut-parallax-quote-title").each(function() {
        var title_original_font_size = $(this).css("font-size"),
           title_original_line_height = $(this).css("line-height");
        if (title_original_font_size) {
           $(this).data("maxfont", title_original_font_size.replace('px', ''));
           $(this).data("lineheight", title_original_line_height);
           var font_ratio = $(this).data("maxfont") <= 75 ? 8 : 4;
           $(this).flowtype({
              maxFont: $(this).data("maxfont"),
              fontRatio: font_ratio,
              minFont: 30,
              lineHeight: $(this).data("lineheight"),
              type: 'title'
           });
        }
     });
  }
  $("#ut-overlay-nav ul > li").each(function() {
     var overlay_font_size = $(this).css("font-size");
     if (overlay_font_size) {
        $(this).data("maxfont", overlay_font_size.replace('px', ''));
        $(this).flowtype({
           maxFont: $(this).data("maxfont"),
           fontRatio: 8,
           minFont: 25
        });
     }
  });

  function add_visual_composer_helper_classes() {
     $('.vc_col-has-fill').each(function() {
        $(this).parent(".vc_row").addClass("ut-row-has-filled-cols");
     });
     $('.vc_section > .vc_row, .vc_section > .vc_vc_row').each(function() {
        var $this = $(this);
        if ($this.parent().children('.vc_row, .vc_vc_row').first().is(this)) {
           if ($this.hasClass("vc_row-has-fill")) {
              $this.parent().addClass("ut-first-row-has-fill");
           }
           $this.addClass('ut-first-row');
        }
        if ($this.parent().children('.vc_row, .vc_vc_row').last().is(this)) {
           if ($this.hasClass("vc_row-has-fill")) {
              $this.parent().addClass("ut-last-row-has-fill");
           }
           $this.addClass('ut-last-row');
        }
     });
     var $contact_content_block = $('#ut-custom-contact-section');
     $('.vc_section').each(function() {
        var $this = $(this);
        if ($this.closest('#ut-custom-hero').length) {
           return;
        }
        if ($this.is(':first-of-type') && $this.is(':visible')) {
           if (!$this.closest('#ut-custom-contact-section').length) {
              $this.addClass('ut-first-section');
           }
           if ($this.closest('#ut-custom-contact-section').length) {
              $this.addClass('ut-first-in-contact-section');
           }
        }
        if ($this.is(':first-of-type') && $this.is(':visible') && $this.next('.vc_row-full-width').next('.vc_section').is(':last-of-type') && !$this.next('.vc_row-full-width').next('.vc_section').is(':visible')) {
           if (!$contact_content_block.length) {
              $this.addClass('ut-last-section');
              if (!$this.hasClass('vc_section-has-fill')) {
                 $("#ut-sitebody").addClass('ut-last-section-has-no-fill');
              }
           }
           if ($contact_content_block.length && $this.closest('#ut-custom-contact-section').length) {
              $this.addClass('ut-last-section');
           }
        }
        if ($this.is(':last-of-type') && $this.is(':visible')) {
           if (!$contact_content_block.length) {
              $this.addClass('ut-last-section');
           }
           if (!$this.hasClass('vc_section-has-fill')) {
              $("#ut-sitebody").addClass('ut-last-section-has-no-fill');
           }
           if ($contact_content_block.length && !$this.hasClass('vc_section-has-fill') && !$this.closest('#ut-custom-contact-section').length) {
              $contact_content_block.addClass('ut-last-content-section-as-no-fill');
           }
        }
        if ($this.is(':last-of-type') && $this.is(':visible') && $this.closest('#ut-custom-contact-section').length) {
           $this.addClass('ut-last-section');
        }
        if ($this.is(':last-of-type') && $this.is(':visible') && $this.prev('.vc_row-full-width').prev('.vc_section').is(':first-of-type') && !$this.prev('.vc_row-full-width').prev('.vc_section').is(':visible')) {
           if (!$this.closest('#ut-custom-contact-section').length) {
              $this.addClass('ut-first-section');
           }
        }
        if ($this.hasClass('vc_section-has-no-fill') && !$this.hasClass('ut-last-row-has-fill') && $this.next('.vc_row-full-width').next('.vc_section').hasClass('vc_section-has-no-fill') && !$this.next('.vc_row-full-width').next('.vc_section').hasClass('ut-first-row-has-fill')) {
           $this.addClass("vc_section-remove-padding-bottom");
        }
     });
     $('.ut-information-box-image-wrap').each(function() {
        var $this = $(this);
        $this.closest('.wpb_wrapper').addClass('ut-contains-information-box');
        if ($this.parent().siblings().not('.ut-information-box').length) {
           $this.closest('.wpb_wrapper').addClass('ut-contains-information-box-mixed');
        }
        if (!$this.parent().siblings().length) {
           $this.parent().addClass('ut-information-box-no-siblings');
        }
     });
     $('.section-header').each(function() {
        if ($(this).closest(".wpb_column").is(":first-child")) {
           $(this).closest(".wpb_column").addClass("ut-first-wpb-column");
        }
        if ($(this).closest(".wpb_content_element").is(":first-child")) {
           $(this).addClass("ut-first-section-title");
        }
     });
  }
  add_visual_composer_helper_classes();
  $(window).utresize(function() {
     add_visual_composer_helper_classes();
  });
  $(document).ajaxComplete(function() {
     add_visual_composer_helper_classes();
  });
  $('.ut-plan-module-popular').each(function() {
     var $this = $(this);
     $this.closest(".wpb_column").addClass("ut-column-with-popular-pricing-table");
  });
  var modern_media_query = window.matchMedia("screen and (-webkit-min-device-pixel-ratio:2)");
  var $brooklyn_body = $("body");
  var $brooklyn_header = $("#header-section");
  var $brooklyn_main = $("#main-content");
  var $header = $("#header-section"),
     $logo = $(".site-logo:not(.ut-overlay-site-logo)").find('img'),
     logo = $logo.data("original-logo"),
     logoalt = $logo.data("alternate-logo");
  var primary_skin = $header.data('primary-skin');
  var secondary_skin = $header.data('secondary-skin');

  function ut_nav_skin_changer(direction, animClassDown, animClassUp, headerClassDown, headerClassUp) {
     animClassUp = typeof animClassUp !== 'undefined' ? animClassUp : '';
     animClassDown = typeof animClassDown !== 'undefined' ? animClassDown : '';
     headerClassUp = typeof headerClassUp !== 'undefined' ? headerClassUp : '';
     headerClassDown = typeof headerClassDown !== 'undefined' ? headerClassDown : '';
     if (direction === "down") {
        if (!site_settings.mobile_nav_open) {
           $logo.attr("src", logoalt);
           $header.attr("class", "ha-header").addClass(headerClassDown).addClass(animClassDown);
        }
        $header.data("primary-skin", secondary_skin);
        $header.data("secondary-skin", secondary_skin);
        site_settings.mobile_hero_passed = true;
     } else if (direction === "up") {
        if (!site_settings.mobile_nav_open) {
           $logo.attr("src", logo);
           $header.attr("class", "ha-header").addClass(headerClassUp).addClass(animClassUp);
        }
        $header.data("primary-skin", primary_skin);
        $header.data("secondary-skin", secondary_skin);
        site_settings.mobile_hero_passed = false;
     }
  }
  $brooklyn_main.waypoint(function(direction) {
     ut_nav_skin_changer(direction, "ut-secondary-custom-skin", "ut-primary-custom-skin", "ut-header-floating bordered-top fullwidth   ", "ut-header-floating bordered-top fullwidth   ");
  }, {
     offset: site_settings.brooklyn_header_scroll_offset + 1
  });
})(jQuery);