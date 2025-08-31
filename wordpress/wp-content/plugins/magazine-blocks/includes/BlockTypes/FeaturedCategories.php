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
class FeaturedCategories extends AbstractBlock {



	/**
	 * Block name.
	 *
	 * @var string Block name.
	 */
	protected $block_name = 'featured-categories';

	public function render( $attributes, $content, $block ) {
		$client_id = magazine_blocks_array_get( $attributes, 'clientId', '' );

		// Query.
		$category            = magazine_blocks_array_get( $attributes, 'category', '' );
		$category_2          = magazine_blocks_array_get( $attributes, 'category2', '' );
		$tag                 = magazine_blocks_array_get( $attributes, 'tag', '' );
		$tag_2               = magazine_blocks_array_get( $attributes, 'tag2', '' );
		$excluded_category   = magazine_blocks_array_get( $attributes, 'excludedCategory', '' );
		$excluded_category_2 = magazine_blocks_array_get( $attributes, 'excludedCategory2', '' );
		$post_type           = magazine_blocks_array_get( $attributes, 'postType', 'post' );
		$post_type2          = magazine_blocks_array_get( $attributes, 'postType2', 'post' );

		$post_count = magazine_blocks_array_get( $attributes, 'postCount', '' );

		// Post Title.
		$post_title_markup = magazine_blocks_array_get( $attributes, 'postTitleMarkup', 'h6' );
		$post_title_markup = magazine_blocks_sanitize_html_tag( $post_title_markup, 'h6' );

		// Image.
		$hover_animation = magazine_blocks_array_get( $attributes, 'hoverAnimation' );

		// Header Meta.
		$enable_category = magazine_blocks_array_get( $attributes, 'enableCategory', '' );
		$enable_comment  = magazine_blocks_array_get( $attributes, 'enableComment', '' );

		// Meta.
		$meta_position  = magazine_blocks_array_get( $attributes, 'metaPosition', '' );
		$enable_author  = magazine_blocks_array_get( $attributes, 'enableAuthor', '' );
		$enable_date    = magazine_blocks_array_get( $attributes, 'enableDate', '' );
		$meta_separator = magazine_blocks_array_get( $attributes, 'separatorType', 'none' );
		$enable_icon    = magazine_blocks_array_get( $attributes, 'enableIcon', '' );

		// Heading
		$enable_heading                  = magazine_blocks_array_get( $attributes, 'enableHeading', 'true' );
		$heading_layout                  = magazine_blocks_array_get( $attributes, 'headingLayout', '' );
		$heading_layout_1_advanced_style = magazine_blocks_array_get( $attributes, 'headingLayout1AdvancedStyle', '' );
		$heading_layout_2_advanced_style = magazine_blocks_array_get( $attributes, 'headingLayout2AdvancedStyle', '' );
		$heading_layout_3_advanced_style = magazine_blocks_array_get( $attributes, 'headingLayout3AdvancedStyle', '' );
		$heading_layout_4_advanced_style = magazine_blocks_array_get( $attributes, 'headingLayout4AdvancedStyle', '' );
		$heading_layout_5_advanced_style = magazine_blocks_array_get( $attributes, 'headingLayout5AdvancedStyle', '' );
		$heading_layout_6_advanced_style = magazine_blocks_array_get( $attributes, 'headingLayout6AdvancedStyle', '' );
		$heading_layout_7_advanced_style = magazine_blocks_array_get( $attributes, 'headingLayout7AdvancedStyle', '' );
		$heading_layout_8_advanced_style = magazine_blocks_array_get( $attributes, 'headingLayout8AdvancedStyle', '' );
		$heading_layout_9_advanced_style = magazine_blocks_array_get( $attributes, 'headingLayout9AdvancedStyle', '' );
		$label                           = magazine_blocks_array_get( $attributes, 'label', 'Latest' );
		$label2                          = magazine_blocks_array_get( $attributes, 'label2', 'Latest' );

		// Post Box.
		$post_box_style = magazine_blocks_array_get( $attributes, 'postBoxStyle', 'boxed' );

		// Excerpt.
		$enable_excerpt = magazine_blocks_array_get( $attributes, 'enableExcerpt', '' );
		$excerpt_limit  = magazine_blocks_array_get( $attributes, 'excerptLimit', '' );

		// ReadMore.
		$enable_readmore = magazine_blocks_array_get( $attributes, 'enableReadMore', '' );
		$read_more_text  = magazine_blocks_array_get( $attributes, 'readMoreText', '' );

		//View All
		$enable_view_more      = magazine_blocks_array_get( $attributes, 'enableViewMore', '' );
		$view_more_text        = magazine_blocks_array_get( $attributes, 'viewMoreText', '' );
		$view_button_position  = magazine_blocks_array_get( $attributes, 'viewButtonPosition', '' );
		$enable_view_more_icon = magazine_blocks_array_get( $attributes, 'enableViewMoreIcon', '' );
		$view_more_icon        = magazine_blocks_array_get( $attributes, 'viewMoreIcon', '' );
		$get_icon              = magazine_blocks_get_icon( $view_more_icon, false );
		$view_more_url         = magazine_blocks_array_get( $attributes, 'viewMoreLink', array() );

		$href   = isset( $view_more_url['url'] ) ? esc_url( $view_more_url['url'] ) : '';
		$target = ! empty( $view_more_url['newTab'] ) ? ' target="_blank"' : '';
		$rel    = ! empty( $view_more_url['noFollow'] ) ? ' rel="nofollow"' : '';

		//offset
		$offset = magazine_blocks_array_get( $attributes, 'offset', 0 );

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
		} elseif ( 'heading-layout-6' === $heading_layout ) {
			$heading_style = $heading_layout_6_advanced_style;
		} elseif ( 'heading-layout-7' === $heading_layout ) {
			$heading_style = $heading_layout_7_advanced_style;
		} elseif ( 'heading-layout-8' === $heading_layout ) {
			$heading_style = $heading_layout_8_advanced_style;
		} elseif ( 'heading-layout-9' === $heading_layout ) {
			$heading_style = $heading_layout_9_advanced_style;
		}

