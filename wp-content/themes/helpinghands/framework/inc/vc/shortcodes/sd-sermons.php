<?php
/**
 * Latest Sermons VC Shortcode
 *
 * @package	HelpingHands
 * @author Skat
 * @copyright 2017, Skat Design
 * @link http://www.skat.tf
 * @since HelpingHands 2.0
 * @version 1.0
 */

if ( ! function_exists( 'sd_sermons' ) ) {
	function sd_sermons( $atts ) {
		$sd = shortcode_atts( array(), $atts );
		
		$args = array(
			'post_type'           => 'sermons',
			'posts_per_page'      => 4,
			'ignore_sticky_posts' => 1,
			'post_status'         => 'publish',
		);
		
		$sd_query = new WP_Query( $args );
		
		$items = $sd_query->post_count;

		global $post;
		
		ob_start();
		?>
			<div class="sd-latest-sermons">
				<?php $i = 0; ?>
				<?php if ( $sd_query->have_posts() ) : while ( $sd_query->have_posts() ) : $sd_query->the_post(); $i++; ?>
				
				<?php
					$sd_video     =  rwmb_meta( 'sd_sermon_video', 'type=oembed' );
					$sd_audios     = rwmb_meta( 'sd_sermon_audio');
					$sd_pdf       =  rwmb_meta( 'sd_sermon_pdf' );
					
					if (  !empty( $sd_audios ) ) {
						foreach ( $sd_audios as $sd_audio ) {
							$sd_sermon_url = $sd_audio['url'];
						}
					}
					$attr = array(
						'src'      => $sd_sermon_url,
					);
				?>
				
				<?php if ( $i == 1 ) : ?>
	
					<div class="col-md-6">
						<div class="sd-first-sermon">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="sd-sermon-thumb">
									<figure>
										<?php the_post_thumbnail( 'sd-sermon-shortcode' ); ?>
									</figure>
								</div>
							<?php endif; ?>
							<div class="sd-first-sermon-content">
								<?php if ( ! empty( $sd_audios ) ) : ?>
									<a class="sd-sermon-modal" href="#sd-sermon-audio<?php echo get_the_ID(); ?>" title="<?php esc_attr_e( 'Audio', 'sd-framework' ); ?>"><i class="fa fa-microphone"></i></a>
								<?php endif; ?>

								<?php if ( ! empty( $sd_video ) ) : ?>
								<a class="sd-sermon-modal" href="#sd-sermon-video<?php echo get_the_ID(); ?>" title="<?php esc_attr_e( 'Video', 'sd-framework' ); ?>"><i class="fa fa-youtube-play"></i></a>
								<?php endif; ?>
								<?php if ( ! empty( $sd_pdf ) ) : ?>
									<a href="<?php echo esc_url( $sd_pdf ); ?>" target="_blank" title="<?php esc_attr_e( 'PDF', 'sd-framework' ); ?>"><i class="fa fa-cloud-download"></i></a>
								<?php endif; ?>
								
								<div id="sd-sermon-video<?php echo get_the_ID(); ?>" class="mfp-hide sd-sermon-video-content">
									<div class="sd-entry-video">
										<?php echo $sd_video; ?>
									</div>
								</div>
								<!-- sd-sermon-video -->
								<div id="sd-sermon-audio<?php echo get_the_ID(); ?>" class="mfp-hide sd-sermon-audio-content">
									<?php echo wp_audio_shortcode( $attr ); ?>
								</div>
								<!-- sd-sermon-audio -->
								<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
								<ul>
									<?php echo  get_the_term_list( $post->ID, 'sermon_topics', '<li>' . __( 'Topic: ', 'sd-framework' ) . ' ', ', ', '</li>' ) ?>
									<?php echo  get_the_term_list( $post->ID, 'sermon_speakers', '<li>' . __( 'Speaker: ', 'sd-framework' ) . '', ', ', '</li>' ) ?>
								</ul>
							</div>
							<!-- sd-first-sermon-content -->
						</div>
						<!-- sd-first-sermon -->
					</div>
					<!-- col-md-6 -->
					
				<?php else : ?>
					<?php if ( $i == 2 && $i !== 3 ) : ?>
						<div class="col-md-6">
							<div class="row">
								<ul class="sd-sermons-right">
					<?php endif; ?>
					
						<li class="sd-sermons-right-item">
							<?php if ( ! empty( $sd_audios ) ) : ?>
								<a class="sd-sermon-modal" href="#sd-sermon-audio<?php echo get_the_ID(); ?>" title="<?php esc_attr_e( 'Audio', 'sd-framework' ); ?>"><i class="fa fa-microphone"></i></a>
							<?php endif; ?>
							<?php if ( ! empty( $sd_video ) ) : ?>
							<a class="sd-sermon-modal" href="#sd-sermon-video<?php echo get_the_ID(); ?>" title="<?php esc_attr_e( 'Video', 'sd-framework' ); ?>"><i class="fa fa-youtube-play"></i></a>
							<?php endif; ?>
							<?php if ( ! empty( $sd_pdf ) ) : ?>
								<a href="<?php echo esc_url( $sd_pdf ); ?>" target="_blank" title="<?php esc_attr_e( 'PDF', 'sd-framework' ); ?>"><i class="fa fa-cloud-download"></i></a>
							<?php endif; ?>
							
							<div id="sd-sermon-video<?php echo get_the_ID(); ?>" class="mfp-hide sd-sermon-video-content">
								<div class="sd-entry-video">
									<?php echo $sd_video; ?>
								</div>
							</div>
							<!-- sd-sermon-video -->
							<div id="sd-sermon-audio<?php echo get_the_ID(); ?>" class="mfp-hide sd-sermon-audio-content">
								<?php echo wp_audio_shortcode( $attr ); ?>
							</div>
							<!-- sd-sermon-audio -->
							<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
							<ul>
								<?php echo  get_the_term_list( $post->ID, 'sermon_topics', '<li>' . __( 'Topic: ', 'sd-framework' ) . ' ', ', ', '</li>' ) ?>
								<?php echo  get_the_term_list( $post->ID, 'sermon_speakers', '<li>' . __( 'Speaker: ', 'sd-framework' ) . '', ', ', '</li>' ) ?>
							</ul>
						</li>
												
					<?php if ( $items == $i ) : ?>
								</ul>
							</div>
						</div>
					<?php endif; ?>
						
						<?php if ( $i == 4 ) { $i = 0;	} ?>
					
					<?php endif; ?>
	
	
				<?php endwhile; endif;  wp_reset_postdata(); ?>
			</div>
			<!-- sd-latest-sermons -->
			
		<?php return ob_get_clean();	
	}
	add_shortcode( 'sd_sermons','sd_sermons' );
}

// Register shortcode to VC

add_action( 'init', 'sd_sermons_vcmap' );

if ( ! function_exists( 'sd_sermons_vcmap' ) ) {
	function sd_sermons_vcmap() {
		vc_map( array(
			'name'              => __( 'Latest Sermons', 'sd-framework' ),
			'description'       => __( 'Latest sermons', 'sd-framework' ),
			'base'              => "sd_sermons",
			'class'             => "sd_sermons",
			'category'          => __( 'Helping Hands Church', 'sd-framework' ),
			'icon'              => "icon-wpb-sd-sermons",
			'admin_enqueue_css' => get_template_directory_uri() . '/framework/inc/vc/assets/css/sd-vc-admin-styles.css',
			'front_enqueue_css' => get_template_directory_uri() . '/framework/inc/vc/assets/css/sd-vc-admin-styles.css',
			'params'            => array(),
		));
	}
}