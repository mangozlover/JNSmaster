<?php

global $mo_theme;

get_header();

$image_size = 'small';

$mo_theme->set_context('loop', 'archive'); // tells the thumbnail functions to prepare lightbox constructs for the image

$layout_option = mo_get_theme_option('mo_archive_styling', 'List');

$layout_manager = mo_get_layout_manager();
if ($layout_manager->is_full_width_layout()) {
    $image_size = 'full';
}
else {
    // 3 Column and 2 Column layouts will share the
    // image and resizing will happen through css
    $image_size = 'large';
}
$list_style = 'default-list';

$excerpt_count = mo_get_theme_option('mo_excerpt_count', 250);

$taxonomy = null;
$display_meta = false;
$query_args = null;

?>

<?php mo_exec_action('before_content'); ?>

    <div id="content" class="<?php echo $list_style ?> <?php echo mo_get_content_class(); ?>">

        <?php mo_exec_action('start_content'); ?>

        <div class="hfeed">

            <?php
            if (isset($query_args) && !empty($query_args)) {
                query_posts($query_args);
            }
            ?>

            <?php if (have_posts()) : ?>

                <?php $first_post = true; ?>

                <?php while (have_posts()) : the_post(); ?>

                    <?php mo_exec_action('before_entry'); ?>

                    <article id="post-<?php the_ID(); ?>"
                             class="<?php echo(join(' ', get_post_class()) . ($first_post ? ' first' : '')); ?> clearfix">

                        <?php mo_exec_action('start_entry');

                        echo '<div class="entry-snippet">';

                        $thumbnail_exists = $thumbnail_exists = mo_thumbnail(array(
                            'image_size' => $image_size,
                            'wrapper' => true,
                            'size' => 'full',
                            'taxonomy' => $taxonomy
                        ));

                        echo '<div class="entry-text-wrap' . ($thumbnail_exists ? '' : ' nothumbnail') . '">';

                        if (!empty($taxonomy)) {
                            echo '<div class="entry-terms multi-color">';

                            echo mo_entry_terms_list('category');

                            echo '</div>'; // .entry-terms

                        }

                        echo mo_get_entry_title();

                        mo_display_blog_entry_text($thumbnail_exists, $excerpt_count);

                        $disable_read_more_button = mo_get_theme_option('mo_disable_read_more_button_in_archives');

                        if (!$disable_read_more_button)
                            echo '<span class="read-more"><a class="button default" href="' . get_permalink() . '" title="' . get_the_title() . '">' . __('Read More', 'mo_theme') . '</a></span>';

                        echo '</div>';

                        if ($display_meta)
                            echo '<div class="entry-meta">' . mo_entry_author() . mo_entry_published("M d") . mo_entry_terms_list('post_tag') . mo_entry_comments_link() . '</div>';

                        echo '</div> <!-- .entry-snippet -->';

                        mo_exec_action('end_entry');

                        ?>

                    </article><!-- .hentry -->

                    <?php mo_exec_action('after_entry'); ?>

                    <?php $first_post = false; ?>

                <?php endwhile; ?>

            <?php else : ?>

                <?php get_template_part('loop-error'); // Loads the loop-error.php template.
                ?>

            <?php endif; ?>

        </div>
        <!-- .hfeed -->

        <?php mo_exec_action('end_content'); ?>

        <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.
        ?>

    </div><!-- #content -->

<?php mo_exec_action('after_content'); ?>

<?php wp_reset_query(); /* Right placement to help not lose context information */
?>

<?php

$mo_theme->set_context('loop', null); //reset it

get_sidebar();

get_footer();