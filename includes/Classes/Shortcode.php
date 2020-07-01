<?php
namespace UltraSlideshow\Classes;
/**
 * Shortcode
 *
 * @package UltraSlideShow
 * @since 1.0.0
 */

/**
 * Shortcode class
 *
 * This class is for registering shortcode
 *
 * @package UltraSlideShow
 * @since 1.0.0
 */
class Shortcode {
	/**
	 * Slide ID
	 *
	 * @var int
	 * @access protected
	 */
	protected $ID;

	/**
	 * Shortcode for displaying slider
	 *
	 * @since 1.0.0
	 * @param array $atts User defined attributes.
	 */
	public function slideshow_by_id( $atts ) {
		if ( ! isset( $atts['id'] ) ) {
			return;
		}
		$this->ID = sanitize_text_field( $atts['id'] );

		$slides  = get_post(
			array(
				'p'         => $this->ID,
				'post_type' => 'ud_slideshow',
			)
		);
		$gallery = get_post_meta( $this->ID, 'uss_gallery', true );
		
		$general_settings = get_post_meta( $this->ID, 'uss_config_general', true );

		$autoplay_settings = get_post_meta( $this->ID, 'uss_config_autoplay', true );
		$autoplay_enabled = $autoplay_settings['autoPlay'];

		$navigation_settings = get_post_meta( $this->ID, 'uss_config_navigation', true );
		$navigation_enabled = $navigation_settings['nav'];

		$pagination_settings = get_post_meta( $this->ID, 'uss_config_pagination', true );
		$pagination_enabled = $pagination_settings['pagination'];

		$breakpoints_slides = get_post_meta( $this->ID, 'uss_config_breakpoints_slides', true );
		$breakpoints_space = get_post_meta( $this->ID, 'uss_config_breakpoints_space', true );

		$general = wp_json_encode( array(
			"initialSlide"          => (int) $general_settings['initialSlide'],
			"direction"             => $general_settings['direction'],
			"speed"                 => (int) $general_settings['speed'],
			"autoHeight"            => (bool) filter_var( $general_settings['autoHeight'], FILTER_VALIDATE_BOOLEAN),
			"effect"                => $general_settings['effect'],
			"slidesPerView"         => (int) $general_settings['slidesPerView'],
			"slidesPerColumn"       => (int) $general_settings['slidesPerColumn'],
			"spaceBetween"          => (int) $general_settings['spaceBetween'],
		));


		if ( 'true' == $autoplay_enabled ) {
			$autoplay = wp_json_encode( array (
				'delay'                 => (int) $autoplay_settings['delay'],
				'stopOnLastSlide'       => filter_var( $autoplay_settings['stopOnLastSlide'], FILTER_VALIDATE_BOOLEAN),
				'disableOnInteraction'  => filter_var( $autoplay_settings['disableOnInteraction'], FILTER_VALIDATE_BOOLEAN),
				'reverseDirection'      => filter_var( $autoplay_settings['reverseDirection'], FILTER_VALIDATE_BOOLEAN),
				'waitForTransition'     => filter_var( $autoplay_settings['waitForTransition'], FILTER_VALIDATE_BOOLEAN)
			) );
		} else {
			$autoplay = $autoplay_enabled;
		}


		
		if ( 'true' == $navigation_enabled ) {
			$navigation = wp_json_encode( array(
				'disabledClass' => "swiper-button-disabled",
				'hiddenClass' => "swiper-button-hidden",
				'nextEl' => ".swiper-button-next",
				'prevEl' => ".swiper-button-prev",
			));
		} else {
			$navigation = $navigation_enabled;
		}

		if ( 'true' == $pagination_enabled ) {
			$pagination = wp_json_encode(
				array ( 
					"type"                  => $pagination_settings['type'],
					"clickable"             => filter_var( $pagination_settings['clickable'] , FILTER_VALIDATE_BOOLEAN),
					"el"                    => '.swiper-pagination',
					"bulletElement"         => 'span',
					"bulletClass"           => 'swiper-pagination-bullet',
					"currentClass"          => 'swiper-pagination-current',
					"bulletActiveClass"     => 'swiper-pagination-bullet-active',
					"clickableClass"        => 'swiper-pagination-clickable',
					"lockClass"             => 'swiper-pagination-lock',
				)
			);
		} else {
			$pagination = $pagination_enabled;
		}

		$breakpoints = wp_json_encode( array(
				640 => array(
					'slidesPerView' => (int) $breakpoints_slides[640],
					'spaceBetween' => (int) $breakpoints_space[640],
				),
				768 => array(
					'slidesPerView' => (int) $breakpoints_slides[768],
					'spaceBetween' => (int) $breakpoints_space[768],
				),
				1024 => array(
					'slidesPerView' => (int) $breakpoints_slides[1024],
					'spaceBetween' => (int) $breakpoints_space[1024],
				),
			)
		);

		$images = explode( ',', $gallery );
		ob_start();
		?>
		<div class="ud-slideshow">
			<div class="swiper-container" data-uslider='uss-<?php echo $atts['id'];?>' data-general='<?php echo $general; ?>' data-autoplay='<?php echo $autoplay; ?>' data-navigation='<?php echo $navigation;?>' data-pagination='<?php echo $pagination;?>' data-breakpoints='<?php echo $breakpoints;?>'>
				<div class="swiper-wrapper">
				<?php
				foreach ( $images as $img ) {
					?>
					<div class="swiper-slide">
						<img src="<?php echo esc_url( wp_get_attachment_image_src( $img, 'full' )[0] ); ?>" alt="">
					</div>
					<?php
				}
				?>
				</div>
				<?php
				if ( 'true' == $pagination_enabled ) {
				?>
				<!-- If we need pagination -->
				<div class="swiper-pagination"></div>
				<?php } ?>

				<?php
				if ( 'true' == $navigation_enabled ) {
				?>
				<!-- If we need navigation buttons -->
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
				<?php } ?>
				
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}