<?php
/**
 * Footer Menu Template
 *
 * Displays the Footer Menu if it has active menu items.
 *
 * @package Invent
 * @subpackage Template
 */

if (has_nav_menu('footer')) : ?>

    <nav id="menu-footer" class="single-depth-menu">

        <?php wp_nav_menu(array(
            'theme_location' => 'footer',
            'container_class' => 'menu',
            'menu_class' => '',
            'menu_id' => 'menu-footer-items',
            'depth' => 1,
            'fallback_cb' => false
        )); ?>

    </nav><!-- #menu-footer -->

<?php endif; ?>