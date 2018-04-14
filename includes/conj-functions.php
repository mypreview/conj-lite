<?php
/**
 * Conj Lite  functions.
 *
 * @author  	Mahdi Yazdani
 * @package 	mypreview-conj
 * @since 	    1.0.0
 */

/**
 * Query if the blog posts page already configured and exists.
 * 
 * @return  bool
 */
if ( ! function_exists( 'mypreview_conj_lite_is_posts_page_configured' ) ) :
	function mypreview_conj_lite_is_posts_page_configured() {

		$get_posts_page = (bool) get_option( 'page_for_posts', TRUE );

		return ( ! empty( $get_posts_page ) ) ? TRUE : FALSE;

	}
endif;

/**
 * Checks if the current page is the fluid template.
 * 
 * @return  bool
 */
if ( ! function_exists( 'mypreview_conj_lite_is_fluid_template' ) ) :
	function mypreview_conj_lite_is_fluid_template() {

		return is_page_template( 'page-templates/template-fluid.php' ) ? TRUE : FALSE;

	}
endif;

/**
 * Checks if the current page is a product archive.
 * 
 * @return  bool
 */
if ( ! function_exists( 'mypreview_conj_lite_is_product_archive' ) ) :
	function mypreview_conj_lite_is_product_archive() {

		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
				return TRUE;
			} else {
				return FALSE;
			} // End If Statement
		} else {
			return FALSE;
		} // End If Statement

	}
endif;

/**
 * Checks if the current page is "NOT" a product archive.
 *
 * @return  bool
 */
if ( ! function_exists( 'mypreview_conj_lite_is_not_product_archive' ) ) :
	function mypreview_conj_lite_is_not_product_archive() {

		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
				return FALSE;
			} else {
				return TRUE;
			} // End If Statement
		} else {
			return TRUE;
		} // End If Statement

	}
endif;

/**
 * Checks if the current page is "NOT" a single product page.
 *
 * @return  bool
 */
if ( ! function_exists( 'mypreview_conj_lite_is_not_product_page' ) ) :
	function mypreview_conj_lite_is_not_product_page() {

		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_product() ) {
				return FALSE;
			} else {
				return TRUE;
			} // End If Statement
		} else {
			return TRUE;
		} // End If Statement

	}
endif;

/**
 * Call a shortcode function by tag name.
 * 
 * @param  	string $tag     The shortcode whose function to call.
 * @param  	array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param  	array  $content The shortcode's content. Default is null (none).
 * @return 	string|bool False on failure, the result of the shortcode on success.
 */
if ( ! function_exists( 'mypreview_conj_lite_do_shortcode' ) ) :
	function mypreview_conj_lite_do_shortcode( $tag, array $atts = array(), $content = null ) {

		global $shortcode_tags;
		if ( ! isset( $shortcode_tags[ $tag ] ) ) {
			return FALSE;
		} // End If Statement
		return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );

	}
endif;


/**
 * Displays an optional post thumbnail.
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @return void
 */
if ( ! function_exists( 'mypreview_conj_lite_post_thumbnail' ) ) :
	function mypreview_conj_lite_post_thumbnail( $is_jarallax = NULL ) {

		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		} // End If Statement

		if ( is_singular() ) :
		?>

		<div class="post-thumbnail">
			<?php 
				the_post_thumbnail( 'post-thumbnail', array(
					'class' => esc_attr( $is_jarallax ),
					'alt' 	=> the_title_attribute( array(
						'echo' => FALSE
					) ),
				) );
			?>
		</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="TRUE">
			<?php
				the_post_thumbnail( 'post-thumbnail', array(
					'class' => esc_attr( $is_jarallax ),
					'alt' 	=> the_title_attribute( array(
						'echo' => FALSE
					) ),
				) );
			?>
		</a>

		<?php endif; // End is_singular().

	}
endif;

/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @return void
 */
