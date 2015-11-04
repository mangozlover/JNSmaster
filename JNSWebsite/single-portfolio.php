<?php

/**
 * Post Template
 *
 * This template is loaded when browsing a Wordpress post.
 *
 * @package Invent
 * @subpackage Template
 */

get_header(); ?>

<?php mo_exec_action('before_content'); ?>

    <div id="content">

        <?php mo_exec_action('start_content'); ?>

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php mo_exec_action('before_entry'); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php mo_exec_action('start_entry'); ?>

                    <div class="entry-content">

                        <?php the_content(); /* No thumbnail support for this. Everything user has to input - videos, audio, slider etc. */ ?>

                        <?php wp_link_pages(array('before' => '<p class="page-links">' . __('Pages:', 'mo_theme'), 'after' => '</p>')); ?>

                        <aside class="portfolio-sidebar">

                            <div class="inner">

                                <?php

                                echo '<div class="threecol">';

                                echo '<div class="portfolio-info" >' . __('Information', 'mo_theme') . '</div > ';

                                $project_client = get_post_meta($post->ID, '_portfolio_client_field', true);
                                if (!empty($project_client)) {
                                    echo '<div class="portfolio-label" >' . __('Client: ', 'mo_theme') . ' </div > ';
                                    echo '<p>' . htmlspecialchars_decode($project_client) . '</p>';
                                }

                                $project_date = get_post_meta($post->ID, '_portfolio_date_field', true);
                                if (!empty($project_date)) {
                                    echo '<div class="portfolio-label" >' . __('Date: ', 'mo_theme') . ' </div > ';
                                    echo '<p>' . htmlspecialchars_decode($project_date) . '</p>';
                                }

                                echo '<div class="portfolio-label" >' . __('Category: ', 'mo_theme') . ' </div > ';
                                echo '<p>' . mo_entry_terms_text('portfolio_category') . '</p>';

                                echo '</div>';

                                echo '<div class="threecol" >';

                                echo '<div class="portfolio-info" >' . __('Services Offered', 'mo_theme') . '</div > ';

                                $project_services = get_post_meta($post->ID, '_portfolio_services_field', true);
                                if (!empty($project_services)) {
                                    echo '<p>' . htmlspecialchars_decode($project_services) . '</p>';
                                }

                                echo '</div>';

                                echo '<div class="sixcol last" >';

                                echo '<div class="portfolio-info" >' . __('Additional Info', 'mo_theme') . '</div > ';

                                $project_info = get_post_meta($post->ID, '_portfolio_info_field', true);
                                if (!empty($project_info)) {
                                    echo '<div class="portfolio-description">' . htmlspecialchars_decode($project_info);
                                    echo '</div>';
                                }

                                $project_url = get_post_meta($post->ID, '_portfolio_link_field', true);
                                if (!empty($project_url)) {
                                    echo '<div class="portfolio-link" ><a href = "' . $project_url . '" class="button theme">' . __('Visit Website', 'mo_theme') . '</a></div > ';
                                }

                                echo '</div>';

                                echo '<div class="clear" ></div>';

                                ?>

                            </div>

                        </aside>

                    </div>
                    <!-- .entry-content -->

                    <?php mo_exec_action('end_entry'); ?>

                    <nav class="portfolio-nav">

                        <div class="inner">

                            <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.   ?>

                        </div>

                    </nav>

                </article><!-- .hentry -->

                <?php mo_exec_action('after_entry'); ?>

                <?php if (mo_get_theme_option('mo_enable_portfolio_comments')) {
                    comments_template('/comments.php', true); // Loads the comments.php template.
                } ?>

            <?php endwhile; ?>

        <?php endif; ?>

        <?php mo_exec_action('end_content'); ?>


    </div><!-- #content -->

<?php mo_exec_action('after_content'); ?>

<?php get_footer(); ?>