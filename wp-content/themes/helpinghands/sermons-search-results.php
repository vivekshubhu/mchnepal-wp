<?php
/**
 * Template Name: Page: Sermons Search Results
 *
 * @package	HelpingHands
 * @author Skat
 * @copyright 2017, Skat Design
 * @link https://www.skat.tf
 * @since HelpingHands 2.0
 */

get_header();

global $sd_data;

$pagination  = $sd_data['sd_pagination_type'];
$blog_prev   = $sd_data['sd_blog_prev'];
$blog_next   = $sd_data['sd_blog_next'];

?>

<?php the_content(); ?>

<div class="sd-sermons-search clearfix">
	<div class="container">
		<?php
			$sd_sermons_search_form = new WP_Advanced_Search( 'sd_sermons_search_form' );
			$sd_sermons_search_form->the_form(); 
		?>
	</div>
</div>
<!-- sd-sermons-search -->
<div class="sd-sermons-page">
	<div class="container">
		<div class="row">
		<?php 

			global $wp_query;
			
			$sd_wpas = new WP_Advanced_Search( 'sd_sermons_search_form' );
			$sd_wpas_query = $sd_wpas->query();
							
		?>
		<?php if ( $sd_wpas_query->have_posts() ): while ( $sd_wpas_query->have_posts() ): $sd_wpas_query->the_post(); ?>
		
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
		
			<div class="sd-sermon-page clearfix">
				<div class="col-md-4">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="sd-sermon-thumb">
							<figure>
								<?php the_post_thumbnail( 'sd-sermon-thumbs' ); ?>
							</figure>
							<div class="sd-sermon-buttons">
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
							</div>
							<!-- sd-sermon-buttons -->
						</div>
						<!-- sd-sermon-thumb -->
					<?php endif; ?>
				</div>
				<!-- col-md-4 -->
				
				<div class="col-md-8">
					<div class="sd-sermon-page-content">
						<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

						<?php if ( $sd_data['sd_sermons_post_meta_enable'] == '1' ) get_template_part( 'framework/inc/post-meta-sermons' ); ?>
						
						<p><?php echo substr( get_the_excerpt(), 0, 250 ) . '...'; ?></p>
						
						<a class="sd-more" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e( 'VIEW SERMON', 'sd-framework' ); ?></a>
						
					</div>
					<!-- sd-sermon-page-content -->
				</div>
				<!-- col-md-9 -->
			</div>
			<!-- sd-sermon-page -->
			
		<?php endwhile; else: ?>
		
		<p>	<?php _e( 'Sorry, no posts matched your criteria.', 'sd-framework' ) ?> </p>
		
		<?php endif; wp_reset_postdata(); ?>
			<!--pagination-->
			<?php if ( $pagination == '1' ) : ?>
				<?php if ( get_previous_posts_link() ) : ?>
				<div class="sd-nav-previous">
					<?php previous_posts_link( $blog_prev ); ?>
				</div>
				<?php endif; ?>
				<?php if ( get_next_posts_link() ) : ?>
				<div class="sd-nav-next">
					<?php next_posts_link( $blog_next ); ?>
				</div>
				<?php endif; ?>
			<?php else : sd_custom_pagination(); endif; ?>
			
			<!--pagination end--> 
			<div class="clearfix"></div>
		</div>
	</div>
	<!-- container --> 
</div>
<!-- sd-sermons-page --> 
<?php get_footer(); ?>