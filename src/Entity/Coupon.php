<?php
/**
 * GS1 code generator
 * Coupon Entity
 * Represents a coupon.
 *
 * @version 1.0
 * @date 2016-05-22
 */

namespace Gs1\Entity;

use Gs1\Exception\ArgumentException;

class Coupon extends AbstractEntity {

  private $id;
  private $value;

  /**
   * @param int [$id] ID
   * @param float [$value] Value
   */
  public function __construct($id = null, $value = null) {
    if ($id !== null) {
      $this->setId($id);
    }

    if ($value !== null) {
      $this->setValue($value);
    }
  }

  /**
   * Returns ID
   *
   * @return int ID
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Returns value
   *
   * @return float Value
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * Sets ID
   *
   * @param int $id ID
   */
  public function setId($id) {
    if (!is_numeric($id)) {
      throw new ArgumentException('Coupon: $id was not numeric');
    }

    $len = strlen($id);

    if ($len === 0) {
      throw new ArgumentException('Coupon: $id can not be empty');
    }

    if ($len > 6) {
      throw new ArgumentException('Coupon: $id can not be longer than 6 characters, ' . $len . ' given');
    }

    $this->id = $id;
  }

  /**
   * Sets value
   *
   * @return float $value Value
   */
  public function setValue($value) {
    if (!is_numeric($value)) {
      throw new ArgumentException('Coupon: $value was not numeric');
    }

    $this->value = $value;
  }
}
?>