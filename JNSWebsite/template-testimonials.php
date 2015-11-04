<?php
/**
 *
 * Template Name: Testimonials
 *
 * Displays all the user testimonials configured for the site
 *
 * @package Invent
 * @subpackage Template
 */

get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$query_args = array(
    'post_type' => 'testimonials',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
);

$number_of_columns = 2;
$image_size = 'square';

$style_class = mo_get_column_style($number_of_columns);

$layout_mode = "fitRows";

mo_exec_action('before_content');
?>

    <div id="content" class="twelvecol">

        <?php mo_exec_action('start_content'); ?>

        <div class="hfeed">

            <?php
            mo_show_page_content();

            if (isset($query_args) && !empty($query_args)) {
                query_posts($query_args);
            }

            if (have_posts()) :

                echo '<ul class="image-grid post-snippets testimonials ' . $layout_mode . ' js-isotope" data-isotope-options=\'{ "itemSelector": ".entry-item", "layoutMode": "' . $layout_mode . '" }\'>';

                while (have_posts()) : the_post();

                    mo_exec_action('before_entry'); ?>

                    <li data-id="<?php echo get_the_ID(); ?>" class="entry-item <?php echo $style_class; ?>">

                        <article id="post-<?php echo get_the_ID(); ?>"
                                 class="<?php echo join(' ', get_post_class()); ?> clearfix">

                            <?php

                            mo_exec_action('start_entry');

                            ?>

                            <div class="entry-snippet">

                                <?php

                                echo '<blockquote class="testimonial">';

                                echo mo_get_entry_title(false);

                                echo '<div class="entry-summary">';

                                the_content();

                                echo '</div>';

                                echo '</blockquote>';

                                echo '<div class="author">';

                                mo_thumbnail(array(
                                    'image_size' => $image_size,
                                    'wrapper' => false,
                                    'before_html' => '<span class="member-img">',
                                    'after_html' => '</span>'
                                ));

                                $author_name = get_post_meta($post->ID, 'mo_student_name', true);

                                if (!empty($author_name)) {
                                    echo '<div class="author-name">' . $author_name . '</div>';
                                }

                                $author_details = get_post_meta($post->ID, 'mo_student_details', true);

                                if (!empty($author_details)) {
                                    echo '<div class="author-details">' . $author_details . '</div>';
                                }

                                echo '</div><!-- .author -->';

                                ?>

                            </div>
                            <!-- .entry-snippet -->

                            <?php mo_exec_action('end_entry'); ?>

                        </article>
                        <!-- .hentry -->

                    </li><!-- .isotope element -->

                    <?php mo_exec_action('after_entry');

                endwhile;

                echo '</ul><!-- post-snippets -->';

            else :

                get_template_part('loop-error'); // Loads the loop-error.php template.

            endif; ?>

        </div>
        <!-- .hfeed -->

        <?php mo_exec_action('end_content'); ?>

        <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.
        ?>

    </div><!-- #content -->

<?php mo_exec_action('after_content');

wp_reset_query(); /* Right placement to help not lose context information */

get_footer();