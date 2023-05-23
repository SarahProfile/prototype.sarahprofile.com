<?php
/*
Plugin name: ELEX WooCommerce Product Price Custom Text (Before & After Text) and Discount
Plugin URI: https://elextensions.com/plugin
Description: The plugin simplifies the task to add a text before and after the product price both globally and individually.It also allows you to apply a quick discount for your products.
Version: 2.0.6
WC requires at least: 2.6.0
WC tested up to: 7.4
Author: ELEXtensions
Author URI: https://elextensions.com/
Text Domain: elex-product-price-custom-text-and-discount
*/

// to check whether accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * To check whether woocommerce is activated
 *
 * @since 1.0.0
*/
if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once  ABSPATH . 'wp-admin/includes/plugin.php';
}
if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	deactivate_plugins( plugin_basename( __FILE__ ) );
	wp_die( '<b>WooCommerce</b> plugin must be active for <b>WooCommerce Product Price Custom Text & Discount (BASIC)</b> to work.' );
}

// review component
if ( ! function_exists( 'get_plugin_data' ) ) {
	require_once  ABSPATH . 'wp-admin/includes/plugin.php';
}
include_once __DIR__ . '/review_and_troubleshoot_notify/review-and-troubleshoot-notify-class.php';
$data                      = get_plugin_data( __FILE__ );
$data['name']              = $data['Name'];
$data['basename']          = plugin_basename( __FILE__ );
$data['rating_url']        = 'https://elextensions.com/plugin/elex-woocommerce-product-price-custom-text-before-after-text-and-discount-plugin-free/#reviews';
$data['documentation_url'] = 'https://elextensions.com/knowledge-base/how-to-set-up-elex-woocommerce-product-price-custom-text-before-after-text-and-discount-plugin/';
$data['support_url']       = 'https://wordpress.org/support/plugin/elex-product-price-custom-text-before-after-text-and-discount-for-woocommerce/';

new \Elex_Review_Components( $data );

//Loading css files(for admin pages)
add_action( 'admin_enqueue_scripts', 'elex_ppct_load_assets_admin' );
function elex_ppct_load_assets_admin() {
	wp_enqueue_style( 'elex_ppct_plugin_styles' , plugin_dir_url( __FILE__ ) . 'resources/admin-css/admin.css', '1.0.0', 'all' );
}

if ( ! defined( 'ELEX_PPCT_IMG_PATH' ) ) {
	define( 'ELEX_PPCT_IMG_PATH', plugin_dir_url( __FILE__ ) . 'resources/' );
}
//setting link for plugin
function elex_ppct_plugin_action_links( $links ) {
	$links = array_merge(
		array(
			'<a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=elex_ppct_discount' ) ) . '">' . __( 'Settings', 'elex-product-price-custom-text-and-discount' ) . '</a>',
			'<a href="https://elextensions.com/product-category/plugins/" target="_blank">' . __( 'ELEX Premium Plugins', 'elex-product-price-custom-text-and-discount' ) . '</a>',
		),
		$links
	);
	return $links;
}
add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'elex_ppct_plugin_action_links' );

//submenu in woocommerce
add_action( 'admin_menu', 'elex_ppct_discount_submenu_page' );
function elex_ppct_discount_submenu_page() {
	add_submenu_page( 'woocommerce', 'Product Price Custom Text & Discount', 'Product Price Custom Text & Discount', 'manage_options', 'admin.php?page=wc-settings&tab=elex_ppct_discount' );
}

require 'includes/elex-ppct-discount-woocommerce-setting.php';
require 'includes/elex-ppct-woocmmerce-variation-settings.php';

// elex_ppct_discount
function elex_ppct_discount( $price, $discount, $type ) {
	if ( 'amount' == $type && is_numeric( $price ) ) {
		$price = ( $price - ( ( float ) $discount ) );
	}
	if ( 'percent' == $type && is_numeric( $price ) ) {
		$price = ( $price - ( $price * ( ( float ) $discount / 100 ) ) );
	}
	return $price;
}

