<?php

$skin_color = urldecode($_GET['skin']);

header("Content-type: text/css; charset: UTF-8");

if (empty($skin_color) || $skin_color === 'default')
    return;

list($r, $g, $b) = sscanf($skin_color, "#%02x%02x%02x");


$output = <<<HTML

th { background: $skin_color; }
a, a:active, a:visited { color: {$skin_color}; }
a:hover { color: #888; }
.dark-bg a { color: {$skin_color} !important; }
blockquote .author, blockquote em, blockquote i, blockquote cite { color: {$skin_color}; }

.dropdown-menu-wrap ul.sub-menu li:hover, .dropdown-menu-wrap ul.sub-menu li.sfHover { background: {$skin_color}; }
#primary-menu > ul.menu > li:hover > ul.sub-menu { border-color: {$skin_color}; }
#primary-menu .hover-bg { border-color: {$skin_color};}
#title-area { background: {$skin_color}; }
#custom-title-area { background: {$skin_color}; }

.post-list .entry-title a:hover, .post-list .entry-title a:visited { color: {$skin_color}; }
.sticky .entry-snippet { border-color: {$skin_color};}
.entry-terms.multi-color .news_category, .entry-terms.multi-color .category { background-color: {$skin_color}; }
a.more-link:hover { color: {$skin_color}; }
a.comment-reply-link, a.comment-edit-link { background-color: {$skin_color}; }
a.comment-reply-link:visited, a.comment-edit-link:visited { background-color: {$skin_color}; }
button, .button, input[type=button], input[type="submit"], input[type="reset"] { background-color: {$skin_color}; border-color: {$skin_color};}
.button.theme:hover { background: {$skin_color} !important; }
.button.theme { border-color: {$skin_color} !important; }


.segment .flex-control-nav li a:hover, .segment .flex-control-nav li a.flex-active { background-color: {$skin_color}; }

#flickr-widget .flickr_badge_image img:hover { border-color: {$skin_color}; }
ul#recentcomments li.recentcomments a { color: {$skin_color}; }
.tagcloud a:hover { background-color: {$skin_color}; }
input#mc_signup_submit { background-color: {$skin_color} !important; }

.header-fancy span { background-color: {$skin_color}; }
h3.fancy-header { background-color: {$skin_color};}

.skill-bar-content { background: {$skin_color}; }
.slogan1 .highlight, .slogan1 .highlight h2 { color: {$skin_color}; }
.heading2 .subtitle span { color: {$skin_color}; }
.heading1.separator .title:after, .heading2.separator .title:after { background: $skin_color; }
h4.subheading:after, h3.subheading:after { border-color: {$skin_color}; }

.segment.slogan blockquote .footer cite { color: {$skin_color}; }
.portfolio-label { color: {$skin_color}; }
.portfolio-index i:hover { color: {$skin_color}; }
#showcase-filter a:hover, #showcase-filter a.active, #showcase-links a:hover, #showcase-links a.active { background: {$skin_color}; border-color: {$skin_color}; }

.stats-bar-content { background: {$skin_color}; }
.number-stats .number-stat .number { color: {$skin_color};}
.number-stats .number-stat .icon-wrap { background: {$skin_color}; }

.pricing-table .pricing-plan.highlight .top-header { background-color: {$skin_color}; }
.pricing-table .plan-details ul li i { color: {$skin_color}; }

.testimonials2-slider-container blockquote cite i { background-color: {$skin_color}; }
.client-testimonials2 .header cite { color: {$skin_color};}
#services-icon-list div.icon { color: {$skin_color};}
#services-icon-list .sub { color: {$skin_color};}
.features-list-alternate i { color: {$skin_color}; }
ul.member-list { border-color: {$skin_color}; }
ul.member-list li a.visible, ul.member-list li a.flex-active { border-color: {$skin_color}; }
ul.member-list li a:hover { color: {$skin_color}; }
#showcase-filter a:hover { background: {$skin_color}; border-color: {$skin_color}; }

.timeline-item:before { background: {$skin_color}; }
.timeline-footer .event-category i { color: {$skin_color}; }

.course-details .header, .staff-details .header, .department-details .header { background: {$skin_color}; }
.post-snippets .type-course .course-id { background: {$skin_color}; }



#column-shortcode-section p { background: {$skin_color}; }

.top-of-page a:hover, .post-list .byline a, .post-list .byline a:active, .post-list .byline a:visited,
#content .hentry h2.entry-title a:hover, .entry-meta span i, .read-more a, .loop-nav a:hover,
.sidebar li > a:hover, .sidebar li:hover > a, #sidebars-footer .widget_text a.small, #sidebars-footer .widget_text a.small:visited,
#home-intro h2 span, .team-member:hover h3 a, .post-snippets .hentry .entry-title a:hover { color: {$skin_color}; }

.widget.widget_nav_menu ul li.current_page_item > a { background: {$skin_color}; }

.bx-wrapper .bx-pager.bx-default-pager a:hover, .bx-wrapper .bx-pager.bx-default-pager a.active,
.page-links a, .page-links a:visited, .pagination a, .pagination a:visited,
.profile-header img:hover { background: {$skin_color}; }

#styleswitcher-button i { color: {$skin_color} !important; }

.profile-header .socials { background: rgba({$r}, {$g} , {$b}, 0.7);}
input:focus, textarea:focus, #content .contact-form input:focus, #content .contact-form textarea:focus,
#footer .contact-form input:focus, #footer .contact-form textarea:focus { border-color: rgba({$r}, {$g} , {$b}, 0.8); }
#home2-heading .heading2 h2, #home3-heading .heading2 h2, .team-member .team-member-hover { background: rgba({$r}, {$g} , {$b}, 0.7); }

#footer .button:hover, #footer button:hover, #footer input[type="button"]:hover, #footer input[type="submit"]:hover, #footer input[type="reset"]:hover {
background-color: {$skin_color} !important;
border-color: {$skin_color} !important;
}

