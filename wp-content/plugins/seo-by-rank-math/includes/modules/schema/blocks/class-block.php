<?php
/**
 * The Block Base
 *
 * @since      0.9.0
 * @package    RankMath
 * @subpackage RankMath\Schema
 * @author     Rank Math <support@rankmath.com>
 */

namespace RankMath\Schema;

use RankMath\Helper;
use RankMath\Traits\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * Block class.
 */
class Block {

	/**
	 * Function to certain tags from the text.
	 *
	 * @param string $text Block content.
	 *
	 * @return string
	 */
	protected function clean_text( $text ) {
		return strip_tags( $text, '<h1><h2><h3><h4><h5><h6><br><ol><ul><li><a><p><b><strong><i><em>' );
	}

	/**
	 * Function to get the block image.
	 *
	 * @param array  $attrs       Block attributes data.
	 * @param string $size        Image size.
	 * @param string $image_class Attachment image class.
	 *
	 * @return string The HTML image element.
	 */
	protected function get_image( $attrs, $size = 'thumbnail', $image_class = 'class=alignright' ) {
		$image_id = empty( $attrs['imageID'] ) ? '' : absint( $attrs['imageID'] );
		if ( ! $image_id ) {
			return '';
		}

		$html = wp_get_attachment_image( $image_id, $size, false, $image_class );

		return $html ? $html : wp_get_attachment_image( $image_id, 'full', false, $image_class );
	}

	/**
	 * Get styles
	 *
	 * @param array $attributes Array of attributes.
	 *
	 * @return string
	 */
	protected function get_styles( $attributes ) {
		return empty( $attributes['textAlign'] ) || ! in_array( $attributes['textAlign'], [ 'right', 'center' ], true )
			? ''
			: ' style="text-align:' . $attributes['textAlign'] . '"';
	}

	/**
	 * Get list style
	 *
	 * @param string $style Style.
	 *
	 * @return string
	 */
	protected function get_list_style( $style ) {
		if ( 'numbered' === $style ) {
			return 'ol';
		}

		return 'unordered' === $style ? 'ul' : 'div';
	}

	/**
	 * Get list item style
	 *
	 * @param string $style Style.
	 *
	 * @return string
	 */
	protected function get_list_item_style( $style ) {
		return in_array( $style, [ 'numbered', 'unordered' ], true ) ? 'li' : 'div';
	}

	/**
	 * Get title wrapper tag.
	 *
	 * @param string $title_wrapper Title wrapper attribute.
	 * @param string $block         Block name.
	 */
	protected function get_title_wrapper( $title_wrapper, $block = 'faq' ) {
		$wrapper = in_array( $title_wrapper, [ 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div' ], true ) ? $title_wrapper : 'h2';

		return apply_filters( "rank_math/blocks/{$block}/title_wrapper", $wrapper );
	}

	/**
	 * Normalize the block text.
	 *
	 * @param string $text  Text.
	 * @param string $block Block name.
	 *
	 * @return string
	 */
	protected function normalize_text( $text, $block ) {
		/**
		 * Filter: Allow developers to preserve line breaks.
		 *
		 * @param bool   $return If set, this will convert all remaining line breaks after paragraphing.
		 * @param string $block  Block name.
		 */
		return wpautop( wp_kses_post( $text ), apply_filters( 'rank_math/block/preserve_line_breaks', true, $block ) );
	}
}
