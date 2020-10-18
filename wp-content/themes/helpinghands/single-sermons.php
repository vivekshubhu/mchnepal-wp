<?php
/**
 * Theme Single Post Sermons
 *
 * @package	HelpingHands
 * @author Skat
 * @copyright 2017, Skat Design
 * @link http://www.skat.tf
 * @since HelpingHands 2.0
 */
get_header(); 

$header_bgs     = rwmb_meta( 'sd_header_page_bg', array( 'size' => 'full' ) );
$bg_repeat      = rwmb_meta( 'sd_bg_repeat', 'type=checkbox');
$repeat_x       = rwmb_meta('sd_repeat_x', 'type=checkbox');
$repeat_y       = rwmb_meta('sd_repeat_y', 'type=checkbox');
$repeat_x       = ( $repeat_x == '1' ? ' repeat-x ' : '' );
$repeat_y       = ( $repeat_y == '1' ? ' repeat-y ' : '');
$custom_title   = rwmb_meta('sd_edd_single_title');
$padding_top    = rwmb_meta('sd_edd_padding_top');
$padding_bottom = rwmb_meta('sd_edd_padding_bottom');
$show_title     = rwmb_meta('sd_edd_page_title');

if ( $bg_repeat == '1' && $repeat_x !== '1' && $repeat_y !== '1' ) {
	$bg_repeat = 'repeat';
} else if ( $repeat_x == '1' || $repeat_y == '1' ) {
	$bg_repeat = '';
} else {
	$bg_repeat = 'no-repeat center center / cover';
}


$styling = array();

if ( ! empty( $header_bgs ) ) {
	foreach ( $header_bgs as $header_bg ) {
		$styling[] = 'background: url(' . $header_bg['full_url'] . ') ' . $bg_repeat . $repeat_x . $repeat_y . ';';
	}
}
if ( !empty( $padding_top ) ) {
	$styling[] = 'padding-top: '. $padding_top .';';
}
if ( !empty( $padding_bottom ) ) {
	$styling[] = 'padding-bottom: '. $padding_bottom .';';
}
$styling = implode( '', $styling );

if ( $styling ) {
	$styling = wp_kses( $styling, array() );
	$styling = ' style="' . esc_attr( $styling ) . '"';
}

?>
<!--left col-->

<?php if ( $show_title == '1' ) : ?>
	<div class="sd-page-top-bg" <?php echo $styling; ?>>
		<div class="container">
			<div>
				<h1><?php if ( ! empty( $custom_title) ) echo $custom_title; else the_title(); ?></h1>
			</div>
			<!-- sd-campaign-single-title -->
		</div>
		<!-- container -->
	</div>
	<!-- sd-page-top-bg -->
<?php endif; ?>
<div class="container sd-single-sermon">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
	<h2 class="sd-single-sermon-title"><?php the_title(); ?></h2>
	<?php get_template_part( 'framework/inc/post-meta-sermons' ); ?>
	<div class="clearfix"></div>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="sd-single-sermon-thumb">
			<figure>
				<?php the_post_thumbnail( 'sd-single-sermon' ); ?>
			</figure>
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
			<div class="sd-single-sermon-buttons">
				<?php if ( ! empty( $sd_audios ) ) : ?>
					<a class="sd-sermon-modal" href="#sd-sermon-audio<?php echo get_the_ID(); ?>" title="<?php esc_attr_e( 'Audio', 'sd-framework' ); ?>"><i class="fa fa-microphone"></i></a>
				<?php endif; ?>
		
				<?php if ( ! empty( $sd_video ) ) : ?>
				<a class="sd-sermon-modal" href="#sd-sermon-video<?php echo get_the_ID(); ?>" title="<?php esc_attr_e( 'Video', 'sd-framework' ); ?>"><i class="fa fa-youtube-play"></i></a>
				<?php endif; ?>
				<?php if ( ! empty( $sd_pdf ) ) : ?>
					<a class="sd-sermon-download" href="<?php echo esc_url( $sd_pdf ); ?>" target="_blank" title="<?php esc_attr_e( 'PDF', 'sd-framework' ); ?>"><i class="fa fa-cloud-download"></i></a>
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
			<!-- sd-single-sermon-buttons -->
		</div>
		<!-- sd-single-sermon-thumb -->
	<?php endif; ?>
	<div class="sd-single-sermon-content">
		<?php the_content(); ?>
		<?php get_template_part( 'framework/inc/share-icons' ); ?>
		<footer class="clearfix">
			<div class="sd-prev-next-post clearfix">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<span class="sd-prev-post">
							<span><?php next_post_link( '%link', '&larr;' . __( 'Previous', 'sd-framework' ) ); ?></span>
							<?php next_post_link( '%link' ); ?>
						</span>
					</div>
					<!-- col-md-6 -->
					<div class="col-md-6 col-sm-6 col-xs-6">
						<span class="sd-next-post">
							<span><?php previous_post_link( '%link',  __( 'Next', 'sd-framework' ) . '&rarr;' ); ?></span>
							<?php previous_post_link( '%link' ); ?>
						</span>
					</div>
					<!-- col-md-6 -->
				</div>
				<!-- row -->
			</div>
			<!-- sd-prev-next-post -->
		</footer>
	</div>
	<!-- sd-single-sermon-content -->
	
	<?php endwhile; else: ?>
		<p><?php _e( 'Sorry, no sermons matched your criteria', 'sd-framework' ) ?>.</p>
	<?php endif; ?>

	<?php if ( $sd_data['sd_blog_comments'] == '1' ) : ?>
		<?php comments_template( '', true ); ?>
	<?php endif; ?>
</div>
<!-- sd-single-sermon -->
<?php get_footer(); ?>