if ( ! function_exists( 'mypreview_conj_lite_posted_on' ) ) :
	function mypreview_conj_lite_posted_on() {

		// Get the author name; wrap it in a link.
		$byline = sprintf(
			/* translators: %s: post author */
			__( 'by %s', 'conj-lite' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
		);

		// Finally, let's write all of this to the page.
		echo '<span class="posted-on">' . wp_kses_post( mypreview_conj_lite_time_link() ) . '</span><span class="byline">' . wp_kses_post( $byline ) . '</span>';

	}
endif;

/**
 * Gets a nicely formatted string for the published date.
 *
 * @return html
 */
if ( ! function_exists( 'mypreview_conj_lite_time_link' ) ) :
	function mypreview_conj_lite_time_link() {

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		} // End If Statement

		$time_string = sprintf( $time_string,
			get_the_date( DATE_W3C ),
			get_the_date(),
			get_the_modified_date( DATE_W3C ),
			get_the_modified_date()
		);

		// Wrap the time string in a link, and preface it with 'Posted on'.
		return sprintf(
			/* translators: %s: Post date */
			__( '<span class="screen-reader-text">Posted on</span> %s', 'conj-lite' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

	}
endif;

/**
 * Gets a formatted string for the number of comments in the post.
 *
 * @return Null | html
 */
if ( ! function_exists( 'mypreview_conj_lite_comments_link' ) ) :
	function mypreview_conj_lite_comments_link() {

		global $post;

		$is_comment_open 		 = 	comments_open( $post->ID );

		if ( $is_comment_open && FALSE === post_password_required() ) {

			if ( is_singular( 'post' ) ) {
				/* translators: %: Number of comments */
				return comments_popup_link( '<span class="leave-reply">0</span>', __( 'One Comment', 'conj-lite' ), __( '% Comments', 'conj-lite' ), 'comments-link' );
			} else {
				/* translators: %: Number of comments */
				return comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'conj-lite' ) . '</span>', __( 'One Comment', 'conj-lite' ), __( '% Comments', 'conj-lite' ), 'comments-link' );
			} // End If Statement

		} // End If Statement

		return NULL;

	}
endif;

/**
 * Prints HTML with meta information for the categories, tags and comments.
 *
 * @return void
 */
if ( ! function_exists( 'mypreview_conj_lite_entry_footer' ) ) :
	function mypreview_conj_lite_entry_footer( $posted_categories = TRUE, $posted_tags = TRUE ) {

		/* translators: used between list items, there is a space after the comma */
		$separate_meta = __( ', ', 'conj-lite' );

		// Get Categories for posts.
		$categories_list = get_the_category_list( $separate_meta );

		// Get Tags for posts.
		$tags_list = get_the_tag_list( '', $separate_meta );

		// We don't want to output .entry-footer if it will be empty, so make sure its not.
		if ( ( ( mypreview_conj_lite_categorized_blog() && $categories_list ) || $tags_list ) || get_edit_post_link() ) {
			if ( 'post' === get_post_type() ) {
				if ( ( $categories_list && mypreview_conj_lite_categorized_blog() ) || $tags_list ) {
					echo '<span class="cat-tags-links">';
						// Make sure there's more than one category before displaying.
						if ( $categories_list && mypreview_conj_lite_categorized_blog() && TRUE === $posted_categories ) {
							echo '<span class="cat-links" data-title="' . __( 'in', 'conj-lite' ) . '"><span class="screen-reader-text">' . __( 'Categories', 'conj-lite' ) . '</span>' . $categories_list . '</span>'; // WPCS: XSS OK.
						} // End If Statement
						if ( $tags_list && TRUE === $posted_tags ) {
							echo '<span class="tags-links"><span class="screen-reader-text">' . __( 'Tags', 'conj-lite' ) . '</span>' . $tags_list . '</span>'; // WPCS: XSS OK.
						} // End If Statement
					echo '</span>';
				} // End If Statement
			} // End If Statement
			mypreview_conj_lite_edit_link();
		} // End If Statement

	}
endif;

/**
 * Prints HTML with meta information for the categories, tags and comments.
 *
 * @return void
 */
if ( ! function_exists( 'mypreview_conj_lite_entry_readmore' ) ) :
	function mypreview_conj_lite_entry_readmore() {

		printf( '<a href="%1$s" target="_self"><i class="feather-arrow-right"></i><span class="screen-reader-text">%2$s</span></a>', esc_url( get_the_permalink() ), esc_html__( 'Read more' , 'conj-lite' ) );

	}
endif;

/**
 * Returns an accessibility-friendly link to edit a post or page.
 *
 * This also gives us a little context about what exactly we're editing
 * (post or page?) so that users understand a bit more where they are in terms
 * of the template hierarchy and their content. Helpful when/if the single-page
 * layout with multiple posts/pages shown gets confusing.
 *
 * @return html
 */
