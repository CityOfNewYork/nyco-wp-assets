<?php

namespace NYCO\QueryMonitor;

class WpAssetsOutput extends \QM_Output_Html {
  /**
   * Constructor. Adds filters to Query Monitor menu for displaying in the panel
   *
   * @param   Object  $collector  Instance of WpAssetsCollector
   *
   * @return  Object              Instance of self (WpAssetsOutput)
   */
  public function __construct($collector) {
    parent::__construct($collector);

    add_filter('qm/output/menus', array($this, 'menus'), 101);
    add_filter('qm/output/menu_class', array($this, 'menuClass'));

    return $this;
  }

  /**
   * Build the output for the Query Monitor table
   *
   * @return  String  The output
   */
  public function output() {
    $integrations = $this->collector->get_data();

    $headers = array(
      __('Handle'),
      __('Main path'),
      __('In footer?')
    );

    $echo = array();

    // phpcs:disable
    $echo[] = '<div class="qm" id="' . esc_attr($this->collector->id()) . '">';
    $echo[] = '  <table>';
    $echo[] = '    <thead>';
    $echo[] = '      <tr>';

    foreach ($headers as $header) {
      $echo[] = '<th scope="col">' . $header . '</th>';
    }

    $echo[] = '      </tr>';
    $echo[] = '    </thead>';
    $echo[] = '    <tbody>';

    foreach ($integrations as $i) {
      $echo[] = '<tr class="qm-odd">';
      $echo[] = '  <td class="qm-nowrap qm-ltr">' . $i['handle'] . '</td>';

      $echo[] = '  <td class="qm-row-caller qm-ltr qm-has-toggle qm-nowrap">';
      $echo[] = '    <button class="qm-toggle" data-on="+" data-off="-" aria-expanded="false" aria-label="Toggle more information">+</button>';

      $echo[] = '    <ol>';
      $echo[] = '      <li>';
      $echo[] = '        <code>' . ((array_key_exists('path', $i)) ? $i['path'] : 'none') . '</code>';
      $echo[] = '      </li>';

      $echo[] = '      <div class="qm-toggled">';
      $echo[] = ((array_key_exists('dep', $i)) ? '<li>Constant Dependency: ' . $i['dep'] . '</li>' : '');
      $echo[] = ((array_key_exists('localize', $i)) ? '<li>Localized Constants: ' . implode(', ', $i['localize']) . '</li>' : '');
      $echo[] = ((array_key_exists('inline', $i)) ? '<li>Inline script: ' . $i['inline']['path'] . '<br> Inline position: ' . $i['inline']['position'] . '</li>' : '');
      $echo[] = ((array_key_exists('style', $i)) ? '<li>Stylesheet: ' . $i['style']['path'] . '</li>' : '');
      $echo[] = ((array_key_exists('body_open', $i)) ? '<li>Body tag: ' . $i['body_open']['path'] . '</li>' : '');
      $echo[] = '      </div>';
      $echo[] = '    </ol>';
      $echo[] = '  </td>';

      $echo[] = '  <td class="qm-nowrap qm-ltr">' . (($i['in_footer']) ? 'true' : 'false') . '</td>';
      $echo[] = '</tr>';
    }

    $echo[] = '    </tbody>';
    $echo[] = '    <tfoot>';
    $echo[] = '      <tr>';

    $echo[] = '        <td colspan="' . count($headers) . '">Total: ' . count($integrations) . '</td>';

    $echo[] = '      </tr>';
    $echo[] = '    </tfoot>';
    $echo[] = '  </table>';
    $echo[] = '</div>';
    // phpcs:enable

    echo implode('', $echo);

    return $echo;
  }

  /**
   * Constructs the menu class
   *
   * @param   Array  $class  Query Monitor menu classes
   *
   * @return  Array          Query Monitor menu classes
   */
  public function menuClass($class) {
    $class[] = 'qm-' . $this->collector->id;

    return $class;
  }

  /**
   * Add menu to panel
   *
   * @param   Array  $menu  Query Monitor menus
   *
   * @return  Array         Query Monitor menus
   */
  public function menus($menus) {
    $menus[] = $this->menu(array(
      'id' => 'qm-' . $this->collector->id,
      'href' => '#qm-' . $this->collector->id,
      'title' => $this->collector->name()
    ));

    return $menus;
  }
}
