<?php
/*
 * Various utility functions required by theme defined here
 * 
 * @package Livemesh_Framework
 *
 */

if (!function_exists('mo_get_entry_title')) {
    function mo_get_entry_title($link = true) {
        global $post;

        $link_start_tag = '';
        $link_end_tag = '';

        if ($link) {
            $link_start_tag = '<a href="' . get_permalink() . '" title="' . get_the_title() . '" rel="bookmark">';
            $link_end_tag = '</a>';
        }

        if (is_front_page() && !is_home()) {
            $title = the_title('<h2 class="' . esc_attr($post->post_type) . '-title entry-title">' . $link_start_tag, $link_end_tag . '</h2>',
                false);
        }
        elseif (is_singular()) {
            $title = the_title('<h1 class="' . esc_attr($post->post_type) . '-title entry-title">', '</h1>', false);
        }
        else {
            $title = the_title('<h2 class="entry-title">' . $link_start_tag, $link_end_tag . '</h2>', false);
        }

        /* If there's no post title, return a default title */
        if (empty($title)) {
            if (!is_singular()) {
                $title = '<h2 class="entry-title no-entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . __('(Untitled)',
                        'mo_theme') . '</a></h2>';
            }
            else {
                $title = '<h1 class="entry-title no-entry-title">' . __('(Untitled)', 'mo_theme') . '</h1>';
            }
        }

        return $title;
    }
}

if (!function_exists('mo_entry_author')) {

    function mo_entry_author() {

        $prefix = '<i class="icon-user13"></i>';

        $author = '<span class="author vcard">' . $prefix . '<a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(get_the_author_meta('display_name')) . '">' . get_the_author_meta('display_name') . '</a></span>';
        return $author;
    }
}

if (!function_exists('mo_entry_published')) {

    function mo_entry_published($format = "M d, Y") {

        $prefix = '<i class="icon-calendar6"></i>';

        $link = '<span class="published">' . $prefix . '<a href="' . get_day_link(get_the_time(__('Y', 'mo_theme')), get_the_time(__('m', 'mo_theme')), get_the_time(__('d', 'mo_theme'))) . '" title="' . sprintf(get_the_time(esc_attr__('l, F, Y, g:i a', 'mo_theme'))) . '">' . get_the_time($format) . '</a></span>';

        return $link;

        $published = '<span class="published">' . $prefix . ' <abbr title="' . sprintf(get_the_time(esc_attr__('l, F, Y, g:i a', 'mo_theme'))) . '">' . sprintf(get_the_time($format)) . '</abbr></span>';

        return $published;
    }
}

if (!function_exists('mo_custom_entry_published')) {

    function mo_custom_entry_published() {

        $published = '<span class="published"><abbr title="' . sprintf(get_the_time(esc_attr__('l, F, Y, g:i a', 'mo_theme'))) . '"><span class="month">' . sprintf(get_the_time('M')) . '</span><span class="date">' . sprintf(get_the_time('d')) . '</span></abbr></span>';
        return $published;
    }
}

if (!function_exists('mo_entry_terms_list')) {

    function mo_entry_terms_list($taxonomy = 'category', $separator = ', ', $before = ' ', $after = ' ') {
        global $post;

        $style = '';
        $output = '';

        $terms = get_the_terms($post->ID, $taxonomy);

        if (!empty($terms)) {
            foreach ($terms as $term)
                break;
            $saved_color = get_tax_meta($term->term_id, 'mo_term_color_field_id');
            if (!empty($saved_color))
                $style = ' style="background-color:' . $saved_color . ';"';
        }
        else {
            return $output;
        }

        $output .= '<span ' . $style . ' class="' . $taxonomy . '">';
        if ($taxonomy == 'post_tag')
            $output .= '<i class="icon-tag"></i>';
        else
            $output .= '<i class="icon-tag"></i>';

        $output .= get_the_term_list($post->ID, $taxonomy, $before, $separator, $after);

        $output .= '</span>';

        return $output;
    }
}

if (!function_exists('mo_entry_terms_text')) {

    function mo_entry_terms_text($taxonomy = 'category', $separator = ' , ') {
        global $post;

        $output = '';

        $terms = get_the_terms($post, $taxonomy);
        if (!empty($terms)) {
            foreach ($terms as $term)
                $term_names[] = $term->name;

            $output = implode($separator, $term_names);
        }

        return $output;
    }
}


