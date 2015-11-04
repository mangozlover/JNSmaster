<?php
/**
 * Custom Meta Boxes using Option Tree framework
 * @package Livemesh_Framework
 */

/**
 * Initialize the meta boxes.
 */
add_action('admin_init', 'mo_custom_meta_boxes');

if (!function_exists('mo_custom_meta_boxes')) {


    function mo_custom_meta_boxes() {

        mo_build_advanced_page_meta_boxes();

        mo_build_layout_option_meta_Boxes();

        mo_build_entry_header_metaboxes();

        mo_build_course_meta_boxes();

        /* mo_build_event_page_meta_boxes(); */

        mo_build_blog_meta_boxes();

        mo_build_department_meta_boxes();

        mo_build_staff_profile_meta_boxes();

        mo_build_testimonials_meta_boxes();

        mo_build_pricing_plan_meta_boxes();

        mo_build_page_section_meta_boxes();

        mo_build_below_header_area_meta_boxes();

    }
}

if (!function_exists('mo_build_below_header_area_meta_boxes')) {
    function mo_build_below_header_area_meta_boxes() {
        $meta_box = array(
            'id' => 'mo_below_header_area_details',
            'title' => __('Below Header Area Details', 'mo_theme'),
            'desc' => '',
            'pages' => array('post', 'page', 'news', 'department'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id' => 'mo_custom_content_below_header',
                    'label' => __('Custom Content Below Header Area', 'mo_theme'),
                    'std' => '',
                    'type' => 'textarea',
                    'rows' => '3',
                    'desc' => 'Enter custom HTML or shortcodes that needs to be displayed in the area below the header/breadcrumbs and above the entry content/sidebar. Useful for display of sliders, galleries etc. before the start of the post/page content.',
                ),

                array(
                    'label' => __('Disable Featured Thumbnail', 'mo_theme'),
                    'id' => 'mo_disable_featured_thumbnail',
                    'type' => 'checkbox',
                    'desc' => 'Specify if featured image shown at the top of the content should be disabled. If a slider or a gallery is being displayed below the header using the option above, it is often redundant to display the featured image shown at the top of the content.',
                    'choices' => array(
                        array(
                            'label' => __('Yes', 'mo_theme'),
                            'value' => 'Yes'
                        )
                    ),
                    'std' => '',
                    'rows' => '',
                    'class' => ''
                ),
            )
        );

        ot_register_meta_box($meta_box);
    }
}

if (!function_exists('mo_build_page_section_meta_boxes')) {
    function mo_build_page_section_meta_boxes() {
        $page_section_meta_box = array(
            'id' => 'mo_page_section_details',
            'title' => 'Page Section Details',
            'desc' => '',
            'pages' => array('page_section'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id' => 'mo_page_section_desc',
                    'label' => __('Page Section Description', 'mo_theme'),
                    'std' => '',
                    'type' => 'textarea',
                    'rows' => '3',
                    'desc' => 'Enter a short description for this page section. This description for the page sections is shown in the page edit window for single page site template pages.<p>When composing a single page, this optional description comes handy in identifying a page section when there are many similar page sections or when title is too short to provide any clue about the function or purpose of the page section.<p>',
                )
            )
        );

        ot_register_meta_box($page_section_meta_box);
    }
}

if (!function_exists('mo_build_layout_option_meta_Boxes')) {

    function mo_build_layout_option_meta_Boxes() {

        $post_layouts = mo_get_entry_layout_options();

        $layout_meta_box = array(
            'id' => 'mo_post_layout',
            'title' => 'Post Layout',
            'desc' => '',
            'pages' => array('post'),
            'context' => 'side',
            'priority' => 'default',
            'fields' => array(
                array(
                    'id' => 'mo_current_post_layout',
                    'label' => __('Current Post Layout', 'mo_theme'),
                    'desc' => 'Choose the layout for the current post.',
                    'std' => '',
                    'type' => 'select',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => '',
                    'choices' => $post_layouts
                )
            )
        );

        ot_register_meta_box($layout_meta_box);

        $my_sidebars = mo_get_user_defined_sidebars();

        $sidebar_meta_box = array(
            'id' => 'mo_sidebar_options',
            'title' => __('Choose Custom Sidebar', 'mo_theme'),
            'desc' => '',
            'pages' => array(
                'post',
                'page'
            ),
            'context' => 'side',
            'priority' => 'default',
            'fields' => array(
                array(
                    'id' => 'mo_primary_sidebar_choice',
                    'label' => __('Custom Sidebar Choice', 'mo_theme'),
                    'desc' => 'Custom sidebar for the post/page. <i>Useful if the post/page is not designated as full width.</i>',
                    'std' => '',
                    'type' => 'select',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => '',
                    'choices' => $my_sidebars
                )
            )
        );

        ot_register_meta_box($sidebar_meta_box);
    }
}

