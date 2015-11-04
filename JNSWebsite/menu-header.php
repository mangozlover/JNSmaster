<?php
/**
 * Header Menu Template
 *
 * Displays the Header Menu if it has active menu items.
 *
 * @package Invent
 * @subpackage Template
 */

if ( has_nav_menu( 'header' ) ) : ?>

    <nav id="header-menu" class="dropdown-menu-wrap">

        <?php wp_nav_menu( array( 'theme_location' => 'header', 'container' => false, 'menu_class' => 'menu', 'menu_id' => '', 'depth' => 3, 'fallback_cb' => false ) ); ?>

    </nav> <!-- #header-menu -->

<?php endif; ?>