if (!function_exists('mo_display_related_posts')) {
    function mo_display_related_posts($args) {

        global $post;

        /** Default config options */
        $defaults = array(
            'header_text' => __("Related Posts", "mo_theme"),
            'taxonomy' => 'category',
            'show_meta' => false,
            'post_count' => 4,
            'number_of_columns' => 4,
            'image_size' => "medium",
            'excerpt_count' => 80,
            'display_summary' => false
        );

        /** Parse default options with config options from $this->bulk_upgrade and extract them */
        $args = wp_parse_args($args, $defaults);
        extract($args);

        $style_class = mo_get_column_style($number_of_columns);

        $posts = mo_related_posts_by_taxonomy(get_the_ID(), $taxonomy, array('posts_per_page' => $post_count));

        if (!empty($posts)):

            $post_count = 0;

            $first_row = true;
            $last_column = false;

            echo '<h4 class="subheading">' . $header_text . '</h4>';

            echo '<div class="related-posts post-snippets">';

            foreach ($posts as $post) {

                setup_postdata($post);

                $post_id = $post->ID;

                if ($last_column) {
                    echo '<div class="clear"></div>';
                    $first_row = false;
                }

                if (++$post_count % $number_of_columns == 0)
                    $last_column = true;
                else
                    $last_column = false;

                echo '<div class="' . $style_class . ' clearfix' . ($last_column ? ' last' : '') . '">';

                echo '<article class="' . join(' ', get_post_class()) . ($first_row ? ' first' : '') . '">';

                $thumbnail_exists = mo_thumbnail(array(
                    'post_id' => $post_id,
                    'image_size' => $image_size,
                    'wrapper' => false,
                    'image_alt' => get_the_title($post_id),
                    'size' => 'full'
                ));

                echo '<div class="entry-text-wrap' . ($thumbnail_exists ? '' : ' nothumbnail') . '">';

                if (get_post_type($post_id) == 'course') {
                    $course_id = get_post_meta($post_id, 'mo_course_identifier', true);
                    if (!empty($course_id)) {
                        echo '<div class="course-id">' . $course_id . '</div>';
                    }
                    echo mo_get_taxonomy_info('course_category');
                }

                $before_title = '<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">';
                $after_title = '</a></h3>';

                the_title($before_title, $after_title);

                if ($show_meta)
                    echo '<div class="byline">' . mo_entry_published() . mo_entry_comments_number() . '</div>';

                if ($excerpt_count != 0) {
                    echo '<div class="entry-summary">';
                    echo mo_truncate_string(get_the_excerpt(), $excerpt_count);
                    echo '</div><!-- .entry-summary -->';
                }

                echo '</div><!-- entry-text-wrap -->';

                echo '</article><!-- .hentry -->';

                echo '</div> <!-- .column-class -->';

            }

            echo '</div> <!-- .related-posts -->';

            echo '<div class="clear"></div>';

            wp_reset_postdata();

        endif;

    }
}

