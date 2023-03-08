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
        'gap' => '46px'
    ), $atts, 'arabic' );

    //sanitize user inputs
    $font_name = sanitize_text_field($atts['font']);

    // Sanitize and validate the size attribute
    $font_size = esc_attr( $atts['size'] );
    if ( ! preg_match( '/^\d+(px|em|rem|%|pt|pc)$/', $font_size ) ) {
        $font_size = '1rem'; // Use default size if user input is invalid
    }

    // Sanitize and validate the gap attribute
    $font_gap = esc_attr( $atts['gap'] );
    if ( ! preg_match( '/^\d+(px|em|rem|%|pt|pc)$/', $font_gap ) ) {
        $font_gap = '46px'; // Use default gap if user input is invalid
    }

    // Check if the font file exists
    $font_files = array(
        plugin_dir_path( __FILE__ ) . 'fonts/' . $font_name . '.eot',
        plugin_dir_path( __FILE__ ) . 'fonts/' . $font_name . '.woff',
        plugin_dir_path( __FILE__ ) . 'fonts/' . $font_name . '.woff2',
        plugin_dir_path( __FILE__ ) . 'fonts/' . $font_name . '.ttf',
        plugin_dir_path( __FILE__ ) . 'fonts/' . $font_name . '.svg',
    );

    foreach ( $font_files as $font_file ) {
        if (file_exists($font_file)) {
            $path = $font_file;
            if (preg_match('/wp-content\/(.*)/', $path, $matches)) {
                $font_file_path = $matches[0];
            }
            break;
        }
    }

    if ( ! isset( $font_file_path ) ) {
        if ( ! isset( $font_file_path ) ) {
            return 'Font file <strong>'.$font_name.'</strong> You Provided not found.';
        }
    }

    static $status_css_arabic_font_2_plus = array();

    // add a var to store current font name
    $search_for = $font_name;

    if (empty($status_css_arabic_font_2_plus)) {
        //if array is empty,(whice it should be on very first run in every page) then register the event to the array and print the standard css for the shortcode then print custom css related to the font
        array_push($status_css_arabic_font_2_plus, "true_css");

        //standard css for the shortcode
        inline_css_arabic_font_2_plus($font_size, $font_gap);

        //custom css related to the font
        user_provided_css_arabic_font_2_plus($font_name, $font_file_path);

        //store the event
        array_push($status_css_arabic_font_2_plus, $search_for);

    } elseif (!in_array(strtolower($search_for), array_map('strtolower', $status_css_arabic_font_2_plus), true) && in_array("true_css", array_map('strtolower', $status_css_arabic_font_2_plus), true)) {
        //if the array isn't empty, then convert font name and array to lower case prior to search the font name in the array, if found and if this is second time, on whice shortcode is executing then simply print custom css related to the font, prior to register the event

        //custom css related to the font
        user_provided_css_arabic_font_2_plus($font_name, $font_file_path);

        //store the event
        array_push($status_css_arabic_font_2_plus, $search_for);

    } else {
        //slience is golden
    }

    // Generate shortcode output
    $output = '<span class="arabic-font-2-lite">' . $content . '</span>';

    return $output;
}

add_shortcode( 'arabic', 'arabic_font_2_lite_shortcode' );

function inline_css_arabic_font_2_plus($size, $gap) {
    ?>
    <style type="text/css">
        .arabic-font-2-lite {
        font-size: <?php echo $size; ?>;
        line-height: <?php echo $gap; ?>;
        }
    </style>
    <?php
}

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