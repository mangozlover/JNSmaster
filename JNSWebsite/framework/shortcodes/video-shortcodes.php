<?php

/* YouTube Video Showcase Shortcode -

Displays an YouTube video with controls for play/pause/mute. The video is not auto-played by default and waits for the user input via the play button.

Displays title headers when the video is paused/stopped or when the video is yet to start.

Usage:

[ytp_video_showcase
id="video-intro"
video_url="http://www.youtube.com/watch?v=PzjwAAskt4o"
containment="self"
placeholder_url="http://portfoliotheme.org/austin/wp-content/uploads/2014/03/video-placeholder.jpg"
title="Design is Problem Solving"
start_at=2
stop_at=20
subtitle="Branding and Marketing"
overlay_color="#0F0A09"
overlay_opacity="0.4"
loop="true"]

Parameters -

id (string) - The id of the DIV element created to wrap the YouTube video (optional). Default is video-intro.
class (string) - The CSS class of the DIV element created to wrap the YouTube video (optional).
video_url (link) - The YouTube URL of the video (ex: http://www.youtube.com/watch?v=PzjwAAskt4o).
mute - false (boolean). A boolean value indicating if the video needs to be started muted. Default is false. The user can mute the video if required with the help of mute/unmute button.
show_controls - false (boolean). Show or hide the controls bar at the bottom of the page.
containment - self (string). The CSS selector of the DOM element where you want the video background; if not specified it takes the “body”; if set to “self” the player will be instanced on that element.
quality- highres (string). Values are ‘default’ or “small”, “medium”, “large”, “hd720”, “hd1080”, “highres”.
optimize_display: true (boolean). Will fit the video size into the window size optimizing the view.
loop: true. true (boolean) or false loops the movie once ended.
start_at: 0 (number). Set the seconds the video should start at.
stop_at: 0 (number). Set the seconds the video should stop at. If 0, the value is ignored.
opacity: 1 (number). 0 to 1 - define the opacity of the video.
vol: 50 (number). 1 to 100 - set the volume level of the video. Default is 50.
ratio: 16/9 (string). ‘4/3’ or “16/9”  to set the aspect ratio of the movie.
autoplay: false (boolean). Specify true or false play the video once ready.
placeholder_url (link)- URL of the placeholder image to be displayed instead of YouTube video in mobile devices.
overlay_color - The color of the overlay to be applied on the video.
overlay_opacity - 0.7 (number). 0 to 1 - The opacity of the overlay color.
overlay_pattern (link)- The URL of the image which can act as a pattern displayed on top of the video.
title (string) -  The title text displayed on top of the video when the video is not playing.
subtitle (string) - The subtitle displayed on top of the video when the video is not playing.
*/

