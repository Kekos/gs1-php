<?php
/**
 * GS1 code generator
 * GTIN parser for Sweden
 *
 * @version 1.1
 * @date 2016-06-10
 */

namespace Gs1\Parser;

use Gs1\Entity\AbstractEntity;
use Gs1\Entity\Product;
use Gs1\Entity\WeightProduct;
use Gs1\Entity\PriceProduct;
use Gs1\Entity\Publication;
use Gs1\Entity\Coupon;
use Gs1\Gtin\Gtin;
use Gs1\Gtin\Gtin13;
use Gs1\Gtin\Gtin8;
use Gs1\Exception\ArgumentException;

class Sweden implements ParserInterface {

  private static $weight_dividers = array(
    3 => 1000,
    4 => 100,
    5 => 10
  );

  private static $price_dividers = array(
    100,
    10,
    0
  );

  /**
   * Parses a GTIN object to Entity
   *
   * @param Gtin $gtin GTIN to parse
   * @return AbstractEntity Entity object
   */
  public static function parse(Gtin $gtin) {
    $code = $gtin->getCode();

    if ($gtin instanceof Gtin13) {
      switch ($code[0]) {
        case 2:
          // Weight or price
          if ($code[1] >= 0 && $code[1] <= 2) {
            $divider = self::$price_dividers[intval($code[1])];
            $price = intval(substr($code, 8, 4));

            return new PriceProduct(substr($code, 2, 6), ($divider == 0 ? $price : $price / $divider));

          } else if ($code[1] >= 3 && $code[1] <= 5) {
            $divider = self::$weight_dividers[intval($code[1])];
            $weight = intval(substr($code, 8, 4));

            return new WeightProduct(substr($code, 2, 6), $weight / $divider);
          }

          break;
        case 7:
          if (substr($code, 0, 4) == '7388') {
            // Publication
            return new Publication(substr($code, 4, 4), intval(substr($code, 8, 4), 10) / 10);
          }
          break;
        case 9:
          // Coupon
          return new Coupon(substr($code, 2, 6), intval(substr($code, 8, 4), 10) / 10);
          break;
      }

      return new Product(substr($code, 6, 6), substr($code, 0, 6));
    }

    return new Product(substr($code, 6, 1), substr($code, 0, 6));
  }
}
?>