/**
 * Theme Customizer enhancements, specific to panels, for a better user experience.
 *
 * @package     mypreview-conj
 */
( function( api ) {

	// Extends our custom "example-1" section.
	api.sectionConstructor['conj-pro'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );