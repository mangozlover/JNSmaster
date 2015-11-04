<?php

if (!function_exists('mo_register_custom_post_types')) {
    function mo_register_custom_post_types() {

        if (current_theme_supports('portfolio')) {
            mo_register_portfolio_type();
        }

        mo_register_gallery_type();

        if (current_theme_supports('composite-page'))
            mo_register_page_section_type();

        mo_register_showcase_slide_type();

       mo_register_department_post_type();

        mo_register_staff_profile_post_type();

        mo_register_testimonials_post_type();

        mo_register_pricing_post_type();

        mo_register_course_post_type();

        mo_register_news_post_type();

        /* Manage Portfolio Columns */
        add_filter('manage_edit-page_section_columns', 'mo_page_section_type_edit_columns');
        add_action('manage_posts_custom_column', 'mo_page_section_type_custom_columns');

        add_filter('manage_edit-gallery_item_columns', 'mo_gallery_item_type_edit_columns');
        add_action('manage_posts_custom_column', 'mo_gallery_item_type_custom_columns');

        /* Manage Testimonials Columns */
        add_filter('manage_edit-testimonials_columns', 'mo_testimonials_edit_columns');
        add_action('manage_posts_custom_column', 'mo_testimonials_columns');

        /* Manage Testimonials Columns */
        add_filter('manage_edit-course_columns', 'mo_courses_edit_columns');
        add_action('manage_posts_custom_column', 'mo_courses_columns');

        /* Manage Testimonials Columns */
        add_filter('manage_edit-department_columns', 'mo_department_edit_columns');
        add_action('manage_posts_custom_column', 'mo_department_columns');

        /* Manage Testimonials Columns */
        add_filter('manage_edit-news_columns', 'mo_news_edit_columns');
        add_action('manage_posts_custom_column', 'mo_news_columns');

        /* Manage Staff Columns */
        add_filter('manage_edit-staff_columns', 'mo_staff_profiles_edit_columns');
        add_action('manage_posts_custom_column', 'mo_staff_profiles_columns');

        add_filter('manage_edit-pricing_columns', 'mo_pricing_edit_columns');
        add_action('manage_posts_custom_column', 'mo_pricing_columns');
    }
}

if (!function_exists('mo_register_testimonials_post_type')) {
    function mo_register_testimonials_post_type() {
        $labels = array(
            'name' => _x('Testimonials', 'post type general name', 'mo_theme'),
            'singular_name' => _x('Testimonial', 'post type singular name', 'mo_theme'),
            'menu_name' => _x('Testimonials', 'post type menu name', 'mo_theme'),
            'add_new' => _x("Add New", "testimonial item", 'mo_theme'),
            'add_new_item' => __('Add New Testimonial', 'mo_theme'),
            'edit_item' => __('Edit Testimonial', 'mo_theme'),
            'new_item' => __('New Testimonial', 'mo_theme'),
            'view_item' => __('View Testimonial', 'mo_theme'),
            'search_items' => __('Search Testimonials', 'mo_theme'),
            'not_found' => __('No Testimonials found', 'mo_theme'),
            'not_found_in_trash' => __('No Testimonials in the trash', 'mo_theme'),
            'parent_item_colon' => '',
        );

        register_post_type('testimonials', array(
            'labels' => $labels,
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'rewrite' => false,
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_icon' => MO_THEME_URL . '/images/admin/balloon-quotation.png',
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'page-attributes'
            )
        ));
    }
}