function mo_ytp_video_showcase_shortcode($atts, $content = null, $shortcode_name = "") {

    extract(shortcode_atts(
        array(
            'id' => 'video-intro',
            'class' => '',
            'video_url' => '',
            'mute' => 'false',
            'show_controls' => 'false',
            'containment' => 'self',
            'quality' => 'highres',
            'optimize_display' => 'true',
            'loop' => 'true',
            'autoplay' => 'false',
            'vol' => '50',
            'ratio' => '16/9',
            'start_at' => '0',
            'stop_at' => '0',
            'opacity' => '1',
            'placeholder_url' => '',
            'placeholder_image_id' => '',
            'title' => '',
            'subtitle' => '',
            'button_text' => '',
            'button_url' => '',
            'overlay_color' => '',
            'overlay_opacity' => '0.7',
            'overlay_pattern' => '',
            'overlay_pattern_id' => ''),
        $atts));

    $output = '';
    if (!empty($video_url)) {

        $autoplay_video = mo_to_boolean($autoplay);

        ob_start(); // Gather output
        ?>

        <div id="<?php echo $id; ?>"
             class="<?php echo str_replace("_", "-", $shortcode_name) . ($class ? ' ' . $class : ''); ?>">

            <div class="video-header">

                <div class="header-content">

                    <?php echo empty($subtitle) ? '' : '<div class="subtitle">' . htmlspecialchars_decode($subtitle) . '</div>'; ?>

                    <button class="play-btn" onclick="jQuery('.ytp-video-showcase #ytp-video').YTPPlay()"><i
                            class="icon-play2"></i>
                    </button>

                    <?php echo empty($title) ? '' : '<h3>' . $title . '</h3>'; ?>

                    <?php echo empty($button_text) ? '' : '<a href="' . $button_url . '" class="action-button button transparent"><span>' . $button_text . '</span></a>'; ?>

                </div>

                <div class="media">
                    <div class="video-bg" <?php echo 'data-video-autoplay=' . ($autoplay_video? 'true': 'false'); ?>>

                        <?php echo '<div id="ytp-video" class="ytp-player" data-property="{gaTrack:false,' . 'videoURL:\'' . $video_url . '\',' . 'mute:' . $mute . ',' . 'loop:' . $loop . ',' . 'vol:' . $vol . ',' . 'ratio:' . $ratio . ',' . 'optimizeDisplay:' . $optimize_display . ',' . 'opacity:' . $opacity . ',' . 'autoPlay:' . $autoplay . ',' . 'quality:\'' . $quality . '\',' . 'showControls:' . $show_controls . ',' . 'containment:\'' . $containment . '\'}"></div>'; ?>

                    </div>

                    <?php
                    if (!empty($placeholder_image_id))
                        $placeholder_url = wp_get_attachment_url($placeholder_image_id);
                    if (!empty($overlay_pattern_id))
                        $overlay_pattern = wp_get_attachment_url($overlay_pattern_id);
                    ?>

                    <div class="img-bg">
                        <img alt="Video Poster" class="video-placeholder"
                             src="<?php echo esc_url($placeholder_url); ?>"/>
                    </div>

                    <?php

                    if (!empty($overlay_color) || !empty($overlay_pattern)) :

                        $hex = $overlay_color;
                        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");

                        $bg_color = empty($overlay_color) ? "" : "background-color: rgba(" . "$r, $g, $b, $overlay_opacity);";
                        $bg_pattern = empty($overlay_pattern) ? "" : "background-image:url(" . $overlay_pattern . ");";

                        ?>

                        <div class="overlay" style="<?php echo ($bg_color) . ($bg_pattern); ?>"></div>

                    <?php

                    endif;

                    ?>
                </div>

                <div class="video-controls">
                    <button class="small-pause-btn" onclick="jQuery('.ytp-video-showcase #ytp-video').YTPPause()"><i
                            class="icon-pause"></i>
                    </button>
                    <button class="small-mute-btn" onclick="jQuery('.ytp-video-showcase #ytp-video').toggleVolume()"><i
                            class="icon-volumemute2"></i></button>
                </div>

            </div>

        </div>
        <?php
        // Save output
        $output = ob_get_contents();
        ob_end_clean();
    }
    return $output;
}

add_shortcode('ytp_video_showcase', 'mo_ytp_video_showcase_shortcode');


/* YouTube Video Section Shortcode -

Displays a section with YouTube video background. Controls for play/pause/mute are provided to the bottom right.

The video is auto-played by default and the title text, subtitle and button is displayed all the time when required parameters for the titles/buttons are provided.

Usage:

[ytp_video_section
id="video-intro"
video_url="http://www.youtube.com/watch?v=RdIh8GiVR9I"
containment="self"
placeholder_url="http://portfoliotheme.org/austin/wp-content/uploads/2014/03/ytp-video-placeholder.jpg"
subtitle="Developers and Designers"
text="All the tools you need to build a top notch website. "
button_text="Purchase theme »"
button_url="http://themeforest.net/user/LiveMesh/portfolio?ref=livemesh"
overlay_pattern="http://portfoliotheme.org/austin/wp-content/themes/austin/dev/images/styleswitcher/patterns/pattern-3.gif"
overlay_color="#31110F"
overlay_opacity="0.3"]

Parameters -

id (string) - The id of the DIV element created to wrap the YouTube video (optional). Default is video-intro.
class (string) - The CSS class of the DIV element created to wrap the YouTube video (optional).
video_url (link) - The YouTube URL of the video (ex: http://www.youtube.com/watch?v=PzjwAAskt4o).
mute - true (boolean). A boolean value indicating if the video needs to be started muted. Default is true. The user can unmute the video if required with the help of mute/unmute button.
show_controls - false (boolean). Show or hide the controls bar at the bottom of the page.
containment - self (string). The CSS selector of the DOM element where you want the video background; if not specified it takes the “body”; if set to “self” the player will be instanced on that element.
quality- highres (string). Values are ‘default’ or “small”, “medium”, “large”, “hd720”, “hd1080”, “highres”.
optimize_display: true (boolean). Will fit the video size into the window size optimizing the view.
loop: true. true (boolean) or false loops the movie once ended.
start_at: 0 (number). Set the seconds the video should start at.
stop_at: 0 (number). Set the seconds the video should stop at. If 0, the value is ignored.
opacity: 1 (number). 0 to 1 - define the opacity of the video.
vol: 50 (number). 1 to 100 - set the volume level of the video. Default is 50.
ratio: 16/9 (string). ‘4/3’ or “16/9”  to set the aspect ratio of the movie.
autoplay: true (boolean). Specify true or false play the video once ready.
placeholder_url (link)- URL of the placeholder image to be displayed instead of YouTube video in mobile devices.
overlay_color - The color of the overlay to be applied on the video.
overlay_opacity - 0.7 (number). 0 to 1 - The opacity of the overlay color.
overlay_pattern (link)- The URL of the image which can act as a pattern displayed on top of the video.
text (string) -  The title text displayed on top of the video when the video is not playing.
subtitle (string) - The subtitle displayed on top of the video when the video is not playing.
button_text (string) - Text of the button shown to the user on top of the video.
button_url (link) - The URL to which the button needs to point to.
*/

