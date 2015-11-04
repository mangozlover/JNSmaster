<?php

get_header();

$number_of_columns = 4;
$image_size = 'small';
$excerpt_count = 138;

$show_content = false;

$style_class = mo_get_column_style($number_of_columns);

$layout_mode = mo_get_theme_option('mo_staff_layout_mode', 'fitRows');
if ($layout_mode == 'masonry')
    $image_size = 'proportional';

mo_exec_action('before_content');
?>

    <div id="content" class="<?php echo mo_get_content_class(); ?>">

        <?php mo_exec_action('start_content'); ?>

        <div class="hfeed">

            <?php

            if (is_page_template('template-staff.php')) {

                mo_show_page_content();

                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                $query_args = array(
                    'post_type' => 'staff',
                    'posts_per_page' => 8,
                    'paged' => $paged,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                );
                query_posts($query_args);

            }

            if (have_posts()) :

                echo mo_get_post_type_archive_links('staff', 'specialization');

                echo '<ul class="image-grid post-snippets ' . $layout_mode . ' js-isotope" data-isotope-options=\'{ "itemSelector": ".entry-item", "layoutMode": "' . $layout_mode . '" }\'>';

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

                                echo '<div class="img-wrap">';

                                $thumbnail_exists = mo_thumbnail(array(
                                    'image_size' => $image_size,
                                    'wrapper' => false
                                ));

                                if ($thumbnail_exists)
                                    echo '<div class="image-overlay"></div>';

                                $post_title = get_the_title();
                                $post_link = get_permalink();

                                echo mo_get_type_info();

                                echo '</div><!-- .img-wrap -->';

                                echo '<div class="entry-text-wrap' . ($thumbnail_exists ? '' : ' nothumbnail') . '">';

                                $staff_title = get_post_meta(get_the_ID(), 'mo_staff_title', true);
                                if (!empty($staff_title)) {
                                    echo '<div class="staff-title">' . $staff_title . '</div>';
                                }

                                echo mo_get_entry_title();

                                echo '<div class="entry-summary">';

                                if ($show_content) {
                                    global $more;
                                    $more = 0;
                                    /*TODO: Remove the more link here since it will be shown later */
                                    the_content(__('Read More <span class="meta-nav">&rarr;</span>', 'mo_theme'));
                                }
                                else {
                                    echo mo_truncate_string(get_the_excerpt(), $excerpt_count);
                                }

                                echo '</div>'; // .entry-summary

                                echo '</div><!-- .entry-text-wrap -->';

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

get_sidebar();

get_footer();