if (!function_exists('mo_register_course_post_type')) {
    function mo_register_course_post_type() {

        $labels = array(
            'name' => _x("Courses", 'post type general name', 'mo_theme'),
            'singular_name' => _x("Course", "post type singular name", 'mo_theme'),
            'menu_name' => _x('Courses', 'post type menu name', 'mo_theme'),
            'add_new' => _x("Add New", "course item", 'mo_theme'),
            'add_new_item' => __("Add New Course", 'mo_theme'),
            'edit_item' => __("Edit Course", 'mo_theme'),
            'new_item' => __("New Course", 'mo_theme'),
            'view_item' => __("View Course", 'mo_theme'),
            'search_items' => __("Search Courses", 'mo_theme'),
            'not_found' => __("No Courses Found", 'mo_theme'),
            'not_found_in_trash' => __("No Courses Found in Trash", 'mo_theme'),
            'parent_item_colon' => ''
        );

        register_post_type('course', array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'exclude_from_search' => false,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'course' ),
            'capability_type' => 'post',
            'taxonomies' => array('course_category'),
            'has_archive' => false,
            'hierarchical' => false,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail',
                'page-attributes'
            )
        ));

        register_taxonomy('course_category', 'course', array(
            'hierarchical' => true,
            'label' => __('Course Categories', 'mo_theme'),
            'singular_label' => __('Course Category', 'mo_theme'),
            'rewrite' => array( 'slug' => 'our-courses' ),
            'query_var' => true,
            'show_ui' => true,
            'public' => true,
            'show_admin_column' => true
        ));

    }
}

if (!function_exists('mo_register_news_post_type')) {
    function mo_register_news_post_type() {

        $labels = array(
            'name' => _x("News", "post type general name", 'mo_theme'),
            'singular_name' => _x("News", "post type singular name", 'mo_theme'),
            'menu_name' => _x('News', 'post type menu name', 'mo_theme'),
            'add_new' => _x("Add New", "news item", 'mo_theme'),
            'add_new_item' => __("Add New News", 'mo_theme'),
            'edit_item' => __("Edit News", 'mo_theme'),
            'new_item' => __("New News", 'mo_theme'),
            'view_item' => __("View News", 'mo_theme'),
            'search_items' => __("Search News", 'mo_theme'),
            'not_found' => __("No News Found", 'mo_theme'),
            'not_found_in_trash' => __("No News Found in Trash", 'mo_theme'),
            'parent_item_colon' => ''
        );

        register_post_type('news', array(
            'labels' => $labels,


            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'publicly_queryable' => true,
            'query_var' => true,
            'exclude_from_search' => false,
            'rewrite' => array('slug' => 'news'),
            'taxonomies' => array('news_category'),
            'show_in_nav_menus' => false,
            'supports' => array(
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
                'trackbacks',
                'custom-fields',
                'comments',
                'revisions',
                'page-attributes'
            )
        ));

        register_taxonomy('news_category', 'news', array(
            'hierarchical' => true,
            'label' => __('News Categories', 'mo_theme'),
            'singular_label' => __('News Category', 'mo_theme'),
            'rewrite' => array( 'slug' => 'news-category' ),
            'query_var' => true,
            'show_ui' => true,
            'public' => true,
            'show_admin_column' => true
        ));
    }
}

if (!function_exists('mo_register_pricing_post_type')) {
    function mo_register_pricing_post_type() {
        $labels = array(
            'name' => _x('Pricing Plans', 'post type general name', 'mo_theme'),
            'singular_name' => _x('Pricing Plan', 'post type singular name', 'mo_theme'),
            'menu_name' => _x('Pricing Plan', 'post type menu name', 'mo_theme'),
            'add_new' => _x('Add New', 'pricing plan item', 'mo_theme'),
            'add_new_item' => __('Add New Pricing Plan', 'mo_theme'),
            'edit_item' => __('Edit Pricing Plan', 'mo_theme'),
            'new_item' => __('New Pricing Plan', 'mo_theme'),
            'view_item' => __('View Pricing Plan', 'mo_theme'),
            'search_items' => __('Search Pricing Plans', 'mo_theme'),
            'not_found' => __('No Pricing Plans found', 'mo_theme'),
            'not_found_in_trash' => __('No Pricing Plans in the trash', 'mo_theme'),
            'parent_item_colon' => ''
        );

        register_post_type('pricing', array(
            'labels' => $labels,
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'rewrite' => false,
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'supports' => array(
                'title',
                'editor',
                'page-attributes'
            )
        ));
    }
}