		// Define the custom excerpt length function as an anonymous function

		// Define the custom excerpt length function as an anonymous function
		$custom_excerpt_length = function ( $length ) use ( $excerpt_limit ) {
			return $excerpt_limit; // Change this number to your desired word limit
		};

		// Add the filter to modify the excerpt length using the anonymous function
		add_filter( 'excerpt_length', $custom_excerpt_length );

		$cat_1_args = array(
			'post_type'           => $post_type,
			'posts_per_page'      => $post_count,
			'status'              => 'publish',
			'cat'                 => $category,
			'tag_id'              => $tag,
			'ignore_sticky_posts' => 1,
			'category__not_in'    => $excluded_category,
			'offset'              => $offset,
		);

		$cat_2_args = array(
			'post_type'           => $post_type2,
			'posts_per_page'      => $post_count,
			'status'              => 'publish',
			'cat'                 => $category_2,
			'tag_id'              => $tag_2,
			'ignore_sticky_posts' => 1,
			'category__not_in'    => $excluded_category_2,
			'offset'              => $offset,
		);

		$cat_name = get_cat_name( $category );

		if ( empty( $cat_name ) ) {
			$cat_name = $label;
		}

		$cat_name2 = get_cat_name( $category_2 );

		if ( empty( $cat_name2 ) ) {
			$cat_name2 = $label;
		}

		# The Loop.
		$html = '';

		$type = get_query_var( 'mzb_template_type' );

		if ( in_array( $type, [ 'archive', 'search', 'single', 'front' ], true ) ) {
			unset( $cat_1_args['cat'], $cat_1_args['tag_id'], $cat_1_args['orderby'], $cat_1_args['order'], $cat_1_args['author'], $cat_1_args['category__not_in'], $cat_1_args['ignore_sticky_posts'], $cat_1_args['paged'], $cat_1_args['offset'] );
			$paged = get_query_var( 'paged' );
			switch ( get_query_var( 'mzb_template_type' ) ) {
				case 'archive':
					if ( is_archive() ) {
						if ( is_category() ) {
							$cat_1_args['category_name'] = get_query_var( 'category_name' );
						} elseif ( is_tag() ) {
							$cat_1_args['tag'] = get_query_var( 'tag' );
						} elseif ( is_author() ) {
							$cat_1_args['author'] = get_query_var( 'author' );
						}
					}
					break;
				case 'search':
					$cat_1_args['s'] = get_search_query();
					break;
			}
		}

