<?php
namespace UltraSlideshow;
/**
 * Core file
 *
 * A class with all core functionalities, definition, include classes
 *
 * @package UltraSlideShow
 * @since 1.0.0
 */

/**
 * Core Class
 *
 * A class with all core functionalities, definition, include classes
 *
 * @package UltraSlideShow
 * @since 1.0.0
 */
final class Init {
	/**
	 * Run
	 *
	 * @since 1.0.0
	 */
	public function run() {
		spl_autoload_register( [ $this, 'autoload' ]);
		if ( is_admin() ) {
			$this->define_admin_hooks();
		} else {
			$this->define_public_hooks();
		}

	}

	/**
	 * Autoload Classes
	 */
	public function autoload( $class ) {
		$file = preg_replace(
			[ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
			[ '', '$1_$2', '_', DIRECTORY_SEPARATOR ],
			$class
		);
		$file = ULTRA_SLIDESHOW_DIR_PATH . 'includes/' . $file . '.php';
		
		if ( file_exists( $file ) ) {
			include( $file );
		}
	}

	/**
	 * Register all of the admin hooks
	 *
	 * @since 1.0.0
	 */
	public function define_admin_hooks() {
		$us_enquequ = new Classes\EnqueueScripts();
		add_action( 'admin_enqueue_scripts', array( $us_enquequ, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $us_enquequ, 'enqueue_admin_scripts' ) );

		$custom_post_type = new Classes\CustomPostType();
		add_action( 'init', array( $custom_post_type, 'custom_post_type' ) );
		

		$custom_meta_box = new Classes\CustomMetaBox();
		add_action( 'add_meta_boxes', array( $custom_meta_box, 'meta_box' ) );
		add_action( 'save_post', array( $custom_meta_box, 'save' ) );

		$customized_column = new Classes\SlideshowColumn();
		add_filter( 'manage_ud_slideshow_posts_columns', array( $customized_column, 'filter_slideshows_column' ) );
		add_action( 'manage_ud_slideshow_posts_custom_column', array( $customized_column, 'slideshows_custom_column' ), 10, 2 );

	}

	/**
	 * Register all of the public hooks
	 *
	 * @since 1.0.0
	 */
	public function define_public_hooks() {
		$us_enquequ = new Classes\EnqueueScripts();
		add_action( 'wp_enqueue_scripts', array( $us_enquequ, 'enqueue_public_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $us_enquequ, 'enqueue_public_scripts' ) );

		$us_shortcode = new Classes\Shortcode();
		add_shortcode( 'ultra-slideshow', array( $us_shortcode, 'slideshow_by_id' ) );

	}
}
