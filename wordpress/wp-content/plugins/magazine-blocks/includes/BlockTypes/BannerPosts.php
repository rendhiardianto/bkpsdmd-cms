<?php

/**
 * Banner Posts block.
 *
 * @package Magazine Blocks
 */

namespace MagazineBlocks\BlockTypes;

use WP_Query;
use function MagazineBlocks\mzb_numbered_pagination;

defined( 'ABSPATH' ) || exit;

/**
 * Button block class.
 */
class BannerPosts extends AbstractBlock {




	/**
	 * Block name.
	 *
	 * @var string Block name.
	 */
	protected $block_name = 'banner-posts';

	public function render( $attributes, $content, $block ) {

		$client_id  = magazine_blocks_array_get( $attributes, 'clientId', '' );
		$class_name = magazine_blocks_array_get( $attributes, 'className', '' );

		// General
		$layout                  = magazine_blocks_array_get( $attributes, 'layout', '' );
		$layout_1_advanced_style = magazine_blocks_array_get( $attributes, 'layout1AdvancedStyle', '' );
		$layout_2_advanced_style = magazine_blocks_array_get( $attributes, 'layout2AdvancedStyle', '' );
		$layout_3_advanced_style = magazine_blocks_array_get( $attributes, 'layout3AdvancedStyle', '' );
		$layout_4_advanced_style = magazine_blocks_array_get( $attributes, 'layout4AdvancedStyle', '' );
		$layout_5_advanced_style = magazine_blocks_array_get( $attributes, 'layout5AdvancedStyle', '' );
		$container               = magazine_blocks_array_get( $attributes, 'container', '' );

		// Query.
		$category          = magazine_blocks_array_get( $attributes, 'category', '' );
		$tag               = magazine_blocks_array_get( $attributes, 'tag', '' );
		$excluded_category = magazine_blocks_array_get( $attributes, 'excludedCategory', '' );
		$order_by          = magazine_blocks_array_get( $attributes, 'orderBy', '' );
		$order_type        = magazine_blocks_array_get( $attributes, 'orderType', '' );
		$author            = magazine_blocks_array_get( $attributes, 'authorName', '' );
		$post_type         = magazine_blocks_array_get( $attributes, 'postType', 'post' );

		// Post Title.
		$post_title_markup = magazine_blocks_array_get( $attributes, 'postTitleMarkup', 'h3' );
		$post_title_markup = magazine_blocks_sanitize_html_tag( $post_title_markup, 'h3' );

		// Header Meta.
		$enable_category = magazine_blocks_array_get( $attributes, 'enableCategory', true );

		// Meta.
		$meta_position    = magazine_blocks_array_get( $attributes, 'metaPosition', '' );
		$enable_author    = magazine_blocks_array_get( $attributes, 'enableAuthor', '' );
		$enable_date      = magazine_blocks_array_get( $attributes, 'enableDate', '' );
		$enable_readtime  = magazine_blocks_array_get( $attributes, 'enableReadTime', '' );
		$enable_viewcount = magazine_blocks_array_get( $attributes, 'enableViewCount', '' );
		$enable_icon      = magazine_blocks_array_get( $attributes, 'enableIcon', '' );
		$meta_separator   = magazine_blocks_array_get( $attributes, 'separatorType', 'none' );

		// Excerpt.
		$enable_excerpt   = magazine_blocks_array_get( $attributes, 'enableExcerpt', '' );
		$excerpt_limit    = magazine_blocks_array_get( $attributes, 'excerptLimit', '' );
		$excerpt_position = magazine_blocks_array_get( $attributes, 'excerptPosition', '' );

		// ReadMore.
		$enable_readmore = magazine_blocks_array_get( $attributes, 'enableReadMore', '' );
		$read_more_text  = magazine_blocks_array_get( $attributes, 'readMoreText', '' );

		// Pagination
		$enable_pagination = magazine_blocks_array_get( $attributes, 'enablePagination', '' );

		//offset
		$offset = magazine_blocks_array_get( $attributes, 'offset', 0 );

		// Featured Image.
		$hover_animation = magazine_blocks_array_get( $attributes, 'hoverAnimation', '' );

		// Pagination.
		$paged         = isset( $_GET[ 'block_id_' . $client_id ] ) ? max( 1, intval( $_GET[ 'block_id_' . $client_id ] ) ) : 1;
		$args['paged'] = $paged;

		$post_box_wrapper_border = magazine_blocks_array_get( $attributes, 'postBoxWrapperBorder', '' );
		if ( isset( $post_box_wrapper_border['border'] ) ) {
			$post_box_wrapper_border = $post_box_wrapper_border['border'];
		} else {
			$post_box_wrapper_border = '';
		}

		$args = array(
			'post_type'           => $post_type,
			'posts_per_page'      => (
				'layout-1' === $layout ? 4 : ( 'layout-2' === $layout ? 3 : ( 'layout-3' === $layout ? 2 : ( 'layout-4' === $layout ? 5 : 4 ) ) )
			),
			'status'              => 'publish',
			'cat'                 => $category,
			'tag_id'              => $tag,
			'orderby'             => $order_by,
			'order'               => $order_type,
			'author'              => $author,
			'category__not_in'    => $excluded_category,
			'ignore_sticky_posts' => 1,
			'offset'              => $offset,
			'paged'               => $paged,
		);

		// Define the custom excerpt length function as an anonymous function
		$custom_excerpt_length = function ( $length ) use ( $excerpt_limit ) {
			return $excerpt_limit; // Change this number to your desired word limit
		};

		// Add the filter to modify the excerpt length using the anonymous function
		add_filter( 'excerpt_length', $custom_excerpt_length );

		if ( 'layout-1' === $layout ) {
			$advanced_style = $layout_1_advanced_style;
		} elseif ( 'layout-2' === $layout ) {
			$advanced_style = $layout_2_advanced_style;
		} elseif ( 'layout-3' === $layout ) {
			$advanced_style = $layout_3_advanced_style;
		} elseif ( 'layout-4' === $layout ) {
			$advanced_style = $layout_4_advanced_style;
		} elseif ( 'layout-5' === $layout ) {
			$advanced_style = $layout_5_advanced_style;
		}

		if ( 'layout-2' === $layout ) {
			$args = array(
				'posts_per_page'      => (
					'layout-2' === $layout ? 3 : ( 'layout-3' === $layout ? 2 : ( 'layout-4' === $layout ? 5 : 4 )
					)
				),
				'status'              => 'publish',
				'cat'                 => $category,
				'tag_id'              => $tag,
				'orderby'             => $order_by,
				'order'               => $order_type,
				'author'              => $author,
				'category__not_in'    => $excluded_category,
				'ignore_sticky_posts' => 1,
				'paged'               => $paged, // Use the paged parameter.
				'offset'              => $offset,
			);
		}

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

		$query = new WP_Query(
			$args
		);

		# The Loop.
		$html = '';

		if ( $query->have_posts() ) {
			$html .= '<div class="mzb-banner-posts mzb-banner-posts-' . esc_attr( $client_id ) . ' ' . esc_attr( $class_name ) . ( 'layout-5' === $layout && 'layout-5-style-2' === $advanced_style && 'stretched' === $container ? 'mzb-alignfull' : '' ) . '">';
			$html .= '<div class="mzb-posts mzb-' . esc_attr( $layout ) . ' mzb-' . esc_attr( $advanced_style ) . '">';

			$index = 1;
			if ( 'layout-5-style-2' === $advanced_style ) {
				$query->the_post();
				$id         = get_post_thumbnail_id();
				$src        = wp_get_attachment_image_src( $id );
				$src        = has_post_thumbnail( get_the_ID() ) ? get_the_post_thumbnail_url( get_the_ID() ) : '';
				$image      = $src ? ' <div class="mzb-featured-image ' . $hover_animation . '"><a href="' . esc_url( get_the_permalink() ) . '"alt="' . get_the_title() . '"/><img src="' . esc_url( $src ) . '" alt="' . get_the_title() . '"/></a></div>' : '';
				$title      = '<' . $post_title_markup . ' class="mzb-post-title"><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a></' . $post_title_markup . '>';
				$category   = ( true === $enable_category ) ? '<span class="mzb-post-categories">' . get_the_category_list( ' ' ) . '</span>' : '';
				$author     = ( true === $enable_author ) ? '<span class="mzb-post-author" >' . ( ( true === $enable_icon ) ? '<img class="post-author-image" src="' . get_avatar_url( get_the_author_meta( 'ID' ) ) . ' "/>' : '' ) . get_the_author_posts_link() . '</span>' : '';
				$date       = ( true === $enable_date ) ? '<span class ="mzb-post-date">' . ( ( true === $enable_icon ) ? '<svg class="mzb-icon mzb-icon--calender" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
									<path d="M1.892 12.929h10.214V5.5H1.892v7.429zm2.786-8.822v-2.09a.226.226 0 00-.066-.166.226.226 0 00-.166-.065H3.98a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.022.122.065.166.044.044.1.065.167.065h.465a.226.226 0 00.166-.065.226.226 0 00.066-.167zm5.571 0v-2.09a.226.226 0 00-.065-.166.226.226 0 00-.167-.065h-.464a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.021.122.065.166.043.044.099.065.167.065h.464a.226.226 0 00.167-.065.226.226 0 00.065-.167zm2.786-.464v9.286c0 .251-.092.469-.276.652a.892.892 0 01-.653.276H1.892a.892.892 0 01-.653-.275.892.892 0 01-.276-.653V3.643c0-.252.092-.47.276-.653a.892.892 0 01.653-.276h.929v-.696c0-.32.113-.593.34-.82.228-.227.501-.34.82-.34h.465c.319 0 .592.113.82.34.227.227.34.5.34.82v.696h2.786v-.696c0-.32.114-.593.34-.82.228-.227.501-.34.82-.34h.465c.32 0 .592.113.82.34.227.227.34.5.34.82v.696h.93c.25 0 .468.092.652.276a.892.892 0 01.276.653z" />
								</svg>' : '' ) .
					'<a href="' . esc_url( get_the_permalink() ) . '"> ' . get_the_date() . '</a></span>' : '';
				$view       = get_post_meta( get_the_ID(), '_mzb_post_view_count', true );
				$read_time  = $enable_readtime ? '<span class="mzb-post-read-time">' .
					( ( true === $enable_icon ) ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
								<path fill-rule="evenodd" d="M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18ZM1 12C1 5.925 5.925 1 12 1s11 4.925 11 11-4.925 11-11 11S1 18.075 1 12Z" clip-rule="evenodd"/>
								<path fill-rule="evenodd" d="M12 5a1 1 0 0 1 1 1v5.382l3.447 1.724a1 1 0 1 1-.894 1.788l-4-2A1 1 0 0 1 11 12V6a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
								</svg>' : '' ) .
					'<span>' .
					self::calculate_read_time( $id ) . '
								min
								read
								</span>
								</span>' : '';
				$view_count = $enable_viewcount ? '<span class="mzb-post-view-count">' .
					( ( true === $enable_icon ) ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
								<path d="M12 17.9c-4.2 0-7.9-2.1-9.9-5.5-.2-.3-.2-.6 0-.9C4.1 8.2 7.8 6 12 6s7.9 2.1 9.9 5.5c.2.3.2.6 0 .9-2 3.4-5.7 5.5-9.9 5.5zM3.9 12c1.6 2.6 4.8 4.2 8.1 4.2s6.4-1.6 8.1-4.2c-1.6-2.6-4.7-4.2-8.1-4.2S5.6 9.4 3.9 12zm8.1 3.3c-1.8 0-3.3-1.5-3.3-3.3s1.5-3.3 3.3-3.3 3.3 1.5 3.3 3.3-1.5 3.3-3.3 3.3zm0-4.9c-.9 0-1.6.8-1.6 1.6 0 .9.8 1.6 1.6 1.6s1.6-.8 1.6-1.6c0-.9-.7-1.6-1.6-1.6z" />
								</svg>' : '' ) .
					'<span>' . $view . '
																									views
																								</span>
																							</span>' : '';
				$html      .= '<div class="mzb-post mzb-first-post--highlight">';
				$html      .= '';
				$html      .= $image;
				$html      .= '<div class="mzb-post-content">';
				if ( $enable_category ) {
					$html .= '<div class="mzb-post-meta">';
					$html .= $category;
					$html .= '</div>';
				}
				if ( 'top' === $meta_position ) {

					if (
						'layout-2' !== $layout ||
						'layout-2-style-3' !== $layout_2_advanced_style ||
						( 'layout-2-style-3' === $layout_2_advanced_style && 1 === $index )
					) {
						$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . $meta_separator . '">';
						$html .= $enable_author ? $author : '';
						$html .= $enable_date ? $date : '';
						$html .= $enable_readtime ? $read_time : '';
						$html .= $enable_viewcount ? $view_count : '';
						$html .= '</div>';
					}
				}
				$html .= $title;
				if ( 'bottom' === $meta_position ) {
					if ( ( $enable_excerpt || $enable_readmore ) && 'above-meta' === $excerpt_position && ( 'layout-4' !== $layout || 1 === $index ) && ( 'layout-5' !== $layout || 1 === $index ) ) {
						$html .= '<div class="mzb-entry-content">';
						$html .= $enable_excerpt ? '<div class="mzb-entry-summary"><p> ' . get_the_excerpt() . '</p></div>' : '';
						$html .= $enable_readmore ? '<div class="mzb-read-more"><a href="' . esc_url( get_the_permalink() ) . '">' . $read_more_text . ' </a></div>' : '';
						$html .= '</div>';
					}

					if (
						'layout-2' !== $layout ||
						'layout-2-style-3' !== $layout_2_advanced_style ||
						( 'layout-2-style-3' === $layout_2_advanced_style && 1 === $index )
					) {
						$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . $meta_separator . '">';
						$html .= $enable_author ? $author : '';
						$html .= $enable_date ? $date : '';
						$html .= $enable_readtime ? $read_time : '';
						$html .= $enable_viewcount ? $view_count : '';
						$html .= '</div>';
					}

					if ( ( $enable_excerpt || $enable_readmore ) && 'below-meta' === $excerpt_position && ( 'layout-4' !== $layout || 1 === $index ) && ( 'layout-5' !== $layout || 1 === $index ) ) {
						$html .= '<div class="mzb-entry-content">';
						$html .= $enable_excerpt ? '<div class="mzb-entry-summary"><p> ' . get_the_excerpt() . '</p></div>' : '';
						$html .= $enable_readmore ? '<div class="mzb-read-more"><a href="' . esc_url( get_the_permalink() ) . '">' . $read_more_text . ' </a></div>' : '';
						$html .= '</div>';
					}
				}
				if ( ( $enable_excerpt || $enable_readmore ) && 'bottom' !== $meta_position && ( 'layout-4' !== $layout || 1 === $index ) && ( 'layout-5' !== $layout || 1 === $index ) ) {
					$html .= '<div class="mzb-entry-content">';
					$html .= $enable_excerpt ? '<div class="mzb-entry-summary"><p> ' . get_the_excerpt() . '</p></div>' : '';
					$html .= $enable_readmore ? '<div class="mzb-read-more"><a href="' . esc_url( get_the_permalink() ) . '">' . $read_more_text . ' </a></div>' : '';
					$html .= '</div>';
				}
				$html .= '</div>';
				$html .= '</div>';
				$html .= '<div class="mzb-bottom-posts-outer-wrapper">';
				$html .= '<div class="mzb-bottom-posts-wrapper' . ( $post_box_wrapper_border ? ' mzb-bottom-posts-wrapper-border' : '' ) . '">';
				while ( $query->have_posts() ) {
					$query->the_post();
					$id         = get_post_thumbnail_id();
					$src        = wp_get_attachment_image_src( $id );
					$src        = has_post_thumbnail( get_the_ID() ) ? get_the_post_thumbnail_url( get_the_ID() ) : '';
					$image      = $src ? ' <div class="mzb-featured-image ' . $hover_animation . '"><a href="' . esc_url( get_the_permalink() ) . '"alt="' . get_the_title() . '"/><img src="' . esc_url( $src ) . '" alt="' . get_the_title() . '"/></a></div>' : '';
					$title      = '<' . $post_title_markup . ' class="mzb-post-title"><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a></' . $post_title_markup . '>';
					$category   = ( true === $enable_category ) ? '<span class="mzb-post-categories">' . get_the_category_list( ' ' ) . '</span>' : '';
					$author     = ( true === $enable_author ) ? '<span class="mzb-post-author" >' . ( ( true === $enable_icon ) ? '<img class="post-author-image" src="' . get_avatar_url( get_the_author_meta( 'ID' ) ) . ' "/>' : '' ) . get_the_author_posts_link() . '</span>' : '';
					$date       = ( true === $enable_date ) ? '<span class ="mzb-post-date">' . ( ( true === $enable_icon ) ? '<svg class="mzb-icon mzb-icon--calender" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
									<path d="M1.892 12.929h10.214V5.5H1.892v7.429zm2.786-8.822v-2.09a.226.226 0 00-.066-.166.226.226 0 00-.166-.065H3.98a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.022.122.065.166.044.044.1.065.167.065h.465a.226.226 0 00.166-.065.226.226 0 00.066-.167zm5.571 0v-2.09a.226.226 0 00-.065-.166.226.226 0 00-.167-.065h-.464a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.021.122.065.166.043.044.099.065.167.065h.464a.226.226 0 00.167-.065.226.226 0 00.065-.167zm2.786-.464v9.286c0 .251-.092.469-.276.652a.892.892 0 01-.653.276H1.892a.892.892 0 01-.653-.275.892.892 0 01-.276-.653V3.643c0-.252.092-.47.276-.653a.892.892 0 01.653-.276h.929v-.696c0-.32.113-.593.34-.82.228-.227.501-.34.82-.34h.465c.319 0 .592.113.82.34.227.227.34.5.34.82v.696h2.786v-.696c0-.32.114-.593.34-.82.228-.227.501-.34.82-.34h.465c.32 0 .592.113.82.34.227.227.34.5.34.82v.696h.93c.25 0 .468.092.652.276a.892.892 0 01.276.653z" />
								</svg>' : '' ) .
						'<a href="' . esc_url( get_the_permalink() ) . '"> ' . get_the_date() . '</a></span>' : '';
					$view       = get_post_meta( get_the_ID(), '_mzb_post_view_count', true );
					$read_time  = $enable_readtime ? '<span class="mzb-post-read-time">' .
						( ( true === $enable_icon ) ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
								<path fill-rule="evenodd" d="M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18ZM1 12C1 5.925 5.925 1 12 1s11 4.925 11 11-4.925 11-11 11S1 18.075 1 12Z" clip-rule="evenodd"/>
								<path fill-rule="evenodd" d="M12 5a1 1 0 0 1 1 1v5.382l3.447 1.724a1 1 0 1 1-.894 1.788l-4-2A1 1 0 0 1 11 12V6a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
								</svg>' : '' ) .
						'<span>' .
						self::calculate_read_time( $id ) . '
								min
								read
								</span>
								</span>' : '';
					$view_count = $enable_viewcount ? '<span class="mzb-post-view-count">' .
						( ( true === $enable_icon ) ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
								<path d="M12 17.9c-4.2 0-7.9-2.1-9.9-5.5-.2-.3-.2-.6 0-.9C4.1 8.2 7.8 6 12 6s7.9 2.1 9.9 5.5c.2.3.2.6 0 .9-2 3.4-5.7 5.5-9.9 5.5zM3.9 12c1.6 2.6 4.8 4.2 8.1 4.2s6.4-1.6 8.1-4.2c-1.6-2.6-4.7-4.2-8.1-4.2S5.6 9.4 3.9 12zm8.1 3.3c-1.8 0-3.3-1.5-3.3-3.3s1.5-3.3 3.3-3.3 3.3 1.5 3.3 3.3-1.5 3.3-3.3 3.3zm0-4.9c-.9 0-1.6.8-1.6 1.6 0 .9.8 1.6 1.6 1.6s1.6-.8 1.6-1.6c0-.9-.7-1.6-1.6-1.6z" />
								</svg>' : '' ) .
						'<span>' . $view . '
																									views
																								</span>
																							</span>' : '';
					$html      .= '<div class="mzb-post">';
					$html      .= '';
					$html      .= $image;
					$html      .= '<div class="mzb-post-content">';
					if ( $enable_category ) {
						$html .= '<div class="mzb-post-meta">';
						$html .= $category;
						$html .= '</div>';
					}
					if ( 'top' === $meta_position ) {
						$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . $meta_separator . '">';
						$html .= $enable_author ? $author : '';
						$html .= $enable_date ? $date : '';
						$html .= $enable_readtime ? $read_time : '';
						$html .= $enable_viewcount ? $view_count : '';
						$html .= '</div>';
					}
					$html .= $title;
					if ( 'bottom' === $meta_position ) {
						$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . $meta_separator . '">';
						$html .= $enable_author ? $author : '';
						$html .= $enable_date ? $date : '';
						$html .= $enable_readtime ? $read_time : '';
						$html .= $enable_viewcount ? $view_count : '';
						$html .= '</div>';
					}
					$html .= '</div>';
					$html .= '</div>';
					++$index;
				}
				$html .= '</div>';
				$html .= '</div>';
			} else {
				while ( $query->have_posts() ) {
					$query->the_post();
					$id         = get_post_thumbnail_id();
					$src        = wp_get_attachment_image_src( $id );
					$src        = has_post_thumbnail( get_the_ID() ) ? get_the_post_thumbnail_url( get_the_ID() ) : '';
					$image      = $src ? ' <div class="mzb-featured-image ' . $hover_animation . '"><a href="' . esc_url( get_the_permalink() ) . '"alt="' . get_the_title() . '"/><img src="' . esc_url( $src ) . '" alt="' . get_the_title() . '"/></a></div>' : '';
					$title      = '<' . $post_title_markup . ' class="mzb-post-title"><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a></' . $post_title_markup . '>';
					$category   = ( true === $enable_category ) ? '<span class="mzb-post-categories">' . get_the_category_list( ' ' ) . '</span>' : '';
					$author     = ( true === $enable_author ) ? '<span class="mzb-post-author" >' . ( ( true === $enable_icon ) ? '<img class="post-author-image" src="' . get_avatar_url( get_the_author_meta( 'ID' ) ) . ' "/>' : '' ) . get_the_author_posts_link() . '</span>' : '';
					$date       = ( true === $enable_date ) ? '<span class ="mzb-post-date">' . ( ( true === $enable_icon ) ? '<svg class="mzb-icon mzb-icon--calender" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
									<path d="M1.892 12.929h10.214V5.5H1.892v7.429zm2.786-8.822v-2.09a.226.226 0 00-.066-.166.226.226 0 00-.166-.065H3.98a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.022.122.065.166.044.044.1.065.167.065h.465a.226.226 0 00.166-.065.226.226 0 00.066-.167zm5.571 0v-2.09a.226.226 0 00-.065-.166.226.226 0 00-.167-.065h-.464a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.021.122.065.166.043.044.099.065.167.065h.464a.226.226 0 00.167-.065.226.226 0 00.065-.167zm2.786-.464v9.286c0 .251-.092.469-.276.652a.892.892 0 01-.653.276H1.892a.892.892 0 01-.653-.275.892.892 0 01-.276-.653V3.643c0-.252.092-.47.276-.653a.892.892 0 01.653-.276h.929v-.696c0-.32.113-.593.34-.82.228-.227.501-.34.82-.34h.465c.319 0 .592.113.82.34.227.227.34.5.34.82v.696h2.786v-.696c0-.32.114-.593.34-.82.228-.227.501-.34.82-.34h.465c.32 0 .592.113.82.34.227.227.34.5.34.82v.696h.93c.25 0 .468.092.652.276a.892.892 0 01.276.653z" />
								</svg>' : '' ) .
						'<a href="' . esc_url( get_the_permalink() ) . '"> ' . get_the_date() . '</a></span>' : '';
					$view       = get_post_meta( get_the_ID(), '_mzb_post_view_count', true );
					$read_time  = $enable_readtime ? '<span class="mzb-post-read-time">' .
						( ( true === $enable_icon ) ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
								<path fill-rule="evenodd" d="M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18ZM1 12C1 5.925 5.925 1 12 1s11 4.925 11 11-4.925 11-11 11S1 18.075 1 12Z" clip-rule="evenodd"/>
								<path fill-rule="evenodd" d="M12 5a1 1 0 0 1 1 1v5.382l3.447 1.724a1 1 0 1 1-.894 1.788l-4-2A1 1 0 0 1 11 12V6a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
								</svg>' : '' ) .
						'<span>' .
						self::calculate_read_time( $id ) . '
								min
								read
								</span>
								</span>' : '';
					$view_count = $enable_viewcount ? '<span class="mzb-post-view-count">' .
						( ( true === $enable_icon ) ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
								<path d="M12 17.9c-4.2 0-7.9-2.1-9.9-5.5-.2-.3-.2-.6 0-.9C4.1 8.2 7.8 6 12 6s7.9 2.1 9.9 5.5c.2.3.2.6 0 .9-2 3.4-5.7 5.5-9.9 5.5zM3.9 12c1.6 2.6 4.8 4.2 8.1 4.2s6.4-1.6 8.1-4.2c-1.6-2.6-4.7-4.2-8.1-4.2S5.6 9.4 3.9 12zm8.1 3.3c-1.8 0-3.3-1.5-3.3-3.3s1.5-3.3 3.3-3.3 3.3 1.5 3.3 3.3-1.5 3.3-3.3 3.3zm0-4.9c-.9 0-1.6.8-1.6 1.6 0 .9.8 1.6 1.6 1.6s1.6-.8 1.6-1.6c0-.9-.7-1.6-1.6-1.6z" />
								</svg>' : '' ) .
						'<span>' . $view . '
																									views
																								</span>
																							</span>' : '';
					$html      .= '<div class="mzb-post">';
					$html      .= '';
					$html      .= $image;
					$html      .= '<div class="mzb-post-content">';
					if ( $enable_category ) {
						$html .= '<div class="mzb-post-meta">';
						$html .= $category;
						$html .= '</div>';
					}
					if ( 'top' === $meta_position ) {

						if (
							'layout-2' !== $layout ||
							'layout-2-style-3' !== $layout_2_advanced_style ||
							( 'layout-2-style-3' === $layout_2_advanced_style && 1 === $index )
						) {
							$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . $meta_separator . '">';
							$html .= $enable_author ? $author : '';
							$html .= $enable_date ? $date : '';
							$html .= $enable_readtime ? $read_time : '';
							$html .= $enable_viewcount ? $view_count : '';
							$html .= '</div>';
						}
					}
					$html .= $title;
					if ( 'bottom' === $meta_position ) {
						if ( ( $enable_excerpt || $enable_readmore ) && 'above-meta' === $excerpt_position && ( 'layout-4' !== $layout || 1 === $index ) && ( 'layout-5' !== $layout || 1 === $index ) ) {
							$html .= '<div class="mzb-entry-content">';
							$html .= $enable_excerpt ? '<div class="mzb-entry-summary"><p> ' . get_the_excerpt() . '</p></div>' : '';
							$html .= $enable_readmore ? '<div class="mzb-read-more"><a href="' . esc_url( get_the_permalink() ) . '">' . $read_more_text . ' </a></div>' : '';
							$html .= '</div>';
						}

						if (
							'layout-2' !== $layout ||
							'layout-2-style-3' !== $layout_2_advanced_style ||
							( 'layout-2-style-3' === $layout_2_advanced_style && 1 === $index )
						) {
							$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . $meta_separator . '">';
							$html .= $enable_author ? $author : '';
							$html .= $enable_date ? $date : '';
							$html .= $enable_readtime ? $read_time : '';
							$html .= $enable_viewcount ? $view_count : '';
							$html .= '</div>';
						}

						if ( ( $enable_excerpt || $enable_readmore ) && 'below-meta' === $excerpt_position && ( 'layout-4' !== $layout || 1 === $index ) && ( 'layout-5' !== $layout || 1 === $index ) ) {
							$html .= '<div class="mzb-entry-content">';
							$html .= $enable_excerpt ? '<div class="mzb-entry-summary"><p> ' . get_the_excerpt() . '</p></div>' : '';
							$html .= $enable_readmore ? '<div class="mzb-read-more"><a href="' . esc_url( get_the_permalink() ) . '">' . $read_more_text . ' </a></div>' : '';
							$html .= '</div>';
						}
					}
					if ( ( $enable_excerpt || $enable_readmore ) && 'bottom' !== $meta_position && ( 'layout-4' !== $layout || 1 === $index ) && ( 'layout-5' !== $layout || 1 === $index ) ) {
						$html .= '<div class="mzb-entry-content">';
						$html .= $enable_excerpt ? '<div class="mzb-entry-summary"><p> ' . get_the_excerpt() . '</p></div>' : '';
						$html .= $enable_readmore ? '<div class="mzb-read-more"><a href="' . esc_url( get_the_permalink() ) . '">' . $read_more_text . ' </a></div>' : '';
						$html .= '</div>';
					}
					$html .= '</div>';
					$html .= '</div>';
					++$index;
				}
			}
			$html .= '</div>';

			// Custom pagination function.
			if ( $enable_pagination ) {
				$html .= mzb_numbered_pagination( $query->max_num_pages, $paged, $client_id );
			}

			$html .= '</div>';
			$query->reset_postdata();
		}
		return $html;
	}

	public function calculate_read_time( $post_id ) {
		$words_per_minute = 200;
		$content          = get_post_field( 'post_content', $post_id );
		$word_count       = str_word_count( wp_strip_all_tags( $content ) );
		$read_time        = ceil( $word_count / $words_per_minute );
		return $read_time;
	}
}