//fetch data from db
function elex_ppct_discount_product( $price, $product ) {

	if ( $product->is_type( 'variation' ) ) {
		$product_id   = $product->get_parent_id();
		$variation_id = $product->get_id();
	} else {
		$product_id = $product->get_id();
	}
	$custom_check_enable      = get_post_meta( $product_id, 'elex_ppct_custom_fields_checkbox', true );
	$check_enable             = get_option( 'elex_ppct_check_field' );
	$custom_discount_checkbox = get_post_meta( $product_id, 'elex_ppct_custom_fields_discount_type_checkbox' , true );
	$selected_categories      = get_option( 'elex_ppct_categories' );

	$categories = get_the_terms( $product_id, 'product_cat' );
	if ( false === $categories ) {
		$categories = array();
	}
	$category_id = array();

	foreach ( $categories as $category ) {
		$category_id[] = $category->term_id;
	}

	if ( ! empty( $variation_id ) ) {
		$variation_discount_checkbox = get_post_meta( $variation_id, 'elex_ppct_variation_use_discount_post_meta', true );
		$use_custom_text_variation = get_post_meta( $variation_id, 'elex_ppct_variation_use_custom_text_plugin', true );
		if ( ( 'yes' === $use_custom_text_variation ) && ( 'yes' === $variation_discount_checkbox ) ) {
			$_discount = get_post_meta( $variation_id, 'elex_ppct_discount_amount', true );  
			$_discount = ( float ) $_discount;
			$_option   = get_post_meta( $variation_id, 'elex_ppct_discount_type', true );
	
			$price = elex_ppct_discount( $price, $_discount, $_option );
	
			return $price;
		} 
	}

	if ( ( 'yes' === $custom_check_enable ) && ( 'yes' === $custom_discount_checkbox ) ) {
		$_discount = get_post_meta( $product_id, 'elex_ppct_discount_amount', true );  
		$_discount = ( float ) $_discount;
		$_option   = get_post_meta( $product_id, 'elex_ppct_discount_type', true );

		$price = elex_ppct_discount( $price, $_discount, $_option );

		return $price;
	} elseif ( ( 'yes' === $check_enable ) && ( 'no' === $custom_check_enable ) && ( count( array_intersect( $category_id, $selected_categories ) ) > 0 ) ) {
		$discount_ = get_option( 'elex_ppct_discount_amount' );
		$discount_ = ( float ) $discount_;
		$option    = get_option( 'elex_ppct_discount_type' );

		$price = elex_ppct_discount( $price, $discount_, $option );

		return $price;
	} else {
		return $price;
	}
}


//for simple product price
add_filter( 'woocommerce_product_get_price', 'elex_ppct_discount_product', 8, 2 );

// for variable product each variation price.
add_filter( 'woocommerce_product_variation_get_price', 'elex_ppct_discount_product', 8, 2 );

// to get the base price of the product.
function elex_ppct_base_price( $product ) {
	remove_filter( 'woocommerce_product_get_regular_price', 'elex_ppct_discount_product', 8, 2 );
	remove_filter( 'woocommerce_product_get_price', 'elex_ppct_discount_product', 8, 2 );

	remove_filter( 'woocommerce_product_variation_get_regular_price', 'elex_ppct_discount_product', 8, 2 );
	remove_filter( 'woocommerce_product_variation_get_price', 'elex_ppct_discount_product', 8, 2 );

	$base_price = $product->get_regular_price();
	// for simple product price.
	add_filter( 'woocommerce_product_get_regular_price', 'elex_ppct_discount_product', 8, 2 );
	add_filter( 'woocommerce_product_get_price', 'elex_ppct_discount_product', 8, 2 );

	// for variable product each variation price.
	add_filter( 'woocommerce_product_variation_get_regular_price', 'elex_ppct_discount_product', 8, 2 );
	add_filter( 'woocommerce_product_variation_get_price', 'elex_ppct_discount_product', 8, 2 );

	return $base_price;
}

function elex_ppct_get_price_to_display( $price, $product ) {
	$global_check_field = get_option( 'elex_ppct_check_field' );

	$base_price = elex_ppct_base_price( $product );
	if ( $product->is_on_sale() ) {
		$price = wc_format_sale_price( $base_price, wc_get_price_to_display( $product ) );
	} elseif ( $product->get_regular_price() != $base_price ) {
		$price = wc_format_sale_price( $base_price, $product->get_price() );
	}
	return $price;
}

