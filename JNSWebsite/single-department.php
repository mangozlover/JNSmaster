<?php

/**
 * Post Template
 *
 * This template is loaded when browsing a Wordpress post.
 *
 * @package Invent
 * @subpackage Template
 */

$image_size = "large";

get_header();
?>

<?php mo_exec_action('before_content'); ?>

    <div id="content" class="<?php echo mo_get_content_class(); ?>">

    <?php mo_exec_action('start_content'); ?>

    <div class="hfeed">

        <?php if (have_posts()) :

            while (have_posts()) : the_post();

                mo_exec_action('before_entry'); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php

                    mo_exec_action('start_entry');

                    ?>

                    <div class="entry-content clearfix">

                        <div class="department-content eightcol">

                            <?php

                            $disable_thumbnail = get_post_meta(get_the_ID(), 'mo_disable_featured_thumbnail');

                            if (empty($disable_thumbnail)) {
                                mo_thumbnail(array(
                                    'image_size' => $image_size,
                                    'before_html' => '<div class="thumbnail">',
                                    'after_html' => '</div>',
                                    'wrapper' => false
                                ));
                            }

                            ?>

                            <?php the_content(); ?>

                        </div>

                        <div class="department-sidebar fourcol last">

                            <div class="department-details box-wrap">

                                <div class="header"><?php echo __('Contact Information', 'mo_theme'); ?></div>

                                <div class="content-wrap">

                                    <div class="department-information info-section first">

                                        <div class="contact-person">

                                            <?php

                                            $contact_name = get_post_meta($post->ID, 'mo_contact_name', true);
                                            if (!empty($contact_name)) {

                                                echo '<div class="name">' . $contact_name . '</div>';

                                            }

                                            $contact_title = get_post_meta($post->ID, 'mo_contact_title', true);
                                            if (!empty($contact_title)) {

                                                echo '<div class="title">' . $contact_title . '</div>';

                                            }

                                            ?>

                                        </div>

                                        <ul class="contact-details">

                                            <?php

                                            $phone = get_post_meta($post->ID, 'mo_phone', true);
                                            if (!empty($phone)) {
                                                echo '<li>';
                                                echo '<i class="icon-phone12"></i>';
                                                echo '<span class="value">' . $phone . '</span>';
                                                echo '</li>';
                                            }

                                            $email = get_post_meta($post->ID, 'mo_email', true);
                                            if (!empty($email)) {
                                                echo '<li>';
                                                echo '<i class="icon-mail7"></i>';
                                                echo '<a class="value" href="mailto:' . $email . '" title="' . __("Email", "mo_theme") . '">' . $email . '</a>';
                                                echo '</li>';
                                            }

                                            $website_url = get_post_meta($post->ID, 'mo_website', true);
                                            if (!empty($website_url)) {
                                                echo '<li>';
                                                echo '<i class="icon-link3"></i>';
                                                echo '<a class="value" href="' . $website_url . '" title="' . __("Website URL", "mo_theme") . '">' . __("Visit Website", "mo_theme") . '</a>';
                                                echo '</li>';
                                            }


                                            $address = get_post_meta($post->ID, 'mo_address', true);
                                            if (!empty($address)) {
                                                echo '<li>';
                                                echo '<i class="icon-location8"></i>';
                                                echo '<span class="value">' . htmlspecialchars_decode($address) . '</span>';
                                                echo '</li>';
                                            }

                                            ?>

                                        </ul>

                                    </div>

                                    <div class="socials info-section">

                                        <?php

                                        $post_id = $post->ID;
                                        $twitter = get_post_meta($post_id, 'mo_twitter', true);
                                        $linkedin = get_post_meta($post_id, 'mo_linkedin', true);
                                        $googleplus = get_post_meta($post_id, 'mo_googleplus', true);
                                        $facebook = get_post_meta($post_id, 'mo_facebook', true);
                                        $dribbble = get_post_meta($post_id, 'mo_dribbble', true);
                                        $instagram = get_post_meta($post_id, 'mo_instagram', true);

                                        echo '<h5 class="subheading">' . __('Stay in Touch', 'mo_theme') . '</h5>';
                                        $shortcode_text = '[social_list';
                                        $shortcode_text .= $twitter ? ' twitter_url="' . $twitter . '"' : '';
                                        $shortcode_text .= $googleplus ? ' googleplus_url="' . $googleplus . '"' : '';
                                        $shortcode_text .= $linkedin ? ' linkedin_url="' . $linkedin . '"' : '';
                                        $shortcode_text .= $facebook ? ' facebook_url="' . $facebook . '"' : '';
                                        $shortcode_text .= $dribbble ? ' dribbble_url="' . $dribbble . '"' : '';
                                        $shortcode_text .= $instagram ? ' instagram_url="' . $instagram . '"' : '';
                                        $shortcode_text .= ' align="right"]';

                                        echo do_shortcode($shortcode_text);

                                        ?>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="clear"></div>

                        <?php

                        $course_ids = get_post_meta(get_the_ID(), 'mo_courses', true);
                        if (!empty($course_ids)) {
                            $args = array(
                                'post_type' => 'course',
                                'header_text' => __('Our Courses', 'mo_theme'),
                                'display_summary' => true
                            );
                            $query_params = array(
                                'post__in' => $course_ids,
                                'orderby' => 'menu_order',
                                'order' => 'ASC');
                            mo_display_custom_post_snippets($args, $query_params);
                        }

                        $args = array(
                            'post_type' => 'staff',
                            'header_text' => __('Our Faculty', 'mo_theme'),
                            'display_summary' => true
                        );
                        $query_params = array(
                            'meta_key' => 'mo_department_for_staff',
                            'meta_value' => get_the_ID(),
                            'meta_compare'  => 'LIKE',
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );
                        mo_display_custom_post_snippets($args, $query_params);

                        ?>

                    </div>
                    <!-- .entry-content -->

                    <?php mo_exec_action('end_entry'); ?>

                </article><!-- .hentry -->

                <?php mo_exec_action('after_entry');

                mo_exec_action('after_singular');

            endwhile;

        endif; ?>

    </div>
    <!-- .hfeed -->

    <?php mo_exec_action('end_content'); ?>

    <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.   ?>

    </div><!-- #content -->

<?php mo_exec_action('after_content'); ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>