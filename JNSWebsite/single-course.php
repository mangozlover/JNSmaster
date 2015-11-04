<?php

/**
 * Post Template
 *
 * This template is loaded when browsing a Wordpress post.
 *
 * @package Invent
 * @subpackage Template
 */

$image_size = 'medium';

get_header();
?>

<?php mo_exec_action('before_content'); ?>

    <div id="content" class="<?php echo mo_get_content_class(); ?>">

        <?php mo_exec_action('start_content'); ?>

        <div class="hfeed">

            <?php if (have_posts()) :

                while (have_posts()) :

                    the_post();

                    mo_exec_action('before_entry'); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php

                        mo_exec_action('start_entry');

                        ?>

                        <div class="entry-content clearfix">

                            <div class="course-content eightcol">

                                <?php the_content(); ?>

                            </div>

                            <div class="course-sidebar fourcol last">

                                <div class="course-details box-wrap">

                                    <?php

                                    mo_thumbnail(array(
                                        'image_size' => $image_size,
                                        'before_html' => '<div class="thumbnail">',
                                        'after_html' => '</div>',
                                        'wrapper' => false
                                    ));

                                    ?>

                                    <div class="content-wrap">

                                        <div class="course-information info-section first">

                                            <h5 class="subheading"><?php echo __('Course Information', 'mo_theme'); ?></h5>

                                            <ul>

                                                <?php

                                                $course_id = get_post_meta($post->ID, 'mo_course_identifier', true);
                                                if (!empty($course_id)) {
                                                    echo '<li>';
                                                    echo '<span class="label">' . __('Course Id:', 'mo_theme') . '</span>';
                                                    echo '<span class="value">' . $course_id . '</span>';
                                                    echo '</li>';
                                                }

                                                $credit = get_post_meta($post->ID, 'mo_credit', true);
                                                if (!empty($credit)) {
                                                    echo '<li>';
                                                    echo '<span class="label">' . __('Credit:', 'mo_theme') . '</span>';
                                                    echo '<span class="value">' . $credit . '</span>';
                                                    echo '</li>';
                                                }

                                                $room = get_post_meta($post->ID, 'mo_room', true);
                                                if (!empty($room)) {
                                                    echo '<li>';
                                                    echo '<span class="label">' . __('Room:', 'mo_theme') . '</span>';
                                                    echo '<span class="value">' . $room . '</span>';
                                                    echo '</li>';
                                                }

                                                $days = get_post_meta($post->ID, 'mo_days', true);
                                                if (!empty($days)) {
                                                    echo '<li>';
                                                    echo '<span class="label">' . __('Days:', 'mo_theme') . '</span>';
                                                    echo '<span class="value">' . $days . '</span>';
                                                    echo '</li>';
                                                }

                                                $timings = get_post_meta($post->ID, 'mo_timings', true);
                                                if (!empty($timings)) {
                                                    echo '<li>';
                                                    echo '<span class="label">' . __('Timings:', 'mo_theme') . '</span>';
                                                    echo '<span class="value">' . $timings . '</span>';
                                                    echo '</li>';
                                                }

                                                ?>

                                            </ul>

                                        </div>

                                        <?php

                                        $staff_ids = get_post_meta($post->ID, 'mo_staff_for_course', true);
                                        if (!empty($staff_ids)) {

                                            echo '<div class="instructors info-section">';

                                            echo '<h5 class="subheading">' . __('Instructors', 'mo_theme') . '</h5>';
                                            mo_display_post_links($staff_ids, "staff", "icon-user4");
                                            echo '</div>';
                                        }

                                        $department_ids = get_post_meta($post->ID, 'mo_department', true);
                                        if (!empty($department_ids)) {

                                            echo '<div class="department info-section">';

                                            echo '<h5 class="subheading">' . __('Department', 'mo_theme') . '</h5>';
                                            mo_display_post_links($department_ids, "department", "icon-shop");
                                            echo '</div>';
                                        }

                                        ?>

                                    </div>
                                    <!-- .text-wrap -->

                                </div>
                                <!--.box-wrap -->

                            </div>
                            <!--.course-sidebar -->

                        </div>
                        <!-- .entry-content -->

                        <?php mo_exec_action('end_entry'); ?>

                    </article>
                    <!-- .hentry -->

                    <?php mo_exec_action('after_entry');

                    $related_courses_ids = get_post_meta($post->ID, 'mo_related_courses', true);
                    if (!empty($related_courses_ids)) {

                        $args = array(
                            'header_text' => __('Related Courses', 'mo_theme'),
                            'post_type' => $post_type,
                            'post_ids' => $related_courses_ids,
                            'enable_sorting' => true
                        );

                        mo_display_selected_posts($args);
                    }
                    else {
                        $args = array(
                            'taxonomy' => 'course_category',
                            'header_text' => __('Related Courses', 'mo_theme'),
                            'display_summary' => true
                        );

                        mo_display_related_posts($args);
                    }

                    mo_exec_action('after_singular');

                endwhile;

            endif;
            ?>

        </div>
        <!-- .hfeed -->

        <?php mo_exec_action('end_content'); ?>

        <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.   ?>

    </div><!-- #content -->

<?php mo_exec_action('after_content'); ?>

<?php get_footer(); ?>