function mo_ytp_video_section_shortcode($atts, $content = null, $shortcode_name = "") {

    extract(shortcode_atts(
        array(
            'id' => 'video-intro',
            'class' => '',
            'video_url' => '',
            'mute' => 'true',
            'show_controls' => 'false',
            'containment' => 'self',
            'quality' => 'highres',
            'optimize_display' => 'true',
            'loop' => 'true',
            'autoplay' => 'true',
            'vol' => '50',
            'ratio' => '16/9',
            'start_at' => '0',
            'stop_at' => '0',
            'opacity' => '1',
            'placeholder_url' => '',
            'placeholder_image_id' => '',
            'text' => '',
            'subtitle' => '',
            'button_text' => '',
            'button_url' => '',
            'overlay_color' => '',
            'overlay_opacity' => '0.7',
            'overlay_pattern' => '',
            'overlay_pattern_id' => ''),
        $atts));

    $output = '';
    if (!empty($video_url)) {

        ob_start(); // Gather output
        ?>

        <div id="<?php echo $id; ?>"
             class="<?php echo str_replace("_", "-", $shortcode_name) . ($class ? ' ' . $class : ''); ?>">

            <div class="video-header">

                <div class="header-content">

                    <?php echo empty($subtitle) ? '' : '<div class="subtitle">' . htmlspecialchars_decode($subtitle) . '</div>'; ?>

                    <?php echo empty($text) ? '' : '<div class="text">' . $text . '</div>'; ?>

                    <?php echo empty($button_text) ? '' : '<a href="' . $button_url . '" class="action-button button transparent"><span>' . $button_text . '</span></a>'; ?>

                </div>

                <div class="media">
                    <div class="video-bg">

                        <?php echo '<div id="ytp-video" class="ytp-player" data-property="{gaTrack:false,' . 'videoURL:\'' . $video_url . '\',' . 'mute:' . $mute . ',' . 'loop:' . $loop . ',' . 'vol:' . $vol . ',' . 'ratio:' . $ratio . ',' . 'optimizeDisplay:' . $optimize_display . ',' . 'opacity:' . $opacity . ',' . 'autoPlay:' . $autoplay . ',' . 'quality:\'' . $quality . '\',' . 'showControls:' . $show_controls . ',' . 'containment:\'' . $containment . '\'}"></div>'; ?>

                    </div>

                    <?php
                    if (!empty($placeholder_image_id))
                        $placeholder_url = wp_get_attachment_url($placeholder_image_id);
                    if (!empty($overlay_pattern_id))
                        $overlay_pattern = wp_get_attachment_url($overlay_pattern_id);
                    ?>

                    <div class="img-bg">
                        <img alt="Video Poster" class="video-placeholder"
                             src="<?php echo esc_url($placeholder_url); ?>"/>
                    </div>

                    <?php

                    if (!empty($overlay_color) || !empty($overlay_pattern)) :

                        $hex = $overlay_color;
                        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");

                        $bg_color = empty($overlay_color) ? "" : "background-color: rgba(" . "$r, $g, $b, $overlay_opacity);";
                        $bg_pattern = empty($overlay_pattern) ? "" : "background-image:url(" . $overlay_pattern . ");";

                        ?>

                        <div class="overlay" style="<?php echo ($bg_color) . ($bg_pattern); ?>"></div>

                    <?php

                    endif;

                    ?>
                </div>

                <div class="video-controls">
                    <button class="small-play-btn" onclick="jQuery('.ytp-video-section #ytp-video').YTPPlay()"><i
                            class="icon-play"></i>
                    </button>
                    <button class="small-pause-btn" onclick="jQuery('.ytp-video-section #ytp-video').YTPPause()"><i
                            class="icon-pause"></i>
                    </button>
                    <button class="small-mute-btn" onclick="jQuery('.ytp-video-section #ytp-video').toggleVolume()"><i
                            class="icon-volumemute2"></i></button>
                </div>

            </div>

        </div>
        <?php
        // Save output
        $output = ob_get_contents();
        ob_end_clean();
    }
    return $output;
}