if (!function_exists('mo_build_event_page_meta_boxes')) {

    function mo_build_event_page_meta_boxes() {

        /* Ensure that the Events Manager plugin is activated */
        if (!class_exists('TribeEvents')) {
            return;
        }

        $organizer_meta_box = array(
            'id' => 'mo_event_organizer',
            'title' => __('Organizer Information', 'mo_theme'),
            'desc' => '',
            'pages' => array(TribeEvents::POSTTYPE),
            'context' => 'side',
            'priority' => 'default',
            'fields' => array(
                array(
                    'label' => __('Choose the staff for this event', 'mo_theme'),
                    'id' => 'mo_staff_for_event',
                    'type' => 'custom-post-type-checkbox',
                    'desc' => __('Choose one or more staff members who will be conducting this event.', 'mo_theme'),
                    'std' => '',
                    'rows' => '',
                    'post_type' => 'staff',
                    'taxonomy' => '',
                    'class' => ''
                )
            )
        );

        ot_register_meta_box($organizer_meta_box);

        $classes_meta_box = array(
            'id' => 'mo_related_event',
            'title' => __('Classes for Event', 'mo_theme'),
            'desc' => '',
            'pages' => array(TribeEvents::POSTTYPE),
            'context' => 'side',
            'priority' => 'default',
            'fields' => array(
                array(
                    'label' => __('Choose the class(es) associated with this event', 'mo_theme'),
                    'id' => 'mo_classes_for_event',
                    'type' => 'custom-post-type-checkbox',
                    'desc' => __('Choose one or more classes that will be conducted as part of this event.', 'mo_theme'),
                    'std' => '',
                    'rows' => '',
                    'post_type' => 'course',
                    'taxonomy' => '',
                    'class' => ''
                )
            )
        );

        ot_register_meta_box($classes_meta_box);

    }
}