function elex_ppct_display_price( $price, $product ) {
	
	if ( $product->is_type( 'variation' ) ) {
		$product_id = $product->get_parent_id();
		$variation_id = $product->get_id();
	} else {
		$product_id = $product->get_id();
	}
	if ( ! $product->is_type( 'variable' ) ) {
		$price = elex_ppct_get_price_to_display( $price, $product );
	}
	$categories = get_the_terms( $product_id, 'product_cat' );
	$category_id = array();

	foreach ( $categories as $category ) {
		$category_id[] = $category->term_id;
	}

	$selected_categories = get_option( 'elex_ppct_categories' );
	$custom_check_enable = get_post_meta( $product_id, 'elex_ppct_custom_fields_checkbox', true );
	$check_enable = get_option( 'elex_ppct_check_field' );
	if ( ! empty( $variation_id ) ) {
		$use_custom_text_variation = get_post_meta( $variation_id, 'elex_ppct_variation_use_custom_text_plugin', true );
		$global_prefix = get_option( 'elex_ppct_prefix_field' );
		$global_suffix = get_option( 'elex_ppct_suffix_field' );
		if ( 'yes' == $check_enable && ( 'yes' != $custom_check_enable ) && ( 'yes' != $use_custom_text_variation ) && ( count( array_intersect( $category_id, $selected_categories ) ) > 0 ) ) {
			$price = $global_prefix . ' ' . $price . ' ' . $global_suffix;
			return $price;
		}
	}

	if ( ( ! empty( $variation_id ) && ( 'yes' == $use_custom_text_variation ) ) ) {
		$use_prefix_variation    = get_post_meta( $variation_id, 'elex_ppct_variation_use_prefix_post_meta', true );
		$use_suffix_variation    = get_post_meta( $variation_id, 'elex_ppct_variation_use_suffix_post_meta', true );
		$add_prefix              = get_post_meta( $variation_id, 'elex_ppct_variation_add_prefix', true );
		$custom_variation_prefix = get_price_before_text_html( $add_prefix );
		$add_suffix              = get_post_meta( $variation_id, 'elex_ppct_variation_add_suffix', true );
		$custom_variation_suffix = get_price_after_text_html( $add_suffix ); 

		if ( 'yes' === $use_prefix_variation ) {
			$price = $custom_variation_prefix . ' ' . $price;
		}
		if ( 'yes' === $use_suffix_variation ) {
			$price = $price . ' ' . $custom_variation_suffix;
		}

		return $price;

	} elseif ( ( 'yes' === $custom_check_enable ) && ! empty( $price ) && ( empty( $use_custom_text_variation ) || 'no' == $use_custom_text_variation ) ) {
		$prefix_checkbox        = get_post_meta( $product_id, 'elex_ppct_custom_fields_prefix_checkbox', true );
		$suffix_checkbox        = get_post_meta( $product_id, 'elex_ppct_custom_fields_suffix_checkbox', true );

		$price_before_text      = get_post_meta( $product_id, 'elex_ppct_custom_fields_prefix', true );
		$price_after_text       = get_post_meta( $product_id, 'elex_ppct_custom_fields_suffix', true );
		$price_before_text_html = get_price_before_text_html( $price_before_text );
		$price_after_text_html  = get_price_after_text_html( $price_after_text );
		if ( ( 'yes' == $suffix_checkbox ) && ( empty( $prefix_checkbox ) || 'no' == $prefix_checkbox ) ) {
			$price = $price . ' ' . $price_after_text_html;
		} elseif ( ( empty( $suffix_checkbox ) || 'no' == $suffix_checkbox ) && ( 'yes' == $prefix_checkbox ) ) {
			$price = $price_before_text_html . ' ' . $price;
		} elseif ( ( 'yes' == $prefix_checkbox ) && ( 'yes' == $suffix_checkbox ) ) {
			$price = $price_before_text_html . ' ' . $price . ' ' . $price_after_text_html;
		}
		return $price;
	} elseif ( ( 'yes' === $check_enable && ( empty( $custom_check_enable ) || 'no' === $custom_check_enable ) ) && ! empty( $price ) ) {

		$price_before_text = get_option( 'elex_ppct_prefix_field' );
		$price_after_text  = get_option( 'elex_ppct_suffix_field' );

		$price_before_text_html = get_price_before_text_html( $price_before_text );
		$price_after_text_html  = get_price_after_text_html( $price_after_text );
		if ( count( array_intersect( $category_id, $selected_categories ) ) > 0 ) {
			$price = $price_before_text_html . ' ' . $price . ' ' . $price_after_text_html;
		}
		return $price;
	} else {
		return $price;
	}
}

function get_price_before_text_html( $price_before_text ) {
	if ( ! empty( $price_before_text ) ) {
		$price_before_text = elex_ppct_return_wpml_string( $price_before_text , 'Prefix text - Product' );
		return '<span class="elex-ppct-before-text">' . $price_before_text . '</span>';
	} else {
		return $price_before_text;
	}
}

function get_price_after_text_html( $price_after_text ) {
	if ( ! empty( $price_after_text ) ) {
		$price_after_text = elex_ppct_return_wpml_string( $price_after_text , 'Suffix text - Product' );
		return '<span class="elex-ppct-after-text">' . $price_after_text . '</span>';
	} else {
		return $price_after_text;
	}
}
add_filter( 'woocommerce_get_price_html', 'elex_ppct_display_price', 999, 2 );

