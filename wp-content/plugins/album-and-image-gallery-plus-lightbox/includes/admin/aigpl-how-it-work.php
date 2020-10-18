<?php
/**
 * Pro Designs and Plugins Feed
 *
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Action to add menu
add_action('admin_menu', 'aigpl_register_design_page');

/**
 * Register plugin design page in admin menu
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_register_design_page() {
	add_submenu_page( 'edit.php?post_type='.AIGPL_POST_TYPE, __('How it works, our plugins and offers', 'album-and-image-gallery-plus-lightbox'), __('How It Works', 'album-and-image-gallery-plus-lightbox'), 'manage_options', 'aigpl-designs', 'aigpl_designs_page' );
}

/**
 * Function to display plugin design HTML
 * 
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_designs_page() {

	$wpos_feed_tabs = aigpl_help_tabs();
	$active_tab 	= isset($_GET['tab']) ? $_GET['tab'] : 'how-it-work';
?>

	<div class="wrap aigpl-wrap">

		<h2 class="nav-tab-wrapper">
			<?php
			foreach ($wpos_feed_tabs as $tab_key => $tab_val) {
				$tab_name	= $tab_val['name'];
				$active_cls = ($tab_key == $active_tab) ? 'nav-tab-active' : '';
				$tab_link 	= add_query_arg( array( 'post_type' => AIGPL_POST_TYPE, 'page' => 'aigpl-designs', 'tab' => $tab_key), admin_url('edit.php') );
			?>

			<a class="nav-tab <?php echo $active_cls; ?>" href="<?php echo $tab_link; ?>"><?php echo $tab_name; ?></a>

			<?php } ?>
		</h2>

		<div class="aigpl-tab-cnt-wrp">
		<?php
			if( isset($active_tab) && $active_tab == 'how-it-work' ) {
				aigpl_howitwork_page();
			}
			else if( isset($active_tab) && $active_tab == 'plugins-feed' ) {
				echo aigpl_get_plugin_design( 'plugins-feed' );
			} 
		?>
		</div><!-- end .aigpl-tab-cnt-wrp -->

	</div><!-- end .aigpl-wrap -->

<?php
}

/**
 * Gets the plugin design part feed
 *
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_get_plugin_design( $feed_type = '' ) {

	$active_tab = isset($_GET['tab']) ? $_GET['tab'] : '';

	// If tab is not set then return
	if( empty($active_tab) ) {
		return false;
	}

	// Taking some variables
	$wpos_feed_tabs = aigpl_help_tabs();
	$transient_key 	= isset($wpos_feed_tabs[$active_tab]['transient_key']) 	? $wpos_feed_tabs[$active_tab]['transient_key'] 	: 'aigpl_' . $active_tab;
	$url 			= isset($wpos_feed_tabs[$active_tab]['url']) 			? $wpos_feed_tabs[$active_tab]['url'] 				: '';
	$transient_time = isset($wpos_feed_tabs[$active_tab]['transient_time']) ? $wpos_feed_tabs[$active_tab]['transient_time'] 	: 172800;
	$cache 			= get_transient( $transient_key );

	if ( false === $cache ) {

		$feed 			= wp_remote_get( esc_url_raw( $url ), array( 'timeout' => 120, 'sslverify' => false ) );
		$response_code 	= wp_remote_retrieve_response_code( $feed );

		if ( ! is_wp_error( $feed ) && $response_code == 200 ) {
			if ( isset( $feed['body'] ) && strlen( $feed['body'] ) > 0 ) {
				$cache = wp_remote_retrieve_body( $feed );
				set_transient( $transient_key, $cache, $transient_time );
			}
		} else {
			$cache = '<div class="error"><p>' . __( 'There was an error retrieving the data from the server. Please try again later.', 'album-and-image-gallery-plus-lightbox' ) . '</div>';
		}
	}
	return $cache;
}

/**
 * Function to get plugin feed tabs
 *
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_help_tabs() {
	$wpos_feed_tabs = array(
						'how-it-work' 	=> array(
												'name' => __('How It Works', 'album-and-image-gallery-plus-lightbox'),
											),
						'plugins-feed' 	=> array(
												'name' 				=> __('Our Plugins', 'album-and-image-gallery-plus-lightbox'),
												'url'				=> 'http://wponlinesupport.com/plugin-data-api/plugins-data.php',
												'transient_key'		=> 'wpos_plugins_feed',
												'transient_time'	=> 172800
											),
					);
	return $wpos_feed_tabs;
}

/**
 * Function to get 'How It Works' HTML
 *
 * @package Album and Image Gallery Plus Lightbox
 * @since 1.0.0
 */
