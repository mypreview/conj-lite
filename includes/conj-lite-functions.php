<?php
/**
 * Conj functions.
 *
 * @author  	Mahdi Yazdani
 * @package 	conj-lite
 * @since 	    1.1.0
 */

/**
 * Checks if the current page is a blog post archive/single.
 *
 * @uses 	is_archive()
 * @uses 	is_author()
 * @uses 	is_category()
 * @uses 	is_home()
 * @uses 	is_single()
 * @uses 	is_tag()
 * @uses 	get_post_type()
 * @return  bool
 */
if ( ! function_exists( 'conj_lite_is_blog_archive' ) ) :
	function conj_lite_is_blog_archive() {

		if ( ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag() ) && 'post' === get_post_type() ) {
			return TRUE;
		} else {
			return FALSE;
		} // End If Statement

	}
endif;

/**
 * Checks if the current page is the fluid template.
 *
 * @uses 	is_page_template()
 * @return  bool
 */
if ( ! function_exists( 'conj_lite_is_fluid_template' ) ) :
	function conj_lite_is_fluid_template() {

		return is_page_template( 'page-templates/template-fluid.php' )  ?  TRUE  :  FALSE;

	}
endif;

/**
 * Call a shortcode function by tag name.
 *
 * @uses 	call_user_func()
 * @param  	string 	$tag     	The shortcode whose function to call.
 * @param  	array  	$atts    	The attributes to pass to the shortcode function. Optional.
 * @param  	array  	$content 	The shortcode's content. Default is null (none).
 * @return 	string|bool 		False on failure, the result of the shortcode on success.
 */
if ( ! function_exists( 'conj_lite_do_shortcode' ) ) :
	function conj_lite_do_shortcode( $tag, array $atts = array(), $content = NULL ) {

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
 * @uses 	is_attachment()
 * @uses 	the_permalink()
 * @uses 	the_post_thumbnail()
 * @uses 	has_post_thumbnail()
 * @uses 	post_password_required()
 * @return 	void
 */
if ( ! function_exists( 'conj_lite_post_thumbnail' ) ) :
	function conj_lite_post_thumbnail() {

		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		} // End If Statement

		if ( is_singular() ) :
		?>
		<div class="post-thumbnail">
			<?php 
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => FALSE
				) ),
			) );
			?>
		</div><!-- .post-thumbnail -->
		<?php else : ?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="TRUE">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => FALSE
				) ),
			) );
			?>
		</a>
		<?php endif; // End is_singular().

	}
endif;

/**
 * Prints HTML markup for the current post title.
 *
 * @uses 	get_the_ID()
 * @uses 	the_title()
 * @uses 	get_post_meta()
 * @uses 	conj_lite_is_powerpack_activated()
 * @return 	null|void
 */
if ( ! function_exists( 'conj_lite_post_title' ) ) :
	function conj_lite_post_title() {

		// Skip printing the page title if it is already removed from the view.
		if ( ! apply_filters( 'conj_lite_is_visible_post_title', '__return_true' ) || is_front_page() ) {
			return;
		} // End If Statement

		printf( '<header class="entry-header">' );

			if ( is_singular() ) {
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			} // End If Statement

		printf( '</header><!-- .entry-header -->' );

	}
endif;

/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @uses 	get_option()
 * @uses 	get_the_author()
 * @uses 	get_author_posts_url()
 * @uses 	get_the_author_meta()
 * @uses 	conj_lite_time_link()
 * @uses 	is_customize_preview()
 * @return 	void
 */
