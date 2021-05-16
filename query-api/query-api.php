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
			echo '<pre>';
			$error_message = $response->get_error_message();
			var_dump( "Something went wrong: $error_message" );
			echo '</pre>';
		} else {
			$valid_response = wp_remote_retrieve_body( $response );
		}
		
		$output .= "<div class='container-fluid thumbnail-container'>";
		$output .= "<div class='row display-flex'>";
		$response_objects = json_decode($valid_response, true);
		$response_objects_count = count($response_objects);
		for ($response_item = 0; $response_item < $response_objects_count; $response_item++) {
			$output .= "<div class='col-md-4'>\n
							<div class='thumbnail'>\n
								<img class='img-responsive' src='".$response_objects[$response_item]["featured_image"]."' >\n
								<div class='caption'>\n
									<h2>".$response_objects[$response_item]["title"]."</h2>
									<p>".$response_objects[$response_item]["excerpt"]."</p>\n
								</div>
							</div>
						</div>";
		}
		$output .= "</div>";
		$output .= "</div>";
		
		
		return $output;
		
	}

	add_shortcode('shortcode', 'query_shortcode_function');

	function include_scripts(){
		wp_enqueue_style( 'query_api_style',  plugin_dir_url( __FILE__ ) . 'includes/css/style.css' );
		wp_enqueue_style( 'query_api_bootstrap',  plugin_dir_url( __FILE__ ) . 'includes/css/bootstrap.min.css' );
	}

	add_action('wp_enqueue_scripts', 'include_scripts');

?>