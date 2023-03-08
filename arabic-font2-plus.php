<?php
/**
 * Plugin Name: Arabic Font 2 Plus
 * Plugin URI: https://thealmahmud.blogspot.com/
 * Description: This plugin allows you to change the font of a single line in a post using a shortcode.
 * Version: 1.3
 * Author: almahmud
 * Author URI: https://thealmahmud.blogspot.com/
 */

 function inline_css_arabic_font_2_plus($size, $gap)
{
    ?>
    <style type="text/css">
        .arabic-font-2-lite {
        font-size: <?php echo $size; ?>;
        line-height: <?php echo $gap; ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'inline_css_arabic_font_2_plus');

function user_provided_css_arabic_font_2_plus($font, $font_path, $css = '') {
    ?>
    <style id="user_provided_css_arabic_font_2_plus" type="text/css">
    @font-face {
        font-family: '<?php echo $font; ?>';
        src: url('<?php echo $font_path; ?>');
    };
    <?php echo $css; ?>
    </style>
    <?php
}
add_action('wp_head', 'user_provided_css_arabic_font_2_plus');

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
        'gap' => '46px'
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
        if ( ! isset( $font_file_path ) ) {
            return 'Font file <strong>'.$atts['font'].'</strong> You Provided not found.';
        }
    }

    static $status_css_arabic_font_2_plus = array();

    // Generate shortcode output
    $output = '<span class="arabic-font-2-lite">' . $content . '</span>';

    return $output;
}

add_shortcode( 'arabic', 'arabic_font_2_lite_shortcode' );
