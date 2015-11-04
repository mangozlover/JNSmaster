<?php
/**
 * Template Name: Portfolio
 *
 * A custom page template for displaying portfolio items
 *
 * @package Invent
 * @subpackage Template
 */
if (!current_theme_supports('portfolio')) {
    return new WP_Error('no_portfolio_support', __('This theme does not support portfolio templates', 'mo_theme'));
}

get_template_part('loop', 'portfolio');