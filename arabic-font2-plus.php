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
 * Generate the Arabic font shortcode output.
 *
 * @param  array $atts Shortcode attributes.
 * @param  string $content Shortcode content.
 * @return string Shortcode output.
 */
function arabic_font_2_lite_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        'font' => 'noorehira',
        'size' => '1rem',
        'gap' => '46px',
        'custom_css' => ''
    ), $atts, 'arabic' );

    // Check if the font file exists
    $font_files = array(
        plugin_dir_path( __FILE__ ) . 'fonts/' . $atts['font'] . '.eot',
        plugin_dir_path( __FILE__ ) . 'fonts/' . $atts['font'] . '.woff',
        plugin_dir_path( __FILE__ ) . 'fonts/' . $atts['font'] . '.woff2',
        plugin_dir_path( __FILE__ ) . 'fonts/' . $atts['font'] . '.ttf',
        plugin_dir_path( __FILE__ ) . 'fonts/' . $atts['font'] . '.svg',
    );

    foreach ( $font_files as $font_file ) {
        if ( file_exists( $font_file ) ) {
            $font_file_path = $font_file;
            break;
        }
    }

    if ( ! isset( $font_file_path ) ) {
        return 'Font file <strong>'.$atts['font'].'</strong> You Provided not found.';
    }

    static $inline_css = array();
    $search_for = $atts['font'];

    if (empty($inline_css)) {
        $inline_css = array(true_css);
        add_action('wp_head', 'main_inline_css');
    } elseif (in_array(strtolower($search_for), array_map('strtolower', $myArray), true)) {
        $custom_css = `@font-face {
        font-family: '`.$atts['font'].`';
        src: url('`.$font_file_path.`');
        };`;
        $custom_css .= $atts['custom_css'];
        add_action( 'wp_head', 'mirror_css', 10, 1, $custom_css );
        array_push($inline_css, $search_for);
    } else {
        //slience is golden
    }


    // Generate shortcode output
    $output = '<span class="arabic-font-2-plus main-style-arabic-font-2-plus">' . $content . '</span>';

    return $output;
}

add_shortcode( 'arabic', 'arabic_font_2_lite_shortcode' );

function main_inline_css(){
    $main_css = `<style> .main-style-arabic-font-2-plus {
            font-size: ` . $atts['size'] . `;
            line-height: ` . $atts['gap'] . `;
            ` . $atts['custom-css'] . `
        }</style>`;
    echo $main_css;
}

function mirror_css($css = '')
{
    echo '<style>'.$css.'</style>';
}