add_filter( 'woocommerce_variable_price_html', 'elex_variation_price_format', 999, 2 );

function elex_ppct_return_wpml_string( $string_to_translate, $name ) {
	// https://wpml.org/documentation/support/wpml-coding-api/wpml-hooks-reference/#hook-620585
	// https://wpml.org/documentation/support/wpml-coding-api/wpml-hooks-reference/#hook-620618
	$package = array(
		'kind' => 'Elex Product Price Custom Text and Discount',
		'name' => 'elex-product-price-custom-text-and-discount',
		'title' => $name,
		'edit_link' => '',
	);
	/**
	 * To register the string in wpml
	 *
	 * @since 1.1.6
	 */
	do_action( 'wpml_register_string', $string_to_translate, $name, $package, $name, 'LINE' );
	/**
	 * To translate string using wpml
	 *
	 * @since 1.1.6
	 */
	$ret_string = apply_filters( 'wpml_translate_string', $string_to_translate, $name, $package );
	return $ret_string;
}
// for variable price range
function elex_variation_price_format( $price, $product ) {
	// Get min/max regular and sale variation prices
	if ( $product->is_type( 'variable' ) ) {
		$prices = $product->get_variation_prices( true );
		if ( empty( $prices['price'] ) ) {
			return $price;
		}
		foreach ( $prices['price'] as $pid => $old_price ) {
			$pobj                    = wc_get_product( $pid );
			$prices['price'][ $pid ] = wc_get_price_to_display( $pobj );
		}
		asort( $prices['price'] );
		asort( $prices['regular_price'] );
		$min_price = current( $prices['price'] );
		$max_price = end( $prices['price'] );
		if ( $min_price !== $max_price ) {
			$price = wc_format_price_range( $min_price, $max_price ) . $product->get_price_suffix();
		}
	}
	return $price;
}

