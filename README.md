Arabic Font 2 Plus "Extended"
==================

Arabic Font 2 Plus "Extended" is a WordPress plugin allows you to change the font of text in a post using a shortcode. 

Installation
------------
[![Github Downloads (total)](https://img.shields.io/github/downloads/hassanmahmudkabir/arabic-font2-plus-extended/total?color=green&label=Downloads)](https://github.com/hassanmahmudkabir/arabic-font2-plus-extended/releases)

1.  Download the plugin from the WordPress Plugin Repository or from the [GitHub repository](https://github.com/hassanmahmudkabir/arabic-font2-plus-extended).
2.  Upload the plugin files to the `/wp-content/plugins/arabic-font2-plus-extended` directory, or install the plugin through the WordPress plugins screen directly.
3.  Activate the plugin through the 'Plugins' screen in WordPress.

Usage
-----

To use the plugin, simply wrap your Arabic text in the `[arabic]` shortcode:

`[arabic]هذا هو نص عربي[/arabic]` 

By default, the plugin will use the noorehira font. If you want to use a specific font, you can specify it in the shortcode:

`[arabic font="Amiri"]هذا هو نص عربي[/arabic]` 

The plugin supports EOT, TTF, WOFF, WOFF2 And SVG font formats. To use a custom font, simply upload the font files to the `wp-content/plugins/arabic-font2-plus-extended/fonts` directory. The font files must be named after the font family they represent. For example, if you have a font family named `Amiri`, you should name your font files `Amiri.ttf`, `Amiri.woff`, or `Amiri.woff2`.

You can also optionally specify the font size in the shortcode. The default font size is 1rem. To change the font size, add the `size` attribute to the shortcode:

`[arabic font="Amiri" size="24px"]هذا هو نص عربي[/arabic]` 

You can also optionally specify the line-height aka line gap in the shortcode. The default line gap is 46px. To change the gap, add the `gap` attribute to the shortcode:

`[arabic font="Amiri" size="24px" gap="48px"]هذا هو نص عربي[/arabic]` 

You May provide VALID css inside custom_css parameter, whice will be applied to your contents inside the shortcode

`[arabic font="noorehira" size="2rem" gap="48px" custom_css="background-color:red"]هذا هو نص عربي[/arabic]` 

And shortcode inside of **[arabic][/arabic]** is allowed, and will execute as it would have been without **[arabic][/arabic]** .

BackStory
--------

Please note This Is A Plugin By [Hassan Mahmud Kabir](https://www.facebook.com/hassan.mahmud.kabir.1/) (hassan.mahmud.kabir[at]gmail.com) Inspired By A Plugin named [Arabic Font 2 Plus](https://github.com/almahmudbd/arabic-font2-plus),Created By ChatGPT By the direction of [almahmud](https://thealmahmud.blogspot.com/)

Support
-------

If you encounter any issues with the plugin, please submit an issue on the [GitHub repository](https://github.com/hassanmahmudkabir/arabic-font2-plus-extended/issues).
