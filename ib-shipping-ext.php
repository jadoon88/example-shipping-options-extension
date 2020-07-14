<?php
/**
 * Plugin Name: IB Shipping Extension
 * Plugin URI: https://github.com/jadoon88
 * Description: Adds 'Carrier ID' field in 'Free' and 'Flat Rate' shipping methods.
 * Version: 1.0
 * Author: Umair Khan Jadoon
 * Author URI: https://github.com/jadoon88
 * Developer: Umair Khan Jadoon
 * Developer URI: https://github.com/jadoon88
 * Text Domain: ib-shipping-ext
 * Domain Path: /languages
 *
 *
 * Copyright: © 2020-2020 Umair Khan Jadoon.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


 if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

include plugin_dir_path(__FILE__).'classes/basic.php';

//Plugin will only inititate if WooCommerce is installed...
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    add_action( 'init', 'ib_shipping_ext_init' );
}

function ib_shipping_ext_init()
{
    $basic=new IBShippingExt\Basic();
}