add_shortcode('ytp_video_section', 'mo_ytp_video_section_shortcode');

/* HTML5 Video Showcase Shortcode -

Displays an HTML5 video with controls for play/pause/mute. The video is not auto-played by default and waits for the user input via the play button.

Displays title headers when the video is paused/stopped or when the video is yet to start.

Usage:

[video_showcase
id="video-intro"
class="video-heading"
mp4_url="http://portfoliotheme.org/austin/wp-content/uploads/2014/04/office.mp4"
ogg_url="http://portfoliotheme.org/austin/wp-content/uploads/2014/04/office.ogv"
webm_url="http://portfoliotheme.org/austin/wp-content/uploads/2014/04/office.webm"
placeholder_url="http://portfoliotheme.org/austin/wp-content/uploads/2014/04/about-video-placeholder.jpg"
subtitle="Developers and Designers"
title="All the tools you need to build a top notch website. "
overlay_pattern="http://portfoliotheme.org/austin/wp-content/themes/austin/dev/images/styleswitcher/patterns/pattern-3.gif"
overlay_color="#31110F"
overlay_opacity="0.3"
loop=true]

Parameters -

id (string) - The id of the DIV element created to wrap the HTML5 video (optional). Default is video-intro.
class (string) - The CSS class of the DIV element created to wrap the HTML5 video (optional). Default is video-heading.
video_id - video1 (string) - The id of the VIDEO element.
mp4_url (link) - The URL of the video uploaded in MP4 format.
ogg_url (link) - The URL of the video uploaded in OGG format.
webm_url (link) - The URL of the video uploaded in WEBM format.
muted - false (boolean). A boolean value indicating if the video needs to be started muted. Default is false. The user can unmute the video if required with the help of mute/unmute button.
loop: true (boolean). Specify true or false to whether loop the movie once ended.
preload: none (string). Specify if the HTML5 video needs to be preloaded irrespective of whether the user chooses to play or not. Possible values are auto (preloads entire video when the page loads), metadata (load only metadata when page loads) and none (preload nothing on page load).
autoplay: false (boolean). Specify true or false to automatically play the video once ready.
placeholder_url (link)- URL of the placeholder image to be displayed instead of HTML5 video in mobile devices.
overlay_color - The color of the overlay to be applied on the video.
overlay_opacity - 0.7 (number). 0 to 1 - The opacity of the overlay color.
overlay_pattern (link)- The URL of the image which can act as a pattern displayed on top of the video.
title (string) -  The title text displayed on top of the video when the video is not playing.
subtitle (string) - The subtitle displayed on top of the video when the video is not playing.
*/
function mo_video_showcase_shortcode($atts, $content = null, $shortcode_name = "") {

    extract(shortcode_atts(
        array(
            'id' => 'video-intro',
            'class' => 'video-heading',
            'video_id' => 'video1',
            'mp4_url' => '',
            'ogg_url' => '',
            'webm_url' => '',
            'autoplay' => 'false',
            'loop' => 'false',
            'muted' => 'false',
            'preload' => 'none',
            'placeholder_url' => '',
            'placeholder_image_id' => '',
            'title' => '',
            'subtitle' => '',
            'text' => '',
            'button_text' => '',
            'button_url' => '',
            'overlay_color' => '',
            'overlay_opacity' => '0.7',
            'overlay_pattern' => '',
            'overlay_pattern_id' => ''),
        $atts));

    $output = '';
    if (!empty($mp4_url) || !empty($ogg_url) || !empty($webm_url)) {

        $muted = mo_to_boolean($muted);
        $loop = mo_to_boolean($loop);
        $autoplay = mo_to_boolean($autoplay);

        ob_start(); // Gather output
        ?>
        <div id="<?php echo $id; ?>"
             class="<?php echo str_replace("_", "-", $shortcode_name) . ($class ? ' ' . $class : ''); ?>">

            <div class="video-header">

                <div class="header-content">

                    <?php echo empty($subtitle) ? '' : '<div class="subtitle">' . htmlspecialchars_decode($subtitle) . '</div>'; ?>

                    <button class="play-btn" onclick="document.getElementById('<?php echo $video_id; ?>').play()"><i
                            class="icon-play2"></i>
                    </button>

                    <?php echo empty($title) ? '' : '<h3>' . $title . '</h3>'; ?>

                    <?php echo empty($button_text) ? '' : '<a href="' . $button_url . '" class="action-button button transparent"><span>' . $button_text . '</span></a>'; ?>

                </div>

                <?php
                if (!empty($placeholder_image_id))
                    $placeholder_url = wp_get_attachment_url($placeholder_image_id);
                if (!empty($overlay_pattern_id))
                    $overlay_pattern = wp_get_attachment_url($overlay_pattern_id);
                ?>

                <div class="media">
                    <div class="video-bg">
                        <video id=<?php echo $video_id; ?>
                               poster="<?php echo esc_url($placeholder_url); ?>"
                               preload="<?php echo $preload; ?>"
                            <?php echo $autoplay ? 'autoplay' : ''; ?> <?php echo $loop ? 'loop' : ''; ?> <?php echo $muted ? 'muted' : ''; ?>>
                            <source src="<?php echo esc_url($mp4_url); ?>" type="video/mp4">
                            <source src="<?php echo esc_url($ogg_url); ?>" type="video/ogg">
                            <source src="<?php echo esc_url($webm_url); ?>" type="video/webm">
                        </video>
                    </div>
                    <div class="img-bg">
                        <img alt="Video Poster" class="video-placeholder"
                             src="<?php echo esc_url($placeholder_url); ?>"/>
                    </div>
                    <?php

                    if (!empty($overlay_color) || !empty($overlay_pattern)) :

                        $hex = $overlay_color;
                        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");

                        $bg_color = empty($overlay_color) ? "" : "background-color: rgba(" . "$r, $g, $b, $overlay_opacity);";
                        $bg_pattern = empty($overlay_pattern) ? "" : "background-image:url(" . $overlay_pattern . ");";

                        ?>

                        <div class="overlay" style="<?php echo ($bg_color) . ($bg_pattern); ?>"></div>

                    <?php

                    endif;

                    ?>
                </div>

                <div class="video-controls">
                    <button class="small-pause-btn"
                            onclick="document.getElementById('<?php echo $video_id; ?>').pause()"><i
                            class="icon-pause"></i>
                    </button>
                    <button class="small-mute-btn"
                            onclick="mo_toggle_html5_video_volume(document.getElementById('<?php echo $video_id; ?>'))">
                        <i class="icon-volumemute2"></i></button>
                </div>

            </div>

        </div>
        <?php
        // Save output
        $output = ob_get_contents();
        ob_end_clean();
    }
    return $output;
}

