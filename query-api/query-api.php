<?php
/**
 * Plugin name: Semantica Query API
 * Plugin URI: https://github.com/Evan031/project-api
 * Description: Get information from external APIs in WordPress
 * Version: 1.0
 * Author: Evan Taylor
 * Author URI: https://evan031.github.io/Portfolio/
 */

	// If this file is access directly, abort!!!
	defined( 'ABSPATH' ) or die( 'Unauthorized Access' );

	function techiepress_get_send_data() {

		$url = 'https://jsonplaceholder.typicode.com/users';
		
		$arguments = array(
			'method' => 'GET'
		);

		$response = wp_remote_get( $url, $arguments );

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			return "Something went wrong: $error_message";
		} else {
			echo '<pre>';
			var_dump( wp_remote_retrieve_body( $response ) );
			echo '</pre>';
		}
	}

	function query_shortcode_function() {
		$url = 'https://www.bohemio.co.za/wp-json/randomposts/posts';
		
		$arguments = array(
			'method' => 'GET'
		);

		$response = wp_remote_get( $url, $arguments );

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			return "Something went wrong: $error_message";
		} else {
			echo '<pre>';
			$valid_response = wp_remote_retrieve_body( $response );
			var_dump( $valid_response );
			echo '</pre>';
		}
		
		$decode_response = var_dump(json_decode($valid_response, true));
		
		return $decode_response;
	}

	add_shortcode('shortcode', 'query_shortcode_function');

	function include_scripts(){
		wp_register_style( 'my_css',  plugin_dir_url( __FILE__ ) . 'includes/css/style.css' );
		wp_enqueue_style( 'my_css' );
	}

	add_action('wp_enqueue_scripts', 'include_scripts');

?>