<?php
// add any new or customised functions here

add_action( 'wp_enqueue_scripts', 'juridica_enqueue_styles' );
function juridica_enqueue_styles() {

    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	// Loads our main stylesheet.
	wp_enqueue_style( 'juridica-child-style', get_stylesheet_uri(), array('parent-style'), 'v1' );

}

function juridica_custom_script_fix()
{
   
	wp_enqueue_script('juridica_script_child',get_stylesheet_directory_uri().'/js/wrapall.js', array('jquery') );
	
}

add_action( 'wp_enqueue_scripts', 'juridica_custom_script_fix', 100 );

function juridica_inline_styles()
		{
		?>
		<style type="text/css">

		<?php if(is_front_page()): ?>
		.wrap-elements {
		  position: absolute !important;
		}
		<?php else: ?>
		.wrap-elements {
		 position: relative !important;
		}
		<?php endif; ?>
		</style>
		<?php
		}

add_action("wp_print_scripts","juridica_inline_styles");
