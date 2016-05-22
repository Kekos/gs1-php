<?php
/**
 * GS1 code generator
 * GTIN parser interface
 *
 * @version 1.0
 * @date 2016-05-22
 */

namespace Gs1\Parser;

use Gs1\Gtin\Gtin;

interface ParserInterface {
  public static function parse(Gtin $gtin);
}
?>