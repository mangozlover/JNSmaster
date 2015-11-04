<?php

/**
 * Post Template
 *
 * This template is loaded when browsing a LearnDash course.
 *
 * @package Invent
 * @subpackage Template
 */

$image_size = 'large';

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

                        <?php mo_exec_action('start_entry'); ?>

                        <div class="entry-content clearfix">

                            <?php

                            $args = mo_get_thumbnail_args_for_singular();

                            mo_thumbnail($args);

                            ?>

                            <div class="entry-text-wrap">

                                <?php

                                the_content();

                                wp_link_pages(array(
                                    'link_before' => '<span class="page-number">',
                                    'link_after' => '</span>',
                                    'before' => '<p class="page-links">' . __('Pages:', 'mo_theme'),
                                    'after' => '</p>'
                                ));

                                ?>

                            </div>

                        </div>
                        <!-- .entry-content -->

                        <?php mo_exec_action('end_entry'); ?>

                    </article>
                    <!-- .hentry -->

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