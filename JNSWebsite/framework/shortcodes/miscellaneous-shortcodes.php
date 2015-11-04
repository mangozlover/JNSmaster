<?php


/* Stats Shortcode -

Wraps an animated percentage stats list.

Usage:

[stats]

[stats_bar title="Web Design 87%" value="87"]

[stats_bar title="Logo Design 60%" value="60"]

[stats_bar title="Brand Marketing 70%" value="70"]

[/stats_bar][stats_bar title="SEO Services 67%" value="67"]

[stats_bar title="Print Collateral 40%" value="40"]

[/stats]


Parameters -

None


*/


function mo_stats($atts, $content) {
    extract(shortcode_atts(array(),
        $atts));
    return '<div class="stats-bars">' . do_shortcode(mo_remove_wpautop($content)) . '</div>';
}

add_shortcode('stats', 'mo_stats');

/* Stats Bar Shortcode -

Displays an animated percentage stats bar. The bar animates to indicate the percentage.

Usage:

[stats]

[stats_bar title="Web Design 87%" value="87"]

[stats_bar title="Logo Design 60%" value="60"]

[stats_bar title="Brand Marketing 70%" value="70"]

[/stats_bar][stats_bar title="SEO Services 67%" value="67"]

[stats_bar title="Print Collateral 40%" value="40"]

[/stats]


Parameters -

title - The title indicating the stats title.
value - The percentage value for the percentage stats to be displayed.

*/
function mo_stats_bar($atts, $content) {
    extract(shortcode_atts(array(
        'title' => 'Web Development 85%',
        'value' => '83'
    ), $atts));
    return '<div class="stats-bar"><h5 class="stats-title">' . $title . '</h5><div class="stats-bar-content" data-perc="' . $value . '"></div></div>';
}

add_shortcode('stats_bar', 'mo_stats_bar');

function mo_animating_stats_bar($atts, $content) {
    extract(shortcode_atts(array(
        'title' => 'Web Development 85%',
        'value' => '83'
    ), $atts));
    return '<div class="stats-bar"><div class="stats-title">' . $title . '</div><div class="stats-bar-content" data-perc="' . $value . '"></div></div>';
}

add_shortcode('animating_stats_bar', 'mo_animating_stats_bar');


/* Animating numbers shortcode -

A wrapper element for the list of numbers, each of which indicate a statistic. The element animates from a start value to display the end number when the user scrolls to the stats section.

Usage:

[number-stats]

[number-stat icon="icon-lab4" title="Pixels Pushed" start_value="87"]26492[/number-stat]

[number-stat icon="icon-java" title="Coffees Consumed" start_value="60"]613[/number-stat]

[number-stat icon="icon-heart11" title="Wide-Grip Pushups" start_value="70"]1277[/number-stat]

[number-stat icon="icon-clock10" title="Hours Worked" start_value="67"]458[/number-stat]

[/number-stats]


Parameters -

None

*/

function mo_number_stats($atts, $content) {
    extract(shortcode_atts(array(),
        $atts));
    return '<div class="number-stats">' . mo_remove_wpautop($content) . '</div>';
}

add_shortcode('number-stats', 'mo_number_stats');

/* Animating numbers shortcode -

Displays a number to indicate a statistic. The element displays the number in the stats section.

Usage:

[number-stats]

[number-stat icon="icon-lab4" title="Pixels Pushed"]26492[/number-stat]

[number-stat icon="icon-java" title="Coffees Consumed"]613[/number-stat]

[number-stat icon="icon-heart11" title="Wide-Grip Pushups"]1277[/number-stat]

[number-stat icon="icon-clock10" title="Hours Worked"]458[/number-stat]

[/number-stats]


Parameters -

title - The title indicating the stats title.
icon - The font icon to be displayed for the statistic being displayed, chosen from the list of icons listed at http://portfoliotheme.org/support/faqs/how-to-use-1500-icons-bundled-with-the-agile-theme/
icon_image_url - The url of the image icon. Can be useful when suitable font icon is not available.
text - Any additional text shown below the title.
*/

