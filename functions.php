<?php

add_action( 'wp_enqueue_scripts', 'illyria_enqueue_styles' );

function illyria_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

function illyria_custom_script_fix() {
   
	wp_enqueue_script('illyria_script_child',get_stylesheet_directory_uri().'/js/wrapall.js', array('jquery') );
	
}

add_action( 'wp_enqueue_scripts', 'illyria_custom_script_fix', 100 );

function illyria_inline_styles() {
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

add_action("wp_print_scripts","illyria_inline_styles");

/**
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function illyria_theme_setup() {
    load_child_theme_textdomain( 'illyria', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'illyria_theme_setup' );

/**
 * Notice in Customize to announce the theme is not maintained anymore
 */
function illyria_customize_register( $wp_customize ) {

	require_once get_stylesheet_directory() . '/class-ti-notify.php';

	$wp_customize->register_section_type( 'Ti_Notify' );

	$wp_customize->add_section(
		new Ti_Notify(
			$wp_customize,
			'ti-notify',
			array( /* translators: Link to the recommended theme */
				'text'     => sprintf( __( 'This theme is not maintained anymore, check-out our latest free one-page theme: %1$s.','illyria' ), sprintf( '<a href="' . admin_url( 'theme-install.php?theme=hestia' ) . '">%s</a>', 'Hestia' ) ),
				'priority' => 0,
			)
		)
	);

	$wp_customize->add_setting( 'illyria-notify', array(
		'sanitize_callback' => 'esc_html',
	) );

	$wp_customize->add_control( 'illyria-notify', array(
		'label'    => __( 'Notification', 'illyria' ),
		'section'  => 'ti-notify',
		'priority' => 1,
	) );
}
add_action( 'customize_register', 'illyria_customize_register' );

/**
 * Notice in admin dashboard to announce the theme is not maintained anymore
 */
function illyria_admin_notice() {

	global $pagenow;

	if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
		echo '<div class="updated notice is-dismissible"><p>';
		printf( /* translators: link to the recommended theme */ __( 'This theme is not maintained anymore, check-out our latest free one-page theme: %1$s.','illyria' ), sprintf( '<a href="' . admin_url( 'theme-install.php?theme=hestia' ) . '">%s</a>', 'Hestia' ) );
		echo '</p></div>';
	}
}
add_action( 'admin_notices', 'illyria_admin_notice', 99 );