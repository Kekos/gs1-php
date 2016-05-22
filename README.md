# GS1 parser and generator for PHP

Encodes and decodes GTIN numbers (EAN-8 and EAN-13) with support for
products having variable weight and price.

## Install

You can install this package via [Composer](http://getcomposer.org/):

```
composer require kekos/gs1
```

## Documentation

### Locales

Each member country of [GS1](http://www.gs1.org/) have their own specification for
products with variable weight and price, magazines and coupons. This is handled
by this library by defining encoding rules in "locales".

Currently only the `Sweden` locale is implemented.

### Generate GTIN

Start by creating an entity:

```PHP
$entity = new \Gs1\Entity\WeightProduct($sku, $weight);
$entity = new \Gs1\Entity\PriceProduct($sku, $price);
$entity = new \Gs1\Entity\Publication($sku, $price);
$entity = new \Gs1\Entity\Coupon($id, $discount);
```

Use `GtinFactory` class by specifying which locale to use:

```PHP
$code = \Gs1\GtinFactory::get('Sweden', $entity);
echo $code;
```

### Parse GTIN

Create a GTIN entity:

```PHP
$gtin = new \Gs1\Gtin\Gtin13($code);
$gtin = new \Gs1\Gtin\Gtin8($code);
```

Use `EntityFactory` class by specifying which locale to use:

```PHP
$entity = \Gs1\EntityFactory::get('Sweden', $gtin);
if ($entity instanceof \Gs1\Entity\WeightProduct) {
  echo 'Weight: ' . $entity->getWeight();
}
```

### Product entity

```PHP
$product = new \Gs1\Entity\Product($sku, $company_prefix);
$product->getSku();
$product->setSku($sku);
$product->getCompanyPrefix();
$product->setCompanyPrefix($company_prefix);
```

### Weight product entity

```PHP
$product = new \Gs1\Entity\WeightProduct($sku, $weight);
$product->getSku();
$product->setSku($sku);
$product->getWeight();
$product->setWeight($weight);
```

### Price product entity

```PHP
$product = new \Gs1\Entity\PriceProduct($sku, $price);
$product->getSku();
$product->setSku($sku);
$product->getPrice();
$product->setPrice($price);
```

### Coupon entity

```PHP
$coupon = new \Gs1\Entity\Coupon($id, $value);
$coupon->getId();
$coupon->setId($id);
$coupon->getValue();
$coupon->setValue($value);
```

### Publication entity

```PHP
$publication = new \Gs1\Entity\Publication($sku, $price);
$publication->getSku();
$publication->setSku($sku);
$publication->getPrice();
$publication->setPrice($price);
```

### GTIN-13 entity (EAN-13) and GTIN-8 entity (EAN-8)

When setting the code you don't have to specify the checksum (digit 8 or 13).
The `Gtin` classes will add the checksum automatically if needed.

```PHP
$gtin = new \Gs1\Gtin\Gtin8($code);
// ...or
$gtin = new \Gs1\Gtin\Gtin13($code);

$gtin->getCode();
$gtin->setCode($code);
$gtin->isValid(); // true or false
$gtin->getChecksum();
$gtin->__toString(); // magic method
```

## Bugs and improvements

Report bugs in GitHub issues or feel free to make a pull request :-)

## License

MIT
