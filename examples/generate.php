<?php
require '../vendor/autoload.php';

use Gs1\GtinFactory;
use Gs1\Entity\WeightProduct;
use Gs1\Entity\PriceProduct;
use Gs1\Entity\Publication;
use Gs1\Entity\Coupon;
use Gs1\Exception\ArgumentException;
use Gs1\Exception\ClassNotFoundException;
?>
<!DOCTYPE html>
<meta charset="utf-8" />
<title>GS1 GTIN generator</title>

<h1>GS1 GTIN generator</h1>

<form action="generate.php" method="GET">
<?php if (isset($_GET['type'])):

        if ($_GET['type'] < 3): ?>
  <p>
    <label>
      SKU:
      <input type="text" name="product" maxlength="6" />
    </label>
  </p>
<?php   else: ?>
  <p>
    <label>
      ID:
      <input type="text" name="id" maxlength="6" />
    </label>
  </p>
<?php   endif;
        if ($_GET['type'] > 0): ?>
  <p>
    <label>
      Price:
      <input type="text" name="price" maxlength="5" />
    </label>
  </p>
<?php   else: ?>
  <p>
    <label>
      Weight:
      <input type="text" name="weight" maxlength="5" />
    </label>
  </p>
<?php   endif; ?>
  <p>
    <button name="generate" value="1">Generate</button>
    <input type="hidden" name="type" value="<?php echo intval($_GET['type']); ?>" />
  </p>
<?php else: ?>
  <p>
    <label>
      Typ:
      <select name="type">
        <option value="0">Weight</option>
        <option value="1">Price</option>
        <option value="2">Publication</option>
        <option value="3">Coupon</option>
      </select>
    </label>
  </p>
  <p>
    <button>Continue</button>
  </p>
<?php endif; ?>
</form>

<?php if (isset($_GET['type'], $_GET['generate'])): ?>

<h2>Result</h2>

<p><a href="generate.php">Create new code</a></p>

<p>
<?php
  try {
    switch ($_GET['type']) {
      case 0:
        $product = new WeightProduct($_GET['product'], $_GET['weight']);
        $code = GtinFactory::get('Sweden', $product);
        break;

      case 1:
        $product = new PriceProduct($_GET['product'], $_GET['price']);
        $code = GtinFactory::get('Sweden', $product);
        break;

      case 2:
        $publication = new Publication($_GET['product'], $_GET['price']);
        $code = GtinFactory::get('Sweden', $publication);
        break;

      case 3:
        $coupon = new Coupon($_GET['id'], $_GET['price']);
        $code = GtinFactory::get('Sweden', $coupon);
        break;
    }

    echo 'GTIN: ' . $code;

  } catch (ArgumentException $ex) {
    echo 'Error: ' . $ex->getMessage();
  } catch (ClassNotFoundException $ex) {
    echo 'Error, maybe wrong locale? ' . $ex->getMessage();
  }
?>
</p>

<?php endif; ?>