if (!function_exists('mo_display_selected_posts')) {
    function mo_display_selected_posts($args) {

        global $post;

        /** Default config options */
        $defaults = array(
            'header_text' => __("Related Posts", "mo_theme"),
            'show_meta' => false,
            'number_of_columns' => 4,
            'image_size' => "medium",
            'excerpt_count' => 80,
            'display_summary' => true,
            'enable_sorting' => false,
            'query_args' => ''
        );

        $args = wp_parse_args($args, $defaults);

        extract($args);

        $query_args = wp_parse_args($query_args, array(
            'post_type' => $post_type,
            'post__in' => $post_ids,
            'numberposts' => -1
        ));

        if ($enable_sorting) {
            $query_args['orderby'] = 'menu_order';
            $query_args['order'] = 'ASC';
        }

        $rposts = get_posts($query_args);

        $style_class = mo_get_column_style($number_of_columns);

        if (!empty($rposts)):

            $post_count = 0;

            $first_row = true;
            $last_column = false;

            echo '<h4 class="subheading">' . $header_text . '</h4>';

            echo '<div class="related-posts post-snippets">';

            foreach ($rposts as $post) {

                setup_postdata($post);

                $post_id = $post->ID;

                if ($last_column) {
                    echo '<div class="clear"></div>';
                    $first_row = false;
                }

                if (++$post_count % $number_of_columns == 0)
                    $last_column = true;
                else
                    $last_column = false;

                echo '<div class="' . $style_class . ' clearfix' . ($last_column ? ' last' : '') . '">';

                echo '<article class="' . join(' ', get_post_class()) . ($first_row ? ' first' : '') . '">';

                $thumbnail_exists = mo_thumbnail(array(
                    'post_id' => $post_id,
                    'image_size' => $image_size,
                    'wrapper' => false,
                    'image_alt' => get_the_title($post_id),
                    'size' => 'full'
                ));

                echo '<div class="entry-text-wrap' . ($thumbnail_exists ? '' : ' nothumbnail') . '">';

                if (get_post_type($post_id) == 'course') {
                    $course_id = get_post_meta($post_id, 'mo_course_identifier', true);
                    if (!empty($course_id)) {
                        echo '<div class="course-id">' . $course_id . '</div>';
                    }
                    echo mo_get_taxonomy_info('course_category');
                }

                $before_title = '<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">';
                $after_title = '</a></h3>';

                the_title($before_title, $after_title);

                if ($show_meta)
                    echo '<div class="byline">' . mo_entry_published() . mo_entry_comments_number() . '</div>';

                if ($excerpt_count != 0) {
                    echo '<div class="entry-summary">';
                    echo mo_truncate_string(get_the_excerpt(), $excerpt_count);
                    echo '</div><!-- .entry-summary -->';
                }

                echo '</div><!-- entry-text-wrap -->';

                echo '</article><!-- .hentry -->';

                echo '</div> <!-- .column-class -->';

            }

            echo '</div> <!-- .related-posts -->';

            echo '<div class="clear"></div>';

            wp_reset_postdata();

        endif;

    }
}

if (!function_exists('mo_related_posts_by_taxonomy')) {

    function mo_related_posts_by_taxonomy($post_id, $taxonomy, $args = array()) {
        $terms = wp_get_object_terms($post_id, $taxonomy);

        //Pluck out the IDs to get an array of IDS
        $term_ids = wp_list_pluck($terms, 'term_id');

        //Query posts with tax_query. Choose in 'IN' if want to query posts with any of the terms
        //Choose 'AND' if you want to query for posts with all terms
        $args = wp_parse_args($args, array(
            'post_type' => get_post_type($post_id),
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'id',
                    'terms' => $term_ids,
                    'operator' => 'IN'
                    //Or 'AND' or 'NOT IN'
                )
            ),
            'ignore_sticky_posts' => 1,
            'numberposts' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post__not_in' => array($post_id)
        ));

        $posts = get_posts($args);

        // Return our results in query form
        return $posts;
    }

}

if (!function_exists('mo_get_post_snippets')) {

// Display grid style posts layout for portfolio or regular posts
    function mo_get_post_snippets($args) {
        global $mo_theme;

        $mo_theme->set_context('loop', 'portfolio'); // tells the thumbnail functions to prepare lightbox constructs for the image

        $output = mo_get_post_snippets_layout($args);

        $mo_theme->set_context('loop', null); //reset it

        return $output;

    }
}

