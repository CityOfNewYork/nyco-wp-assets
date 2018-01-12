# NYCO WP Assets

Helpers for managing assets in Wordpress

## Installation
```
composer require nyco/wp-assets
```

## Enqueue Style

`Nyco\Enqueue\style`

Enqueues stylesheet with hashed filename for cache busting. Supports language
code in file name. The naming pattern is `<name>-<hash><min>.css`. By default,
the minified stylesheet will be enqueued. Add the url parameter `debug=1` to
enqueue the non minified stylesheet. You will also need to supply the `$min`
string argument as there is no default.

#### Usage

Require in `functions.php`.
```
require_once(get_template_directory() . '/vendor/nyco/wp-assets/style');
```

In `functions.php` or `single.php`, etc.
```
Enqueue\style();
// Enqueues "style-default-<hash>.css"

Enqueue\style('style-sp', '');
// Multi-lingual example. Enqueues "style-sp-<hash>.css"

Enqueue\style('style', '.min');
// Enqueues "style-<hash>.min.css" if ?debug=1 else, enqueues "style-<hash>.css"
```

In template (twig).
```
{{ function('Enqueue\\style') }}
{# Enqueues "style-<hash>.css" #}

{{ function('Enqueue\\style', 'style-sp') }}
{# Enqueues "style-sp-<hash>.css" #}

{{ function('Enqueue\\style', 'style', '.min') }}
{# Enqueues "style-<hash>.min.css" if ?debug=1 else, enqueues "style-<hash>.css" #}
```

#### Arguments

* `[string]  $name ` Optional, The base name of the stylesheet source. Default: `'style'`
* `[boolean] $min  ` Optional, The post fix for minified files. Default: `''`
* `[array]   $deps ` Optional, maps to wp_enqueue_style `$deps`. Default: `array()`
* `[string]  $media` Optional, maps to wp_enqueue_style `$media`. Default: `'all'`

## Enqueue Script

`Nyco\Enqueue\script`
Enqueues script with hashed filename for cache busting. The naming pattern is
`<name>-<hash><ugl>.js`. The uglified script will be enqueued if the `$ugl`
argument is supplied. Add the url parameter `debug=1` to enqueue the non uglified
script. You will also need to supply the `$ugl` string argument as there is no default.

#### Usage

Require in `functions.php`.
```
require_once(get_template_directory() . '/vendor/nyco/wp-assets/script');
```

In `functions.php` or `single.php`, etc.
```
Enqueue\script();
// Enqueues `main-<hash>.js`

Enqueue\script('main', 'min.');
// Enqueues `main-<hash>.min.js` if ?debug=1
// else, enqueues `main-<hash>.js`

Enqueue\script('view');
// Enqueues `view-<hash>.js`
```

In template (twig).
```
{{ function('Enqueue\\script') }}
{# Enqueues `main-<hash>.js` #}

{{ function('Enqueue\\script', 'main', '.min') }}
{# Enqueues `main-<hash>.js` if ?debug=1 else, enqueues `main-<hash>.js` #}

{{ function('Enqueue\\script', 'view') }}
{# Enqueues `view-<hash>.js` #}
```

#### Arguments

* `[string]  $name     ` The name of the script source
* `[boolean] $ugl      ` Optional, The post fix for minified files. Default: `''`
* `[array]   $deps     ` Optional, maps to wp_enqueue_script `$deps`. Default: `array()`
* `[array]   $in_footer` Optional, maps to wp_enqueue_script `$in_footer`. Default: `true`

### Contributing

Clone repository and create feature branch. Make changes and run `composer run lint`
to follow the coding specification. `composer run format` can help fix some of the issues.

## To Do
- [ ] Set up unit tests.
- [x] Publish to packagist.
- [x] Conduct environment tests.