if ( ! function_exists( 'conj_lite_posted_on' ) ) :
	function conj_lite_posted_on() {

		// Get the author name; wrap it in a link.
		$byline = sprintf(
			/* translators: %s: post author */
			esc_html__( 'by %s', 'conj-lite' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
		);

		// Finally, let's write all of this to the page.
		echo '<span class="posted-on">' . conj_lite_time_link() . '</span><span class="byline">' . wp_kses_post( $byline ) . '</span>';

	}
endif;

/**
 * Gets a nicely formatted string for the published date.
 *
 * @uses 	get_the_time()
 * @uses 	get_the_date()
 * @uses 	get_permalink()
 * @uses 	is_customize_preview()
 * @uses 	get_the_modified_date()
 * @uses 	get_the_modified_time()
 * @return 	html
 */
if ( ! function_exists( 'conj_lite_time_link' ) ) :
	function conj_lite_time_link() {

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = sprintf( '<time class="entry-date published updated" datetime="%1$s">%2$s</time>', get_the_modified_date( DATE_W3C ), get_the_modified_date() );
		} else {
			$time_string = sprintf( '<time class="entry-date published" datetime="%1$s">%2$s</time>', get_the_date( DATE_W3C ), get_the_date() );
		} // End If Statement

		// Wrap the time string in a link, and preface it with 'Posted on'.
		return sprintf(
			/* translators: 1: Open span tag, 2: Close span tag, 3: Post date. */
			esc_html__( '%1$sPosted on%2$s %3$s', 'conj-lite' ), '<span class="screen-reader-text">', '</span>', '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

	}
endif;

/**
 * Gets a formatted string for the number of comments in the post.
 *
 * @uses 	get_option()
 * @uses 	comments_open()
 * @uses 	post_password_required()
 * @uses 	is_customize_preview()
 * @return 	Null | html
 */
if ( ! function_exists( 'conj_lite_comments_link' ) ) :
	function conj_lite_comments_link() {

		global $post;

		$is_comment_open = comments_open( $post->ID );

		if ( $is_comment_open && FALSE === post_password_required() ) {
			/* translators: %: Number of comments */
			return comments_popup_link( '<span class="leave-reply">' . esc_html__( 'Leave a comment', 'conj-lite' ) . '</span>', esc_html__( 'One Comment', 'conj-lite' ), esc_html__( '% Comments', 'conj-lite' ), 'comments-link' );
		} // End If Statement

		return NULL;

	}
endif;

/**
 * Prints HTML with meta information for the categories, tags and comments.
 *
 * @uses 	get_option()
 * @uses 	get_the_category_list()
 * @uses 	get_the_tag_list()
 * @uses 	is_customize_preview()
 * @uses 	conj_lite_categorized_blog()
 * @return 	void
 */
if ( ! function_exists( 'conj_lite_entry_footer' ) ) :
	function conj_lite_entry_footer( $posted_categories = TRUE, $posted_tags = TRUE ) {

		// Empty space used between list items, there is no space or comma
		$separate_meta = '';

		// Get Categories for posts.
		$categories_list = get_the_category_list( $separate_meta );

		// Get Tags for posts.
		$tags_list = get_the_tag_list( '', $separate_meta );

		// We don't want to output .entry-footer if it will be empty, so make sure its not.
		if ( ( ( conj_lite_categorized_blog() && $categories_list ) || $tags_list ) || get_edit_post_link() ) {
			if ( 'post' === get_post_type() ) {
				if ( ( $categories_list && conj_lite_categorized_blog() ) || $tags_list ) {
					echo '<span class="cat-tags-links">';
						// Make sure there's more than one category before displaying.
						if ( $categories_list && conj_lite_categorized_blog() && TRUE === $posted_categories ) {
							echo '<span class="cat-links" data-title="' . esc_html__( 'in', 'conj-lite' ) . '"><span class="screen-reader-text">' . esc_html__( 'Categories', 'conj-lite' ) . '</span>' . $categories_list . '</span>'; // WPCS: XSS OK.
						} // End If Statement
						if ( $tags_list && TRUE === $posted_tags ) {
							echo '<span class="tags-links"><span class="screen-reader-text">' . esc_html__( 'Tags', 'conj-lite' ) . '</span>' . $tags_list . '</span>'; // WPCS: XSS OK.
						} // End If Statement
					echo '</span>';
				} // End If Statement
			} // End If Statement
			conj_lite_edit_link();
		} // End If Statement

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
 * @uses 	is_search()
 * @uses 	edit_post_link()
 * @return 	html
 */
if ( ! function_exists( 'conj_lite_edit_link' ) ) :
	function conj_lite_edit_link() {

		if ( is_search() ) {
			return;
		} // End If Statement

		$link = edit_post_link(
			sprintf(
					/* translators: 1: Open span tag, 2: Name of current post, 3: Close span tag.  */
					esc_html__( 'Edit this post%1$s "%2$s"%3$s', 'conj-lite' ), '<span class="screen-reader-text">', get_the_title(), '</span>'
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
 * @uses 	get_transient()
 * @uses 	get_categories()
 * @uses 	set_transient()
 * @uses 	is_preview()
 * @return 	bool
 */
if ( ! function_exists( 'conj_lite_categorized_blog' ) ) :
	function conj_lite_categorized_blog() {

		$category_count = get_transient( 'conj_lite_categories' );
		
		if ( FALSE === $category_count ) {
			// Create an array of all the categories that are attached to posts.
			$categories = get_categories( array(
				'fields' => 'ids',
				'hide_empty' => 1,
				// We only need to know if there is more than one category.
				'number' => 2
			) );
			// Count the number of categories that are attached to the posts.
			$category_count = count( $categories );
			set_transient( 'conj_lite_categories', $category_count );
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
 * @uses 	is_home()
 * @uses 	esc_url()
 * @uses 	get_bloginfo()
 * @uses 	has_custom_logo()
 * @uses 	is_front_page()
 * @param  	bool $echo     Whether the site branding markup should be displayed or returned.
 * @return 	html
 */
if ( ! function_exists( 'conj_lite_site_title_or_logo' ) ) :
	function conj_lite_site_title_or_logo( $echo = TRUE ) {

		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$get_custom_logo =	get_custom_logo();
			$tag = ( is_front_page() ) 	? 	'h1' : 'div'; 	 
			$html = sprintf( '<%1$s class="logo">%2$s<span class="screen-reader-text alt-logo">%3$s</span></%4$s>', esc_html( $tag ), $get_custom_logo, esc_html( get_bloginfo( 'name' ) ), esc_html( $tag ) );
		} else {
			$tag = ( is_front_page() ) 	? 'h1' 	: 'p'; 
			$html = sprintf( '<%1$s class="beta site-title"><a href="%2$s" rel="home">%3$s</a></%4$s>', esc_attr( $tag ), esc_url( home_url( '/' ) ), esc_html( get_bloginfo( 'name' ) ), esc_attr( $tag ) );

			if ( '' !== get_bloginfo( 'description' ) ) {
				$html .= sprintf( '<p class="site-description">%1$s</p>', esc_html( get_bloginfo( 'description', 'display' ) ) );
			} // End If Statement
		} // End If Statement

		if ( ! $echo ) {
			return $html;
		} // End If Statement

		echo wp_kses_post( $html );

	}
endif;

/**
 * Shim for sites older than 5.2.
 *
 * @link 	https://core.trac.wordpress.org/ticket/12563
 */
if ( ! function_exists( 'wp_body_open' ) ) :
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;