if (!function_exists('mo_build_department_meta_boxes')) {

    function mo_build_department_meta_boxes() {

        $department_meta_box = array(
            'id' => 'mo_department',
            'title' => __('Department Information', 'mo_theme'),
            'desc' => '',
            'pages' => array('department'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'label' => __('Choose the courses for this department', 'mo_theme'),
                    'id' => 'mo_courses',
                    'type' => 'custom-post-type-checkbox',
                    'desc' => __('Choose one or more courses conducted by this department.', 'mo_theme'),
                    'std' => '',
                    'rows' => '',
                    'post_type' => 'course',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
                    'id' => 'mo_contact_name',
                    'label' => __('Department Contact', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Enter the name of the contact person for the department.', 'mo_theme'),
                ),
                array(
                    'id' => 'mo_contact_title',
                    'label' => __('Department Contact Title', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Specify the title of the contact person for the department.', 'mo_theme'),
                ),
                array(
                    'id' => 'mo_phone',
                    'label' => __('Phone Number', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Enter the phone number for the department.', 'mo_theme'),
                ),
                array(
                    'id' => 'mo_email',
                    'label' => __('Contact Email', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Enter the email for contacting the department.', 'mo_theme'),
                ),
                array(
                    'id' => 'mo_website',
                    'label' => __('Website', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Enter the website URL for the department.', 'mo_theme'),
                ),
                array(
                    'id' => 'mo_address',
                    'label' => __('Contact Address', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'textarea',
                    'desc' => __('Enter the department address.', 'mo_theme'),
                ),
                array(
                    'id' => 'mo_twitter',
                    'label' => 'Twitter',
                    'desc' => __('URL of the Twitter page of the department.', 'mo_theme'),
                    'std' => '',
                    'type' => 'text',
                    'class' => ''
                ),
                array(
                    'id' => 'mo_linkedin',
                    'label' => 'LinkedIn',
                    'desc' => __('URL of the LinkedIn profile of the department.', 'mo_theme'),
                    'std' => '',
                    'type' => 'text',
                    'class' => ''
                ),
                array(
                    'id' => 'mo_facebook',
                    'label' => 'Facebook',
                    'desc' => __('URL of the Facebook page of the department.', 'mo_theme'),
                    'std' => '',
                    'type' => 'text',
                    'class' => ''
                ),
                array(
                    'id' => 'mo_googleplus',
                    'label' => 'Google Plus',
                    'desc' => __('URL of the Google Plus page of the department.', 'mo_theme'),
                    'std' => '',
                    'type' => 'text',
                    'class' => ''
                ),
                array(
                    'id' => 'mo_instagram',
                    'label' => 'Instagram',
                    'desc' => __('URL of the Instagram feed for the department.', 'mo_theme'),
                    'std' => '',
                    'type' => 'text',
                    'class' => ''
                )

            )
        );

        ot_register_meta_box($department_meta_box);

    }
}

if (!function_exists('mo_build_course_meta_boxes')) {

    function mo_build_course_meta_boxes() {

        $course_meta_box = array(
            'id' => 'mo_course_information',
            'title' => __('Course Information', 'mo_theme'),
            'desc' => '',
            'pages' => array('course'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'label' => __('Choose the staff handling this course', 'mo_theme'),
                    'id' => 'mo_staff_for_course',
                    'type' => 'custom-post-type-checkbox',
                    'desc' => __('Choose one or more staff members who will be conducting this course.', 'mo_theme'),
                    'std' => '',
                    'rows' => '',
                    'post_type' => 'staff',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
                    'label' => __('Choose the department(s) handling this course', 'mo_theme'),
                    'id' => 'mo_department',
                    'type' => 'custom-post-type-checkbox',
                    'desc' => __('Choose one or more departments which handle this course.', 'mo_theme'),
                    'std' => '',
                    'rows' => '',
                    'post_type' => 'department',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
                    'label' => __('Related Courses', 'mo_theme'),
                    'id' => 'mo_related_courses',
                    'type' => 'custom-post-type-checkbox',
                    'desc' => __('Choose the related courses if you need to handpick them for display. If nothing is chosen, by default, all courses which belong to the same course category are displayed as related courses.', 'mo_theme'),
                    'std' => '',
                    'rows' => '',
                    'post_type' => 'course',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
                    'id' => 'mo_course_identifier',
                    'label' => __('Course Id', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Enter the course identifier.', 'mo_theme'),
                ),
                array(
                    'id' => 'mo_discipline',
                    'label' => __('Course Discipline', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Enter the course discipline.', 'mo_theme'),
                ),
                array(
                    'id' => 'mo_credit',
                    'label' => __('Credit', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Specify the course credit.', 'mo_theme'),
                ),
                array(
                    'id' => 'mo_room',
                    'label' => __('Room Number', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Enter the information for the room where the course will be conducted.', 'mo_theme'),
                ),
                array(
                    'id' => 'mo_days',
                    'label' => __('Days the course is conducted', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Specify the week days when the course will be conducted.', 'mo_theme'),
                ),
                array(
                    'id' => 'mo_timings',
                    'label' => __('Course Timings', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Specify the timings during the day when the course will be conducted.', 'mo_theme'),
                ),

            )
        );

        ot_register_meta_box($course_meta_box);

    }
}

if (!function_exists('mo_build_advanced_page_meta_boxes')) {

    function mo_build_advanced_page_meta_boxes() {

        $menu_array = array(
            array(
                'value' => 'default',
                'label' => __('Default', 'mo_theme'),
                'src' => ''
            )
        );

        $menu_items = get_terms('nav_menu', array('hide_empty' => true));
        foreach ($menu_items as $wp_menu) {
            $menu_array[] = array(
                'value' => $wp_menu->slug,
                'label' => $wp_menu->name,
                'src' => ''
            );
        };

        $advanced_page_meta_box = array(
            'id' => 'mo_advanced_entry_options',
            'title' => 'Advanced Entry Options',
            'desc' => '',
            'pages' => array(
                'post',
                'page',
                'portfolio'
            ),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id' => 'mo_slider_choice',
                    'label' => 'Display Slider and Remove Title Header',
                    'desc' => 'Select your choice of Slider type to be shown in the top section of the page, replacing the default page/post title header for this page. This option is often used with full width page templates like Home Page or Composite Page, although one can choose to display sliders in any page.',
                    'std' => '',
                    'type' => 'select',
                    'section' => 'general_default',
                    'rows' => '',
                    'post_type' => 'page,post,portfolio',
                    'taxonomy' => '',
                    'class' => '',
                    'choices' => array(
                        array(
                            'value' => 'None',
                            'label' => 'None',
                            'src' => ''
                        ),
                        array(
                            'value' => 'Revolution',
                            'label' => 'Revolution Slider',
                            'src' => ''
                        ),
                        array(
                            'value' => 'FlexSlider',
                            'label' => 'FlexSlider',
                            'src' => ''
                        ),
                        array(
                            'value' => 'Nivo',
                            'label' => 'Nivo',
                            'src' => ''
                        )
                    ),
                ),
                array(
                    'id' => 'mo_revolution_slider_choice',
                    'label' => 'Revolution Slider Choice',
                    'desc' => 'If Revolution Slider type is chosen above, choose the instance of Revolution Slider to be displayed in the page/post/portfolio. <strong><i>The Revolution Slider plugin bundled with the theme must be installed and activated before you can choose the slider for display.</i></strong>',
                    'std' => '',
                    'type' => 'select',
                    'section' => 'general_default',
                    'rows' => '',
                    'post_type' => 'page,post,portfolio',
                    'taxonomy' => '',
                    'class' => '',
                    'choices' => mo_get_revolution_slider_options(),
                ),
                array(
                    'id' => 'mo_remove_title_header',
                    'label' => __('Remove Title Header', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'checkbox',
                    'post_type' => 'page',
                    'desc' => 'Do not display normal title headers for this entry (disables both custom or default headers specified in heading options below). Useful if normal headers with page/post title and description (or custom HTML) need to be replaced with custom content for a entry as is often the case for pages that use Composite Page template or Home Page template.',
                    'choices' => array(
                        array(
                            'value' => 'Yes',
                            'label' => __('Yes', 'mo_theme'),
                            'src' => ''
                        )
                    )
                ),
                array(
                    'id' => 'mo_custom_primary_navigation_menu',
                    'label' => __('Choose Custom Primary Navigation Menu', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'select',
                    'desc' => 'Choose the page specific header navigation menu created using tools in ' . mo_get_menu_admin_url() . '. Useful for one page/single page templates with multiple internal navigation links. Users can choose to any of the custom menu designed in that screen for this page. <br/>Leave "Default" selected to display any global WordPress Menu set by you in ' . mo_get_menu_admin_url() . '.',
                    'choices' => $menu_array
                )

            )
        );

        ot_register_meta_box($advanced_page_meta_box);
    }
}

if (!function_exists('mo_build_blog_meta_boxes')) {

    function mo_build_blog_meta_boxes() {
        $post_meta_box = array(
            'id' => 'mo_post_thumbnail_detail',
            'title' => 'Post Thumbnail Options',
            'desc' => '',
            'pages' => array('post'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(

                array(
                    'label' => __('Use Video as Thumbnail', 'mo_theme'),
                    'id' => 'mo_use_video_thumbnail',
                    'type' => 'checkbox',
                    'desc' => 'Specify if video will be used as a thumbnail instead of a featured image.',
                    'choices' => array(
                        array(
                            'label' => __('Yes', 'mo_theme'),
                            'value' => 'Yes'
                        )
                    ),
                    'std' => '',
                    'rows' => '',
                    'class' => ''
                ),

                array(
                    'label' => __('Video URL', 'mo_theme'),
                    'id' => 'mo_video_thumbnail_url',
                    'type' => 'text',
                    'desc' => 'Specify the URL of the video (Youtube or Vimeo only).',
                    'std' => '',
                    'rows' => '',
                    'class' => ''
                ),

                array(
                    'label' => __('Use Slider as Thumbnail', 'mo_theme'),
                    'id' => 'mo_use_slider_thumbnail',
                    'type' => 'checkbox',
                    'desc' => 'Specify if slider will be used as a thumbnail instead of a featured image or a video.',
                    'choices' => array(
                        array(
                            'label' => __('Yes', 'mo_theme'),
                            'value' => 'Yes'
                        )
                    ),
                    'std' => '',
                    'rows' => '',
                    'class' => ''
                ),

                array(
                    'label' => __('Images for thumbnail slider', 'mo_theme'),
                    'id' => 'post_slider',
                    'desc' => 'Specify the images to be used a slider thumbnails for the post',
                    'type' => 'list-item',
                    'class' => '',
                    'settings' => array(
                        array(
                            'id' => 'slider_image',
                            'label' => __('Image', 'mo_theme'),
                            'desc' => '',
                            'std' => '',
                            'type' => 'upload',
                            'class' => '',
                            'choices' => array()
                        )
                    )
                )

            )
        );

        ot_register_meta_box($post_meta_box);
    }
}


if (!function_exists('mo_build_entry_header_metaboxes')) {

    function mo_build_entry_header_metaboxes() {
        $header_meta_box = array(
            'id' => 'mo_entry_header_options',
            'title' => 'Header Options',
            'desc' => '',
            'pages' => array(
                'post',
                'page',
                'portfolio',
                'department',
                'staff',
                'course'
            ),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id' => 'mo_description',
                    'label' => __('Description', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'textarea',
                    'desc' => 'Enter the description of the page/post. Shown under the entry title.',
                    'rows' => '2'
                ),
                array(
                    'id' => 'mo_entry_title_background',
                    'label' => __('Entry Title Background', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'background',
                    'desc' => 'Specify a background for your page/post title and description.'
                ),
                array(
                    'id' => 'mo_entry_title_height',
                    'label' => __('Page/Post Title Height', 'mo_theme'),
                    'desc' => 'Specify the approximate height in pixel units that the entry title area for a page/post occupies along with the background. <br><br> Does not apply when custom heading content is specified. ',
                    'type' => 'text',
                    'std' => '',
                    'rows' => '',
                    'class' => ''
                ),
                array(
                    'id' => 'mo_disable_breadcrumbs_for_entry',
                    'label' => __('Disable Breadcrumbs on this Post/Page', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'checkbox',
                    'desc' => 'Disable Breadcrumbs on this Post/Page. Breadcrumbs can be a hindrance in many pages that showcase marketing content. Home pages and wide layout pages will have no breadcrumbs displayed.',
                    'choices' => array(
                        array(
                            'value' => 'Yes',
                            'label' => __('Yes', 'mo_theme'),
                            'src' => ''
                        )
                    )
                )
            )
        );

        ot_register_meta_box($header_meta_box);

        $custom_header_meta_box = array(
            'id' => 'mo_custom_entry_header_options',
            'title' => 'Custom Header Options',
            'desc' => '',
            'pages' => array(
                'post',
                'page',
                'portfolio'
            ),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id' => 'mo_custom_heading_background',
                    'label' => __('Custom Heading Background', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'background',
                    'desc' => 'Specify a background for custom heading content that replaces the regular page/post title area. Spans entire screen width or maximum available width (boxed layout).'
                ),
                array(
                    'id' => 'mo_custom_heading_content',
                    'label' => __('Custom Heading Content', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'textarea',
                    'desc' => 'Enter custom heading content HTML markup that replaces the regular page/post title area. This can be any of these - image, a slider, a slogan, purchase/request quote button, an invitation to signup or any plain marketing material.<br><br>Shown under the logo area. Be aware of SEO implications and <strong>use heading tags appropriately</strong>.',
                    'rows' => '8'
                ),
                array(
                    'id' => 'mo_wide_heading_layout',
                    'label' => __('Custom Heading Content spans entire screen width', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'checkbox',
                    'desc' => 'Make the heading content span the entire screen width. While the background graphics or color spans entire screen width for custom heading content, the HTML markup consisting of heading text and content is restricted to the 1140px grid in the center of the window. <br>Choosing this option will make the content span the entire screen width or max available width(boxed layout).<br><strong>Choose this option when when you want to go for a custom heading with maps or a wide slider like the revolution slider in the custom heading area</strong>.',
                    'choices' => array(
                        array(
                            'value' => 'Yes',
                            'label' => __('Yes', 'mo_theme'),
                            'src' => ''
                        )
                    )
                )
            )
        );

        ot_register_meta_box($custom_header_meta_box);
    }
}

if (!function_exists('mo_build_testimonials_meta_boxes')) {
    function mo_build_testimonials_meta_boxes() {
        $testimonials_meta_box = array(
            'id' => 'mo_testimonial_details',
            'title' => __('Testimonial Details', 'mo_theme'),
            'desc' => '',
            'pages' => array('testimonials'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id' => 'mo_student_name',
                    'label' => __('Student Name', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Enter the name of the student for the testimonial.', 'mo_theme'),
                ),
                array(
                    'id' => 'mo_student_details',
                    'label' => __('Student Details', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Enter the details, if any, of the student for the testimonial.', 'mo_theme'),
                )
            )
        );

        ot_register_meta_box($testimonials_meta_box);
    }
}

if (!function_exists('mo_build_pricing_plan_meta_boxes')) {
    function mo_build_pricing_plan_meta_boxes() {
        $pricing_meta_box = array(
            'id' => 'mo_pricing_details',
            'title' => __('Pricing Plan Details', 'mo_theme'),
            'desc' => '',
            'pages' => array('pricing'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id' => 'mo_price_tag',
                    'label' => __('Price Tag', 'mo_theme'),
                    'std' => '',
                    'type' => 'text',
                    'desc' => 'Enter the price tag for the pricing plan. <strong>HTML is accepted</strong>',
                ),
                array(
                    'id' => 'mo_pricing_tagline',
                    'label' => __('Tagline Text', 'mo_theme'),
                    'desc' => 'Provide any taglines like "Most Popular", "Best Value", "Best Selling", "Most Flexible" etc. that you would like to use for this pricing plan.',
                    'std' => '',
                    'type' => 'text',
                    'class' => ''
                ),
                array(
                    'id' => 'mo_pricing_img',
                    'label' => __('Pricing Image', 'mo_theme'),
                    'desc' => 'Choose the custom image that represents this pricing plan, if any.',
                    'std' => '',
                    'type' => 'upload',
                ),
                array(
                    'id' => 'mo_pricing_url',
                    'label' => __('URL for the Pricing link/button', 'mo_theme'),
                    'std' => '',
                    'type' => 'text',
                    'desc' => 'Provide the target URL for the link or the button shown for this pricing plan.'
                ),
                array(
                    'id' => 'mo_pricing_button_text',
                    'label' => __('Text for the Pricing link/button', 'mo_theme'),
                    'std' => '',
                    'type' => 'text',
                    'desc' => 'Provide the text for the link or the button shown for this pricing plan.'
                ),
                array(
                    'id' => 'mo_highlight_pricing',
                    'label' => __('Highlight Pricing Plan', 'mo_theme'),
                    'desc' => 'Specify if you want to highlight the pricing plan.',
                    'std' => '',
                    'type' => 'checkbox',
                    'class' => '',
                    'choices' => array(
                        array(
                            'value' => 'Yes',
                            'label' => __('Yes', 'mo_theme'),
                            'src' => ''
                        )
                    )
                )
            )
        );

        ot_register_meta_box($pricing_meta_box);
    }
}

if (!function_exists('mo_build_staff_profile_meta_boxes')) {
    function mo_build_staff_profile_meta_boxes() {
        $staff_meta_box = array(
            'id' => 'mo_staff_profile_options',
            'title' => __('Staff Profile Details', 'mo_theme'),
            'desc' => '',
            'pages' => array('staff'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id' => 'mo_staff_title',
                    'label' => __('Staff Title', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Provide the title for the staff/faculty.', 'mo_theme')
                ),
                array(
                    'id' => 'mo_phone',
                    'label' => __('Phone', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Provide phone for the staff/faculty.', 'mo_theme')
                ),
                array(
                    'id' => 'mo_email',
                    'label' => __('Email', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Provide email for the staff/faculty.', 'mo_theme')
                ),
                array(
                    'id' => 'mo_website',
                    'label' => __('Website URL', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'text',
                    'desc' => __('Provide website URL for the staff/faculty.', 'mo_theme')
                ),
                array(
                    'id' => 'mo_campus_address',
                    'label' => __('Campus Address', 'mo_theme'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'textarea',
                    'desc' => __('Provide campus for the staff/faculty.', 'mo_theme')
                ),
                array(
                    'label' => __('Choose the Department', 'mo_theme'),
                    'id' => 'mo_department_for_staff',
                    'type' => 'custom-post-type-checkbox',
                    'desc' => __('Choose the department to which this staff/faculty belongs to.', 'mo_theme'),
                    'std' => '',
                    'rows' => '',
                    'post_type' => 'department',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
                    'label' => __('Courses Taught', 'mo_theme'),
                    'id' => 'mo_courses_taught',
                    'type' => 'custom-post-type-checkbox',
                    'desc' => __('Choose the courses taught by this staff/faculty.', 'mo_theme'),
                    'std' => '',
                    'rows' => '',
                    'post_type' => 'course',
                    'taxonomy' => '',
                    'class' => ''
                ),
                array(
                    'id' => 'mo_twitter',
                    'label' => 'Twitter',
                    'desc' => __('URL of the Twitter page of the staff/faculty.', 'mo_theme'),
                    'std' => '',
                    'type' => 'text',
                    'class' => ''
                ),
                array(
                    'id' => 'mo_linkedin',
                    'label' => 'LinkedIn',
                    'desc' => __('URL of the LinkedIn profile of the staff/faculty.', 'mo_theme'),
                    'std' => '',
                    'type' => 'text',
                    'class' => ''
                ),
                array(
                    'id' => 'mo_facebook',
                    'label' => 'Facebook',
                    'desc' => __('URL of the Facebook page of the staff/faculty.', 'mo_theme'),
                    'std' => '',
                    'type' => 'text',
                    'class' => ''
                ),
                array(
                    'id' => 'mo_googleplus',
                    'label' => 'Google Plus',
                    'desc' => __('URL of the Google Plus page of the staff/faculty.', 'mo_theme'),
                    'std' => '',
                    'type' => 'text',
                    'class' => ''
                ),
                array(
                    'id' => 'mo_instagram',
                    'label' => 'Instagram',
                    'desc' => __('URL of the Instagram feed for the staff/faculty.', 'mo_theme'),
                    'std' => '',
                    'type' => 'text',
                    'class' => ''
                )
            )
        );

        ot_register_meta_box($staff_meta_box);
    }
}

if (!function_exists('mo_get_user_defined_sidebars')) {
    function mo_get_user_defined_sidebars() {
        $my_sidebars = array(
            array(
                'label' => __('Default', 'mo_theme'),
                'value' => 'default'
            )
        );

        $sidebar_list = mo_get_theme_option('mo_sidebar_list');

        if (!empty($sidebar_list)) {
            foreach ($sidebar_list as $sidebar_item) {
                $sidebar = array(
                    'label' => $sidebar_item['title'],
                    'value' => $sidebar_item['id']
                );
                $my_sidebars [] = $sidebar;
            }
        }

        return $my_sidebars;
    }
}

if (!function_exists('mo_get_menu_admin_url')) {
    function mo_get_menu_admin_url() {
        $menu_admin_url = get_home_url() . '/wp-admin/nav-menus.php';

        $menu_admin_url = '<a href="' . $menu_admin_url . '" title="' . __('Appearances Menu Screen',
                'mo_theme') . '">' . __('Appearances Menu Screen', 'mo_theme') . '</a>';

        return $menu_admin_url;
    }
}