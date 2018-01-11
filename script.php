<?php

namespace Nyco\Enqueue;

/**
 * Enqueue a hashed script based on it's name.
 * Enqueue the minified version based on debug mode.
 *
 * @param [string]  $name      The name of the script source
 * @param [boolean] $ugl       Optional, The post fix for minified files.
 *                             Default: ''
 * @param [array]   $deps      Optional, maps to wp_enqueue_script $deps.
 *                             Default: array()
 * @param [array]   $in_footer Optional, maps to wp_enqueue_script $in_footer.
 *                             Default: true
 *
 * @return [null]
 */
function script($name = 'main', $ugl = '', $deps = array(), $in_footer = true) {
  $dir = get_template_directory();

  $files = array_filter(
    scandir("$dir/assets/js/"),
    function ($var) use ($name) {
      return (strpos($var, "$name-") !== false);
    }
  );

  $hash = str_replace(array("$name-", '.js'), '', array_values($files)[0]);
  $ugl = (isset($_GET['debug'])) ? '' : $ugl;
  $uri = get_template_directory_uri();
  $src = "$uri/assets/js/$name-$hash$ugl.js";

  wp_enqueue_script($name, $src, $deps, null, $in_footer);
}