if (!function_exists('mo_register_department_post_type')) {
    function mo_register_department_post_type() {
        // Labels
        $labels = array(
            'name' => _x("Department", "post type general name", 'mo_theme'),
            'singular_name' => _x("Department", "post type singular name", 'mo_theme'),
            'menu_name' => _x('Departments', 'post type menu name', 'mo_theme'),
            'add_new' => _x("Add New", "department item", 'mo_theme'),
            'add_new_item' => __("Add New Department", 'mo_theme'),
            'edit_item' => __("Edit Department", 'mo_theme'),
            'new_item' => __("New Department", 'mo_theme'),
            'view_item' => __("View Department", 'mo_theme'),
            'search_items' => __("Search Departments", 'mo_theme'),
            'not_found' => __("No Departments Found", 'mo_theme'),
            'not_found_in_trash' => __("No Departments Found in Trash", 'mo_theme'),
            'parent_item_colon' => ''
        );

        // Register post type
        register_post_type('department', array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'hierarchical' => false,
            'publicly_queryable' => true,
            'query_var' => true,
            'exclude_from_search' => false,
            'show_in_nav_menus' => false,
            'has_archive' => false,
            'rewrite' => array( 'slug' => 'department' ),
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes')
        ));

    }

}

if (!function_exists('mo_register_staff_profile_post_type')) {
    function mo_register_staff_profile_post_type() {
        // Labels
        $labels = array(
            'name' => _x("Staff", "post type general name", 'mo_theme'),
            'singular_name' => _x("Staff", "post type singular name", 'mo_theme'),
            'menu_name' => _x('Staff Profiles', 'post type menu name', 'mo_theme'),
            'add_new' => _x("Add New", "staff item", 'mo_theme'),
            'add_new_item' => __("Add New Profile", 'mo_theme'),
            'edit_item' => __("Edit Profile", 'mo_theme'),
            'new_item' => __("New Profile", 'mo_theme'),
            'view_item' => __("View Profile", 'mo_theme'),
            'search_items' => __("Search Profiles", 'mo_theme'),
            'not_found' => __("No Profiles Found", 'mo_theme'),
            'not_found_in_trash' => __("No Profiles Found in Trash", 'mo_theme'),
            'parent_item_colon' => ''
        );

        // Register post type
        register_post_type('staff', array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'hierarchical' => false,
            'publicly_queryable' => true,
            'query_var' => true,
            'taxonomies' => array('specialization'),
            'exclude_from_search' => false,
            'show_in_nav_menus' => false,
            'menu_icon' => get_template_directory_uri() . '/images/admin/users.png',
            'has_archive' => false,
            'rewrite' => array( 'slug' => 'faculty' ),
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes')
        ));

        register_taxonomy('specialization', 'staff', array(
            'hierarchical' => true,
            'label' => __('Specializations', 'mo_theme'),
            'singular_label' => __('Specialization', 'mo_theme'),
            'rewrite' => array( 'slug' => 'specialization' ),
            'query_var' => true,
            'show_ui' => true,
            'public' => true,
            'show_admin_column' => true
        ));


    }

}

