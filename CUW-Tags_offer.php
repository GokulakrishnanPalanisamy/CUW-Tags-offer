<?php
/**
 * Plugin Name:          Tag offer in Checkout Upsell
 * Plugin URI:           https://www.flycart.org/products/wordpress/upsell-order-bump-for-woocommerce
 * Description:          Adding Tag Offers in Checkout Upsell
 * Version:              1.3.0
 * Requires at least:    5.3
 * Requires PHP:         5.6
 * Author:               Flycart
 * Author URI:           https://www.flycart.org
 * Text Domain:          checkout-upsell-woocommerce
 * Domain Path:          /i18n/languages
 * License:              GPL v3 or later
 * License URI:          https://www.gnu.org/licenses/gpl-3.0.html
 * WC requires at least: 4.2
 * WC tested up to:      7.8
 */

defined('ABSPATH') || exit;
use CUW\App\Controllers\Controller;

function CUTO_checkPlugin() {
    add_filter('cuw_conditions',function($conditions){
        require 'CUW_tag.php';
        $conditions['tags'] = array(
            'name' => __("Tags of Items in the cart", 'checkout-upsell-woocommerce'),
            'group' => __("Cart", 'checkout-upsell-woocommerce'),
            'handler' => new CUW_tag(),
            'campaigns' => ['pre_purchase', 'post_purchase'],
        );
        return $conditions;
    });
}
add_action( 'cuw_after_init', 'CUTO_checkPlugin' );



    add_filter('cuw_ajax_auth_request_handlers',function($con){
        return array_merge($con,['list_tags'=>function(){
            $query = CUW\App\Controllers\Controller::app()->input->get('query', '', 'post');
            $tag_list=get_terms( array(
                'taxonomy' => 'product_tag',
                'hide_empty' => false,
            ) );
            return array_map(function ($tag) {
                return [
                    'id' => (string) $tag->term_id,
                    'text' => $tag->name,
                ];
            }, $tag_list);
        }]);
    });