/** Load Plugin Text Domain. */
function elex_ppct_load_plugin_textdomain() {
	load_plugin_textdomain( 'elex-product-price-custom-text-and-discount', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
}
add_action( 'plugins_loaded', 'elex_ppct_load_plugin_textdomain' );
add_action( 'admin_init', 'elex_plugin_active' );

function elex_plugin_active() {
	$has_migration = get_option( 'elex_ppct_migration' );   
	if ( '2' === $has_migration || 2 === $has_migration ) {
		return;
	}
	$amount  = get_option( 'elex_ppct_discount_amount' );
	$percent = get_option( 'elex_ppct_discount_percent' );
	if ( intval( $amount ) > 0 ) {
		add_option( 'elex_ppct_discount_type', 'amount' );
	} else {
		add_option( 'elex_ppct_discount_type', 'percent' );
		update_option( 'elex_ppct_discount_amount', $percent );
	}
	delete_option( 'elex_ppct_discount_percent' );

	if ( ( empty( get_option( 'elex_ppct_check_field' ) ) ) || ( empty( get_option( 'elex_ppct_categories' ) ) ) ) {
		$args = array(
			'taxonomy' => 'product_cat',
			'fields ' => 'ids',
			'get' => 'all',
		);
		$all_categories = get_categories( $args );
		foreach ( $all_categories as $all_category ) {
			$all_category_ids[] = $all_category->term_id;
		}
		update_option( 'elex_ppct_select_all_categories_id', 'yes' );
		update_option( 'elex_ppct_categories', $all_category_ids );
	}

	global $wpdb;

	$wpdb->query( "INSERT INTO {$wpdb->prefix}postmeta(post_id,meta_key,meta_value) SELECT post_id,'elex_ppct_custom_fields_prefix_checkbox','yes' FROM {$wpdb->prefix}postmeta WHERE meta_key='elex_ppct_custom_fields_prefix' AND meta_value != ''" );
	$wpdb->query( "INSERT INTO {$wpdb->prefix}postmeta(post_id,meta_key,meta_value) SELECT post_id,'elex_ppct_custom_fields_suffix_checkbox','yes' FROM {$wpdb->prefix}postmeta WHERE meta_key='elex_ppct_custom_fields_suffix' AND meta_value != ''" );
	$wpdb->query( "INSERT INTO {$wpdb->prefix}postmeta(post_id,meta_key,meta_value) SELECT post_id,'elex_ppct_custom_fields_discount_type_checkbox','yes' FROM {$wpdb->prefix}postmeta WHERE meta_key='elex_ppct_discount_amount' AND meta_value != ''" );

	// For use custom text for variations
	$wpdb->query( "INSERT INTO {$wpdb->prefix}postmeta(post_id,meta_key,meta_value) SELECT post_id,'elex_ppct_variation_use_custom_text_plugin','yes' FROM {$wpdb->prefix}postmeta WHERE meta_key='elex_ppct_variation_add_prefix' AND meta_value != ''" );
	$wpdb->query( "INSERT INTO {$wpdb->prefix}postmeta(post_id,meta_key,meta_value) SELECT post_id,'elex_ppct_variation_use_custom_text_plugin','yes' FROM {$wpdb->prefix}postmeta WHERE meta_key='elex_ppct_variation_add_suffix' AND meta_value != ''" );
	$wpdb->query( "INSERT INTO {$wpdb->prefix}postmeta(post_id,meta_key,meta_value) SELECT post_id,'elex_ppct_variation_use_custom_text_plugin','yes' FROM {$wpdb->prefix}postmeta WHERE meta_key='elex_ppct_discount_amount' AND meta_value != ''" );

	$wpdb->query( "INSERT INTO {$wpdb->prefix}postmeta(post_id,meta_key,meta_value) SELECT post_id,'elex_ppct_variation_use_prefix_post_meta','yes' FROM {$wpdb->prefix}postmeta WHERE meta_key='elex_ppct_variation_add_prefix' AND meta_value != ''" );
	$wpdb->query( "INSERT INTO {$wpdb->prefix}postmeta(post_id,meta_key,meta_value) SELECT post_id,'elex_ppct_variation_use_suffix_post_meta','yes' FROM {$wpdb->prefix}postmeta WHERE meta_key='elex_ppct_variation_add_suffix' AND meta_value != ''" );
	$wpdb->query( "INSERT INTO {$wpdb->prefix}postmeta(post_id,meta_key,meta_value) SELECT post_id,'elex_ppct_variation_use_discount_post_meta','yes' FROM {$wpdb->prefix}postmeta WHERE meta_key='elex_ppct_discount_amount' AND meta_value != ''" );

	$wpdb->query( "INSERT INTO  {$wpdb->prefix}postmeta(post_id,meta_key,meta_value) SELECT post_id,'elex_ppct_discount_type','amount' FROM {$wpdb->prefix}postmeta WHERE meta_key='elex_ppct_custom_fields_discount_amount' AND meta_value>0" );
	$wpdb->query( "UPDATE  {$wpdb->prefix}postmeta SET meta_key='elex_ppct_discount_amount' WHERE meta_key='elex_ppct_custom_fields_discount_amount' AND meta_value>0" );

	$wpdb->query( "INSERT INTO {$wpdb->prefix}postmeta(post_id,meta_key,meta_value) SELECT post_id,'elex_ppct_discount_type','percent' FROM {$wpdb->prefix}postmeta WHERE meta_key='elex_ppct_custom_fields_discount_percent' AND meta_value>0" );
	$wpdb->query( "UPDATE {$wpdb->prefix}postmeta SET meta_key='elex_ppct_discount_amount' WHERE meta_key='elex_ppct_custom_fields_discount_percent' AND meta_value>0" );

	$wpdb->query( "INSERT INTO {$wpdb->prefix}postmeta(post_id,meta_key,meta_value) SELECT post_id,'elex_ppct_discount_type','amount' FROM {$wpdb->prefix}postmeta WHERE meta_key='elex_ppct_variation_discount_amount' AND meta_value>0" );
	$wpdb->query( "UPDATE  {$wpdb->prefix}postmeta SET meta_key='elex_ppct_discount_amount' WHERE meta_key='elex_ppct_variation_discount_amount' AND meta_value>0" );

	$wpdb->query( "INSERT INTO {$wpdb->prefix}postmeta(post_id,meta_key,meta_value) SELECT post_id,'elex_ppct_discount_type','percent' FROM {$wpdb->prefix}postmeta WHERE meta_key='elex_ppct_variation_discount_percent' AND meta_value>0" );
	$wpdb->query( "UPDATE  {$wpdb->prefix}postmeta SET meta_key='elex_ppct_discount_amount' WHERE meta_key='elex_ppct_variation_discount_percent' AND meta_value>0" );

	$wpdb->query( "DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key IN ('elex_ppct_custom_fields_discount_amount', 'elex_ppct_custom_fields_discount_percent','elex_ppct_variation_discount_amount','elex_ppct_variation_discount_percent')" );

	update_option( 'elex_ppct_migration', 2 );
}
