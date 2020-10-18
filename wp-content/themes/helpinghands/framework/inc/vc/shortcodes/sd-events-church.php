<?php
/**
 * Latest Church Events VC Shortcode
 *
 * @package	HelpingHands
 * @author Skat
 * @copyright 2017, Skat Design
 * @link http://www.skat.tf
 * @since HelpingHands 2.0
 * @version 1.0
 */

if ( ! function_exists( 'sd_latest_events_church' ) ) {
	function sd_latest_events_church( $atts ) {
		$sd = shortcode_atts( array(
			'style' => '1',
			'cats'  => '',
			'items' => '2',
		), $atts );
		
		$style  = $sd['style'];
		$cats   = $sd['cats'];
		$items  = $sd['items'];
		
		if ( ! empty( $cats ) ) {
			$cats = explode( ", ", ", $cats  " );
		}
		
		$today = current_time( 'timestamp' );
		
		$args = array(
			'post_type'           => 'events',
			'posts_per_page'      => $items,
			'ignore_sticky_posts' => 1,
			'post_status'         => 'publish',
			'meta_key'            => 'sd_dov',
			'meta_value'          => $today,
			'meta_compare'        => '>=',
			'orderby'             => 'meta_value',
			'order'               => 'ASC',
			'tax_query' => array(
				array(
					'taxonomy' => 'event_category',
					'field'    => 'term_id',
					'terms'    => $cats,
				),
			),
		);
		
		if ( empty( $cats ) ) {
			unset( $args['tax_query'] );
		}
		
		$sd_query = new WP_Query( $args );
		
		$items = $sd_query->post_count;

	
		ob_start();
		?>
			<div class="<?php if ( $style == '2' ) echo 'row'; ?> sd-events-church">
				<?php if ( $sd_query->have_posts() ) : while ( $sd_query->have_posts() ) : $sd_query->the_post();?>
				<?php 
					$dov        = rwmb_meta( 'sd_dov' );
					$sd_ev_addr = rwmb_meta( 'sd_event_address' );
					$sd_ev_city = rwmb_meta( 'sd_event_city' );
				?>
					
						<?php if ( $style == '1' ) : ?>
							<div class="col-md-6 sd-church-event-style1">
								<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
								<span class="sd-dov">
									<i class="fa fa-calendar"></i> <?php echo date_i18n( get_option( 'date_format' ), $dov );  ?> <?php echo _x( 'at', 'refering to time', 'sd-framework' ); ?> <?php echo gmdate( get_option( 'time_format' ), $dov ); ?>
								</span>
								<?php if ( ! empty( $sd_ev_city ) ) : ?>
									<span class="sd-event-city"><i class="fa fa-map-marker"></i> <?php echo $sd_ev_city; ?></span>
								<?php endif; ?>
							</div>
		
		
						<?php else : ?>
							
							<div class="col-md-12 sd-church-event-style2">
								<div class="col-md-4">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="sd-event-thumb">
										<figure>
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'sd-events-church' ); ?></a>
										</figure>
										<div class="sd-ev-date"> 
											<span class="sd-ev-day"><?php echo date_i18n( 'd', $dov );  ?></span>
											<span class="ev-month"><?php echo date_i18n( 'M', $dov );  ?></span>
											<span class="ev-year"><?php echo date_i18n( 'Y', $dov );  ?></span>
										</div>
										<!-- sd-ev-date -->
									</div>
								<?php endif; ?>
								</div>
								<!-- col-md-4 -->
								
								<div class="col-md-5">
									<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
									<span class="sd-dov">
										<i class="fa fa-clock-o"></i> <?php echo gmdate( get_option( 'time_format' ), $dov ); ?>
									</span>
									<?php if ( ! empty( $sd_ev_city ) ) : ?>
										<span class="sd-event-city"><i class="fa fa-map-marker"></i> <?php echo $sd_ev_city; ?></span>
									<?php endif; ?>
									<p><?php echo substr( get_the_excerpt(), 0, 80 ) . '...'; ?></p>
								</div>
								<!-- col-md-4 -->
								
								<div class="col-md-3 sd-center">
									<a class="sd-more sd-link-trans" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e( 'REGISTER', 'sd-framework' ); ?></a>
								</div>
								
							</div>
							<!-- col-md-12 -->
							
							
						<?php endif; ?>
				<?php endwhile; endif;  wp_reset_postdata(); ?>
			</div>
			<!-- row -->
			
		<?php return ob_get_clean();	
	}
	add_shortcode( 'sd_latest_events_church','sd_latest_events_church' );
}

// Register shortcode to VC

add_action( 'init', 'sd_latest_events_church_vcmap' );

if ( ! function_exists( 'sd_latest_events_church_vcmap' ) ) {
	function sd_latest_events_church_vcmap() {
		vc_map( array(
			'name'              => __( 'Church Latest Events', 'sd-framework' ),
			'description'       => __( 'Church Latest event items', 'sd-framework' ),
			'base'              => "sd_latest_events_church",
			'class'             => "sd_latest_events_church",
			'category'          => __( 'Helping Hands Church', 'sd-framework' ),
			'icon'              => "icon-wpb-sd-events",
			'admin_enqueue_css' => get_template_directory_uri() . '/framework/inc/vc/assets/css/sd-vc-admin-styles.css',
			'front_enqueue_css' => get_template_directory_uri() . '/framework/inc/vc/assets/css/sd-vc-admin-styles.css',
			'params'            => array(
				array(
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => __( 'Style', 'sd-framework' ),
					'param_name'  => 'style',
					'value'       => array( 
										__( 'Style 1 (grid)', 'sd-framework' )    => '1',
										__( 'Style 2 (list)', 'sd-framework' )    => '2',
									 ),
					'save_always' => true,
					'std'         => '1',
					'description' => __( 'Select the style layout.', 'sd-framework' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => __( 'Categories', 'sd-framework' ),
					'param_name'  => 'cats',
					'value'       => '',
					'description' => __( 'Insert the ids of the categories you want to pull posts from (optional). Comma separated. (eg. 2, 43)', 'sd-framework' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => __( 'Number of Items', 'sd-framework' ),
					'param_name'  => 'items',
					'value'       => '2',
					'description' => __( 'Insert the number of items to display. Default is 2.', 'sd-framework' ),
				),
			),
		));
	}
}