function aigpl_howitwork_page() { ?>

	<style type="text/css">
		.wpos-pro-box .hndle{background-color:#0073AA; color:#fff;}
		.wpos-pro-box.postbox{background:#dbf0fa none repeat scroll 0 0; border:1px solid #0073aa; color:#191e23;}
		.postbox-container .wpos-list li:before{font-family: dashicons; content: "\f139"; font-size:20px; color: #0073aa; vertical-align: middle;}
		.aigpl-wrap .wpos-button-full{display:block; text-align:center; box-shadow:none; border-radius:0;}
		.aigpl-shortcode-preview{background-color: #e7e7e7; font-weight: bold; padding: 2px 5px; display: inline-block; margin:0 0 2px 0;}
		.upgrade-to-pro{font-size:18px; text-align:center; margin-bottom:15px;}
		.wpos-copy-clipboard{-webkit-touch-callout: all; -webkit-user-select: all; -khtml-user-select: all; -moz-user-select: all; -ms-user-select: all; user-select: all;}
	</style>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<!--How it workd HTML -->
			<div id="post-body-content">
				<div class="meta-box-sortables">
					<div class="postbox">

						<h3 class="hndle">
							<span><?php _e( 'How It Works - Display and shortcode', 'album-and-image-gallery-plus-lightbox' ); ?></span>
						</h3>

						<div class="inside">
							<table class="form-table">
								<tbody>
									<tr>
										<th>
											<label><?php _e('Geeting Started with Album Gallery', 'album-and-image-gallery-plus-lightbox'); ?>:</label>
										</th>
										<td>
											<ul>
												<li><?php _e('Step-1. Go to "Album Gallery --> Add Album Gallery tab".', 'album-and-image-gallery-plus-lightbox'); ?></li>
												<li><?php _e('Step-2. Add Album title, description and images under Album and Image Gallery Plus Lightbox - Settings.', 'album-and-image-gallery-plus-lightbox'); ?></li>
												<li><?php _e('Step-3. Under "Choose Gallery Images" click on "Gallery Images" button and select multiple images from WordPress media and click on "Add to Gallery" button.', 'album-and-image-gallery-plus-lightbox'); ?></li>
												<li><?php _e('Step-4. You can find out shortcode for album under "Album Gallery" list view.', 'album-and-image-gallery-plus-lightbox'); ?></li>
											</ul>
										</td>
									</tr>

									<tr>
										<th>
											<label><?php _e('How Shortcode Works', 'album-and-image-gallery-plus-lightbox'); ?>:</label>
										</th>
										<td>
											<ul>
												<li><?php _e('Step-1. Create a page like Album OR My Album.', 'album-and-image-gallery-plus-lightbox'); ?></li>
												<li><?php _e('Step-2. Put below shortcode as per your need.', 'album-and-image-gallery-plus-lightbox'); ?></li>
											</ul>
										</td>
									</tr>

									<tr>
										<th>
											<label><?php _e('All Shortcodes', 'album-and-image-gallery-plus-lightbox'); ?>:</label>
										</th>
										<td>
											<span class="wpos-copy-clipboard aigpl-shortcode-preview">[aigpl-gallery]</span> – <?php _e('Gallery Grid Shortcode', 'album-and-image-gallery-plus-lightbox'); ?> <br />
											<span class="wpos-copy-clipboard aigpl-shortcode-preview">[aigpl-gallery-slider]</span> – <?php _e('Gallery Slider Shortcode', 'album-and-image-gallery-plus-lightbox'); ?> <br />
											<span class="wpos-copy-clipboard aigpl-shortcode-preview">[aigpl-gallery-album]</span> – <?php _e('Image Album Grid Shortcode', 'album-and-image-gallery-plus-lightbox'); ?> <br />
											<span class="wpos-copy-clipboard aigpl-shortcode-preview">[aigpl-gallery-album-slider]</span> – <?php _e('Image Album Slider Shortcode', 'album-and-image-gallery-plus-lightbox'); ?>
										</td>
									</tr>

									<tr>
										<th>
											<label><?php _e('Need Support?', 'album-and-image-gallery-plus-lightbox'); ?></label>
										</th>
										<td>
											<p><?php _e('Check plugin document for shortcode parameters and demo for designs.', 'album-and-image-gallery-plus-lightbox'); ?></p> <br/>
											<a class="button button-primary" href="https://docs.wponlinesupport.com/album-and-image-gallery-plus-lightbox/" target="_blank"><?php _e('Documentation', 'album-and-image-gallery-plus-lightbox'); ?></a>
											<a class="button button-primary" href="https://demo.wponlinesupport.com/album-and-image-gallery-plus-lightbox-demo/" target="_blank"><?php _e('Demo for Designs', 'album-and-image-gallery-plus-lightbox'); ?></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div><!-- .inside -->
					</div><!-- #general -->
				</div><!-- .meta-box-sortables -->
			</div><!-- #post-body-content -->
			
			<!--Upgrad to Pro HTML -->
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox wpos-pro-box">
						<h3 class="hndle">
							<span><?php _e( 'Upgrate to Pro', 'album-and-image-gallery-plus-lightbox' ); ?></span>
						</h3>
						<div class="inside">
							<ul class="wpos-list">
								<li><?php _e('15+ image gallery designs', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('4 shortcodes ', 'album-and-image-gallery-plus-lightbox'); ?>[aigpl-gallery], [aigpl-gallery-slider], [aigpl-gallery-album] and [aigpl-gallery-album-slider]</li>
								<li><?php _e('Display album category wise', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('Easy Drag & Drop Image Feature', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('Masonry style for image gallery', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('Display gallery image with title and description', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('Display image album with title and description', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('Custom link to gallery image', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('Gutenberg Block Support', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('Template overriding feature support', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('Strong Shortcode Parameters', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('Slider Center Mode Effect', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('Slider RTL support', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('Visual Composer support', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('Custom CSS option', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('Fully responsive', 'album-and-image-gallery-plus-lightbox'); ?></li>
								<li><?php _e('100% Multi language', 'album-and-image-gallery-plus-lightbox'); ?></li>
							</ul>
							<div class="upgrade-to-pro"><?php echo sprintf( __( 'Gain access to <strong>Album and Image Gallery Plus Lightbox</strong> included in <br /><strong>Essential Plugin Bundle', 'album-and-image-gallery-plus-lightbox' ) ); ?></div>
							<a class="button button-primary wpos-button-full" href="https://www.wponlinesupport.com/wp-plugin/album-image-gallery-plus-lightbox/?ref=WposPratik&utm_source=WP&utm_medium=Album-Gallery&utm_campaign=Upgrade-PRO" target="_blank"><?php _e('Go Premium ', 'album-and-image-gallery-plus-lightbox'); ?></a>
							<p><a class="button button-primary wpos-button-full" href="https://demo.wponlinesupport.com/prodemo/album-and-image-gallery-plus-lightbox-pro/" target="_blank"><?php _e('View PRO Demo ', 'album-and-image-gallery-plus-lightbox'); ?></a></p>
						</div><!-- .inside -->
					</div><!-- #general -->

					<div class="postbox">
						<h3 class="hndle">
							<span><?php _e( 'Help to improve this plugin!', 'album-and-image-gallery-plus-lightbox' ); ?></span>
						</h3>
						<div class="inside">
							<p><?php _e('Enjoyed this plugin? You can help by rate this plugin', 'album-and-image-gallery-plus-lightbox'); ?> <a href="https://wordpress.org/support/plugin/album-and-image-gallery-plus-lightbox/reviews/#new-post" target="_blank"><?php _e('5 stars!', 'album-and-image-gallery-plus-lightbox'); ?></a></p>
						</div><!-- .inside -->
					</div><!-- #general -->
				</div><!-- .meta-box-sortables -->
			</div><!-- #post-container-1 -->

		</div><!-- #post-body -->
	</div><!-- #poststuff -->
<?php }