.tabs .current, .tabs .current:hover, .tabs li.current a { border-top-color: {$skin_color}; }
.toggle-label:hover, .active-toggle .toggle-label:hover { background-color: {$skin_color}; }

ul.tab-list, ul.member-list { border-bottom: 1px solid {$skin_color}; }
ul.tab-list li a.visible, ul.tab-list li a.flex-active, ul.member-list li a.visible, ul.member-list li a.flex-active { border-bottom: 3px solid {$skin_color}; }
ul.tab-list li a:hover, ul.member-list li a:hover { color: {$skin_color}; }

.sidebar .text-content a, #footer .text-content a { color: {$skin_color}; }

.gallery-carousel .carousel-container .owl-carousel.owl-theme .owl-prev, .gallery-carousel .carousel-container .owl-carousel.owl-theme .owl-next { background: {$skin_color}; }

/* Plugins Skins Styles */

/*---------- Events Manager ------------- */

table.em-calendar thead { background: {$skin_color}; }
table.em-calendar td.eventful-today a , table.em-calendar td.eventful a { color: {$skin_color}; }

#tribe-events-content .tribe-events-tooltip h4, #tribe_events_filters_wrapper .tribe_events_slider_val, .single-tribe_events a.tribe-events-ical,
.single-tribe_events a.tribe-events-gcal {
  color: {$skin_color};
  }
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"] > a,
#tribe_events_filters_wrapper input[type=submit], .tribe-events-button, #tribe-events .tribe-events-button, .tribe-events-button.tribe-inactive,
#tribe-events .tribe-events-button:hover, .tribe-events-button:hover, .tribe-events-button.tribe-active:hover {
  background: {$skin_color};
  }

/* ------------ LearnDash LMS --------------*/

#learndash_lessons a, #learndash_quizzes a, .expand_collapse a, .learndash_topic_dots a, .learndash_topic_dots a > span, #learndash_lesson_topics_list span a, #learndash_profile a, #learndash_profile a span {
  color: {$skin_color} !important;
  }
.wpProQuiz_content h2:after { border-color: {$skin_color}; }
.wpProQuiz_button, .wpProQuiz_button:hover { background-color: {$skin_color} !important; border-color: {$skin_color} !important; }

/*------- WooCommerce ---------*/

.woocommerce-site .cart-contents .cart-count {
  background: {$skin_color};
}

.woocommerce input[name="update_cart"], .woocommerce input[name="proceed"], .woocommerce input[name="woocommerce_checkout_place_order"],
 .woocommerce-page input[name="update_cart"], .woocommerce-page input[name="proceed"], .woocommerce-page input[name="woocommerce_checkout_place_order"] {
  color: #ffffff;
  background-color: {$skin_color};
  }
.woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit, .woocommerce #content input.button, .woocommerce a.button.alt,
.woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce #content input.button.alt,
.woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce-page #respond input#submit,
.woocommerce-page #content input.button, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt,
.woocommerce-page #respond input#submit.alt, .woocommerce-page #content input.button.alt {
background: {$skin_color};
border-color: {$skin_color};
}

.woocommerce a.add_to_cart_button, .woocommerce-page a.add_to_cart_button { background: transparent; border-color: #aaa;}

.woocommerce .quantity .plus, .woocommerce #content .quantity .plus, .woocommerce .quantity .minus, .woocommerce #content .quantity .minus, .woocommerce-page .quantity .plus,
.woocommerce-page #content .quantity .plus, .woocommerce-page .quantity .minus, .woocommerce-page #content .quantity .minus {
background: {$skin_color};
}

.woocommerce .woocommerce-message, .woocommerce .woocommerce-info, .woocommerce .woocommerce-error {
border-color: rgba({$r}, {$g} , {$b}, 0.3);
background: rgba({$r}, {$g} , {$b}, 0.1);
}

.woocommerce span.onsale, .woocommerce-page span.onsale { background: {$skin_color}; }

.woocommerce-site .cart-contents .cart-count { background: {$skin_color}; }

.woocommerce .star-rating span:before, .woocommerce-page .star-rating span:before {
  color: {$skin_color};
  }
.woocommerce span.onsale, .woocommerce-page span.onsale {
  background: {$skin_color};
  text-shadow: none;
  box-shadow: none;
  }
.woocommerce-message,  .woocommerce-info,  .woocommerce-error {
    border: 1px solid rgba({$r}, {$g} , {$b}, 0.3);
    background: rgba({$r}, {$g} , {$b}, 0.2);
}
.cart-contents .cart-count {
    background: {$skin_color};
}
ul.products li.product h3:hover {
    color: {$skin_color};
}

.tp_recent_tweets li a { color: {$skin_color} !important; }

.instagram-pics img:hover { border-color: {$skin_color} !important; }

.tp-caption.medium_bg_austin { background-color: {$skin_color} !important; }
.tp-caption.medium_bg_orange { background-color: rgba({$r}, {$g} , {$b}, 0.75) !important; }

HTML;

echo $output;
?>