if (!function_exists('mo_register_portfolio_type')) {
    function mo_register_portfolio_type() {

        $labels = array(
            'name' => _x('Portfolio', 'portfolio name', 'mo_theme'),
            'singular_name' => _x('Portfolio Entry', 'portfolio type singular name', 'mo_theme'),
            'menu_name' => _x('Portfolio', 'portfolio type menu name', 'mo_theme'),
            'add_new' => _x('Add New', 'portfolio item', 'mo_theme'),
            'add_new_item' => __('Add New Portfolio Entry', 'mo_theme'),
            'edit_item' => __('Edit Portfolio Entry', 'mo_theme'),
            'new_item' => __('New Portfolio Entry', 'mo_theme'),
            'view_item' => __('View Portfolio Entry', 'mo_theme'),
            'search_items' => __('Search Portfolio Entries', 'mo_theme'),
            'not_found' => __('No Portfolio Entries Found', 'mo_theme'),
            'not_found_in_trash' => __('No Portfolio Entries Found in Trash', 'mo_theme'),
            'parent_item_colon' => ''
        );

        register_post_type('portfolio', array(
                'labels' => $labels,

                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'publicly_queryable' => true,
                'query_var' => true,
                'exclude_from_search' => false,
                'rewrite' => array('slug' => 'portfolio'),
                'taxonomies' => array('portfolio_category'),
                'show_in_nav_menus' => false,
                'menu_position' => 20,
                'menu_icon' => MO_THEME_URL . '/images/admin/portfolio.png',
                'supports' => array(
                    'title',
                    'editor',
                    'thumbnail',
                    'comments',
                    'excerpt',
                    'custom-fields'
                )
            )
        );

        register_taxonomy('portfolio_category', array('portfolio'), array(
            'hierarchical' => true,
            'label' => __('Portfolio Categories', 'mo_theme'),
            'singular_label' => __('Portfolio Category', 'mo_theme'),
            'rewrite' => true,
            'query_var' => true
        ));
    }
}

if (!function_exists('mo_register_gallery_type')) {
    function mo_register_gallery_type() {

        $labels = array(
            'name' => _x('Gallery', 'gallery name', 'mo_theme'),
            'singular_name' => _x('Gallery Entry', 'gallery type singular name', 'mo_theme'),
            'menu_name' => _x('Gallery', 'gallery type menu name', 'mo_theme'),
            'add_new' => _x('Add New', 'gallery', 'mo_theme'),
            'add_new_item' => __('Add New Gallery Entry', 'mo_theme'),
            'edit_item' => __('Edit Gallery Entry', 'mo_theme'),
            'new_item' => __('New Gallery Entry', 'mo_theme'),
            'view_item' => __('View Gallery Entry', 'mo_theme'),
            'search_items' => __('Search Gallery Entries', 'mo_theme'),
            'not_found' => __('No Gallery Entries Found', 'mo_theme'),
            'not_found_in_trash' => __('No Gallery Entries Found in Trash', 'mo_theme'),
            'parent_item_colon' => ''
        );

        register_post_type('gallery_item', array(
                'labels' => $labels,

                'public' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'publicly_queryable' => true,
                'query_var' => true,
                'exclude_from_search' => false,
                'rewrite' => array('slug' => 'gallery'),
                'taxonomies' => array('gallery_category'),
                'show_in_nav_menus' => false,
                'menu_position' => 20,
                'menu_icon' => MO_THEME_URL . '/images/admin/portfolio.png',
                'supports' => array(
                    'title',
                    'thumbnail',
                    'excerpt'
                )
            )
        );

        register_taxonomy('gallery_category', array('gallery_item'), array(
            'hierarchical' => true,
            'label' => __('Gallery Categories', 'mo_theme'),
            'singular_label' => __('Gallery Category', 'mo_theme'),
            'rewrite' => true,
            'query_var' => true
        ));
    }

}

