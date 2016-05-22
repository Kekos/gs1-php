<?php
/**
 * GS1 code generator
 * PriceProduct Entity
 * Represents a product with variable price.
 *
 * @version 1.0
 * @date 2016-05-21
 */

namespace Gs1\Entity;

use Gs1\Exception\ArgumentException;

class PriceProduct extends AbstractEntity {

  private $sku;
  private $price;

  /**
   * @param int [$sku] SKU, PLU or article number
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
   * Sets SKU, PLU or article number
   *
   * @param int $sku SKU, PLU or article number
   */
  public function setSku($sku) {
    if (!is_numeric($sku)) {
      throw new ArgumentException('PriceProduct: $sku was not numeric');
    }

    $len = strlen($sku);

    if ($len === 0) {
      throw new ArgumentException('PriceProduct: $sku can not be empty');
    }

    if ($len > 6) {
      throw new ArgumentException('PriceProduct: $sku can not be longer than 6 characters, ' . $len . ' given');
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
      throw new ArgumentException('PriceProduct: $price was not numeric');
    }

    $this->price = $price;
  }
}
?>