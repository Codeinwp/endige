<?php

add_action( 'wp_enqueue_scripts', 'Illyria_enqueue_styles' );

function Illyria_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

function Illyria_custom_script_fix() {
   
	wp_enqueue_script('Illyria_script_child',get_stylesheet_directory_uri().'/js/wrapall.js', array('jquery') );
	
}

add_action( 'wp_enqueue_scripts', 'Illyria_custom_script_fix', 100 );

function Illyria_inline_styles() {
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

add_action("wp_print_scripts","Illyria_inline_styles");

/**
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function Illyria_theme_setup() {
    load_child_theme_textdomain( 'Illyria', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'Illyria_theme_setup' );

/**
 * Notice in Customize to announce the theme is not maintained anymore
 */
function Illyria_customize_register( $wp_customize ) {

	require_once get_stylesheet_directory() . '/class-ti-notify.php';

	$wp_customize->register_section_type( 'Ti_Notify' );

	$wp_customize->add_section(
		new Ti_Notify(
			$wp_customize,
			'ti-notify',
			array( /* translators: Link to the recommended theme */
				'text'     => sprintf( __( 'This theme is not maintained anymore, check-out our latest free one-page theme: %1$s.','Illyria' ), sprintf( '<a href="' . admin_url( 'theme-install.php?theme=hestia' ) . '">%s</a>', 'Hestia' ) ),
				'priority' => 0,
			)
		)
	);

	$wp_customize->add_setting( 'Illyria-notify', array(
		'sanitize_callback' => 'esc_html',
	) );

	$wp_customize->add_control( 'Illyria-notify', array(
		'label'    => __( 'Notification', 'Illyria' ),
		'section'  => 'ti-notify',
		'priority' => 1,
	) );
}
add_action( 'customize_register', 'Illyria_customize_register' );

/**
 * Notice in admin dashboard to announce the theme is not maintained anymore
 */
function Illyria_admin_notice() {

	global $pagenow;

	if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
		echo '<div class="updated notice is-dismissible"><p>';
		printf( /* translators: link to the recommended theme */ __( 'This theme is not maintained anymore, check-out our latest free one-page theme: %1$s.','Illyria' ), sprintf( '<a href="' . admin_url( 'theme-install.php?theme=hestia' ) . '">%s</a>', 'Hestia' ) );
		echo '</p></div>';
	}
}
add_action( 'admin_notices', 'Illyria_admin_notice', 99 );