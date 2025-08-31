<?php

/**
 * Post List block.
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
class PostList extends AbstractBlock {




	/**
	 * Block name.
	 *
	 * @var string Block name.
	 */
	protected $block_name = 'post-list';

	public function render( $attributes, $content, $block ) {

		$client_id    = magazine_blocks_array_get( $attributes, 'clientId', '' );
		$css_id       = magazine_blocks_array_get( $attributes, 'cssID', '' );
		$class_name   = magazine_blocks_array_get( $attributes, 'className', '' );
		$image_toggle = magazine_blocks_array_get( $attributes, 'imageToggle', 'true' );
		$position     = magazine_blocks_array_get( $attributes, 'position', 'left' );

		// Query.
		$category          = magazine_blocks_array_get( $attributes, 'category', '' );
		$tag               = magazine_blocks_array_get( $attributes, 'tag', '' );
		$excluded_category = magazine_blocks_array_get( $attributes, 'excludedCategory', '' );
		$order_by          = magazine_blocks_array_get( $attributes, 'orderBy', '' );
		$order_type        = magazine_blocks_array_get( $attributes, 'orderType', '' );
		$author            = magazine_blocks_array_get( $attributes, 'authorName', '' );
		$post_count        = magazine_blocks_array_get( $attributes, 'postCount', '' );
		$post_type         = magazine_blocks_array_get( $attributes, 'postType', 'post' );

		// General.
		$layout                  = magazine_blocks_array_get( $attributes, 'layout', '' );
		$layout_1_advanced_style = magazine_blocks_array_get( $attributes, 'layout1AdvancedStyle', '' );
		$layout_2_advanced_style = magazine_blocks_array_get( $attributes, 'layout2AdvancedStyle', '' );

		//Column.
		$column = magazine_blocks_array_get( $attributes, 'column', '4' );

		// Heading.
		$enable_heading                  = magazine_blocks_array_get( $attributes, 'enableHeading', '' );
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

		//  Image.
		$hover_animation = magazine_blocks_array_get( $attributes, 'hoverAnimation', '' );

		// Meta.
		$meta_position    = magazine_blocks_array_get( $attributes, 'metaPosition', '' );
		$enable_date      = magazine_blocks_array_get( $attributes, 'enableDate', '' );
		$enable_readtime  = magazine_blocks_array_get( $attributes, 'enableReadTime', '' );
		$enable_viewcount = magazine_blocks_array_get( $attributes, 'enableViewCount', '' );
		$enable_icon      = magazine_blocks_array_get( $attributes, 'enableIcon', '' );
		$meta_separator   = magazine_blocks_array_get( $attributes, 'separatorType', 'none' );

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

		// Pagination
		$enable_pagination = magazine_blocks_array_get( $attributes, 'enablePagination', '' );

		//offset
		$offset = magazine_blocks_array_get( $attributes, 'offset', 0 );

		//number list
		$enable_number_list = magazine_blocks_array_get( $attributes, 'enableNumberList', false );
		$number_layout      = magazine_blocks_array_get( $attributes, 'numberLayout', 'default' );
		$number_position    = magazine_blocks_array_get( $attributes, 'numberPosition', 'with-image' );

		//  $enable_category, $enable_comment, $category_position, $enable_category_border are set from attributes
		$enable_category        = magazine_blocks_array_get( $attributes, 'enableCategory', false );
		$enable_comment         = magazine_blocks_array_get( $attributes, 'enableComment', false );
		$category_position      = magazine_blocks_array_get( $attributes, 'categoryPosition', 'out-image' );
		$enable_category_border = magazine_blocks_array_get( $attributes, 'enableCategoryBorder', false );

		// Define the custom excerpt length function as an anonymous function
		$custom_excerpt_length = function ( $length ) use ( $excerpt_limit ) {
			return $excerpt_limit; // Change this number to your desired word limit
		};

		// Pagination.
		$paged         = isset( $_GET[ 'block_id_' . $client_id ] ) ? max( 1, intval( $_GET[ 'block_id_' . $client_id ] ) ) : 1;
		$args['paged'] = $paged;

		// Add the filter to modify the excerpt length using the anonymous function
		add_filter( 'excerpt_length', $custom_excerpt_length );

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

		if ( 'layout-1' === $layout ) {
			$advanced_style = $layout_1_advanced_style;
		} elseif ( 'layout-2' === $layout ) {
			$advanced_style = $layout_2_advanced_style;
		}

		$column_style = $column;
		if ( 'layout-1-style-2' === $layout_1_advanced_style ) {
			$column_style = $column;
		}

		$number_style = '';
		if ( true === $enable_number_list ) {
			$number_style = 'mzb-number-list';
		}

		$number_layout_style = '';
		if ( 'default' === $number_layout || 'circle' === $number_layout || 'square' === $number_layout || 'zero' === $number_layout ) {
			$number_layout_style = $number_layout;
		}

		$number_position_style = '';
		if ( 'with-image' === $number_position || 'with-text' === $number_position ) {
			$number_position_style = $number_position;
		}

		$args = array(
			'post_type'           => $post_type,
			'posts_per_page'      => $post_count,
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

		$cat_name = get_cat_name( $category );

		$cat_name = empty( $cat_name ) ? 'Latest' : $cat_name;

		$type = get_query_var( 'mzb_template_type' );

		// Prepare category and comment HTML
		$category_html = '';
		if ( $enable_category ) {
			$category_html = '<span class="mzb-post-categories">' . get_the_category_list( ' ' ) . '</span>';
		}

		$comment_html = '';
		if ( $enable_comment ) {
			$comment_count = get_comments_number();
			$comment_html  = '<span class="comments-link"><svg class="mzb-icon mzb-icon--comment" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
								<path fill-rule="evenodd" d="M12 4c-5.19 0-9 3.33-9 7 0 1.756.84 3.401 2.308 4.671l.412.358-.46 3.223 3.456-1.728.367.098c.913.245 1.893.378 2.917.378 5.19 0 9-3.33 9-7s-3.81-7-9-7zM1 11c0-5.167 5.145-9 11-9s11 3.833 11 9-5.145 9-11 9c-1.06 0-2.087-.122-3.06-.352l-6.2 3.1.849-5.94C1.999 15.266 1 13.246 1 11z"></path>
							</svg> ' . esc_html( $comment_count ) . '</span>';
		}

		if ( in_array( $type, array( 'archive', 'search', 'single', 'front' ), true ) ) {
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
			$html .= '<div id="' . $css_id . '" class="mzb-post-list mzb-post-list-' . $client_id . ' ' . $class_name . '">';
			$html .= '<div class="mzb-post-heading mzb-' . $heading_layout . ' mzb-' . $heading_style . '">';
			if ( $enable_heading ) {
				$html .= '<h2 class="mzb-heading-text">' . esc_html( $label ) . '</h2>';
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

			$html .= '<div class="mzb-posts mzb-' . $layout . ' mzb-' . $advanced_style . ' mzb-post-col--' . $column_style . ' ' . $number_style . ' mzb-number-list__' . $number_layout_style . ' mzb-number-list__' . $number_position_style . '">';
			while ( $query->have_posts() ) {
				$query->the_post();
				$id    = get_post_thumbnail_id();
				$src   = wp_get_attachment_image_src( $id );
				$src   = has_post_thumbnail( get_the_ID() ) ? get_the_post_thumbnail_url( get_the_ID() ) : '';
				$image = $src ? '<div class="mzb-featured-image ' . $hover_animation . ' mzb-category-' . $category_position . '">
				    <a href="' . esc_url( get_the_permalink() ) . '" alt="' . get_the_title() . '">
				        <img src="' . esc_url( $src ) . '" alt="' . get_the_title() . '"/>
				    </a>'
					. ( ( ( $enable_category || $enable_comment ) && $category_position === 'in-image' )
						? ( '<div class="mzb-post-meta' . ( $enable_category_border ? ' mzb-post-border-enable' : '' ) . '">'
							. ( $enable_category ? '<span class="mzb-post-categories">' . get_the_category_list( ' ' ) . '</span>' : '' )
							. $comment_html
							. '</div>' )
						: '' )
					. '</div>'
					: '';
				$img   = ( true === $image_toggle ) ? $image : '';
				if ( ! $src ) {
					$position_class = "$position no-thumbnail";
				} else {
					$position_class = $position;
				}

				$title      = '<h3 class="mzb-post-title"><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a></h3>';
				$date       = $enable_date ? '<span class ="mzb-post-date">' . ( ( true === $enable_icon ) ? '<svg class="mzb-icon mzb-icon--calender" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
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
				$html      .= '<div class="mzb-post magazine-post--pos-' . $position_class . '">';
				$html      .= '';
				$html      .= $img;

				if ( 'top' === $meta_position ) {
					$html .= '<div class="mzb-post-content">';
					if ( ( $enable_category || $enable_comment ) && 'out-image' === $category_position ) {

						$border_class = $enable_category_border ? ' mzb-post-border-enable' : '';
						$html        .= '<div class="mzb-post-meta' . $border_class . '">';
						$html        .= '<span class="mzb-post-categories">' . get_the_category_list( ' ' ) . '</span>';
						$html        .= $comment_html;
						$html        .= '</div>';
					}
					if ( $enable_date || $enable_readtime || $enable_viewcount ) {
						$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . $meta_separator . '">';
						$html .= $enable_date ? $date : '';
						$html .= $enable_readtime ? $read_time : '';
						$html .= $enable_viewcount ? $view_count : '';
						$html .= '</div>';
					}
					$html .= $title;
					if ( $enable_excerpt || $enable_readmore ) {
						$html .= '<div class="mzb-entry-content">';
						$html .= $enable_excerpt ? '<div class="mzb-entry-summary"><p> ' . get_the_excerpt() . '</p></div>' : '';
						$html .= $enable_readmore ? '<div class="mzb-read-more"><a href="' . esc_url( get_the_permalink() ) . '">' . $read_more_text . ' </a></div>' : '';
						$html .= '</div>';
					}
					$html .= '</div>';
				} elseif ( 'bottom' === $meta_position ) {
					$html .= '<div class="mzb-post-content">';
					if ( ( $enable_category || $enable_comment ) && 'out-image' === $category_position ) {

						$border_class = $enable_category_border ? ' mzb-post-border-enable' : '';
						$html        .= '<div class="mzb-post-meta' . $border_class . '">';
						$html        .= '<span class="mzb-post-categories">' . get_the_category_list( ' ' ) . '</span>';
						$html        .= $comment_html;
						$html        .= '</div>';
					}
					$html .= $title;
					if ( $enable_date || $enable_readtime || $enable_viewcount ) {
						$html .= '<div class="mzb-post-entry-meta mzb-meta-separator--' . $meta_separator . '">';
						$html .= $enable_date ? $date : '';
						$html .= $enable_readtime ? $read_time : '';
						$html .= $enable_viewcount ? $view_count : '';
						$html .= '</div>';
					}
					if ( $enable_excerpt || $enable_readmore ) {
						$html .= '<div class="mzb-entry-content">';
						$html .= $enable_excerpt ? '<div class="mzb-entry-summary"><p> ' . get_the_excerpt() . '</p></div>' : '';
						$html .= $enable_readmore ? '<div class="mzb-read-more"><a href="' . esc_url( get_the_permalink() ) . '">' . $read_more_text . ' </a></div>' : '';
						$html .= '</div>';
					}
					$html .= '</div>';
				}
				$html .= '</div>';
			}

			$html .= '</div>';

			// Custom pagination function.
			if ( $enable_pagination ) {
				$html .= mzb_numbered_pagination( $query->max_num_pages, $paged, $client_id );
			}

			$html .= '</div>';
			wp_reset_postdata();
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