if (!function_exists('mo_get_post_snippets_list')) {

    // Display posts snippets list for flexslider carousel
    function mo_get_post_snippets_list($args) {

        /* Extract the array to allow easy use of variables. */
        extract($args);

        if ($post_type == 'portfolio')
            $taxonomy = 'portfolio_category';
        elseif ($post_type == 'gallery_item')
            $taxonomy = 'gallery_category';
        elseif ($post_type == 'news')
            $taxonomy = 'news_category';
        elseif ($post_type == 'course')
            $taxonomy = 'course_category';
        elseif ($post_type == 'staff')
            $taxonomy = 'specialization';
        elseif ($post_type == 'department')
            $taxonomy = '';
        elseif ($post_type == 'post' || $post_type == 'sfwd-courses')
            $taxonomy = 'category';

        if (!empty($post_ids))
            $loop = new WP_Query(array(
                'post_type' => $post_type,
                'posts_per_page' => $post_count,
                'post__in' => explode(',', $post_ids)
            ));
        elseif (empty($taxonomy) || empty($terms))
            $loop = new WP_Query(array(
                'ignore_sticky_posts' => 1,
                'post_type' => $post_type,
                'posts_per_page' => $post_count
            ));
        else
            $loop = new WP_Query(array(
                'post_type' => $post_type,
                'posts_per_page' => $post_count,
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'slug',
                        'terms' => explode(',', $terms)
                    )
                )
            ));

        $output = '';

        if ($loop->have_posts()) :

            $hide_thumbnail = mo_to_boolean($hide_thumbnail);

            $display_title = mo_to_boolean($display_title);

            $show_meta = mo_to_boolean($show_meta);

            $display_summary = mo_to_boolean($display_summary);

            while ($loop->have_posts()) : $loop->the_post();

                $thumbnail_exists = false;

                $output .= '<article class="' . join(' ', get_post_class()) . '">';

                if (!$hide_thumbnail) {
                    $thumbnail_url = mo_get_thumbnail(array(
                        'show_image_info' => true,
                        'image_size' => $image_size
                    ));
                    if (!empty($thumbnail_url)) {
                        $thumbnail_exists = true;
                        $output .= $thumbnail_url;
                    }
                }

                if ($display_title || $display_summary || $show_meta) {

                    $output .= "\n" . '<div class="entry-text-wrap ' . ($thumbnail_exists ? '' : 'nothumbnail') . '">';

                    if ($post_type == 'news' || $post_type == 'post') {

                        $output .= '<div class="entry-terms multi-color">';

                        $output .= mo_entry_terms_list($taxonomy);

                        $output .= '</div>'; // .entry-terms
                    }


                    if ($post_type == 'course') {

                        $course_id = get_post_meta(get_the_ID(), 'mo_course_identifier', true);
                        if (!empty($course_id)) {
                            $output .= '<div class="course-id">' . $course_id . '</div>';
                        }
                    	$output .= mo_get_taxonomy_info('course_category');
                    }

                    if ($post_type == 'staff') {

                        $staff_title = get_post_meta(get_the_ID(), 'mo_staff_title', true);
                        if (!empty($staff_title)) {
                            $output .= '<div class="staff-title">' . $staff_title . '</div>';
                        }
                    }

                    if ($display_title)
                        $output .= "\n" . the_title('<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h3>', false);

                    if ($display_summary) {

                        $output .= '<div class="entry-summary">';

                        if ($show_excerpt) {
                            $output .= mo_truncate_string(get_the_excerpt(), $excerpt_count);
                        }
                        else {
                            global $more;
                            $more = 0;
                            $output .= get_the_content(__('Read More <span class="meta-nav">&rarr;</span>', 'mo_theme'));
                        }
                        $output .= '</div><!-- .entry-summary -->';
                    }

                    $output .= '</div><!-- .entry-text-wrap -->';

                    if ($show_meta) {
                        if ($post_type == 'post' || $post_type == 'news')
                            $output .= '<div class="byline">' . mo_entry_published() . mo_entry_comments_number() . '</div>';
                    }

                }

                $output .= '</article><!-- .hentry -->';


            endwhile;

        endif;

        wp_reset_postdata();

        return $output;
    }
}

if (!function_exists('mo_display_post_nuggets_grid_style')) {

    function mo_display_post_nuggets_grid_style($args) {

        /* Set the default arguments. */
        $defaults = array(
            'loop' => null,
            'number_of_columns' => 2,
            'image_size' => 'medium',
            'excerpt_count' => 120,
            'show_meta' => false,
            'style' => null
        );

        /* Merge the input arguments and the defaults. */
        $args = wp_parse_args($args, $defaults);

        /* Extract the array to allow easy use of variables. */
        extract($args);

        $style_class = mo_get_column_style($number_of_columns);

        if ($loop->have_posts()) :
            $post_count = 0;

            $first_row = true;
            $last_column = false;

            $style = ($style ? ' ' . $style : '');

            echo '<div class="post-list' . $style . '">';

            while ($loop->have_posts()) : $loop->the_post();

                if ($last_column) {
                    echo '<div class="start-row"></div>';
                    $first_row = false;
                }

                if (++$post_count % $number_of_columns == 0)
                    $last_column = true;
                else
                    $last_column = false;

                echo '<div class="' . $style_class . ' clearfix' . ($last_column ? ' last' : '') . '">';

                echo '<article class="' . join(' ', get_post_class()) . ($first_row ? ' first' : '') . '">';

                $thumbnail_exists = mo_thumbnail(array(
                    'image_size' => $image_size,
                    'wrapper' => true,
                    'size' => 'full'
                ));

                echo '<div class="entry-text-wrap' . ($thumbnail_exists ? '' : ' nothumbnail') . '">';

                $before_title = '<div class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">';
                $after_title = '</a></div>';

                the_title($before_title, $after_title);

                if ($show_meta)
                    echo '<div class="byline">' . mo_entry_published() . mo_entry_comments_number() . '</div>';

                if ($excerpt_count != 0) {
                    echo '<div class="entry-summary">';
                    echo mo_truncate_string(get_the_excerpt(), $excerpt_count);
                    echo '</div><!-- .entry-summary -->';
                }

                echo '</div><!-- entry-text-wrap -->';

                echo '</article><!-- .hentry -->';

                echo '</div> <!-- .column-class -->';

            endwhile;

            echo '</div> <!-- post-list -->';

            echo '<div class="clear"></div>';

        endif;

        wp_reset_postdata(); // Right placement to help not lose context information
    }
}

