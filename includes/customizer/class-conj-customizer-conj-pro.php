<?php
/**
 * Class to create custom get CONJ PRO control.
 *
 * @see         https://codex.wordpress.org/Theme_Customization_API
 * @see 		https://github.com/justintadlock/trt-customizer-pro/blob/master/example-1/section-pro.php
 * @see         http://ottopress.com/2012/making-a-custom-control-for-the-theme-customizer/
 * @author  	Mahdi Yazdani
 * @package 	mypreview-conj
 * @since 	    1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * The CONJ PRO control class
 */
class MyPreview_Conj_Lite_Customizer_CONJ_PRO_Control extends WP_Customize_Section {
	/**
	 * The type var
	 *
	 * @var string $type the type of customize section being rendered.
	 */
	public $type 	= 'conj-pro';
	/**
	 * The pro_text var
	 *
	 * @var string $pro_text the custom button text to output.
	 */
	public $pro_text = '';
	/**
	 * The pro_url var
	 *
	 * @var string $class the custom pro button URL.
	 */
	public $pro_url 	= '';
	/**
	 * Add custom parameters to pass to the JS via JSON.
	 * 
	 * @return void
	 */
	public function json() {
    	
		$json = parent::json();

		$json['pro_text'] 	= 	$this->pro_text;
		$json['pro_url']  	= 	esc_url( $this->pro_url );

		return $json;

	}
	/**
	 * Outputs the Underscore.js template.
	 *
	 * @return void
	 */
	protected function render_template() {
		
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">

			<h3 class="accordion-section-title">
				{{ data.title }}

				<# if ( data.pro_text && data.pro_url ) { #>
					<a href="{{ data.pro_url }}" class="button button-primary alignright" target="_blank">{{ data.pro_text }}</a>
				<# } #>
			</h3>
			
		</li>
		<?php
		
	}

}