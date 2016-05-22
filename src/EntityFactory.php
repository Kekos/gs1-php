<?php
/**
 * GS1 code generator
 * Entity Factory
 *
 * @version 1.0
 * @date 2016-05-22
 */

namespace Gs1;

use Gs1\Entity\AbstractEntity;
use Gs1\Entity\Gtin;
use Gs1\Exception\ClassNotFoundException;

class EntityFactory {

  /**
   * Parses a GTIN object to Entity
   *
   * @param string $locale Locale used
   * @param Gtin $gtin Entity to generate GTIN for
   * @return AbstractEntity Entity object
   */
  public static function get($locale, $gtin) {
    $class = '\\Gs1\\Parser\\' . $locale;

    if (!class_exists($class)) {
      throw new ClassNotFoundException('GTIN Parser not found for locale ' . $locale);
    }

    return $class::parse($gtin);
  }
}
?>