if (!function_exists('mo_get_post_image_size')) {

    function mo_get_post_image_size($size_name) {
        // Translate user language to to theme specific image size
        if ($size_name == "small")
            $size_name = "mini";
        elseif ($size_name == "medium")
            $size_name = "small";
        else
            $size_name = "mini";

        return $size_name;
    }
}

if (!function_exists('mo_get_thumbnail_post_list')) {
    function mo_get_thumbnail_post_list($args) {

        /* Set the default arguments. */
        $defaults = array(
            'loop' => null,
            'image_size' => 'small',
            'style' => null,
            'show_meta' => false,
            'excerpt_count' => 120,
            'hide_thumbnail' => false
        );

        /* Merge the input arguments and the defaults. */
        $args = wp_parse_args($args, $defaults);

        /* Extract the array to allow easy use of variables. */
        extract($args);

        if (isset($enable_sorting) && $enable_sorting) {
            $query_args['orderby'] = 'menu_order';
            $query_args['order'] = 'ASC';
        }

        if (!$loop)
            $loop = new WP_Query($query_args);

        if ($loop->have_posts()):

            $css_class = $image_size . '-size';

            $style = ($style ? ' ' . $style : '');

            $output = '<ul class="post-list' . $style . ' ' . $css_class . '">';

            $hide_thumbnail = mo_to_boolean($hide_thumbnail);

            $show_meta = mo_to_boolean($show_meta);

            while ($loop->have_posts()) : $loop->the_post();

                $output .= '<li>';

                $thumbnail_exists = false;

                $output .= "\n" . '<article class="' . join(' ', get_post_class()) . '">' . "\n"; // Removed id="post-'.get_the_ID() to help avoid duplicate IDs validation error in the page

                if (!$hide_thumbnail) {
                    $thumbnail_url = mo_get_thumbnail(array('image_size' => $image_size));
                    if (!empty($thumbnail_url)) {
                        $thumbnail_exists = true;
                        $output .= $thumbnail_url;
                    }
                }

                $output .= "\n" . '<div class="entry-text-wrap ' . ($thumbnail_exists ? '' : 'nothumbnail') . '">';

                $output .= "\n" . the_title('<h4 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h4>', false);

                if ($show_meta) {
                    $output .= '<div class="byline">' . mo_entry_published() . mo_entry_comments_number() . '</div>';
                }

                if ($excerpt_count != 0) {

                    $output .= "\n" . '<div class="entry-summary">';

                    $excerpt_text = mo_truncate_string(get_the_excerpt(), $excerpt_count);
                    $output .= $excerpt_text;

                    $output .= "\n" . '</div><!-- entry-summary -->';
                }

                $output .= "\n" . '</div><!-- entry-text-wrap -->';

                $output .= "\n" . '</article><!-- .hentry -->';

                $output .= '</li>';

            endwhile;

            $output .= '</ul>';

        endif;

        wp_reset_postdata();

        return $output;
    }
}

