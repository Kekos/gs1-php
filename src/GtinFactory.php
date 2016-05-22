<?php
/**
 * GS1 code generator
 * GTIN Factory
 *
 * @version 1.0
 * @date 2016-05-22
 */

namespace Gs1;

use Gs1\Entity\AbstractEntity;
use Gs1\Gtin\Gtin;
use Gs1\Exception\ClassNotFoundException;

class GtinFactory {

  /**
   * Generates a GTIN object from given Entity
   *
   * @param string $locale Locale used
   * @param AbstractEntity $entity Entity to generate GTIN for
   * @return Gtin GTIN entity object
   */
  public static function get($locale, AbstractEntity $entity) {
    $class = '\\Gs1\\Generator\\' . $locale;

    if (!class_exists($class)) {
      throw new ClassNotFoundException('GTIN Generator not found for locale ' . $locale);
    }

    return $class::generate($entity);
  }
}
?>