/* HTML5 Video Section Shortcode -

Displays a section with HTML5 video background. Controls for play/pause/mute are provided to the bottom right.

The video is auto-played by default and the title text, subtitle and button is displayed all the time when required parameters for the titles/buttons are provided.

Usage:

[video_section
id="html5-video-bg1"
mp4_url="http://portfoliotheme.org/austin/wp-content/uploads/2014/02/snow.mp4"
ogg_url="http://portfoliotheme.org/austin/wp-content/uploads/2014/02/snow.ogv"
webm_url="http://portfoliotheme.org/austin/wp-content/uploads/2014/02/snow.webm"
placeholder_url="http://portfoliotheme.org/austin/wp-content/uploads/2014/02/snow.jpg"
subtitle="Developers and Designers"
text="All the tools you need to build a top notch website. "
button_text="Purchase theme »"
button_url="http://themeforest.net/user/LiveMesh/portfolio?ref=livemesh"
overlay_pattern="http://portfoliotheme.org/austin/wp-content/themes/austin/dev/images/styleswitcher/patterns/pattern-3.gif"
overlay_color="#31110F"
overlay_opacity="0.3"]

Parameters -

id (string) - The id of the DIV element created to wrap the HTML5 video (optional). Default is video-intro.
class (string) - The CSS class of the DIV element created to wrap the HTML5 video (optional).
video_id - video-bg1 (string) - The id of the VIDEO element.
mp4_url (link) - The URL of the video uploaded in MP4 format.
ogg_url (link) - The URL of the video uploaded in OGG format.
webm_url (link) - The URL of the video uploaded in WEBM format.
muted - true (boolean). A boolean value indicating if the video needs to be started muted. Default is true. The user can unmute the video if required with the help of mute/unmute button.
loop: true (boolean). Specify true or false to whether loop the movie once ended.
preload: none (string). Specify if the HTML5 video needs to be preloaded irrespective of whether the user chooses to play or not. Possible values are auto (preloads entire video when the page loads), metadata (load only metadata when page loads) and none (preload nothing on page load).
autoplay: true (boolean). Specify true or false to automatically play the video once ready.
placeholder_url (link)- URL of the placeholder image to be displayed instead of HTML5 video in mobile devices.
overlay_color - The color of the overlay to be applied on the video.
overlay_opacity - 0.7 (number). 0 to 1 - The opacity of the overlay color.
overlay_pattern (link)- The URL of the image which can act as a pattern displayed on top of the video.
text (string) -  The title text displayed on top of the video when the video is not playing.
subtitle (string) - The subtitle displayed on top of the video when the video is not playing.
button_text (string) - Text of the button shown to the user on top of the video.
button_url (link) - The URL to which the button needs to point to.
*/

