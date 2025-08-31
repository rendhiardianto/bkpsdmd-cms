<?php

/**
 * Featured Posts block.
 *
 * @package Magazine Blocks
 */

namespace MagazineBlocks\BlockTypes;

use WP_Query;

defined( 'ABSPATH' ) || exit;

/**
 * Button block class.
 */
class TabPost extends AbstractBlock {

	/**
	 * Block name.
	 *
	 * @var string Block name.
	 */
	protected $block_name = 'tab-post';

	public function render( $attributes, $content, $block ) {

		$client_id         = magazine_blocks_array_get( $attributes, 'clientId', '' );
		$class_name        = magazine_blocks_array_get( $attributes, 'className', '' );
		$css_id            = magazine_blocks_array_get( $attributes, 'cssID', '' );
		$post_count        = magazine_blocks_array_get( $attributes, 'postCount', '4' );
		$post_title_markup = magazine_blocks_array_get( $attributes, 'postTitleMarkup', 'h3' );

		// Query.
		$category          = magazine_blocks_array_get( $attributes, 'category', '' );
		$tag               = magazine_blocks_array_get( $attributes, 'tag', '' );
		$excluded_category = magazine_blocks_array_get( $attributes, 'excludedCategory', '' );
		$order_by          = magazine_blocks_array_get( $attributes, 'orderBy', '' );
		$order_type        = magazine_blocks_array_get( $attributes, 'orderType', '' );
		$author            = magazine_blocks_array_get( $attributes, 'authorName', '' );

		// Header Meta.
		$enable_category = magazine_blocks_array_get( $attributes, 'enableCategory', '' );

		// Meta.
		$meta_position  = magazine_blocks_array_get( $attributes, 'metaPosition', '' );
		$enable_author  = magazine_blocks_array_get( $attributes, 'enableAuthor', '' );
		$enable_date    = magazine_blocks_array_get( $attributes, 'enableDate', '' );
		$meta_separator = magazine_blocks_array_get( $attributes, 'separatorType', 'none' );
		$enable_icon    = magazine_blocks_array_get( $attributes, 'enableIcon', '' );
		$enable_excerpt = magazine_blocks_array_get( $attributes, 'enableExcerpt', true );

		// Offset.
		$offset = magazine_blocks_array_get( $attributes, 'offset', 0 );

		$args = array(
			'posts_per_page'      => $post_count,
			'post_status'         => 'publish',
			'cat'                 => $category,
			'tag_id'              => $tag,
			'orderby'             => $order_by,
			'order'               => $order_type,
			'author'              => $author,
			'category__not_in'    => $excluded_category,
			'ignore_sticky_posts' => 1,
			'offset'              => $offset,
		);

		$popular = array(
			'posts_per_page' => $post_count,
			'orderby'        => 'comment_count',
			'post_status'    => 'publish',
		);

		$type = get_query_var( 'mzb_template_type' );

		if ( in_array( $type, [ 'archive', 'search', 'single', 'front' ], true ) ) {
			unset( $args['cat'], $args['tag_id'], $args['orderby'], $args['order'], $args['author'], $args['category__not_in'], $args['ignore_sticky_posts'], $args['paged'], $args['offset'] );
			$paged = get_query_var( 'paged' );
			switch ( get_query_var( 'mzb_template_type' ) ) {
				case 'archive':
					if ( is_archive() ) {
						if ( is_category() ) {
							$args['category_name'] = get_query_var( 'category_name' );
						} elseif ( is_tag() ) {
							$args['tag'] = get_query_var( 'tag' );
						} elseif ( is_author() ) {
							$args['author'] = get_query_var( 'author' );
						}
					}
					break;
				case 'search':
					$args['s'] = get_search_query();
					break;
			}
		}

		$query = new WP_Query( $args );

		$popular_query = new WP_Query( $popular );

		# The Loop.
		$html = '';

		$html .= '<div id="' . esc_attr( $css_id ) . '" class="mzb-tab-post mzb-tab-post-' . esc_attr( $client_id ) . ' ' . esc_attr( $class_name ) . '" data-active-tab="latest">';
		$html .= '<div class="mzb-tab-controls">';
		$html .= '<div data-tab="latest" class="mzb-tab-title active">' . esc_html__( 'Latest', 'magazine-blocks' ) . '</div>';
		$html .= '<div data-tab="popular" class="mzb-tab-title">' . esc_html__( 'Popular', 'magazine-blocks' ) . '</div>';
		$html .= '</div>';
		$html .= '<div class="mzb-posts" data-posts="latest">';

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$id    = get_post_thumbnail_id();
				$src   = wp_get_attachment_image_src( $id );
				$src   = has_post_thumbnail( get_the_ID() ) ? get_the_post_thumbnail_url( get_the_ID() ) : '';
				$image = $src ? '<div class="mzb-featured-image"><a href="' . esc_url( get_the_permalink() ) . '"><img src="' . esc_url( $src ) . '" alt="' . esc_attr( get_the_title() ) . '"/> </a></div>' : '';
				if ( ! $src ) {
					$position_class = 'no-thumbnail';
				} else {
					$position_class = '';
				}
				$title    = '<' . $post_title_markup . ' class="mzb-post-title"><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a></' . $post_title_markup . '>';
				$category = ( true === $enable_category ) ? '<span class="mzb-post-categories">' . get_the_category_list( ' ' ) . '</span>' : '';
				$author   = ( true === $enable_author ) ? '<span class="mzb-post-author" >' . ( ( true === $enable_icon ) ? '<img class="post-author-image" src="' . get_avatar_url( get_the_author_meta( 'ID' ) ) . '" alt="' . esc_attr( get_the_author() ) . '" />' : '' ) . get_the_author_posts_link() . '</span>' : '';
				$date     = ( true === $enable_date ) ? '<span class ="mzb-post-date">' . ( ( true === $enable_icon ) ? '<svg class="mzb-icon mzb-icon--calender" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
								<path d="M1.892 12.929h10.214V5.5H1.892v7.429zm2.786-8.822v-2.09a.226.226 0 00-.066-.166.226.226 0 00-.166-.065H3.98a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.022.122.065.166.044.044.1.065.167.065h.465a.226.226 0 00.166-.065.226.226 0 00.066-.167zm5.571 0v-2.09a.226.226 0 00-.065-.166.226.226 0 00-.167-.065h-.464a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.021.122.065.166.043.044.099.065.167.065h.464a.226.226 0 00.167-.065.226.226 0 00.065-.167zm2.786-.464v9.286c0 .251-.092.469-.276.652a.892.892 0 01-.653.276H1.892a.892.892 0 01-.653-.275.892.892 0 01-.276-.653V3.643c0-.252.092-.47.276-.653a.892.892 0 01.653-.276h.929v-.696c0-.32.113-.593.34-.82.228-.227.501-.34.82-.34h.465c.319 0 .592.113.82.34.227.227.34.5.34.82v.696h2.786v-.696c0-.32.114-.593.34-.82.228-.227.501-.34.82-.34h.465c.32 0 .592.113.82.34.227.227.34.5.34.82v.696h.93c.25 0 .468.092.652.276a.892.892 0 01.276.653z" />
							</svg>' : '' ) .
							'<a href="' . esc_url( get_the_permalink() ) . '"> ' . get_the_date() . '</a></span>' : '';
				$html    .= '<div class="mzb-post ' . esc_attr( $position_class ) . '">';
				$html    .= $image;
				$html    .= '<div class="mzb-post-content">';
				if ( $enable_category ) {
					$html .= '<div class="mzb-post-meta">';
					$html .= $category;
					$html .= '</div>';
				}
				if ( 'top' === $meta_position ) {
					if ( $enable_author || $enable_date ) {
						$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . esc_attr( $meta_separator ) . '">';
						$html .= $enable_author ? $author : '';
						$html .= $enable_date ? $date : '';
						$html .= '</div>';
					}
				}
				if ( $enable_excerpt ) {
					$html .= $title;
				}
				if ( 'bottom' === $meta_position ) {
					if ( $enable_author || $enable_date ) {
						$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . esc_attr( $meta_separator ) . '">';
						$html .= $enable_author ? $author : '';
						$html .= $enable_date ? $date : '';
						$html .= '</div>';
					}
				}
				$html .= '</div>';
				$html .= '</div>';
			}
			wp_reset_postdata();
		}
		$html .= '</div>';
		if ( $popular_query->have_posts() ) {
			$html .= '<div class="mzb-posts" data-posts="popular">';
			while ( $popular_query->have_posts() ) {
				$popular_query->the_post();
				$id    = get_post_thumbnail_id();
				$src   = wp_get_attachment_image_src( $id );
				$src   = has_post_thumbnail( get_the_ID() ) ? get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) : '';
				$image = $src ? '<div class="mzb-featured-image"><a href="' . esc_url( get_the_permalink() ) . '"><img src="' . esc_url( $src ) . '" alt="' . esc_attr( get_the_title() ) . '"/> </a></div>' : '';
				if ( ! $src ) {
					$position_class = 'no-thumbnail';
				} else {
					$position_class = '';
				}
				$title  = '<' . $post_title_markup . ' class="mzb-post-title"><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a></' . $post_title_markup . '>';
				$author = ( true === $enable_author ) ? '<span class="mzb-post-author" >' . ( ( true === $enable_icon ) ? '<img class="post-author-image" src="' . get_avatar_url( get_the_author_meta( 'ID' ) ) . '" alt="' . esc_attr( get_the_author() ) . '" />' : '' ) . get_the_author_posts_link() . '</span>' : '';
				$date   = ( true === $enable_date ) ? '<span class ="mzb-post-date">' . ( ( true === $enable_icon ) ? '<svg class="mzb-icon mzb-icon--calender" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
								<path d="M1.892 12.929h10.214V5.5H1.892v7.429zm2.786-8.822v-2.09a.226.226 0 00-.066-.166.226.226 0 00-.166-.065H3.98a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.022.122.065.166.044.044.1.065.167.065h.465a.226.226 0 00.166-.065.226.226 0 00.066-.167zm5.571 0v-2.09a.226.226 0 00-.065-.166.226.226 0 00-.167-.065h-.464a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.021.122.065.166.043.044.099.065.167.065h.464a.226.226 0 00.167-.065.226.226 0 00.065-.167zm2.786-.464v9.286c0 .251-.092.469-.276.652a.892.892 0 01-.653.276H1.892a.892.892 0 01-.653-.275.892.892 0 01-.276-.653V3.643c0-.252.092-.47.276-.653a.892.892 0 01.653-.276h.929v-.696c0-.32.113-.593.34-.82.228-.227.501-.34.82-.34h.465c.319 0 .592.113.82.34.227.227.34.5.34.82v.696h2.786v-.696c0-.32.114-.593.34-.82.228-.227.501-.34.82-.34h.465c.32 0 .592.113.82.34.227.227.34.5.34.82v.696h.93c.25 0 .468.092.652.276a.892.892 0 01.276.653z" />
							</svg>' : '' ) .
				                                      '<a href="' . esc_url( get_the_permalink() ) . '"> ' . get_the_date() . '</a></span>' : '';
				$html  .= '<div class="mzb-post ' . esc_attr( $position_class ) . '">';
				$html  .= $image;
				$html  .= '<div class="mzb-post-content">';
				if ( 'top' === $meta_position ) {
					if ( $enable_author || $enable_date ) {
						$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . esc_attr( $meta_separator ) . '">';
						$html .= $enable_author ? $author : '';
						$html .= $enable_date ? $date : '';
						$html .= '</div>';
					}
				}
				if ( $enable_excerpt ) {
					$html .= $title;
				}
				if ( 'bottom' === $meta_position ) {
					if ( $enable_author || $enable_date ) {
						$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . esc_attr( $meta_separator ) . '">';
						$html .= $enable_author ? $author : '';
						$html .= $enable_date ? $date : '';
						$html .= '</div>';
					}
				}
				$html .= '</div>';
				$html .= '</div>';
			}
			$html .= '</div>';
			wp_reset_postdata();
		}
		$html .= '</div>';
		return $html;
	}
}
