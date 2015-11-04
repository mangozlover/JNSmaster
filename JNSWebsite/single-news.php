<?php

/**
 * Post Template
 *
 * This template is loaded when browsing a Feature Custom Post Type.
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

                            $disable_thumbnail = get_post_meta(get_the_ID(), 'mo_disable_featured_thumbnail');

                            if (empty($disable_thumbnail)) {
                                
                                mo_thumbnail(array(
                                    'image_size' => $image_size,
                                    'before_html' => '<div class="wrap">',
                                    'after_html' => '</div>',
                                    'wrapper' => false
                                ));
                                
                            }

                            ?>

                            <div class="entry-text-wrap">

                                <?php

                                echo '<div class="entry-terms multi-color">';

                                echo mo_entry_terms_list('news_category');

                                echo '</div>'; // .entry-terms

                                echo mo_get_entry_title();

                                the_content();

                                wp_link_pages(array(
                                    'link_before' => '<span class="page-number">',
                                    'link_after' => '</span>',
                                    'before' => '<p class="page-links">' . __('Pages:', 'mo_theme'),
                                    'after' => '</p>'
                                ));

                                ?>

                            </div>

                            <?php
                            echo '<div class="entry-meta">' . mo_entry_published("M d") . mo_entry_author() . mo_entry_comments_link() . '</div>';
                            ?>

                        </div>
                        <!-- .entry-content -->

                        <?php mo_exec_action('end_entry'); ?>

                    </article>
                    <!-- .hentry -->

                    <?php mo_exec_action('after_entry');

                    mo_exec_action('after_singular');

                    comments_template('/comments.php', true); // Loads the comments.php template.

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