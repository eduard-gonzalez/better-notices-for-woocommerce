<?php
/**
 * Plugin Name: Better Notices for WooCommerce
 * Plugin URI: https://eduardogonzalez.me/better-notices-for-woocommerce/
 * Description: A simple plugin to add a better style to WooCommerce notices implemented with SweetAlert2 for variable products.
 * Version: 1.0.0
 * Author: Efrain Gonzalez
 * Author URI: https://eduardogonzalez.me/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: better-notices-for-woocommerce
 * Domain Path: /languages
 */

defined('WPINC') || define('WPINC', 'wp-includes');

/* Activate */
register_activation_hook(__FILE__, 'bnwc_activate');
function bnwc_activate()
{
    if (!is_plugin_active('woocommerce/woocommerce.php')) {
        wp_die(
            esc_html__('Better Notices for WooCommerce requires WooCommerce to be installed and active.', 'better-notices-for-woocommerce')
        );
    }
}

/* Deactivate */
register_deactivation_hook(__FILE__, 'bnwc_deactivate');
function bnwc_deactivate()
{
    if (!is_plugin_active('woocommerce/woocommerce.php')) {
        wp_die(
            esc_html__('Better Notices for WooCommerce has been deactivated.', 'better-notices-for-woocommerce')
        );
    }
}

/* Uninstall and flush cache */
register_uninstall_hook(__FILE__, 'bnwc_uninstall');
function bnwc_uninstall()
{
    if (!is_plugin_active('woocommerce/woocommerce.php')) {
        wp_die(
            esc_html__('Better Notices for WooCommerce has been uninstalled.', 'better-notices-for-woocommerce')
        );
        /* Flush cache */
        wp_cache_flush();
    }
}

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('wp_enqueue_scripts', 'bnwc_enqueue_scripts');

    /**
     * Add scripts and styles
     */
    function bnwc_enqueue_scripts()
    {
        if (!wp_script_is('sweetalert2', 'enqueued')) {
            wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@9', array('jquery'), '9.0.0', true);
        }
        wp_enqueue_script('bnwc', plugin_dir_url(__FILE__) . 'assets/bnwc-js-public.js', array('jquery'), '1.0.0', true);
    }
} else {
    add_action('admin_notices', 'bnwc_admin_notice');

    /**
     * Validate if WooCommerce is installed and active
     */
    function bnwc_admin_notice()
    {
        printf(
            '<div class="notice notice-error is-dismissible"><p>%s</p></div>',
            esc_html__('Better Notices for WooCommerce requires WooCommerce to be installed and active.', 'better-notices-for-woocommerce')
        );
    }
}
