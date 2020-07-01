<?php
namespace UltraSlideshow\Classes;
/**
 * Custom post type
 *
 * @package UltraSlideShow
 * @since 1.0.0
 */

/**
 * Custom post type class
 *
 * This class is for registering custom post type
 *
 * @package UltraSlideShow
 * @since 1.0.0
 */
class CustomPostType {

	/**
	 * Post Type Labels
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $labels;

	/**
	 * Post Type Args
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $args;

	/**
	 * Register new custom post type
	 *
	 * This method will register custom post type
	 *
	 * @since 1.0.0
	 */
	public function custom_post_type() {
		$this->labels = array(
			'name'          => _x( 'Slideshow', 'Post type general name', 'ultra-slideshow' ),
			'singular_name' => _x( 'Slideshow', 'Post type singular name', 'ultra-slideshow' ),
			'menu_name'     => _x( 'Slideshow', 'Admin Menu title', 'ultra-slideshow' ),
		);
		$this->args   = array(
			'labels'    => $this->labels,
			'public'    => false,
			'show_ui'   => true,
			'menu_icon' => 'dashicons-slides',
			'supports'  => array(
				'title',
			),
		);
		register_post_type( 'ud_slideshow', $this->args );
	}

}
