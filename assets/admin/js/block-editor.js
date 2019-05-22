/**
 * Block editor enhancements.
 *
 * Contains functionality to dynamically update the block editor
 * configuration and styling.
 *
 * @requires 	wp-block-editor
 * @package     conj-lite
 * @author     	MyPreview (Github: @mahdiyazdani, @mypreview)
 */
( function() {

	/**
	 * Check if the main sidebar is active (has widgets).
	 * This uses a custom property `conjLiteHasSidebarActive` added via the
	 * `block_editor_settings` filter.
	 *
	 * @return 	{boolean} 	Whether sidebar is active.
	 */
	const sidebarIsActive = () => {
		let settings = wp.data.select( 'core/editor' ).getEditorSettings();

		if ( settings.hasOwnProperty( 'conjLiteHasSidebarActive' ) && !! settings.conjLiteHasSidebarActive ) {
			return true;
		}

		return false;
	};

	/**
	 * Get current page template name.
	 *
	 * @return 	{string} 	The page template name.
	 */
	const getCurrentPageTemplate = () => {
		return wp.data.select( 'core/editor' ).getEditedPostAttribute( 'template' );
	};

	/**
	 * Check if the active theme supports a wide layout.
	 *
	 * @return {boolean} Whether the theme supports wide layout.
	 */
	const themeSupportsWide = () => {
		let settings = wp.data.select( 'core/editor' ).getEditorSettings();

		if ( settings.hasOwnProperty( 'alignWide' ) && !! settings.alignWide ) {
			return true;
		}

		return false;
	};

	/**
	 * Update editor wide support.
	 *
	 * @param 	{boolean} 	alignWide 	Whether the editor supports alignWide support.
	 * @return 	{void}
	 */
	const updateWideSupport = ( alignWide ) => {
		wp.data.dispatch( 'core/editor' ).updateEditorSettings( { 'alignWide': !! alignWide } );
	};

	/**
	 * Update `data-align` attribute on each block.
	 *
	 * @param 	{boolean} 	alignWide 	Whether alignWide is supported.
	 * @return 	{void}
	 */
	const updateAlignAttribute = ( alignWide ) => {
		let blocks = wp.data.select( 'core/block-editor' ).getBlocks();

		blocks.forEach( ( block ) => {
			if ( block.attributes.hasOwnProperty( 'align' ) ) {
				let align = block.attributes.align;

				if ( ! [ 'full', 'wide' ].includes( align ) ) {
					return;
				}

				let blockWrapper = document.getElementById( 'block-' + block.clientId );

				if ( blockWrapper ) {
					blockWrapper.setAttribute( 'data-align', alignWide ? align : '' );
				}
			}
		} );
	};

	/**
	 * Add custom class to editor wrapper if main sidebar is active.
	 *
	 * @param 	{boolean} 	showSidebar 	Whether to add custom class.
	 * @return 	{void}
	 */
	const toggleCustomSidebarClass = ( showSidebar ) => {
		let editorWrapper = document.getElementsByClassName( 'editor-writing-flow' );

		if ( ! editorWrapper.length ) {
			return;
		}

		if ( !! showSidebar ) {
			editorWrapper[0].classList.add( 'conj-lite-has-sidebar__active' );
		} else {
			editorWrapper[0].classList.remove( 'conj-lite-has-sidebar__active' );
		}
	};

	/**
	 * Update editor and blocks when layout changes.
	 *
	 * @return 	{void}
	 */
	const maybeUpdateEditor = () => {
		if ( 'page-templates/template-fluid.php' === getCurrentPageTemplate() ) {
			updateWideSupport( true );
			toggleCustomSidebarClass( false );
			updateAlignAttribute( true );
		} else if ( sidebarIsActive() ) {
			updateWideSupport( false );
			toggleCustomSidebarClass( true );
			updateAlignAttribute( false );
		} else {
			updateWideSupport( true );
			toggleCustomSidebarClass( false );
			updateAlignAttribute( true );
		}
	};

	wp.domReady( () => {

		// Don't do anything if the theme doesn't declare support for `align-wide`.
		if ( ! themeSupportsWide() ) {
			return;
		}

		maybeUpdateEditor();

		let pageTemplate = getCurrentPageTemplate();

		wp.data.subscribe( () => {
			if ( getCurrentPageTemplate() !== pageTemplate ) {
				pageTemplate = getCurrentPageTemplate();

				maybeUpdateEditor();
			}
		} );
	} );
} )();