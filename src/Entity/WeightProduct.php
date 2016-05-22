<?php
/**
 * GS1 code generator
 * WeightProduct Entity
 * Represents a product with variable weight.
 *
 * @version 1.0
 * @date 2016-05-22
 */

namespace Gs1\Entity;

use Gs1\Exception\ArgumentException;

class WeightProduct extends AbstractEntity {

  private $sku;
  private $weight;

  /**
   * @param int [$sku] SKU, PLU or article number
   * @param float [$weight] Weight
   */
  public function __construct($sku = null, $weight = null) {
    if ($sku !== null) {
      $this->setSku($sku);
    }
    
    if ($weight !== null) {
      $this->setWeight($weight);
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
   * Returns weight
   *
   * @return float Weight
   */
  public function getWeight() {
    return $this->weight;
  }

  /**
   * Sets SKU, PLU or article number
   *
   * @param int $sku SKU, PLU or article number
   */
  public function setSku($sku) {
    if (!is_numeric($sku)) {
      throw new ArgumentException('WeightProduct: $sku was not numeric');
    }

    $len = strlen($sku);

    if ($len === 0) {
      throw new ArgumentException('WeightProduct: $sku can not be empty');
    }

    if ($len > 6) {
      throw new ArgumentException('WeightProduct: $sku can not be longer than 6 characters, ' . $len . ' given');
    }

    $this->sku = $sku;
  }

  /**
   * Sets weight
   *
   * @return float $weight Weight
   */
  public function setWeight($weight) {
    if (!is_numeric($weight)) {
      throw new ArgumentException('WeightProduct: $weight was not numeric');
    }

    $this->weight = $weight;
  }
}
?>