if (!function_exists('mo_register_page_section_type')) {
    function mo_register_page_section_type() {

        $labels = array(
            'name' => _x('Page Section', 'page section general name', 'mo_theme'),
            'singular_name' => _x('Page Section', 'page section singular name', 'mo_theme'),
            'menu_name' => _x('Page Sections', 'post type menu name', 'mo_theme'),
            'add_new' => _x('Add New', 'page ', 'mo_theme'),
            'add_new_item' => __('Add New Page Section', 'mo_theme'),
            'edit_item' => __('Edit Page Section', 'mo_theme'),
            'new_item' => __('New Page Section', 'mo_theme'),
            'view_item' => __('View Page Section', 'mo_theme'),
            'search_items' => __('Search Page Sections', 'mo_theme'),
            'not_found' => __('No Page Sections Found', 'mo_theme'),
            'not_found_in_trash' => __('No Page Sections Found in Trash', 'mo_theme'),
            'parent_item_colon' => ''
        );

        register_post_type('page_section', array(
                'labels' => $labels,
                'description' => __('A custom post type which represents a section like about, work, services, staff etc. part of a typical single page site. Can be made up of one or more segments.', 'mo_theme'),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'page',
                'hierarchical' => false,
                'publicly_queryable' => true,
                'query_var' => true,
                'exclude_from_search' => true,
                'show_in_nav_menus' => false,
                'menu_position' => 15,
                'menu_icon' => MO_THEME_URL . '/images/admin/blogs-stack.png',
                'rewrite' => array('slug' => 'page-section'),
                'supports' => array(
                    'title',
                    'editor',
                    'page-attributes',
                    'revisions'
                )
            )
        );

    }
}

if (!function_exists('mo_register_showcase_slide_type')) {
    function mo_register_showcase_slide_type() {
        register_post_type('showcase_slide', array(
            'labels' => array(
                'name' => __('Showcase Slides', 'mo_theme'),
                'singular_name' => __('Showcase Slide', 'post type singular name', 'mo_theme'),
                'menu_name' => _x('Showcase Slides', 'post type menu name', 'mo_theme'),
                'add_new' => _x('Add New', 'showcase slide item', 'mo_theme'),
                'add_new_item' => __('Add New Slide', 'mo_theme'),
                'edit_item' => __('Edit Slide', 'mo_theme'),
                'new_item' => __('New Slide', 'mo_theme'),
                'view_item' => __('View Slide', 'mo_theme'),
                'search_items' => __('Search Slides', 'mo_theme'),
                'not_found' => __('No Slides Found', 'mo_theme'),
                'not_found_in_trash' => __('No Slides Found in Trash', 'mo_theme'),
                'parent_item_colon' => ''
            ),
            'description' => __('A custom post type which has the required information to display showcase slides in a slider', 'mo_theme'),
            'public' => false,
            'show_ui' => true,
            'publicly_queryable' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'exclude_from_search' => true,
            'menu_position' => 20,
            'menu_icon' => MO_THEME_URL . '/images/admin/slides-stack.png',
            'supports' => array(
                'title',
                'thumbnail',
                'page-attributes'
            )
        ));
    }
}

if (!function_exists('mo_page_section_type_edit_columns')) {
    function mo_page_section_type_edit_columns($columns) {

        $new_columns = array(

            'page_section_order' => __('Order', 'mo_theme')
        );

        $columns = array_merge($columns, $new_columns);

        return $columns;
    }
}

if (!function_exists('mo_page_section_type_custom_columns')) {
    function mo_page_section_type_custom_columns($column) {
        global $post;
        switch ($column) {
            case 'page_section_order':
                echo $post->menu_order;
                break;
        }
    }
}

if (!function_exists('mo_gallery_item_type_edit_columns')) {
    function mo_gallery_item_type_edit_columns($columns) {

        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Gallery Title', 'mo_theme'),
            'gallery_thumbnail' => __('Thumbnail', 'mo_theme'),
            'gallery_category' => __('Category', 'mo_theme')
        );

        return $columns;
    }
}

if (!function_exists('mo_gallery_item_type_custom_columns')) {

    function mo_gallery_item_type_custom_columns($column) {
        global $post;
        switch ($column) {
            case 'gallery_category':
                echo get_the_term_list($post->ID, 'gallery_category', '', ', ', '');
                break;
            case 'gallery_thumbnail':
                mo_thumbnail(array(
                    'image_size' => 'mini',
                    'wrapper' => false,
                    'image_alt' => get_the_title(),
                    'size' => 'thumbnail'
                ));
                break;
        }
    }
}