if (!function_exists('mo_get_post_snippets_layout')) {

    function mo_get_post_snippets_layout($args) {

        /* Extract the array to allow easy use of variables. */
        extract($args);

        if ($post_type == 'portfolio')
            $taxonomy = 'portfolio_category';
        elseif ($post_type == 'gallery_item')
            $taxonomy = 'gallery_category';
        elseif ($post_type == 'news')
            $taxonomy = 'news_category';
        elseif ($post_type == 'course')
            $taxonomy = 'course_category';
        elseif ($post_type == 'staff')
            $taxonomy = 'specialization';
        elseif ($post_type == 'department')
            $taxonomy = '';
        elseif ($post_type == 'post' || $post_type == 'sfwd-courses')
            $taxonomy = 'category';

        if (!empty($post_ids))
            $query_args = array(
                'post_type' => $post_type,
                'posts_per_page' => $post_count,
                'post__in' => explode(',', $post_ids)
            );
        elseif (empty($taxonomy) || empty($terms))
            $query_args = array(
                'ignore_sticky_posts' => 1,
                'post_type' => $post_type,
                'posts_per_page' => $post_count
            );
        else
            $query_args = array(
                'post_type' => $post_type,
                'posts_per_page' => $post_count,
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'slug',
                        'terms' => explode(',', $terms)
                    )
                )
            );

        if (isset($enable_sorting) && $enable_sorting) {
            $query_args['orderby'] = 'menu_order';
            $query_args['order'] = 'ASC';
        }

        $loop = new WP_Query($query_args);

        $image_size = mo_get_image_size_for_layout($layout_mode, $image_size);

        $output = '';

        if ($loop->have_posts()) :

            $style_class = mo_get_column_style($number_of_columns, $no_margin);

            if ($post_type == 'portfolio' || $post_type == 'gallery_item')
                $style_class .= ' showcase-item';

            $hide_thumbnail = mo_to_boolean($hide_thumbnail);

            $display_title = mo_to_boolean($display_title);

            $show_meta = mo_to_boolean($show_meta);

            $display_summary = mo_to_boolean($display_summary);

            $show_excerpt = mo_to_boolean($show_excerpt);

            if (!empty($title))
                $output .= '<h3 class="post-snippets-title">' . $title . '</h3>';

            $output .= '<ul class="image-grid post-snippets ' . $layout_class . ' ' . $layout_mode . ' js-isotope" data-isotope-options=\'{ "itemSelector": ".entry-item", "layoutMode": "' . $layout_mode . '" }\'>';

            while ($loop->have_posts()) : $loop->the_post();

                $thumbnail_exists = false;

                $output .= '<li data-id="' . get_the_ID() . '" class="' . $style_class . ' entry-item">';

                $output .= "\n" . '<article class="' . join(' ', get_post_class()) . '">';

                if (!$hide_thumbnail) {
                    if ($post_type == 'post')
                        $thumbnail_output = mo_get_blog_thumbnail($image_size, $taxonomy);
                    else
                        $thumbnail_output = mo_get_thumbnail(array(
                            'image_size' => $image_size,
                            'taxonomy' => $taxonomy
                        ));
                    if (!empty($thumbnail_output)) {
                        $thumbnail_exists = true;
                        $output .= $thumbnail_output;
                    }
                }

                if ($display_title || $display_summary || $show_meta) {
                    $output .= "\n" . '<div class="entry-text-wrap ' . ($thumbnail_exists ? '' : 'nothumbnail') . '">';

                    if ($post_type == 'news' || $post_type == 'post') {

                        $output .= '<div class="entry-terms multi-color">';

                        $output .= mo_entry_terms_list($taxonomy);

                        $output .= '</div>'; // .entry-terms
                    }

                    if ($post_type == 'course') {
                        $course_id = get_post_meta(get_the_ID(), 'mo_course_identifier', true);

                        if (!empty($course_id)) {
                            $output .= '<div class="course-id">' . $course_id . '</div>';
                        }

                        $output .= mo_get_taxonomy_info('course_category');
                    }

                    if ($post_type == 'staff') {
                        $staff_title = get_post_meta(get_the_ID(), 'mo_staff_title', true);
                        if (!empty($staff_title)) {
                            $output .= '<div class="staff-title">' . $staff_title . '</div>';
                        }
                    }

                    if ($display_title)
                        $output .= "\n" . the_title('<h4 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h4>', false);

                    if ($display_summary) {

                        $output .= '<div class="entry-summary">';

                        if ($show_excerpt) {
                            $output .= mo_truncate_string(get_the_excerpt(), $excerpt_count);
                        }
                        else {
                            global $more;
                            $more = 0;
                            $output .= get_the_content(__('Read More <span class="meta-nav">&rarr;</span>', 'mo_theme'));
                        }
                        $output .= '</div><!-- .entry-summary -->';
                    }

                    $output .= '</div><!-- .entry-text-wrap -->';

                    if ($show_meta) {
                        if ($post_type == 'post' || $post_type == 'news')
                            $output .= '<div class="byline">' . mo_entry_published() . mo_entry_comments_number() . '</div>';
                    }
                }

                $output .= '</article><!-- .hentry -->';

                $output .= '</li><!-- .isotope element -->';

            endwhile;

            $output .= '</ul> <!-- post-snippets -->';

        endif;

        wp_reset_postdata();

        return $output;
    }
}

