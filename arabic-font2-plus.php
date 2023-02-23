<?php
/*
Plugin Name: Arabic Font 2 Plus
Plugin URI: https://ruqyahbd.org/
Description: This plugin allows you to change the font of a single line in a post using a shortcode.
Author: almahmud & ChatGPT
Version: 1.2
Author URI: https://thealmahmud.blogspot.com/
*/

function custom_arabic_font_shortcode($atts, $content = null) {
  // Get font family and font size from shortcode attributes, or use the default font and font size if not specified
  $font_family = isset($atts['font']) ? $atts['font'] : 'noorehira';
  $font_size = isset($atts['size']) ? $atts['size'] : '22px';

  // Check if the font file exists
  $font_file = plugin_dir_path(__FILE__) . 'fonts/' . $font_family . '.ttf';

  if (!file_exists($font_file)) {
    $font_file = plugin_dir_path(__FILE__) . 'fonts/noorehira.ttf';
  }

  // Enqueue the font file
  wp_enqueue_style('custom-arabic-font-' . $font_family, plugin_dir_url(__FILE__) . 'fonts/' . $font_family . '.css');

  // Return the content with the custom font and font size applied
  return '<span style="font-family: ' . $font_family . '; font-size: ' . $font_size . ';">' . $content . '</span>';
}

add_shortcode('arabic', 'custom_arabic_font_shortcode');
?>
