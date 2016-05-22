<?php
/**
 * GS1 code generator
 * Product Entity
 * Represents a product with fixed price and weight.
 *
 * @version 1.0
 * @date 2016-05-22
 */

namespace Gs1\Entity;

use Gs1\Exception\ArgumentException;

class Product extends AbstractEntity {

  private $sku;
  private $company_prefix;

  /**
   * @param int [$sku] SKU or article number
   * @param int [$company_prefix] Company prefix
   */
  public function __construct($sku = null, $company_prefix = null) {
    if ($sku !== null) {
      $this->setSku($sku);
    }

    if ($company_prefix !== null) {
      $this->setCompanyPrefix($company_prefix);
    }
  }

  /**
   * Returns SKU
   *
   * @return int SKU
   */
  public function getSku() {
    return $this->sku;
  }

  /**
   * Returns Company prefix
   *
   * @return int Company prefix
   */
  public function getCompanyPrefix() {
    return $this->company_prefix;
  }

  /**
   * Sets SKU
   *
   * @param int $sku SKU or article number
   */
  public function setSku($sku) {
    if (!is_numeric($sku)) {
      throw new ArgumentException('Product: $sku was not numeric');
    }

    $len = strlen($sku);

    if ($len < 1) {
      throw new ArgumentException('Product: $sku can not be shorter than 3 characters, ' . $len . ' given');
    }

    if ($len > 6) {
      throw new ArgumentException('Product: $sku can not be longer than 6 characters, ' . $len . ' given');
    }

    $this->sku = $sku;
  }

  /**
   * Sets Company prefix
   *
   * @return int $company_prefix Company prefix
   */
  public function setCompanyPrefix($company_prefix) {
    if (!is_numeric($company_prefix)) {
      throw new ArgumentException('Product: $company_prefix was not numeric');
    }

    $len = strlen($company_prefix);

    if ($len < 6) {
      throw new ArgumentException('Product: $company_prefix can not be shorter than 6 characters, ' . $len . ' given');
    }

    if ($len > 9) {
      throw new ArgumentException('Product: $company_prefix can not be longer than 9 characters, ' . $len . ' given');
    }

    $this->company_prefix = $company_prefix;
  }
}
?>