function mo_video_section_shortcode($atts, $content = null, $shortcode_name = "") {

    extract(shortcode_atts(
        array(
            'id' => 'video-intro',
            'class' => '',
            'video_id' => 'video-bg1',
            'mp4_url' => '',
            'ogg_url' => '',
            'webm_url' => '',
            'autoplay' => 'true',
            'loop' => 'true',
            'muted' => 'true',
            'preload' => 'none',
            'placeholder_url' => '',
            'placeholder_image_id' => '',
            'subtitle' => '',
            'text' => '',
            'button_text' => '',
            'button_url' => '',
            'overlay_color' => '',
            'overlay_opacity' => '0.7',
            'overlay_pattern' => '',
            'overlay_pattern_id' => ''),
        $atts));

    $output = '';
    if (!empty($mp4_url) || !empty($ogg_url) || !empty($webm_url)) {

        $muted = mo_to_boolean($muted);
        $loop = mo_to_boolean($loop);
        $autoplay = mo_to_boolean($autoplay);

        ob_start(); // Gather output
        ?>
        <div id="<?php echo $id; ?>"
             class="<?php echo str_replace("_", "-", $shortcode_name) . ($class ? ' ' . $class : ''); ?>">

            <div class="video-header">

                <div class="header-content">

                    <?php echo empty($subtitle) ? '' : '<div class="subtitle">' . htmlspecialchars_decode($subtitle) . '</div>'; ?>

                    <?php echo empty($text) ? '' : '<div class="text">' . $text . '</div>'; ?>

                    <?php echo empty($button_text) ? '' : '<a href="' . $button_url . '" class="action-button button transparent"><span>' . $button_text . '</span></a>'; ?>

                </div>

                <?php
                if (!empty($placeholder_image_id))
                    $placeholder_url = wp_get_attachment_url($placeholder_image_id);
                if (!empty($overlay_pattern_id))
                    $overlay_pattern = wp_get_attachment_url($overlay_pattern_id);
                ?>

                <div class="media">
                    <div class="video-bg">
                        <video id=<?php echo $video_id; ?>
                               poster="<?php echo esc_url($placeholder_url); ?>"
                               preload="<?php echo $preload; ?>"
                            <?php echo $autoplay ? 'autoplay' : ''; ?> <?php echo $loop ? 'loop' : ''; ?> <?php echo $muted ? 'muted' : ''; ?>>
                            <source src="<?php echo esc_url($mp4_url); ?>" type="video/mp4">
                            <source src="<?php echo esc_url($ogg_url); ?>" type="video/ogg">
                            <source src="<?php echo esc_url($webm_url); ?>" type="video/webm">
                        </video>
                    </div>
                    <div class="img-bg">
                        <img alt="Video Poster" class="video-placeholder"
                             src="<?php echo esc_url($placeholder_url); ?>"/>
                    </div>
                    <?php

                    if (!empty($overlay_color) || !empty($overlay_pattern)) :

                        $hex = $overlay_color;
                        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");

                        $bg_color = empty($overlay_color) ? "" : "background-color: rgba(" . "$r, $g, $b, $overlay_opacity);";
                        $bg_pattern = empty($overlay_pattern) ? "" : "background-image:url(" . $overlay_pattern . ");";

                        ?>

                        <div class="overlay" style="<?php echo ($bg_color) . ($bg_pattern); ?>"></div>

                    <?php

                    endif;

                    ?>
                </div>

                <div class="video-controls">
                    <button class="small-play-btn" onclick="document.getElementById('<?php echo $video_id; ?>').play()">
                        <i
                            class="icon-play"></i>
                    </button>
                    <button class="small-pause-btn"
                            onclick="document.getElementById('<?php echo $video_id; ?>').pause()"><i
                            class="icon-pause"></i>
                    </button>
                    <button class="small-mute-btn"
                            onclick="mo_toggle_html5_video_volume(document.getElementById('<?php echo $video_id; ?>'))">
                        <i
                            class="icon-volumemute2"></i></button>
                </div>

            </div>

        </div>
        <?php
        // Save output
        $output = ob_get_contents();
        ob_end_clean();
    }
    return $output;
}

