<?php

/* Upcoming Events Shortcode -

Displays a list of events. These events are entered by creating Event custom post types in the Events tab of the WordPress Admin.

The events are managed by The Events Calendar Pro plugin

Usage:

[upcoming_events post_count=4 all_events_link="true" class="simple-list"]

Parameters -

post_count - number (default - 5) The number of events to be displayed. By default displays all of the custom posts entered as feature in the Features tab of the WordPress Admin (optional).
category_ids - A comma separated category ids of the Event custom post types created in the Events tab of the WordPress Admin. Helps to filter the events for display (optional).
all_events_link - boolean (default true) - Specify if a link to all events must be displayed below the list of events.
no_upcoming_events - boolean (default - false) - Applies only when there are no upcoming events found. If set to true, no message will be displayed indicating that no upcoming events were found.
class  - string - The class name to be inserted for the element wrapping the list of posts displayed.
*/

if (!function_exists('mo_events_shortcode')) {
    function mo_events_shortcode($atts, $content = null, $code) {
        extract(shortcode_atts(array(
            'post_count' => '5',
            'category_ids' => '',
            'class' => '',
            'all_events_link' => 'true',
            'no_upcoming_events' => 'false'
        ), $atts));

        $no_upcoming_events = mo_to_boolean($no_upcoming_events);
        $all_events_link = mo_to_boolean($all_events_link);

        if (function_exists('tribe_get_events')) {

            $args = array(
                'eventDisplay' => 'list',
                'posts_per_page' => (int)$post_count,
            );

            if (!empty($category_ids)) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => TribeEvents::TAXONOMY,
                        'terms' => $category_ids,
                        'field' => 'ID',
                        'include_children' => false
                    )
                );
            }

            $posts = tribe_get_events($args);
        }

        // if no posts, and the don't show if no posts checked, let's bail
        if (!$posts && $no_upcoming_events) {
            return;
        }

        // Gather output
        ob_start();

        if ($posts) {

            ?>

            <ol class="hfeed vcalendar upcoming-events-list <?php echo $class; ?>">

                <?php

                /* Credit - http://wordpress.stackexchange.com/questions/9834/setup-postdata-does-not-seem-to-be-working
                *  Must use $global $post */
                global $post;

                foreach ($posts as $post) :

                    setup_postdata($post);

                    if (class_exists('TribeEventsPro')) {
                        $ecp = TribeEventsPro::instance();
                        $tooltip_status = $ecp->recurring_info_tooltip_status();
                        $ecp->disable_recurring_info_tooltip();
                    }

                    ?>

                    <li class="<?php tribe_events_event_classes() ?>">

                        <h4 class="entry-title summary">
                            <a href="<?php echo tribe_get_event_link(); ?>" rel="bookmark"><?php the_title(); ?></a>
                        </h4>

                        <div class="duration">
                            <?php echo tribe_events_event_schedule_details(); ?>
                        </div>

                    </li>

                    <?php

                    if (isset($tooltip_status)) {
                        $ecp->enable_recurring_info_tooltip();
                    }

                endforeach;

                ?>

            </ol><!-- .hfeed -->

            <?php

            if ($all_events_link) {

                // Link to the main events page (should work even if month/list views are disabled)
                $event_url = tribe_get_events_link();

                ?>


                <p>
                    <a href="<?php echo $event_url; ?>" rel="bookmark" class="all-events-link">
                        <?php

                        if (empty($category)) {
                            echo __('View All Events', 'mo_theme');
                        }
                        else {
                            echo __('View All Events in Category', 'mo_theme');
                        }

                        ?>
                    </a>
                </p>
            <?php

            }
        }
        else {
            echo '<p>' . __('There are no upcoming events at this time.', 'mo_theme') . '</p>';
        }

        /* resets the WordPress Query */
        wp_reset_postdata();

        // Save output
        $events = ob_get_contents();

        ob_end_clean();

        return $events;
    }

}

add_shortcode('upcoming_events', 'mo_events_shortcode');
