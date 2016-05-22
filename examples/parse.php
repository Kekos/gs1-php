<?php
require '../vendor/autoload.php';

use Gs1\EntityFactory;
use Gs1\Gtin\Gtin13;
use Gs1\Gtin\Gtin8;
use Gs1\Entity\Product;
use Gs1\Entity\WeightProduct;
use Gs1\Entity\PriceProduct;
use Gs1\Entity\Publication;
use Gs1\Entity\Coupon;
use Gs1\Exception\ArgumentException;
use Gs1\Exception\ClassNotFoundException;
?>
<!DOCTYPE html>
<meta charset="utf-8" />
<title>GS1 GTIN parser</title>

<h1>GS1 GTIN parser</h1>

<form action="parse.php" method="GET">
  <p>
    <label>
      GTIN (8 or 13 chars):
      <input type="text" name="code" autofocus="on" />
    </label>
  </p>
  <p>
    <button>Send</button>
  </p>
</form>

<?php if (isset($_GET['code'])): ?>

<h2>Result</h2>

<p>
<?php
  try {
    $len = strlen($_GET['code']);

    if ($len === 8) {
      $gtin = new Gtin8($_GET['code']);
    } else if ($len === 13) {
      $gtin = new Gtin13($_GET['code']);
    } else {
      throw new ArgumentException('GTIN must be 8 or 13 characters');
    }

    if (!$gtin->isValid()) {
      throw new ArgumentException('GTIN checksum not valid');
    }

    $entity = EntityFactory::get('Sweden', $gtin);

    if ($entity instanceof WeightProduct) {
      echo 'SKU: ' . $entity->getSku() . '<br />';
      echo 'Weight: ' . $entity->getWeight() . '<br />';

    } else if ($entity instanceof PriceProduct) {
      echo 'SKU: ' . $entity->getSku() . '<br />';
      echo 'Price: ' . $entity->getPrice() . '<br />';

    } else if ($entity instanceof Coupon) {
      echo 'ID (Coupon): ' . $entity->getId() . '<br />';
      echo 'Discount: ' . $entity->getValue() . '<br />';

    } else if ($entity instanceof Publication) {
      echo 'SKU (Publication): ' . $entity->getSku() . '<br />';
      echo 'Price: ' . $entity->getPrice() . '<br />';

    } else if ($entity instanceof Product) {
      echo 'Company Prefix: ' . $entity->getCompanyPrefix() . '<br />';
      echo 'SKU: ' . $entity->getSku() . '<br />';
    }

  } catch (ArgumentException $ex) {
    echo 'Error: ' . $ex->getMessage();
  } catch (ClassNotFoundException $ex) {
    echo 'Error, maybe wrong locale? ' . $ex->getMessage();
  }
?>
</p>

<?php endif; ?>