function mo_number_stat($atts, $content) {
    extract(shortcode_atts(array(
        'title' => 'Hours Burnt',
        'text' => '',
        'icon' => false,
        'icon_image_url' => false
    ), $atts));

    $icon_output = '';

    if (!empty($icon_image_url) || !empty($icon)) {
        $icon_output .= '<div class="icon-wrap">';
        if (!empty ($icon_image_url)) {
            $icon_output .= '<img src="' . $icon_image_url . '"/>';
        }
        else if (!empty ($icon)) {
            $icon_output .= '<i class="' . $icon . '"></i>';
        }
        $icon_output .= '</div>';
    }

    if (!empty($text))
        $text = '<div class="text">' . $text . '</div>';

    return '<div class="number-stat">'. $icon_output . '<div class="number">' . $content . '</div><div class="text-wrap"><div class="stats-title">' . $title . '</div>' . $text . '</div></div>';
}

add_shortcode('number-stat', 'mo_number_stat');

function mo_animate_single_number($atts, $content) {
    extract(shortcode_atts(array(
        'title' => 'Hours Burnt',
        'start_value' => '0',
        'end_value' => '0',
        'icon' => false,
        'icon_image_id' => false
    ), $atts));

    $font_icon = '';
    $image_element = '';

    if (!empty ($icon_image_id)) {
        $image_element = '<img src="' . wp_get_attachment_url($icon_image_id) . '"/>';
    }
    else if (!empty ($icon)) {
        $font_icon = '<i class="' . $icon . '"></i>';
    }

    return '<div class="stats"><div class="number" data-stop="' . $end_value . '">' . $start_value . '</div><div class="stats-title">' . $font_icon . $image_element . $title . '</div></div>';
}

add_shortcode('animate_number', 'mo_animate_single_number');

/* Piechart Shortcode -

Displays a piechart for a percentage statistic with a title in the middle of the piechart displayed.
While the piechart animates to indicate the percentage specified, a textual representation of the statistic is also displayed in the center of the piechart.

Usage:

[piechart percent=70 title="Repeat Customers"]

[piechart percent=92 title="Referral Work"]

Parameters -

title - The title indicating the stats title.
value - The percentage value for the percentage stats.


*/


function mo_piechart($atts, $content) {
    extract(shortcode_atts(array(
        'percent' => 85,
        'title' => ''
    ), $atts));

    $output = '<div class="piechart">';
    $output .= '<div class="percentage" data-percent="' . $percent . '"><span>' . $percent . '<sup>%</sup></span></div>';
    $output .= '<h4 class="label">' . $title . '</h4>';
    $output .= '</div>';

    return $output;
}

add_shortcode('piechart', 'mo_piechart');


add_shortcode('marketing_offer', 'mo_marketing_offer_shortcode');

/* Service Item Shortcode -

Display a service item with an image or a font icon specified by the user on the top, followed by title and description below the image/icon.

Usage:

[service_item image_url="http://portfoliotheme.org/invent/wp-content/uploads/2014/05/muscles.png" title="Personal Training" description="Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut."]

Parameters -

title - The title displayed below the image or font icon, above the description.
image_url - The URL of the image displayed at the top of the box displaying the marketing offer.
icon_class - The class name for the icon font as documented in the http://portfoliotheme.org/support/faqs/how-to-use-1500-icons-bundled-with-the-agile-theme/.
If an image_url has been specified, this font icon parameter is ignored.
description - The textual description to be displayed below the title.


*/
function mo_service_item_shortcode($atts, $content) {

    extract(shortcode_atts(array(
        'image_url' => '',
        'image_id' => '',
        'icon' => '',
        'title' => '',
        'description' => ''
    ), $atts));

    $output = '<div class="service-item">';

    if (!empty($image_id)) {

        $output .= '<img src="' . wp_get_attachment_url($image_id) . '" alt="' . $title . '"/>';
    }
    elseif (!empty($image_url)) {

        $output .= '<img src="' . $image_url . '" alt="' . $title . '"/>';
    }
    elseif (!empty($icon)) {
        $output .= '<i class="' . $icon . '"></i>';
    }

    $output .= '<h3>' . $title . '</h3>';

    $output .= '<div class="description">';

    $output .= $description;

    $output .= '</div>';

    $output .= '</div>';

    return $output;
}

add_shortcode('service_item', 'mo_service_item_shortcode');