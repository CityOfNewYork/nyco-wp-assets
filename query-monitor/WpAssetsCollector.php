<?php

namespace NYCO\QueryMonitor;

class WpAssetsCollector extends \QM_Collector {
  /** @var  String  Query monitor add on panel ID */
  public $id = 'nyco-wp-assets';

  /** @var  String  Query monitor add on panel name */
  public $name = 'NYCO WP Assets';

  /**
   * Constructor. Sets instance of WpAssets to self
   *
   * @param   Object  $WpAssets  Instance of WpAssets
   *
   * @return  Object             Instance of self (WpAssetsCollector)
   */
  public function __construct($WpAssets) {
    $this->WpAssets = $WpAssets;

    return $this;
  }

  /**
   * Get the Add on name
   *
   * @return  String  The Add on name
   */
  public function name() {
    return __($this->name);
  }

  /**
   * Set data to the collector
   *
   * @return  Array  Data for the output
   */
  public function process() {
    $integrations = $this->WpAssets->loadIntegrations();

    $this->data = ($integrations) ? $integrations : array();

    return $this->data;
  }
}
