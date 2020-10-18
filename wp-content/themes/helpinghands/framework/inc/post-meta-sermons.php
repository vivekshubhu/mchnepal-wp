<?php
/* ------------------------------------------------------------------------ */
/* Post Meta Sermons
/* ------------------------------------------------------------------------ */
global $sd_data;

$sd_sermons_meta = $sd_data['sd_sermons_post_meta'];

?>

<aside class="sd-sermons-meta">
	<ul>
		<?php if ( $sd_sermons_meta[1] == '1' ) : ?>
			<?php echo  get_the_term_list( $post->ID, 'sermon_topics', '<li>' . __( 'Topic: ', 'sd-framework' ) . ' ', ', ', '</li>' ) ?>
		<?php endif; ?>
		
		<?php if ( $sd_sermons_meta[2] == '1' ) : ?>
			<?php echo  get_the_term_list( $post->ID, 'sermon_books', '<li>' . __( 'Book: ', 'sd-framework' ) . '  ', ', ', '</li>' ) ?>
		<?php endif; ?>
		
		<?php if ( $sd_sermons_meta[3] == '1' ) : ?>
			<?php echo  get_the_term_list( $post->ID, 'sermon_series', '<li>' . __( 'Series: ', 'sd-framework' ) . '', ', ', '</li>' ) ?>
		<?php endif; ?>
		
		<?php if ( $sd_sermons_meta[4] == '1' ) : ?>
			<?php echo  get_the_term_list( $post->ID, 'sermon_speakers', '<li>' . __( 'Speaker: ', 'sd-framework' ) . '', ', ', '</li>' ) ?>
		<?php endif; ?>
		
	</ul>
</aside>
<!-- sd-sermons-meta -->