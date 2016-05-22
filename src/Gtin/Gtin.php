<?php
/**
 * GS1 code generator
 * GTIN Entity
 *
 * @version 1.0
 * @date 2016-05-22
 */

namespace Gs1\Gtin;

abstract class Gtin {

  protected $code;

  /**
   * @param string [$code] GTIN code
   */
  public function __construct($code = null) {
    if ($code !== null) {
      $this->setCode($code);
    }
  }

  /**
   * Returns Code
   *
   * @return string Code
   */
  public function getCode() {
    if (strlen($this->code) === (static::LENGTH - 1)) {
      $this->code .= $this->getChecksum();
    }

    return $this->code;
  }

  /**
   * Checks if current code is valid
   *
   * @return bool
   */
  public function isValid() {
    if (strlen($this->code) === static::LENGTH) {
      return ($this->getChecksum() === (int) $this->code[static::LENGTH - 1]);
    }

    return false;
  }

  /**
   * Returns checksum for current code
   *
   * @return int Checksum
   */
  public function getChecksum() {
    $sum = 0;
    $weightflag = true;

    for ($i = static::LENGTH - 2; $i >= 0; $i--) {
      $sum += (int) $this->code[$i] * ($weightflag ? 3 : 1);
      $weightflag = !$weightflag;
    }

    return (10 - ($sum % 10)) % 10;
  }

  /**
   * Validates code
   *
   * @param string $code GTIN code
   */
  protected function validateCode($code) {
    if (!is_numeric($code)) {
      throw new ArgumentException('Gtin: $code was not numeric');
    }

    if (!is_string($code)) {
      throw new ArgumentException('Gtin: $code must be a string, ' . gettype($code) . ' given');
    }
  }

  /**
   * Sets code
   *
   * @param string $code GTIN code
   */
  public function setCode($code) {
    $this->validateCode($code);
    $this->code = $code;
  }

  /**
   * Sets part of code, pads with zeroes up to maxlength
   *
   * @param int $maxlength GTIN code
   * @param string $code GTIN code
   */
  public function setPart($maxlength, $code) {
    if (!is_int($maxlength)) {
      throw new ArgumentException('Gtin: $maxlength must be a int, ' . gettype($maxlength) . ' given');
    }

    $this->validateCode($code);
    $this->code .= str_pad($code, $maxlength, '0', STR_PAD_LEFT);
  }

  public function __toString() {
    return (string) $this->getCode();
  }
}
?>