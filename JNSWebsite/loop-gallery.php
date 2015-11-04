<?php

get_header();
?>

    <div id="showcase-template">

        <?php

        $image_size = 'medium';

        $column_count = intval(mo_get_theme_option('mo_gallery_column_count', 3));
        $post_count = intval(mo_get_theme_option('mo_gallery_post_count', 6));
        $layout_mode = mo_get_theme_option('mo_gallery_layout_mode', 'fitRows');
        if ($layout_mode == 'masonry')
            $image_size = 'proportional';

        $args = array(
            'number_of_columns' => $column_count,
            'image_size' => $image_size,
            'posts_per_page' => $post_count,
            'filterable' => false,
            'post_type' => 'gallery_item',
            'layout_mode' => $layout_mode
        );

        mo_display_gallery_content($args);
        ?>

    </div> <!-- #showcase-template -->

<?php

get_sidebar();

get_footer(); // Loads the footer.php template.

?>