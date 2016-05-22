<?php
/**
 * GS1 code generator
 * Publication Entity
 * Represents a publication like newspaper or magazine.
 *
 * @version 1.0
 * @date 2016-05-22
 */

namespace Gs1\Entity;

use Gs1\Exception\ArgumentException;

class Publication extends AbstractEntity {

  private $sku;
  private $price;

  /**
   * @param int [$sku] SKU or article number
   * @param float [$price] Price
   */
  public function __construct($sku = null, $price = null) {
    if ($sku !== null) {
      $this->setSku($sku);
    }

    if ($price !== null) {
      $this->setPrice($price);
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
   * Returns price
   *
   * @return float Price
   */
  public function getPrice() {
    return $this->price;
  }

  /**
   * Sets SKU or article number
   *
   * @param int $sku SKU or article number
   */
  public function setSku($sku) {
    if (!is_numeric($sku)) {
      throw new ArgumentException('Publication: $sku was not numeric');
    }

    $len = strlen($sku);

    if ($len === 0) {
      throw new ArgumentException('Publication: $sku can not be empty');
    }

    if ($len > 4) {
      throw new ArgumentException('Publication: $sku can not be longer than 4 characters, ' . $len . ' given');
    }

    $this->sku = $sku;
  }

  /**
   * Sets price
   *
   * @return float $price Price
   */
  public function setPrice($price) {
    if (!is_numeric($price)) {
      throw new ArgumentException('Publication: $price was not numeric');
    }

    $this->price = $price;
  }
}
?>