if ( ! function_exists( 'mypreview_conj_lite_edit_link' ) ) :
	function mypreview_conj_lite_edit_link() {

		if ( is_search() ) {
			return NULL;
		} // End If Statement

		$link = edit_post_link(
			sprintf(
					/* translators: %s: Name of current post */
					__( 'Edit this post<span class="screen-reader-text"> "%s"</span>', 'conj-lite' ),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
		);

		return $link;

	}
endif;

/**
 * Returns TRUE if a blog has more than 1 category.
 *
 * @return bool
 */
if ( ! function_exists( 'mypreview_conj_lite_categorized_blog' ) ) :
	function mypreview_conj_lite_categorized_blog() {

		$category_count = get_transient( 'mypreview_conj_lite_categories' );
		
		if ( FALSE === $category_count ) {
			// Create an array of all the categories that are attached to posts.
			$categories = get_categories( array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				// We only need to know if there is more than one category.
				'number'     => 2
			) );
			// Count the number of categories that are attached to the posts.
			$category_count = count( $categories );
			set_transient( 'mypreview_conj_lite_categories', $category_count );
		} // End If Statement

		// Allow viewing case of 0 or 1 categories in post preview.
		if ( is_preview() ) {
			return TRUE;
		} // End If Statement

		return $category_count > 1;

	}
endif;

/**
 * Display the site title or logo.
 *
 * @param  bool $echo     Whether the site branding markup should be displayed or returned.
 * @return html
 */
if ( ! function_exists( 'mypreview_conj_lite_site_title_or_logo' ) ) :
	function mypreview_conj_lite_site_title_or_logo( $echo = TRUE ) {

		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {

			$logo = get_custom_logo();
			if ( mypreview_conj_lite_is_front_page_configured() && mypreview_conj_lite_is_homepage_template() ) {
				$html = '<h1 class="logo">' . $logo . '</h1>';
			} elseif ( ! mypreview_conj_lite_is_posts_page_configured() && is_home() ) {
				$html = '<h1 class="logo">' . $logo . '</h1>';
			} else {
				$html = $logo;
			} // End If Statement


		} elseif ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) {

			// Copied from jetpack_the_site_logo() function.
			$logo    = site_logo()->logo;
			// Check for WP 4.5 Site Logo
			$logo_id = get_theme_mod( 'custom_logo' ); 
			// Use WP Core logo if present, otherwise use Jetpack's.
			$logo_id = $logo_id ? $logo_id : $logo['id']; 
			$size    = site_logo()->theme_size();
			
			$html    = sprintf( '<a href="%1$s" class="site-logo-link" rel="home" itemprop="url">%2$s</a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image(
					$logo_id,
					$size,
					FALSE,
					array(
						'class'     => 'site-logo attachment-' . $size,
						'data-size' => $size,
						'itemprop'  => 'logo'
					)
				)
			);

			$html = apply_filters( 'jetpack_the_site_logo', $html, $logo, $size );
		} else {

			if ( ! mypreview_conj_lite_is_posts_page_configured() && is_home() ) {
				$tag = 'h1';
			} else {
				$tag = 'p';
			} // End If Statement

			$html = '<' . esc_attr( $tag ) . ' class="beta site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></' . esc_attr( $tag ) .'>';

			if ( '' !== get_bloginfo( 'description' ) ) {
				$html .= '<p class="site-description">' . esc_html( get_bloginfo( 'description', 'display' ) ) . '</p>';
			} // End If Statement

		} // End If Statement

		if ( ! $echo ) {
			return $html;
		} // End If Statement

		echo wp_kses_post( $html );

	}
endif;


/**
 * Get attachment ID from a WordPress image URL.
 *
 * @param  url  	$url   	A direct URL to the image.
 * @return integer        	Associated id of passed image URL. 
 */
if ( ! function_exists( 'mypreview_conj_lite_get_attachment_id' ) ) :
	function mypreview_conj_lite_get_attachment_id( $url ) {

		$attachment_id 	= 	0;
		$url 			= 	esc_url( $url );
		$dir 			= 	wp_upload_dir();

		// Is URL in uploads directory?
		if ( FALSE !== strpos( $url, $dir['baseurl'] . '/' ) ) {

			$file = basename( $url );
			$query_args = array(
				'post_type' 	=> 	'attachment',
				'post_status' 	=> 	'inherit',
				'fields' 		=> 	'ids',
				'meta_query' 	=> 	array(
										array(
											'value' 	=> 	$file,
											'compare' 	=> 	'LIKE',
											'key' 		=> 	'_wp_attachment_metadata',
										) ,
				)
			);

			$query = new WP_Query( $query_args );

			if ( $query->have_posts() ) {

				foreach( $query->posts as $post_id ) {

					$meta 					= 	wp_get_attachment_metadata( $post_id );
					$original_file 			= 	basename( $meta['file'] );
					$cropped_image_files 	= 	wp_list_pluck( $meta['sizes'], 'file' );

					if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) :

						$attachment_id 	= 	$post_id;
						break;
					
					endif;

				}

			} // End If Statement

			wp_reset_postdata();

		} // End If Statement

		return intval( $attachment_id );

	}
endif;