<?php

namespace Nyco\Enqueue;

/**
 * Enqueue a hashed style based on it's name.
 *
 * @param [string]  $name  Optional, The base name of the stylesheet source.
 *                         Default: 'style'
 * @param [boolean] $min   Optional, The post fix for minified files.
 *                         Default: ''
 * @param [array]   $deps  Optional, maps to wp_enqueue_style $deps.
 *                         Default: array()
 * @param [string]  $media Optional, maps to wp_enqueue_style $media.
 *                         Default: 'all'
 *
 * @return [null]
 */
function style($name = 'style', $min = '', $deps = [], $media = 'all') {

  $dir = get_template_directory();

  $files = array_filter(
    scandir($dir),
    function ($var) use ($name) {
      return (strpos($var, "$name-") !== false);
    }
  );

  $hash = str_replace(["$name-", '.css'], '', array_values($files)[0]);
  $min = (isset($_GET['debug'])) ? '' : $min;
  $uri = get_template_directory_uri();
  $src = "$uri/$name-$hash$min.css";

  wp_enqueue_style($name, $src, $deps, null, $media);
}
