<?php
/**
 * Advanced Search
 *
 * @package	HelpingHands
 * @author Skat
 * @copyright 2017, Skat Design
 * @link http://www.skat.tf
 * @since HelpingHands 2.0
 */

require_once( get_template_directory() . '/wp-advanced-search/wpas.php' );

if ( ! function_exists( 'sd_sermons_advanced_search_form' ) ) {
	function sd_sermons_advanced_search_form() {
		
		global $sd_data;
		
		$sd_form_args = array();
		
		$results_page_id = ( ! empty( $sd_data['search_sermons_results'] ) ? $sd_data['search_sermons_results'] : '' );

		$sd_form_args['form'] = array( 'action' => get_permalink( $results_page_id )  );
		
		$sd_form_args['wp_query'] = array(
			'post_type' => 'sermons',
			'posts_per_page' => 12,
		);
		
		$sd_form_args['fields'][] = array(
			'type'       => 'taxonomy',
			'taxonomy'   => 'sermon_topics',
			'format'     => 'select',
			'allow_null' => esc_html__( 'Topics', 'sd-framework' ),
			'class'      => array( 'sd-topics-select' ),
		);
		
		$sd_form_args['fields'][] = array(
			'type'     => 'taxonomy',
			'taxonomy' => 'sermon_books',
			'format'   => 'select',
			'allow_null' => esc_html__( 'Books', 'sd-framework' ),
			'class'    => array( 'sd-books-select' ),
		);
		
		$sd_form_args['fields'][] = array(
			'type'     => 'taxonomy',
			'taxonomy' => 'sermon_series',
			'format'   => 'select',
			'allow_null' => esc_html__( 'Series', 'sd-framework' ),
			'class'    => array( 'sd-series-select' ),
		);
		
		$sd_form_args['fields'][] = array(
			'type'     => 'taxonomy',
			'taxonomy' => 'sermon_speakers',
			'format'   => 'select',
			'allow_null' => esc_html__( 'Speakers', 'sd-framework' ),
			'class'    => array( 'sd-speakers-select' ),
		);
		
		$sd_form_args['fields'][] = array(
			'type'     => 'search',
			'format'   => 'text',
			'placeholder' => esc_html__( 'Keywords', 'sd-framework' ),
		);
		
		$sd_form_args['fields'][] = array(
			'type'     => 'submit',
			'value'    => esc_html__( 'FILTER', 'sd-framework' ),
		);
		
		register_wpas_form( 'sd_sermons_search_form', $sd_form_args );
	}
	add_action( 'init', 'sd_sermons_advanced_search_form' );
}
?>