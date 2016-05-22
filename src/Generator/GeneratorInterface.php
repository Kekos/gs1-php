<?php
/**
 * GS1 code generator
 * GTIN generator interface
 *
 * @version 1.0
 * @date 2016-05-22
 */

namespace Gs1\Generator;

use Gs1\Entity\AbstractEntity;

interface GeneratorInterface {
  public static function generate(AbstractEntity $entity);
}
?>