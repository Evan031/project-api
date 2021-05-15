<?php
/**
 * Plugin Name: Semantica Project API
 * Plugin URI: https://github.com/Evan031/project-api
 * Description: Semantica Project API Plugin
 * Version: 1.0
 * Author: Evan Taylor
 * Author URI: https://evan031.github.io/Portfolio/
 */


function random_posts() {
	$args = [
		'numberposts' => 3,
		'post_type' => 'post',
		'orderby' => 'rand',
	];

	$posts = get_posts($args);

	$data = [];
	$i = 0;

	foreach($posts as $post) {
		$data[$i]['id'] = $post->ID;
		$data[$i]['title'] = $post->post_title;
		$data[$i]['excerpt'] = $post->post_excerpt;	
		$data[$i]['featured_image']['large'] = get_the_post_thumbnail_url($post->ID, 'large');
		$i++;
	}

	return $data;
}

add_action('rest_api_init', function() {
	register_rest_route('randomposts', 'posts', [
		'methods' => 'GET',
		'callback' => 'random_posts',
	]);

});
