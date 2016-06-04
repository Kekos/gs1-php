<?php
/**
 * GS1 code generator
 * GTIN generator for Sweden
 *
 * @version 1.1
 * @date 2016-06-04
 */

namespace Gs1\Generator;

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

class Sweden implements GeneratorInterface {

  private static $weight_modulators = array(
    1 => 5,
    2 => 4,
    3 => 3
  );

  private static $price_modulators = array(
    0 => 2,
    1 => 1,
    2 => 0
  );

  /**
   * Generates a GTIN object from given Entity
   *
   * @param AbstractEntity $entity Entity to generate GTIN for
   * @return Gtin GTIN entity object
   */
  public static function generate(AbstractEntity $entity) {
    if ($entity instanceof Product) {

      try {
        $gtin = new Gtin8();
        $gtin->setPart(6, $entity->getCompanyPrefix());
        $gtin->setPart(1, $entity->getSku());

      } catch (ArgumentException $ex) {
        $gtin = new Gtin13();
        $gtin->setPart(9, $entity->getCompanyPrefix());
        $gtin->setPart(3, $entity->getSku());
      }

    } else if ($entity instanceof WeightProduct) {
      $gtin = new Gtin13();
      $weight = self::toFloat($entity->getWeight());

      $decimals = self::getDecimalsCount($weight);
      $decimals = max(1, min(3, $decimals));
      $modulator = self::$weight_modulators[$decimals];
      $weight = substr(str_replace('.', '', $weight), 0, 4);

      $gtin->setPart(2, '2' . $modulator);
      $gtin->setPart(6, $entity->getSku());
      $gtin->setPart(4, $weight);

    } else if ($entity instanceof PriceProduct) {
      $gtin = new Gtin13();
      $price = self::toFloat($entity->getPrice());

      $decimals = self::getDecimalsCount($price);
      $decimals = max(0, min(2, $decimals));
      $modulator = self::$price_modulators[$decimals];
      $price = substr(str_replace('.', '', $price), 0, 4);

      $gtin->setPart(2, '2' . $modulator);
      $gtin->setPart(6, $entity->getSku());
      $gtin->setPart(4, $price);

    } else if ($entity instanceof Publication) {
      $gtin = new Gtin13();
      $price = self::toFloat($entity->getPrice());

      $decimals = self::getDecimalsCount($price);
      if ($decimals == 0) {
        $price = substr($price, 0, 3) . '0';
      } else {
        $price = substr(str_replace('.', '', $price), 0, 4);
      }

      $gtin->setPart(4, '7388');
      $gtin->setPart(4, $entity->getSku());
      $gtin->setPart(4, $price);

    } else if ($entity instanceof Coupon) {
      $gtin = new Gtin13();
      $value = self::toFloat($entity->getValue());

      $decimals = self::getDecimalsCount($value);
      if ($decimals == 0) {
        $value = substr($value, 0, 3) . '0';
      } else {
        $value = substr(str_replace('.', '', $value), 0, 4);
      }

      $gtin->setPart(2, '99');
      $gtin->setPart(6, $entity->getId());
      $gtin->setPart(4, $value);
    }

    return $gtin;
  }

  /**
   * Returns the number of decimals in float
   *
   * @param float $number Number
   * @return int Number of decimals
   */
  private static function getDecimalsCount($number) {
    return strlen(substr(strrchr($number, '.'), 1));
  }

  /**
   * Converts string to float
   *
   * @param float $number Number
   * @return float Float
   */
  private static function toFloat($number) {
    return str_replace(',', '.', floatval(str_replace(',', '.', $number)));
  }
}
?>