		if ( in_array( $type, [ 'archive', 'search', 'single', 'front' ], true ) ) {
			unset( $cat_2_args['cat'], $cat_2_args['tag_id'], $cat_2_args['orderby'], $cat_2_args['order'], $cat_2_args['author'], $cat_2_args['category__not_in'], $cat_2_args['ignore_sticky_posts'], $cat_2_args['paged'], $cat_2_args['offset'] );
			$paged = get_query_var( 'paged' );
			switch ( get_query_var( 'mzb_template_type' ) ) {
				case 'archive':
					if ( is_archive() ) {
						if ( is_category() ) {
							$cat_2_args['category_name'] = get_query_var( 'category_name' );
						} elseif ( is_tag() ) {
							$cat_2_args['tag'] = get_query_var( 'tag' );
						} elseif ( is_author() ) {
							$cat_2_args['author'] = get_query_var( 'author' );
						}
					}
					break;
				case 'search':
					$cat_2_args['s'] = get_search_query();
					break;
			}
		}

		$query = new WP_Query( $cat_1_args );

		$query_2 = new WP_Query( $cat_2_args );
		if ( $query->have_posts() || $query_2->have_posts() ) {
			$html .= '<div class="mzb-featured-categories mzb-featured-categories-' . $client_id . '">';
			$html .= '<div class="mzb-category-posts">';
			$html .= '<div class="mzb-category-1-posts mzb-' . $post_box_style . '">';
			$html .= '<div class="mzb-post-heading mzb-' . $heading_layout . ' mzb-' . $heading_style . '">';
			if ( $enable_heading ) {
				$html .= '<h2 class="mzb-heading-text">' . esc_html( $cat_name ) . '</h2>';
			}
			if ( $enable_view_more && 'top' === $view_button_position ) {
				$html .= '<div class="mzb-view-more"><a href="' . $href . '"' . $target . $rel . '>';
				$html .= '<p>' . $view_more_text . '</p>';
				if ( $enable_view_more_icon ) {
					$html .= $get_icon;
				}
				$html .= '</a></div>';
			}
			$html .= '</div>';
			while ( $query->have_posts() ) {
				$query->the_post();
				$id       = get_post_thumbnail_id();
				$src      = wp_get_attachment_image_src( $id );
				$src      = has_post_thumbnail( get_the_ID() ) ? get_the_post_thumbnail_url( get_the_ID() ) : '';
				$image    = $src ? '<div class="mzb-featured-image ' . $hover_animation . '"><a href="' . esc_url( get_the_permalink() ) . '"alt="' . get_the_title() . '"/><img src="' . esc_url( $src ) . '" alt="' . get_the_title() . '"/> </a></div>' : '';
				$title    = '<a href="' . esc_url( get_the_permalink() ) . '"><' . $post_title_markup . ' class="mzb-post-title">' . get_the_title() . '</' . $post_title_markup . '></a>';
				$category = $enable_category ? '<span class="mzb-post-categories">' . get_the_category_list( ' ' ) . '</span>' : '';
				$comment  = '<a href="' . get_comments_link() . '">' . get_comments_number() . '</a>';
				$date     = '<span class ="mzb-post-date">' . ( ( true === $enable_icon ) ? '<svg class="mzb-icon mzb-icon--calender" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
								<path d="M1.892 12.929h10.214V5.5H1.892v7.429zm2.786-8.822v-2.09a.226.226 0 00-.066-.166.226.226 0 00-.166-.065H3.98a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.022.122.065.166.044.044.1.065.167.065h.465a.226.226 0 00.166-.065.226.226 0 00.066-.167zm5.571 0v-2.09a.226.226 0 00-.065-.166.226.226 0 00-.167-.065h-.464a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.021.122.065.166.043.044.099.065.167.065h.464a.226.226 0 00.167-.065.226.226 0 00.065-.167zm2.786-.464v9.286c0 .251-.092.469-.276.652a.892.892 0 01-.653.276H1.892a.892.892 0 01-.653-.275.892.892 0 01-.276-.653V3.643c0-.252.092-.47.276-.653a.892.892 0 01.653-.276h.929v-.696c0-.32.113-.593.34-.82.228-.227.501-.34.82-.34h.465c.319 0 .592.113.82.34.227.227.34.5.34.82v.696h2.786v-.696c0-.32.114-.593.34-.82.228-.227.501-.34.82-.34h.465c.32 0 .592.113.82.34.227.227.34.5.34.82v.696h.93c.25 0 .468.092.652.276a.892.892 0 01.276.653z" />
							</svg>' : '' ) .
					'<a href="' . esc_url( get_the_permalink() ) . '"> ' . get_the_date() . '</a></span>';
				$author   = ( true === $enable_author ) ? '<span class="mzb-post-author" >' . ( ( true === $enable_icon ) ? '<img class="post-author-image" src="' . get_avatar_url( get_the_author_meta( 'ID' ) ) . ' "/>' : '' ) . get_the_author_posts_link() . '</span>' : '';
				$html    .= '<div class="mzb-post">';
				$html    .= '';
				$html    .= $image;
				$html    .= '<div class="mzb-post-content">';
				if ( $enable_category || $enable_comment ) {
					$html .= '<div class="mzb-post-meta">';
					$html .= $category;
					if ( $enable_comment ) {
						$html .= '<span class="comments-link">';
						$html .= '<svg class="mzb-icon mzb-icon--comment" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
							<path fill-rule="evenodd" d="M12 4c-5.19 0-9 3.33-9 7 0 1.756.84 3.401 2.308 4.671l.412.358-.46 3.223 3.456-1.728.367.098c.913.245 1.893.378 2.917.378 5.19 0 9-3.33 9-7s-3.81-7-9-7zM1 11c0-5.167 5.145-9 11-9s11 3.833 11 9-5.145 9-11 9c-1.06 0-2.087-.122-3.06-.352l-6.2 3.1.849-5.94C1.999 15.266 1 13.246 1 11z"></path>
						</svg>';
						$html .= $comment;
						$html .= '</span>';
					}
					$html .= '</div>';
				}
				if ( ( $enable_author || $enable_date ) && 'top' === $meta_position ) {
					$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . $meta_separator . '">';
					$html .= $enable_author ? $author : '';
					$html .= $enable_date ? $date : '';
					$html .= '</div>';
				}
				$html .= $title;
				if ( ( $enable_author || $enable_date ) && 'bottom' === $meta_position ) {
					$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . $meta_separator . '">';
					$html .= $enable_author ? $author : '';
					$html .= $enable_date ? $date : '';
					$html .= '</div>';
				}
				if ( $enable_excerpt || $enable_readmore ) {
					$html .= '<div class="mzb-entry-content">';
					$html .= $enable_excerpt ? '<div class="mzb-entry-summary"><p> ' . get_the_excerpt() . '</p></div>' : '';
					$html .= $enable_readmore ? '<div class="mzb-read-more"><a href="' . esc_url( get_the_permalink() ) . '">' . $read_more_text . ' </a></div>' : '';
					$html .= '</div>';
				}
				$html .= '</div>';
				$html .= '</div>';
			}
			if ( $enable_view_more && 'bottom' === $view_button_position ) {
				$html .= '<div class="mzb-view-more"><a href="' . $href . '"' . $target . $rel . '>';
				$html .= '<p>' . $view_more_text . '</p>';
				if ( $enable_view_more_icon ) {
					$html .= $get_icon;
				}
				$html .= '</a></div>';
			}
			$html .= '</div>';

			$html .= '<div class="mzb-category-2-posts mzb-' . $post_box_style . '">';
			$html .= '<div class="mzb-post-heading mzb-' . $heading_layout . ' mzb-' . $heading_style . '">';
			if ( $enable_heading ) {
				$html .= '<h2 class="mzb-heading-text">' . esc_html( $cat_name2 ) . '</h2>';
			}
			if ( $enable_view_more && 'top' === $view_button_position ) {
				$html .= '<div class="mzb-view-more"><a href="' . $href . '"' . $target . $rel . '>';
				$html .= '<p>' . $view_more_text . '</p>';
				if ( $enable_view_more_icon ) {
					$html .= $get_icon;
				}
				$html .= '</a></div>';
			}
			$html .= '</div>';
			while ( $query_2->have_posts() ) {
				$query_2->the_post();
				$id       = get_post_thumbnail_id();
				$src      = wp_get_attachment_image_src( $id );
				$src      = has_post_thumbnail( get_the_ID() ) ? get_the_post_thumbnail_url( get_the_ID() ) : '';
				$image    = $src ? '<div class="mzb-featured-image ' . $hover_animation . '"><a href="' . esc_url( get_the_permalink() ) . '"alt="' . get_the_title() . '"/><img src="' . esc_url( $src ) . '" alt="' . get_the_title() . '"/> </a></div>' : '';
				$title    = '<h3 class="mzb-post-title"><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a></h3>';
				$category = $enable_category ? '<span class="mzb-post-categories">' . get_the_category_list( ' ' ) . '</span>' : '';
				$comment  = '<a href="' . get_comments_link() . '">' . get_comments_number() . '</a>';
				$date     = '<span class ="mzb-post-date">' . ( ( true === $enable_icon ) ? '<svg class="mzb-icon mzb-icon--calender" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
								<path d="M1.892 12.929h10.214V5.5H1.892v7.429zm2.786-8.822v-2.09a.226.226 0 00-.066-.166.226.226 0 00-.166-.065H3.98a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.022.122.065.166.044.044.1.065.167.065h.465a.226.226 0 00.166-.065.226.226 0 00.066-.167zm5.571 0v-2.09a.226.226 0 00-.065-.166.226.226 0 00-.167-.065h-.464a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.021.122.065.166.043.044.099.065.167.065h.464a.226.226 0 00.167-.065.226.226 0 00.065-.167zm2.786-.464v9.286c0 .251-.092.469-.276.652a.892.892 0 01-.653.276H1.892a.892.892 0 01-.653-.275.892.892 0 01-.276-.653V3.643c0-.252.092-.47.276-.653a.892.892 0 01.653-.276h.929v-.696c0-.32.113-.593.34-.82.228-.227.501-.34.82-.34h.465c.319 0 .592.113.82.34.227.227.34.5.34.82v.696h2.786v-.696c0-.32.114-.593.34-.82.228-.227.501-.34.82-.34h.465c.32 0 .592.113.82.34.227.227.34.5.34.82v.696h.93c.25 0 .468.092.652.276a.892.892 0 01.276.653z" />
							</svg>' : '' ) .
					'<a href="' . esc_url( get_the_permalink() ) . '"> ' . get_the_date() . '</a></span>';
				$html    .= '<div class="mzb-post">';
				$html    .= '';
				$html    .= $image;
				$html    .= '<div class="mzb-post-content">';
				if ( $enable_category || $enable_comment ) {
					$html .= '<div class="mzb-post-meta">';
					$html .= $category;
					if ( $enable_comment ) {
						$html .= '<span class="comments-link">';
						$html .= '<svg class="mzb-icon mzb-icon--comment" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
							<path fill-rule="evenodd" d="M12 4c-5.19 0-9 3.33-9 7 0 1.756.84 3.401 2.308 4.671l.412.358-.46 3.223 3.456-1.728.367.098c.913.245 1.893.378 2.917.378 5.19 0 9-3.33 9-7s-3.81-7-9-7zM1 11c0-5.167 5.145-9 11-9s11 3.833 11 9-5.145 9-11 9c-1.06 0-2.087-.122-3.06-.352l-6.2 3.1.849-5.94C1.999 15.266 1 13.246 1 11z"></path>
						</svg>';
						$html .= $comment;
						$html .= '</span>';
					}
					$html .= '</div>';
				}
				if ( $enable_date && 'top' === $meta_position ) {
					$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . $meta_separator . '">';
					$html .= $enable_date ? $date : '';
					$html .= '</div>';
				}
				$html .= $title;
				if ( $enable_date && 'bottom' === $meta_position ) {
					$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . $meta_separator . '">';
					$html .= '';
					$html .= $enable_date ? $date : '';
					$html .= '</div>';
				}
				if ( $enable_excerpt || $enable_readmore ) {
					$html .= '<div class="mzb-entry-content">';
					$html .= $enable_excerpt ? '<div class="mzb-entry-summary"><p> ' . get_the_excerpt() . '</p></div>' : '';
					$html .= $enable_readmore ? '<div class="mzb-read-more"><a href="' . esc_url( get_the_permalink() ) . '">' . $read_more_text . ' </a></div>' : '';
					$html .= '</div>';
				}
				$html .= '</div>';
				$html .= '</div>';
			}
			if ( $enable_view_more && 'bottom' === $view_button_position ) {
				$html .= '<div class="mzb-view-more"><a href="' . $href . '"' . $target . $rel . '>';
				$html .= '<p>' . $view_more_text . '</p>';
				if ( $enable_view_more_icon ) {
					$html .= $get_icon;
				}
				$html .= '</a></div>';
			}
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
			wp_reset_postdata();
		}
		return $html;
	}
}
