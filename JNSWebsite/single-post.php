<?php

/**
 * Post Template
 *
 * This template is loaded when browsing a Wordpress post.
 *
 * @package Invent
 * @subpackage Template
 */

function mo_display_post_thumbnail() {

    $post_id = get_the_ID();
    $args = mo_get_thumbnail_args_for_singular();
    $image_size = $args['image_size'];
    $thumbnail_exists = mo_display_video_or_slider_thumbnail($post_id, $image_size);
    if (!$thumbnail_exists) {

        $thumbnail_exists = mo_thumbnail($args);
    }
    return $thumbnail_exists;

}

get_header();
?>

<?php mo_exec_action('before_content'); ?>

    <div id="content" class="<?php echo mo_get_content_class(); ?>">

        <?php mo_exec_action('start_content'); ?>

        <div class="hfeed">

            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                    <?php mo_exec_action('before_entry'); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php mo_exec_action('start_entry'); ?>

                        <div class="entry-content clearfix">

                            <?php

                            $disable_thumbnail = get_post_meta(get_the_ID(), 'mo_disable_featured_thumbnail');

                            if (empty($disable_thumbnail))
                                mo_display_post_thumbnail();

                            ?>

                            <div class="entry-text-wrap">

                                <div class="entry-terms multi-color">

                                    <?php echo mo_entry_terms_list('category'); ?>

                                </div>

                                <?php echo mo_get_entry_title(); ?>

                                <?php the_content(); ?>

                                <?php wp_link_pages(array(
                                    'link_before' => '<span class="page-number">',
                                    'link_after' => '</span>',
                                    'before' => '<p class="page-links">' . __('Pages:', 'mo_theme'),
                                    'after' => '</p>'
                                )); ?>

                            </div>

                        </div>
                        <!-- .entry-content -->

                        <?php
                        echo '<div class="entry-meta">' . mo_entry_published("M d") . mo_entry_author() . mo_entry_terms_list('post_tag') . mo_entry_comments_link() . '</div>';
                        ?>

                        <?php mo_exec_action('end_entry'); ?>

                    </article><!-- .hentry -->

                    <?php mo_exec_action('after_entry'); ?>

                    <?php mo_display_sidebar('after-singular-post'); ?>

                    <?php mo_exec_action('after_singular'); ?>

                    <?php comments_template('/comments.php', true); // Loads the comments.php template.   ?>

                <?php endwhile; ?>

            <?php endif; ?>

        </div>
        <!-- .hfeed -->

        <?php mo_exec_action('end_content'); ?>

        <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.   ?>

    </div><!-- #content -->

<?php mo_exec_action('after_content'); ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>