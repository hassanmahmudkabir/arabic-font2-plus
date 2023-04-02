<?php
/**
 * Plugin Name: Arabic Font 2 Plus "Extended"
 * Plugin URI: https://thealmahmud.blogspot.com/
 * Description: This plugin allows you to change the font of text in a post using a shortcode. Use it as [arabic]Your Text[/arabic], You may attach parameters such As   1)font (Required): provide the font name (without extention) you uploaded to this plugin's font directory      2)size (Optional): will set font-size for the text      3)gap (Optional): will set line-height for the text      4)custom-css (Optional): you may provide VALID css, whice will be applied to your text       Your Text may Contain Shortcode, we will do the execution for you, example: [arabic][another_shortcode]Your Text[/another_shortcode] [/arabic]

Please note This Is A Plugin By Hassan Mahmud Kabir(https://www.facebook.com/hassan.mahmud.kabir.1/) (hassan.mahmud.kabir@gmail.com) Inspired By A Plugin Arabic Font 2 Plus (https://github.com/almahmudbd/arabic-font2-plus),Created By ChatGPT By the direction almahmud(https://thealmahmud.blogspot.com/)
 * Version: 2.0
 * Author: almahmud & Hassan Mahmud Kabir
 * Author URI: https://thealmahmud.blogspot.com/
 */

/**
 * DEVELOPER NOTE:
 * Hello, it's Hassan Here. this plugin was created at first with the help of ChatGPT by almahmud. As it wasn't working as intended i did take the job to fix it and Alhamdullah (All Praise TO Allah). Though There are a vast amount of existing plugins whice do the same as this one, i take this refactoring(back then i thought) job as a fun challenge And It's here now.
 * This Plugin Is Rewritten, From "Kind Of Scratch", because previous plugin was so much confusing and much more work was need to be performed, So I took this One From https://github.com/almahmudbd/arabic-font2-plus ,then tried to
 * fix known bugs
 * improve code security
 * introduced some critical logic checking
 * repetative css printing was eliminated
 * introduced some major new feature such as custom css, input "validation" etc
 *
 * Have A Happy Time
 **/

/**
 * Generate the Arabic font shortcode output.
 *
 * @param  array $atts Shortcode attributes.
 * @param  string $content Shortcode content.
 * @return string Shortcode output.
 */
function arabic_font_shortcode_callback( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        'font' => 'noorehira',
        'size' => '1rem',
        'gap' => '46px',
        'custom_css' => ''
    ), $atts, 'arabic' );

    //sanitize user inputs
    $font_name = sanitize_text_field($atts['font']);
    $custom_css = sanitize_text_field($atts['custom_css']);

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

    if (!isset( $font_file_path)) {
        return 'Font file <strong>'.$font_name.'</strong> You Provided not found.';
    }

    static $css_bin = array();

    // add a var to store current font name
    $search_for = $font_name;

    if (empty($css_bin)) {
        //if array is empty,(whice it should be on very first run in every page) then register the event to the array and print the standard css for the shortcode then print custom css related to the font
        array_push($css_bin, "true_css");

        //standard css for the shortcode
        basic_css_arabic_font_2_plus($font_size, $font_gap);

        //custom css related to the font
        font_css_arabic_font_2_plus($font_name, $font_file_path);

        //store the event
        array_push($css_bin, $search_for);

    } elseif (!in_array(strtolower($search_for), array_map('strtolower', $css_bin), true) && in_array("true_css", array_map('strtolower', $css_bin), true)) {
        //if the array isn't empty, then convert font name and array to lower case prior to search the font name in the array, if found and if this is second time, on whice shortcode is executing then simply print custom css related to the font, prior to register the event

        //custom css related to the font
        font_css_arabic_font_2_plus($font_name, $font_file_path);

        //store the event
        array_push($css_bin, $search_for);

    } else {
        //slience is golden
    }

    // Generate shortcode output
    $output = '<div class="arabic-font-2-lite" style="font-family: '.$font_name.';'.$custom_css.'">' . do_shortcode($content) . '</div>';

    return $output;
}

add_shortcode( 'arabic', 'arabic_font_shortcode_callback' );

function basic_css_arabic_font_2_plus($size, $gap) {
    ?>
    <style id="main_css_arabic_font_2_plus" type="text/css">
        .arabic-font-2-lite {
        font-size: <?php echo $size; ?>;
        line-height: <?php echo $gap; ?>;
        }
    </style>
    <?php
}

function font_css_arabic_font_2_plus($font, $font_path) {
    ?>
    <style id="font_css_arabic_font_2_plus" type="text/css">
    @font-face {
        font-family: '<?php echo $font; ?>';
        src: url(/<?php echo $font_path; ?>);
    };
    </style>
    <?php
}
