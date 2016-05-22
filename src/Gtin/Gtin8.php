<?php
/**
 * GS1 code generator
 * GTIN-8 Entity
 *
 * @version 1.0
 * @date 2016-05-22
 */

namespace Gs1\Gtin;

use Gs1\Exception\ArgumentException;

class Gtin8 extends Gtin {

  const LENGTH = 8;

  /**
   * Sets code
   *
   * @param string $code GTIN-8 code
   */
  public function setCode($code) {
    $len = strlen($code);

    if ($len > 8) {
      throw new ArgumentException('Gtin13: $code can not be longer than 8 characters, ' . $len . ' given');
    }

    if ($len < 7) {
      throw new ArgumentException('Gtin13: $code can not be shorter than 7 characters, ' . $len . ' given');
    }

    parent::setCode($code);
  }
}
?>