add_shortcode('video_showcase', 'mo_video_showcase_shortcode');

add_shortcode('video_section', 'mo_video_section_shortcode');

/* HTML5 Audio Shortcode -

Displays a HTML5 audio clip with controls.

Usage:

[html5_audio ogg_url="http://mydomain.com/song.ogg" mp3_url="http://mydomain.com/song.mp3" ]

Parameters -

ogg_url - The URL of the audio clip uploaded in OGG format.
mp3_url - The URL of the audio clip uploaded in MP3 format.

*/

function mo_html5_audio_shortcode($atts, $content = null, $code = "") {

    extract(shortcode_atts(array('mp3_url' => '', 'ogg_url' => ''), $atts));


    if (!empty($mp3_url) || !empty($ogg_url)) {
        return <<<HTML
<div class="video-box">
<audio controls="controls">
  <source src="{$ogg_url}" type="audio/ogg" />
  <source src="{$mp3_url}" type="audio/mp3" />
  Your browser does not support the HTML5 audio. Do upgrade. 
</audio>
</div>
HTML;
    }
}

add_shortcode('html5_audio', 'mo_html5_audio_shortcode');

/* Video Thumbnail Shortcode -

Displays a image thumbnail for a video with a play button in the center. The play button opens the video in a lightbox.

Usage:

[video_thumbnail image_url="http://mydomain.com/video-thumb.jpg" video_url="http://vimeo.com/81860930"]

Parameters -

image_url - The URL of the image thumbnail.
video_url - The URL of the video that needs to be opened in a lightbox on user pressing the play button.

*/

function mo_video_thumbnail_shortcode($atts, $content = null, $code = "") {

    extract(shortcode_atts(array('image_url' => '', 'video_url' => ''), $atts));


    if (!empty($image_url) || !empty($video_url)) {
        return <<<HTML
<div class="video-thumbnail-wrap">
<a class="video-placeholder" href="{$video_url}" data-gal="prettyPhoto">
<img src="{$image_url}" class="alignone"/>
<div class="video-play-button"></div>
</a>
</div>
HTML;
    }
}

add_shortcode('video_thumbnail', 'mo_video_thumbnail_shortcode');
?>