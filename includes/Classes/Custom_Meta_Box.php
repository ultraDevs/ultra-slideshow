<?php
namespace UltraSlideshow\Classes;
/**
 * Custom meta box
 *
 * @package UltraSlideShow
 * @since 1.0.0
 */

/**
 * Custom meta box class
 *
 * This class is for registering custom meta box
 *
 * @package UltraSlideShow
 * @since 1.0.0
 */
class CustomMetaBox {
	/**
	 * Post type
	 *
	 * Post Type
	 *
	 * @var string
	 */
	protected $post_type;

	/**
	 * Add Meta Box
	 */
	public function meta_box() {
		add_meta_box( 'uss_gallery', __( 'Image Gallery', 'ultra-slideshow' ), array( $this, 'gallery_render' ), 'ud_slideshow', 'advanced', 'high' );
		add_meta_box( 'uss_settings', __( 'Settings', 'ultra-slideshow' ), array( $this, 'settings_render' ), 'ud_slideshow', 'advanced', 'high' );
		add_meta_box( 'uss_shortcode', __( 'Shortcode', 'ultra-slideshow' ), array( $this, 'metabox_shortcode_render' ), 'ud_slideshow', 'side', 'high' );
	}

	/**
	 * Shortcode Metabox render
	 *
	 * @since 1.0.0
	 * @param WP_Post $post The Post Object.
	 */
	public function metabox_shortcode_render( $post ) {
		?>
		<div class="ud-copy">
			<input type="text" value="[ultra-slideshow id=<?php echo intval( $post->ID ); ?>]" id="uss_shortcode_txt">
			<button type="button" class="copyData">Copy to clipboard</button>
		</div>
		<?php
	}
	/**
	 * Render Image Meta Box Content
	 *
	 * This method will render meta box content
	 *
	 * @param WP_Post $post The Post Object.
	 * @since 1.0.0
	 */
	public function gallery_render( $post ) {

		// Add an nonce to check when saving.
		wp_nonce_field( 'gallery_metabox', 'gallery_mb_nonce' );

		$gallery = get_post_meta( $post->ID, 'uss_gallery', true );

		$images = explode( ',', $gallery );
		?>
		<table class="table">
			<tr>
				<td>
					<ul id="us_gallery_sortable_wordpress_gallery" class="sortable_img_gallery sortable_wordpress_gallery">
					<?php
					if ( 0 < count( $images ) && '' !== $images[0] ) {
						foreach ( $images as $g_img ) {
							?>
							<li tabindex="0" role="checkbox" aria-label="<?php echo esc_html( get_the_title( $g_img ) ); ?>" aria-checked="true" data-id="<?php echo esc_html( $g_img ); ?>" class="attachment save-ready selected details">
								<div class="attachment-preview js--select-attachment type-image subtype-jpeg potrait">
									<div class="thumbnail">
										<div class="centered">
											<img src="<?php echo esc_url( wp_get_attachment_thumb_url( $g_img ) ); ?>" alt="" draggable="false">
										</div>
									</div>
								</div>
								<button type="button" data-gallery="#us_gallery_sortable_wordpress_gallery" class="button-link check remove-sortable-wordpress-gallery-image" tabindex="0"><span class="media-modal-icon"></span><span class="screen-reader-text">Deselect</span></button>
							</li>
							<?php
						}
					}
					?>

					</ul>
					<input id="us_gallery_sortable_wordpress_gallery_input" type="hidden" name="gallery_imgs" value="<?php echo esc_html( $gallery ); ?>">
					<input type="button" class="button button-primary add_img_gallery" data-gallery="#us_gallery_sortable_wordpress_gallery" value="<?php esc_html_e( 'Add Images', 'ultra-slideshow' ); ?>">
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Render the General Settings metabox
	 * 
	 * 
	 * @param WP_Post $post The Post Object.
	 * @since 1.0.0
	 */
	public function settings_render( $post ) {
		
		$general_settings = get_post_meta( $post->ID, 'uss_config_general', true );
		$autoplay_settings = get_post_meta( $post->ID, 'uss_config_autoplay', true );
		$navigation_settings = get_post_meta( $post->ID, 'uss_config_navigation', true );
		$pagination_settings = get_post_meta( $post->ID, 'uss_config_pagination', true );
		$breakpoints_slides = get_post_meta( $post->ID, 'uss_config_breakpoints_slides', true );
		$breakpoints_space = get_post_meta( $post->ID, 'uss_config_breakpoints_space', true );

		?>
		<div class="uss-settings__sec">
			<div class="uss-nav__tabs">
				<ul class="mh-nav__tabs">
					<li class="active">
						<a href="#general">General</a>
					</li>
					<li class="">
						<a href="#autoplay">Autoplay</a>
					</li>
					<li class="">
						<a href="#navigation">Navigation</a>
					</li>
					<li class="">
						<a href="#pagination">Pagination</a>
					</li>
					<li class="">
						<a href="#breakpoints">Breakpoints</a>
					</li>
				</ul>
				<div class="uss-tabs__content">
					<div id="general" class="us-tab__pane active">
						<table class="uss-table">
							<tbody>
								<tr>
									<th scope="row">Slides Per View</th>
									<td>
										<input type="text" name="uss_config_general[slidesPerView]" value="<?php echo $this->get_meta_value( $general_settings, 'slidesPerView', 1 );?>">
									</td>
								</tr>
								<tr>
									<th scope="row">Slides Per Column</th>
									<td>
										<input type="text" name="uss_config_general[slidesPerColumn]" value="<?php echo $this->get_meta_value( $general_settings, 'slidesPerColumn', 1 );?>">
									</td>
								</tr>
								<tr>
									<th scope="row">Initial Slide</th>
									<td>
										<input type="text" name="uss_config_general[initialSlide]" value="<?php echo $this->get_meta_value( $general_settings, 'initialSlide', 0 );?>">
									</td>
								</tr>
								<tr>
									<th scope="row">Direction</th>
									<td>
										<select name="uss_config_general[direction]" id="">
											<option value="horizontal" <?php selected( $this->get_meta_value( $general_settings, 'direction', 'horizontal' ), 'horizontal' ); ?>>Horizontal</option>
											<option value="vertical" <?php selected( $this->get_meta_value( $general_settings, 'direction', 'horizontal' ), 'vertical' ); ?>>Vertical</option>
										</select>
									</td>
								</tr>
								<tr>
									<th scope="row">Transition Speed</th>
									<td>
										<input type="text" name="uss_config_general[speed]" value="<?php echo $this->get_meta_value( $general_settings, 'speed', 300 );?>">
									</td>
								</tr>
								<tr>
									<th scope="row">Tranisition Effect</th>
									<td>
										<select name="uss_config_general[effect]" id="g_effect">
											<option value="slide" <?php selected( $this->get_meta_value( $general_settings, 'effect', 'slide' ), 'slide' ); ?>>Slide</option>
											<option value="coverflow" <?php selected( $this->get_meta_value( $general_settings, 'effect', 'slide' ), 'coverflow' ); ?>>Coverflow</option>
											<option value="fade" <?php selected( $this->get_meta_value( $general_settings, 'effect', 'slide' ), 'fade' ); ?>>Fade</option>
											<option value="cube" <?php selected( $this->get_meta_value( $general_settings, 'effect', 'slide' ), 'cube' ); ?>>Cube</option>
											<option value="flip" <?php selected( $this->get_meta_value( $general_settings, 'effect', 'slide' ), 'flip' ); ?>>Flip</option>
										</select>
									</td>
								</tr>
								<tr>
									<th scope="row">Auto Height</th>
									<td>
										<label style="margin-right: 10px;">
											<input type="radio" name="uss_config_general[autoHeight]" value="true" <?php checked( $this->get_meta_value( $general_settings, 'autoHeight', 'false' ), 'true' ); ?>> True
										</label>
										<label>
											<input type="radio" name="uss_config_general[autoHeight]" value="false" <?php checked( $this->get_meta_value( $general_settings, 'autoHeight', 'false' ), 'false' ); ?>> False
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row">Space Between</th>
									<td>
										<input type="text" name="uss_config_general[spaceBetween]" value="<?php echo $this->get_meta_value( $general_settings, 'spaceBetween', 0 );?>">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div id="autoplay" class="us-tab__pane">
						<table class="uss-table">
							<tbody>
								<tr>
									<th scope="row">Autoplay</th>
									<td>
										<label style="margin-right: 10px;">
											<input type="radio" name="uss_config_autoplay[autoPlay]" value="true" <?php checked( $this->get_meta_value( $autoplay_settings, 'autoPlay', 'true' ), 'true' ); ?>> True
										</label>
										<label>
											<input type="radio" name="uss_config_autoplay[autoPlay]" value="false" <?php checked( $this->get_meta_value( $autoplay_settings, 'autoPlay', 'true' ), 'false' ); ?>> False
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row">Transition Delay (in ms)</th>
									<td>
										<input type="text" name="uss_config_autoplay[delay]" value="<?php echo $this->get_meta_value( $autoplay_settings, 'delay', 3000 );?>">
									</td>
								</tr>
								<tr>
									<th scope="row">Stop on Last Slide</th>
									<td>
										<label style="margin-right: 10px;">
											<input type="radio" name="uss_config_autoplay[stopOnLastSlide]" value="true" <?php checked( $this->get_meta_value( $autoplay_settings, 'stopOnLastSlide', 'false' ), 'true' ); ?>> True
										</label>
										<label>
											<input type="radio" name="uss_config_autoplay[stopOnLastSlide]" value="false" <?php checked( $this->get_meta_value( $autoplay_settings, 'stopOnLastSlide', 'false' ), 'false' ); ?>> False
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row">Disable On Interaction</th>
									<td>
										<label style="margin-right: 10px;">
											<input type="radio" name="uss_config_autoplay[disableOnInteraction]" value="true" <?php checked( $this->get_meta_value( $autoplay_settings, 'disableOnInteraction', 'true' ), 'true' ); ?>> True
										</label>
										<label>
											<input type="radio" name="uss_config_autoplay[disableOnInteraction]" value="false" <?php checked( $this->get_meta_value( $autoplay_settings, 'disableOnInteraction', 'true' ), 'false' ); ?>> False
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row">Reverse Direction</th>
									<td>
										<label style="margin-right: 10px;">
											<input type="radio" name="uss_config_autoplay[reverseDirection]" value="true" <?php checked( $this->get_meta_value( $autoplay_settings, 'reverseDirection', 'false' ), 'true' ); ?>> True
										</label>
										<label>
											<input type="radio" name="uss_config_autoplay[reverseDirection]" value="false" <?php checked( $this->get_meta_value( $autoplay_settings, 'reverseDirection', 'false' ), 'false' ); ?>> False
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row">Wait For Transition</th>
									<td>
										<label style="margin-right: 10px;">
											<input type="radio" name="uss_config_autoplay[waitForTransition]" value="true" <?php checked( $this->get_meta_value( $autoplay_settings, 'waitForTransition', 'true' ), 'true' ); ?>> True
										</label>
										<label>
											<input type="radio" name="uss_config_autoplay[waitForTransition]" value="false" <?php checked( $this->get_meta_value( $autoplay_settings, 'waitForTransition', 'true' ), 'false' ); ?>> False
										</label>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div id="navigation" class="us-tab__pane">
						<table class="uss-table">
							<tbody>
								<tr>
									<th scope="row">Navigation</th>
									<td>
										<label style="margin-right: 10px;">
											<input type="radio" name="uss_config_navigation[nav]" value="true" <?php checked( $this->get_meta_value( $navigation_settings, 'nav', 'true' ), 'true' ); ?>> True
										</label>
										<label>
											<input type="radio" name="uss_config_navigation[nav]" value="false" <?php checked( $this->get_meta_value( $navigation_settings, 'nav', 'true' ), 'false' ); ?>> False
										</label>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div id="pagination" class="us-tab__pane">
						<table class="uss-table">
							<tbody>
								<tr>
									<th scope="row">Pagination</th>
									<td>
										<label style="margin-right: 10px;">
											<input type="radio" name="uss_config_pagination[pagination]" value="true" <?php checked( $this->get_meta_value( $pagination_settings, 'pagination', 'true' ), 'true' ); ?>> True
										</label>
										<label>
											<input type="radio" name="uss_config_pagination[pagination]" value="false" <?php checked( $this->get_meta_value( $pagination_settings, 'pagination', 'true' ), 'false' ); ?>> False
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row">Type</th>
									<td>
										<select name="uss_config_pagination[type]" id="">
											<option value="bullets" <?php selected( $this->get_meta_value( $pagination_settings, 'type', 'bullets' ), 'bullets' ); ?>>Bullets</option>
											<option value="fraction" <?php selected( $this->get_meta_value( $pagination_settings, 'type', 'slide' ), 'fraction' ); ?>>Fraction</option>
											<option value="progressbar" <?php selected( $this->get_meta_value( $pagination_settings, 'type', 'slide' ), 'progressbar' ); ?>>Progress Bar</option>
										</select>
									</td>
								</tr>
								<tr>
									<th scope="row">Clickable</th>
									<td>
										<label style="margin-right: 10px;">
											<input type="radio" name="uss_config_pagination[clickable]" value="true" <?php checked( $this->get_meta_value( $pagination_settings, 'clickable', 'true' ), 'true' ); ?>> True
										</label>
										<label>
											<input type="radio" name="uss_config_pagination[clickable]" value="false" <?php checked( $this->get_meta_value( $pagination_settings, 'clickable', 'true' ), 'false' ); ?>> False
										</label>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div id="breakpoints" class="us-tab__pane">
						<table class="uss-table">
							<tbody>
								<tr class="uss-brdr-b">
									<th>Mobile</th>
									<td>
										<div>
											<label for="">Slides Per View</label>
											<input type="text" name="uss_config_breakpoints_slides[640]" value="<?php echo $this->get_meta_value( $breakpoints_slides, '640', 1 );?>" id="spv">
										</div>
										<div>
											<label for="">Space Between</label>
											<input type="text" name="uss_config_breakpoints_space[640]" value="<?php echo $this->get_meta_value( $breakpoints_space, '640', 5 );?>" id="sspace">
										</div>
									</td>
								</tr>
								<tr class="uss-brdr-b">
									<th>Tablet</th>
									<td>
										<div>
											<label for="">Slides Per View</label>
											<input type="text" name="uss_config_breakpoints_slides[768]" value="<?php echo $this->get_meta_value( $breakpoints_slides, '768', 2 );?>" id="spv">
										</div>
										<div>
											<label for="">Space Between</label>
											<input type="text" name="uss_config_breakpoints_space[768]" value="<?php echo $this->get_meta_value( $breakpoints_space, '768', 5 );?>" id="sspace">
										</div>
									</td>
								</tr>
								<tr class="uss-brdr-b">
									<th>Desktop</th>
									<td>
										<div>
											<label for="">Slides Per View</label>
											<input type="text" name="uss_config_breakpoints_slides[1024]" value="<?php echo $this->get_meta_value( $breakpoints_slides, '1024', 2 );?>" id="spv">
										</div>
										<div>
											<label for="">Space Between</label>
											<input type="text" name="uss_config_breakpoints_space[1024]" value="<?php echo $this->get_meta_value( $breakpoints_space, '1024', 5 );?>" id="sspace">
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Save Metabox Data
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {

		// Check Nonce.
		if ( ! isset( $_POST['gallery_mb_nonce'] ) ) {
			return $post_id;
		}

		// Verify Nonce.
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gallery_mb_nonce'] ) ), 'gallery_metabox' ) ) {
			return;
		}

		/**
		 * Check if this is an autosave
		 */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check user's permission.
		if ( ! current_user_can( 'edit_post' ) ) {
			return $post_id;
		}

		/**
		 * It's safe to save data.
		 */
		$gallery = sanitize_text_field( isset( $_POST['gallery_imgs'] ) ? wp_unslash( $_POST['gallery_imgs'] ) : '' );

		// Update Meta field.
		update_post_meta( $post_id, 'uss_gallery', $gallery );

		$s_general_settings = array();
		foreach ( $_POST['uss_config_general'] as $key => $general_setting ) {
			$s_general_settings[$key] = wp_filter_post_kses ( $general_setting );
		}

		$s_autoplay_settings = array();
		foreach ( $_POST['uss_config_autoplay'] as $key => $value ) {
			$s_autoplay_settings[$key] = wp_filter_post_kses ( $value );
		}

		$s_nav_settings = array();
		foreach ( $_POST['uss_config_navigation'] as $key => $value ) {
			$s_nav_settings[$key] = wp_filter_post_kses ( $value );
		}

		$s_pagination_settings = array();
		foreach ( $_POST['uss_config_pagination'] as $key => $value ) {
			$s_pagination_settings[$key] = wp_filter_post_kses ( $value );
		}

		$s_breakpoints_slides = array();
		foreach ( $_POST['uss_config_breakpoints_slides'] as $key => $value ) {
			$s_breakpoints_slides[$key] = wp_filter_post_kses ( $value );
		}

		$s_breakpoints_space = array();
		foreach ( $_POST['uss_config_breakpoints_space'] as $key => $value ) {
			$s_breakpoints_space[$key] = wp_filter_post_kses ( $value );
		}
		
		update_post_meta ( $post_id, 'uss_config_general', $s_general_settings );
		update_post_meta ( $post_id, 'uss_config_autoplay', $s_autoplay_settings );
		update_post_meta ( $post_id, 'uss_config_navigation', $s_nav_settings );
		update_post_meta ( $post_id, 'uss_config_pagination', $s_pagination_settings );
		update_post_meta ( $post_id, 'uss_config_breakpoints_slides', $s_breakpoints_slides );
		update_post_meta ( $post_id, 'uss_config_breakpoints_space', $s_breakpoints_space );
	}

	/**
	 * Meta data
	 * 
	 * @param array $settings Settings Array
	 * @param string $key Meta key
	 * @param mixed $default Default
	 */
	public function get_meta_value( $settings, $key, $default ) {
		$result = '';
		if ( is_array( $settings ) && isset ( $settings[ $key ] ) ) {
			$result = $settings[$key];
		}
		if ( '' == $result ) {
			$result = $default;
		}
		return $result;
	}
}