if (!function_exists('mo_get_type_info')) {
    function mo_get_type_info($button_text = '') {

        $post_title = get_the_title();
        $post_link = get_permalink();

        if (empty($button_text)) {
            $button_text = __('View Details', 'mo_theme');
        }

        echo '<div class="type-info">';
        echo '<div class="post-title"><a title="' . $post_title . '" href="' . $post_link . '">' . $post_title . '</a></div>';
        echo '<a class="button transparent" href="' . $post_link . '" title="' . $post_title . '">' . $button_text . '</a>';
        echo '</div>';

    }
}

if (!function_exists('mo_get_post_type_archive_links')) {

    function mo_get_post_type_archive_links($post_type, $taxonomy) {

        $output = '';

        $terms = get_terms($taxonomy);

        if (!empty($terms)) {

            $output .= '<ul id="showcase-links">';

            $archive_url = mo_get_post_type_archive_url($post_type);

            if (!empty($archive_url))
                $output .= '<li class="post-archive"><a class="showcase-filter" href="' . $archive_url . '">' . __('All', 'mo_theme') . '</a></li>';

            foreach ($terms as $term) {

                $category_url = get_term_link($term);

                if (is_wp_error($category_url))
                    continue;

                $current = is_tax($taxonomy, $term->term_id);

                $output .= '<li class="category-archive"><a class="category-link' . ($current ? ' active' : '') . '" href="' . $category_url . '" title="View all items filed under ' . $term->name . '">' . $term->name . '</a></li>';

            }

            $output .= '</ul>';

        }

        return $output;
    }
}

if (!function_exists('mo_display_custom_content_below_header')) {

    function mo_display_custom_content_below_header() {

        global $post;

        $before_content_text = get_post_meta(get_the_ID(), 'mo_custom_content_below_header', true);

        if (!empty($before_content_text)) {

            echo '<div id="before-content-area">';

            echo do_shortcode($before_content_text);

            echo '</div><!-- .before-content-area -->';

        }

    }
}

if (!function_exists('mo_display_post_links')) {
    function mo_display_post_links($post_ids, $post_type = "post", $icon = "") {

        $args = array(
            'post_type' => $post_type,
            'post__in' => $post_ids,
            'numberposts' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );
        $post_members = get_posts($args);

        foreach ($post_members as $post_member) {

            $post_id = $post_member->ID;

            $post_title = get_the_title($post_id);

            echo '<div class="post-link">';

            echo '<i class="' . $icon . '"></i>';

            echo '<a href="' . get_permalink($post_id) . '" title="' . $post_title . '">' . $post_title . '</a>';

            echo '</div>';

        }
        wp_reset_postdata();
    }
}

