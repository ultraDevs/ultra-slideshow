<?php
namespace UltraSlideshow\Classes;
/**
 * Enqueue styles scripts functionality
 *
 * @package UltraSlideShow
 * @since 1.0.0
 */

/**
 * Enqueue styles scripts class
 *
 * This class is for enqueuing styles, scripts
 *
 * @package UltraSlideShow
 * @since 1.0.0
 */
class EnqueueScripts {
	/**
	 * Register admin stylesheets
	 *
	 * @since 1.0.0
	 */
	public function enqueue_admin_styles() {

		wp_enqueue_style( 'us-admin', ULTRA_SLIDESHOW_ASSETS . 'admin/css/us-admin.css', array(), ULTRA_SLIDESHOW_VERSION, 'all' );
	}

	/**
	 * Register admin scripts
	 *
	 * @since 1.0.0
	 */
	public function enqueue_admin_scripts() {

		wp_enqueue_script( 'us-admin', ULTRA_SLIDESHOW_ASSETS . 'admin/js/us-admin.js', array( 'jquery' ), ULTRA_SLIDESHOW_VERSION, false );

		wp_register_script( 'us-gallery', ULTRA_SLIDESHOW_ASSETS . 'admin/js/gallery.js', array(), ULTRA_SLIDESHOW_VERSION, false );
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}
		wp_enqueue_script( 'us-gallery' );
	}

	/**
	 * Register public stylesheets
	 *
	 * @since 1.0.0
	 */
	public function enqueue_public_styles() {

		wp_enqueue_style( 'us-public', ULTRA_SLIDESHOW_ASSETS . 'public/css/us-public.css', array(), ULTRA_SLIDESHOW_VERSION, 'all' );
		wp_enqueue_style( 'us-swiper', ULTRA_SLIDESHOW_ASSETS . 'public/swiper/css/swiper.min.css', array(), ULTRA_SLIDESHOW_VERSION, 'all' );
	}

	/**
	 * Register public scripts
	 *
	 * @since 1.0.0
	 */
	public function enqueue_public_scripts() {

		wp_enqueue_script( 'us-swiper', ULTRA_SLIDESHOW_ASSETS . 'public/swiper/js/swiper.min.js', array( 'jquery' ), ULTRA_SLIDESHOW_VERSION, true );
		wp_enqueue_script( 'us-public', ULTRA_SLIDESHOW_ASSETS . 'public/js/us-public.js', array(), ULTRA_SLIDESHOW_VERSION, true );
	}
}
