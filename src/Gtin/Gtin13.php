<?php
/**
 * GS1 code generator
 * GTIN-13 Entity
 *
 * @version 1.0
 * @date 2016-05-22
 */

namespace Gs1\Gtin;

use Gs1\Exception\ArgumentException;

class Gtin13 extends Gtin {

  const LENGTH = 13;

  /**
   * Sets code
   *
   * @param string $code GTIN-13 code
   */
  public function setCode($code) {
    $len = strlen($code);

    if ($len > 13) {
      throw new ArgumentException('Gtin13: $code can not be longer than 13 characters, ' . $len . ' given');
    }

    if ($len < 12) {
      throw new ArgumentException('Gtin13: $code can not be shorter than 12 characters, ' . $len . ' given');
    }

    parent::setCode($code);
  }
}
?>