if (!function_exists('mo_display_custom_post_snippets')) {
    function mo_display_custom_post_snippets($args, $query_params) {

        global $post;

        /** Default config options */
        $defaults = array(
            'header_text' => false,
            'show_meta' => false,
            'post_type' => 'post',
            'number_of_columns' => 4,
            'image_size' => "medium",
            'excerpt_count' => 80,
            'display_summary' => false
        );

        /** Parse default options with config options from $this->bulk_upgrade and extract them */
        $args = wp_parse_args($args, $defaults);
        extract($args);

        $style_class = mo_get_column_style($number_of_columns);

        $query_params['post_type'] = $post_type;
        $query_params['posts_per_page'] = -1;
        $query_params['paged'] = get_query_var('paged') ? get_query_var('paged') : 1;

        $posts = get_posts($query_params);

        if (!empty($posts)):

            $post_count = 0;

            $first_row = true;
            $last_column = false;

            if ($header_text)
                echo '<h4 class="subheading">' . $header_text . '</h4 >';

            echo '<div class="related-posts post-snippets">';

            foreach ($posts as $post) {

                setup_postdata($post);

                $post_id = $post->ID;

                if ($last_column) {
                    echo '<div class="clear"></div>';
                    $first_row = false;
                }

                if (++$post_count % $number_of_columns == 0)
                    $last_column = true;
                else
                    $last_column = false;

                echo '<div class="' . $style_class . ' clearfix' . ($last_column ? ' last' : '') . '">';

                echo '<article class="' . join(' ', get_post_class()) . ($first_row ? ' first' : '') . '">';

                $thumbnail_exists = mo_thumbnail(array(
                    'post_id' => $post_id,
                    'image_size' => $image_size,
                    'wrapper' => false,
                    'image_alt' => get_the_title($post_id),
                    'size' => 'full'
                ));

                echo '<div class="entry-text-wrap' . ($thumbnail_exists ? '' : ' nothumbnail') . '">';

                if ($post_type == 'course') {
                    $course_id = get_post_meta($post_id, 'mo_course_identifier', true);
                    if (!empty($course_id)) {
                        echo '<div class="course-id">' . $course_id . '</div>';
                    }
                    echo mo_get_taxonomy_info('course_category');
                }
                elseif ($post_type == 'staff') {
                    $staff_title = get_post_meta($post_id, 'mo_staff_title', true);
                    if (!empty($staff_title)) {
                        echo '<div class="staff-title">' . $staff_title . '</div>';
                    }
                }

                $before_title = '<h3 class="entry-title"><a href = "' . get_permalink() . '" title = "' . get_the_title($post_id) . '" rel = "bookmark">';
                $after_title = '</a ></h3>';

                the_title($before_title, $after_title);

                if ($show_meta)
                    echo '<div class="byline">' . mo_entry_published() . mo_entry_comments_number() . '</div>';

                if ($excerpt_count != 0) {
                    echo '<div class="entry-summary">';
                    echo mo_truncate_string(get_the_excerpt(), $excerpt_count);
                    echo '</div ><!-- .entry - summary-->';
                }

                echo '</div><!--entry-text - wrap-->';

                echo '</article><!-- .hentry-->';

                echo '</div> <!-- .column -class -->';

            }

            echo '</div> <!--post-list -->';

            echo '<div class="clear" ></div>';

            wp_reset_postdata();

        endif;

    }

}

if (!function_exists('mo_get_taxonomy_info')) {

    function mo_get_taxonomy_info($taxonomy) {
        $output = '';
        $terms = get_the_terms(get_the_ID(), $taxonomy);
        if ($terms) {
            $output .= '<div class="terms">';
            $term_count = 0;
            foreach ($terms as $term) {
                if ($term_count != 0)
                    $output .= ', ';
                $output .= '<a href="' . get_term_link($term->slug, $taxonomy) . '">' . $term->name . '</a>';
                $term_count = $term_count + 1;
            }
            $output .= '</div>';
        }
        return $output;
    }
}

if (!function_exists('mo_get_post_type_archive_url')) {

    function mo_get_post_type_archive_url($post_type) {

        $archive_url = get_post_type_archive_link($post_type);

        if (empty($archive_url)) {
            $page_id = mo_get_post_type_archive_page_id($post_type);
            if (!empty($page_id))
                $archive_url = get_permalink($page_id);
        }
        return $archive_url;
    }

}

if (!function_exists('mo_get_post_type_archive_page_id')) {

    function mo_get_post_type_archive_page_id($post_type) {

        $page_id = null;

        $archive_template_map = mo_get_archive_template_map();

        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => $archive_template_map[$post_type]
        ));
        foreach ($pages as $page) {
            $page_id = $page->ID;
        }

        return $page_id;
    }

}

if (!function_exists('mo_get_archive_template_map')) {
    function mo_get_archive_template_map() {
        $archive_template_map = array(
            'sfwd-courses' => 'template-ld-courses.php',
            'course' => 'template-courses.php',
            'department' => 'template-departments.php',
            'staff' => 'template-staff.php',
            'news' => 'template-news.php',
            'gallery' => 'template-gallery.php',
            'portfolio' => 'template-portfolio.php',
            'post' => 'template-blog.php'
        );
        return $archive_template_map;
    }
}