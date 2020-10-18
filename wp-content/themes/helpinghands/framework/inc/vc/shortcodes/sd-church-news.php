<?php
/*-----------------------------------------------------------------------------------*/
/*	Latest Blog Items
/*-----------------------------------------------------------------------------------*/

if (!function_exists( 'sd_latest_news_church' ) ) {
	function sd_latest_news_church( $atts ) {
		$sd =  shortcode_atts( array(
			'latest'  => 'rb',
			'cats'	  => '',
			'items'	  => '4',
			'columns' => 'four',
		), $atts );
		
		$latest  = $sd['latest'];
		$cats    = $sd['cats'];
		$items   = $sd['items'];
		$columns = $sd['columns'];
		
		if ( $latest == 'rb' ) {
		
			$args = array(
				'post_type'           => 'post',
				'cat'                 => $cats,
				'posts_per_page'      => $items,
				'ignore_sticky_posts' => 1,
				'post_status'         => 'publish',
			);
		
		} else {
			
			$args = array(
				'post_type'           => 'events',
				'posts_per_page'      => $items,
				'ignore_sticky_posts' => 1,
				'post_status'         => 'publish',
				'meta_key'            => 'sd_dov',
				'orderby'             => 'meta_value',
				'order'               => 'DESC',
				'tax_query' => array(
					array(
						'taxonomy' => 'event_category',
						'field'    => 'term_id',
						'terms'    => array( $cats ),
					),
				),
			);
		
			if ( empty( $cats ) ) {
				unset( $args['tax_query'] );
			}
				
		}
		
		$sd_query = new WP_Query( $args );

		ob_start();
		?>
		
	
			<?php if ( $sd_query->have_posts() ) : while ( $sd_query->have_posts() ) : $sd_query->the_post(); ?>
			
				<div class="col-md-6">
					<div class="sd-church-news-item sd-all-trans">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="sd-entry-thumb">
								<figure>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'sd-church-news' ); ?></a>
								</figure>
								<div class="sd-ch-news-date">
									<span class="sd-ch-news-day"><?php the_time( 'd' ); ?></span>
									<span class="sd-ch-news-month"><?php the_time( 'M' ); ?></span>
									<span class="sd-ch-news-year"><?php the_time( 'Y' ); ?></span>
								</div>
								<!-- sd-ch-news-date -->
							</div>
							<!-- sd-entry-thumb -->
						<?php endif; ?>
						<div class="sd-ch-news-content">
							<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo substr( get_the_excerpt(), 0, 80 ) . '...'; ?></p>
						</div>
						<!-- sd-ch-news-content -->
					</div>
					<!-- sd-church-news-item -->
				</div>
				<!-- col-md-6 -->

			<?php endwhile; endif;  wp_reset_postdata(); ?>

		<?php return ob_get_clean();	
	}
	add_shortcode( 'sd_latest_news_church','sd_latest_news_church' );
}

// Register shortcode to VC

add_action( 'init', 'sd_latest_news_church_vcmap' );

if ( ! function_exists( 'sd_latest_news_church_vcmap' ) ) {
	function sd_latest_news_church_vcmap() {
		vc_map( array(
			'name'              => __( 'Latest Church News', 'sd-framework' ),
			'description'       => __( 'Latest church news', 'sd-framework' ),
			'base'              => "sd_latest_news_church",
			'class'             => "sd_latest_news_church",
			'category'          => __( 'Helping Hands Church', 'sd-framework' ),
			'icon'              => "icon-wpb-sd-blog",
			'admin_enqueue_css' => get_template_directory_uri() . '/framework/inc/vc/assets/css/sd-vc-admin-styles.css',
			'front_enqueue_css' => get_template_directory_uri() . '/framework/inc/vc/assets/css/sd-vc-admin-styles.css',
			'params'            => array(
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => __( 'Number of items to show', 'sd-framework' ),
					'param_name'  => 'items',
					'value'       => '4',
					'description' => __( 'Insert the number of items to show.', 'sd-framework' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => __( 'Categories', 'sd-framework' ),
					'param_name'  => 'cats',
					'value'       => '',
					'description' => __( 'Insert the ids of the categories you want to pull posts from (optional). Comma separated. (eg. 2, 43)', 'sd-framework' ),
				),
			),
		));
	}
}