if (!function_exists('mo_staff_profiles_edit_columns')) {
    function mo_staff_profiles_edit_columns($columns) {

        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Staff Name', 'mo_theme'),
            'staff_thumbnail' => __('Staff Photo', 'mo_theme'),
            'staff_title' => __('Title', 'mo_theme'),
            'staff_department' => __('Department', 'mo_theme'),
            'staff_order' => __('Order', 'mo_theme')
        );

        return $columns;
    }
}

if (!function_exists('mo_staff_profiles_columns')) {

    function mo_staff_profiles_columns($column) {
        global $post;
        switch ($column) {
            case 'staff_thumbnail':
                mo_thumbnail(array(
                    'image_size' => 'mini',
                    'wrapper' => false,
                    'image_alt' => get_the_title(),
                    'size' => 'thumbnail'
                ));
                break;
            case 'staff_title':
                $staff_title = get_post_meta($post->ID, 'mo_staff_title', true);
                if (!empty($staff_title)) {
                    echo $staff_title;
                }
                break;
            case 'staff_department':
                $department_names = array();
                $department_ids = get_post_meta($post->ID, 'mo_department_for_staff', true);
                if (!empty($department_ids)) {
                    foreach ($department_ids as $department_id) {
                        $department_names[] = get_the_title($department_id);
                    }
                }
                echo implode(', ', $department_names);
                break;
            case 'staff_order':
                echo $post->menu_order;
                break;
        }
    }
}

if (!function_exists('mo_testimonials_edit_columns')) {
    function mo_testimonials_edit_columns($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', 'mo_theme'),
            'testimonial' => __('Testimonial', 'mo_theme'),
            'testimonial-customer-image' => __('Student\'s Photo', 'mo_theme'),
            'testimonial-customer-name' => __('Student\'s Name', 'mo_theme'),
            'testimonial-customer-details' => __('Student\'s Details', 'mo_theme'),
            'testimonial-order' => __('Testimonial Order', 'mo_theme')
        );

        return $columns;
    }
}

/**
 * Customizing the list view columns
 *
 * This functions is attached to the 'manage_posts_custom_column' action hook.
 */
if (!function_exists('mo_testimonials_columns')) {
    function mo_testimonials_columns($column) {
        global $post;
        switch ($column) {
            case 'testimonial':
                echo wp_trim_words( get_the_excerpt(), 25);
                break;
            case 'testimonial-customer-image':
                mo_thumbnail(array(
                    'image_size' => 'mini',
                    'wrapper' => false,
                    'image_alt' => get_the_title(),
                    'size' => 'thumbnail'
                ));
                break;
            case 'testimonial-customer-name':
                echo get_post_meta($post->ID, 'mo_student_name', true);
                break;
            case 'testimonial-customer-details':
                echo get_post_meta($post->ID, 'mo_student_details', true);
                break;
            case 'testimonial-order':
                echo $post->menu_order;
                break;
        }
    }
}

if (!function_exists('mo_courses_edit_columns')) {
    function mo_courses_edit_columns($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Course Name', 'mo_theme'),
            'course-image' => __('Thumbnail', 'mo_theme'),
            'course-description' => __('Description', 'mo_theme'),
            'course-staff' => __('Staff/Faculty', 'mo_theme'),
            'course-order' => __('Course Order', 'mo_theme')
        );

        return $columns;
    }
}

/**
 * Customizing the list view columns
 *
 * This functions is attached to the 'manage_posts_custom_column' action hook.
 */
if (!function_exists('mo_courses_columns')) {
    function mo_courses_columns($column) {
        global $post;
        switch ($column) {
            case 'course-image':
                mo_thumbnail(array(
                    'image_size' => 'mini',
                    'wrapper' => false,
                    'image_alt' => get_the_title(),
                    'size' => 'thumbnail'
                ));
                break;
            case 'course-description':
                echo wp_trim_words( get_the_excerpt(), 10);
                break;
            case 'course-staff':
                $staff_names = array();
                $staff_ids = get_post_meta($post->ID, 'mo_staff_for_course', true);
                if (!empty($staff_ids)) {
                    foreach ($staff_ids as $staff_id) {
                        $staff_names[] = get_the_title($staff_id);
                    }
                }
                echo implode(', ', $staff_names);
                break;
            case 'course-order':
                echo $post->menu_order;
                break;
        }
    }
}

