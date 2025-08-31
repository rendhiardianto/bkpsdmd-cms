<?php
/**
 * Featured Posts block.
 *
 * @package Magazine Blocks
 */

namespace MagazineBlocks\BlockTypes;

defined( 'ABSPATH' ) || exit;

/**
 * Button block class.
 */
class CategoryList extends AbstractBlock {

	/**
	 * Block name.
	 *
	 * @var string Block name.
	 */
	protected $block_name = 'category-list';

	public function render( $attributes, $content, $block ) {
		$client_id = magazine_blocks_array_get( $attributes, 'clientId', '' );

		// General.
		$layout                  = magazine_blocks_array_get( $attributes, 'layout', '' );
		$layout_1_advanced_style = magazine_blocks_array_get( $attributes, 'layout1AdvancedStyle', '' );
		$layout_2_advanced_style = magazine_blocks_array_get( $attributes, 'layout2AdvancedStyle', '' );
		$layout_3_advanced_style = magazine_blocks_array_get( $attributes, 'layout3AdvancedStyle', '' );
		$post_box_style          = magazine_blocks_array_get( $attributes, 'postBoxStyle', 'true' );
		$icon_list               = magazine_blocks_array_get( $attributes, 'listIcon', '' );
		$get_icon                = magazine_blocks_get_icon( $icon_list['icon'], false );
		$enable_icon             = $icon_list['enable'];

		$count = magazine_blocks_array_get( $attributes, 'categoryCount', '4' );

		// Heading
		$enable_heading                  = magazine_blocks_array_get( $attributes, 'enableHeading', '' );
		$heading_layout                  = magazine_blocks_array_get( $attributes, 'headingLayout', '' );
		$heading_layout_1_advanced_style = magazine_blocks_array_get( $attributes, 'headingLayout1AdvancedStyle', '' );
		$heading_layout_2_advanced_style = magazine_blocks_array_get( $attributes, 'headingLayout2AdvancedStyle', '' );
		$heading_layout_3_advanced_style = magazine_blocks_array_get( $attributes, 'headingLayout3AdvancedStyle', '' );
		$heading_layout_4_advanced_style = magazine_blocks_array_get( $attributes, 'headingLayout4AdvancedStyle', '' );
		$heading_layout_5_advanced_style = magazine_blocks_array_get( $attributes, 'headingLayout5AdvancedStyle', '' );
		$label                           = magazine_blocks_array_get( $attributes, 'label', 'Categories' );

		if ( 'layout-1' === $layout ) {
			$advanced_style = $layout_1_advanced_style;
		} elseif ( 'layout-2' === $layout ) {
			$advanced_style = $layout_2_advanced_style;
		} elseif ( 'layout-3' === $layout ) {
			$advanced_style = $layout_3_advanced_style;
			if ( $post_box_style ) {
				$advanced_style .= ' separator';
			}
		}

		if ( 'heading-layout-1' === $heading_layout ) {
			$heading_style = $heading_layout_1_advanced_style;
		} elseif ( 'heading-layout-2' === $heading_layout ) {
			$heading_style = $heading_layout_2_advanced_style;
		} elseif ( 'heading-layout-3' === $heading_layout ) {
			$heading_style = $heading_layout_3_advanced_style;
		} elseif ( 'heading-layout-4' === $heading_layout ) {
			$heading_style = $heading_layout_4_advanced_style;
		} elseif ( 'heading-layout-5' === $heading_layout ) {
			$heading_style = $heading_layout_5_advanced_style;
		}

		$categories = get_categories(
			array(
				'hide_empty'          => 1,
				'number'              => $count,
				'ignore_sticky_posts' => 1,
			)
		);

		# The Loop.
		$html = '';

		$html .= '<div class="mzb-category-list mzb-category-list-' . esc_attr( $client_id ) . '">';
		$html .= $enable_heading ? '<div class="mzb-post-heading mzb-' . esc_attr( $heading_layout ) . ' mzb-' . esc_attr( $heading_style ) . '"><h2 class="mzb-heading-text">' . esc_html( $label ) . '</h2></div>' : '';

		if ( '' !== $advanced_style ) {
			$advanced_style_class = $advanced_style;
		} else {
			$advanced_style_class = '';
		}

		$html .= '<div class="mzb-posts mzb-' . esc_attr( $layout ) . ' ' . esc_attr( $advanced_style_class ) . '">';
		foreach ( $categories as $category ) {
			$cat_id = get_cat_ID( $category->cat_name );
			$src    = get_category_image( $category->slug );
			$html  .= '<div class="mzb-post mzb-' . $cat_id . '">';
			if ( 'layout-1-style-2' === $advanced_style ) {
				$html .= '<div class="mzb-title-wrapper" style="background-image: url(' . esc_url( $src ) . ');">';
				$html .= '<div class="mzb-title"' . ( function_exists( 'colormag_category_color' ) ? ' style="background-color:' . colormag_category_color( $cat_id ) . ';"' : '' ) . '>';
				$html .= '<span class="mzb-post-categories"><a href="' . get_category_link( $cat_id ) . '">' . get_cat_name( $cat_id ) . '</a></span>';
				$html .= '<div class="mzb-post-count-wrapper">';
				$html .= '<div class="mzb-post-count"><a href="' . get_category_link( $cat_id ) . '"> ' . $category->category_count . ' Posts </a></div>';
				$html .= '</div>';
				$html .= '</div>';
				$html .= '</div>';
			} else {
				$html     .= '<div class="mzb-title-wrapper" style="background-image: url(' . esc_url( $src ) . ');">';
				$html     .= '<span class="mzb-post-categories">' .
						( $enable_icon ? '<span class="mzb-list-icon">' . $get_icon . '</span>' : '' ) .
						'<a href="' . get_category_link( $cat_id ) . '">' . get_cat_name( $cat_id ) . '</a></span>';
				$html     .= '</div>';
				$html     .= '<div class="mzb-post-count-wrapper">';
				$html     .= '<div class="mzb-post-count">';
					$html .= '(<a href="' . get_category_link( $cat_id ) . '"> ' . $category->category_count . ' <span class="mzb-post-count-text">Posts</span> </a>)';
				$html     .= '</div>';
				$html     .= '</div>';
			}

			$html .= '</div>';
		}
		$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
}

function get_category_image( $cat_slug ) {
	$args = array(
		'category_name' => $cat_slug,
		'post_per_page' => 1,
		'order_by'      => 'date',
		'order '        => 'desc',
	);
	$post = get_posts( $args );
	if ( $post ) {
		$post_id = $post[0]->ID;
		if ( has_post_thumbnail( $post_id ) ) {
			return get_the_post_thumbnail_url( $post_id );
		}
	}
}
