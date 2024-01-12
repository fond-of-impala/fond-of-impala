# Allowed Product Quantity Module
[![CI](https://github.com/fond-of-impala/allowed-product-quantity/actions/workflows/main.yml/badge.svg)](https://github.com/fond-of-impala/allowed-product-quantity/actions/workflows/main.yml)
[![license](https://img.shields.io/github/license/fond-of-impala/allowed-product-quantity.svg)](https://packagist.org/packages/fond-of-impala/allowed-product-quantity)

Module was migrated from `fond-of-spryker/allowed-product-quantity`. Please read below for migration instruction!

## Installation

```
composer require fond-of-impala/allowed-product-quantity
```

## Migration

To prevent losing data, please rename db data like

```
do
$$
begin
ALTER TABLE fos_allowed_product_quantity RENAME CONSTRAINT "fos_allowed_product_quantity-fk_product_abstract" TO "foi_allowed_product_quantity-fk_product_abstract";
ALTER TABLE foi_allowed_product_quantity RENAME CONSTRAINT "fos_allowed_product_quantity-unique-fk_product_abstract" TO "foi_allowed_product_quantity-unique-fk_product_abstract";
ALTER TABLE fos_allowed_product_quantity RENAME TO foi_allowed_product_quantity;
end
$$;
```

You can use also the `fond-of-oryx/propel-pre-migration` package for migration. Just use the package and create migration file with the above content!