if (!function_exists('mo_department_edit_columns')) {
    function mo_department_edit_columns($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Department Name', 'mo_theme'),
            'department-image' => __('Thumbnail', 'mo_theme'),
            'department-description' => __('Description', 'mo_theme'),
            'department-order' => __('Course Order', 'mo_theme')
        );

        return $columns;
    }
}

/**
 * Customizing the list view columns
 *
 * This functions is attached to the 'manage_posts_custom_column' action hook.
 */
if (!function_exists('mo_department_columns')) {
    function mo_department_columns($column) {
        global $post;
        switch ($column) {
            case 'department-image':
                mo_thumbnail(array(
                    'image_size' => 'mini',
                    'wrapper' => false,
                    'image_alt' => get_the_title(),
                    'size' => 'thumbnail'
                ));
                break;
            case 'department-description':
                echo wp_trim_words( get_the_excerpt(), 10);
                break;
            case 'department-order':
                echo $post->menu_order;
                break;
        }
    }
}

if (!function_exists('mo_news_edit_columns')) {
    function mo_news_edit_columns($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', 'mo_theme'),
            'news-image' => __('Thumbnail', 'mo_theme'),
            'news-description' => __('Description', 'mo_theme'),
            'news-order' => __('Order', 'mo_theme')
        );

        return $columns;
    }
}

/**
 * Customizing the list view columns
 *
 * This functions is attached to the 'manage_posts_custom_column' action hook.
 */
if (!function_exists('mo_news_columns')) {
    function mo_news_columns($column) {
        global $post;
        switch ($column) {
            case 'news-name':
                echo get_the_title();
                break;
            case 'news-description':
                echo wp_trim_words( get_the_excerpt(), 10);
                break;
            case 'news-image':
                mo_thumbnail(array(
                    'image_size' => 'mini',
                    'wrapper' => false,
                    'image_alt' => get_the_title(),
                    'size' => 'thumbnail'
                ));
                break;
            case 'news-order':
                echo $post->menu_order;
                break;
        }
    }
}

if (!function_exists('mo_pricing_edit_columns')) {
    function mo_pricing_edit_columns($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Pricing Plan Name', 'mo_theme'),
            'pricing-plan-price-tag' => __('Price Tag', 'mo_theme'),
            'pricing-tagline' => __('Tagline', 'mo_theme'),
            'pricing-image' => __('Image', 'mo_theme'),
            'pricing-plan-url' => __('Pricing Plan URL', 'mo_theme'),
            'pricing-plan-order' => __('Pricing Plan Order', 'mo_theme')
        );

        return $columns;
    }
}

/**
 * Customizing the list view columns
 *
 * This functions is attached to the 'manage_posts_custom_column' action hook.
 */
if (!function_exists('mo_pricing_columns')) {
    function mo_pricing_columns($column) {
        global $post;
        switch ($column) {
            case 'pricing-plan-price-tag':
                echo get_post_meta($post->ID, 'mo_price_tag', true);
                break;
            case 'pricing-plan-url':
                echo get_post_meta($post->ID, 'mo_pricing_url', true);
                break;
            case 'pricing-tagline':
                echo get_post_meta($post->ID, 'mo_pricing_tagline', true);
                break;
            case 'pricing-image':
                $image_url = get_post_meta($post->ID, 'mo_pricing_img', true);
                if (!empty($image_url))
                    echo '<img alt="' . $post->post_title . '" src="' . $image_url . '" /><br>';
                break;
            case 'pricing-plan-order':
                echo $post->menu_order;
                break;

        }
    }
}
