<?php
/**
 * Plugin Name: Arabic Font 2 Plus
 * Plugin URI: https://thealmahmud.blogspot.com/
 * Description: This plugin allows you to change the font of a single line in a post using a shortcode.
 * Version: 1.3
 * Author: almahmud
 * Author URI: https://thealmahmud.blogspot.com/
 */

/**
 * Enqueue styles for shortcode display.
 */
function arabic_font_2_lite_enqueue_styles() {
    wp_enqueue_style( 'arabic-font-2-lite-style', plugin_dir_url( __FILE__ ) . 'style.css', array(), '1.0', 'all' );
}

add_action( 'wp_enqueue_scripts', 'arabic_font_2_lite_enqueue_styles' );

/**
 * Generate the Arabic font shortcode output.
 *
 * @param  array $atts Shortcode attributes.
 * @param  string $content Shortcode content.
 * @return string Shortcode output.
 */
function arabic_font_2_lite_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        'font' => 'noorehira',
        'size' => '26px',
        'gap' => '46px'
    ), $atts, 'arabic' );

    // Check if the font file exists
    $font_files = array(
        plugin_dir_path( __FILE__ ) . 'fonts/' . $atts['font'] . '.ttf',
        plugin_dir_path( __FILE__ ) . 'fonts/' . $atts['font'] . '.woff',
        plugin_dir_path( __FILE__ ) . 'fonts/' . $atts['font'] . '.woff2',
    );

    foreach ( $font_files as $font_file ) {
        if ( file_exists( $font_file ) ) {
            $font_file_path = $font_file;
            break;
        }
    }

    if ( ! isset( $font_file_path ) ) {
        return 'Font file not found.';
    }

    // Generate shortcode output
    $output = '<span class="arabic-font-2-lite" style="font-family: ' . $atts['font'] . '; font-size: ' . $atts['size'] . '; line-height: ' . $atts['gap'] . ';">' . $content . '</span>';

    return $output;
}

add_shortcode( 'arabic', 'arabic_font_2_lite_shortcode' );
