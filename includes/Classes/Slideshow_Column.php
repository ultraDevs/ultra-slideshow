<?php
namespace UltraSlideshow\Classes;
/**
 * Custom Slideshow Column
 *
 * @package UltraSlideShow
 * @since 1.0.0
 */

/**
 * Custom Slideshow Column  class
 *
 * This class helps to customize Slideshow column
 *
 * @package UltraSlideShow
 * @since    1.0.0
 */
class SlideshowColumn {

	/**
	 * Filter Slideshow column
	 *
	 * @since 1.0.0
	 * @param array $columns Post Type Column.
	 */
	public function filter_slideshows_column( $columns ) {
		$columns = array(
			'cb'        => $columns['cb'],
			'title'     => __( 'Title', 'ultra-slideshow' ),
			'shortcode' => __( 'Shortcode', 'ultra-slideshow' ),
			'author' => __( 'Author', 'ultra-slideshow' ),
			'date'      => __( 'Date', 'ultra-slideshow' ),
		);
		return $columns;

	}

	/**
	 * Customize Column Data
	 *
	 * @since 1.0.0
	 * @param string $column Column.
	 * @param int    $post_id Post ID.
	 */
	public function slideshows_custom_column( $column, $post_id ) {
		if ( 'shortcode' === $column ) {
			echo '[ultra-slideshow id=' . intval( $post_id ) . ']';
		}
	}
}