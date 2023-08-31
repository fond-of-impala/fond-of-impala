# Product Image Grouping Product Page Search
[![CI](https://github.com/fond-of-impala/product-image-grouping-product-page-search/actions/workflows/main.yml/badge.svg)](https://github.com/fond-of-impala/product-image-grouping-product-page-search/actions/workflows/main.yml)
[![license](https://img.shields.io/github/license/fond-of-impala/product-image-grouping-product-page-search.svg)](https://packagist.org/packages/fond-of-impala/product-image-grouping-product-page-search)

This package will group the image sets by name. Example:

```
"groupedImages": {
  "setName1": [
    {
      "externalUrlSmall": "https:\/\/...",
      "externalUrlLarge": "https:\/\/...",
      "sortOrder": 5
    },
    {
      "externalUrlSmall": "https:\/\/...",
      "externalUrlLarge": "https:\/\/...",
      "sortOrder": 10
    },
    {
      "externalUrlSmall": "https:\/\/...",
      "externalUrlLarge": "https:\/\/...",
      "sortOrder": 15
    }
  ],
  "setName2": [
    {
      "externalUrlSmall": "https:\/\/...",
      "externalUrlLarge": "https:\/\/...",
      "sortOrder": 0
    }
  ]
}
```


## Installation

```
composer require fond-of-impala/product-image-grouping-product-page-search
```

## Usage

In src/Pyz/Client/Catalog/CatalogDependencyProvider.php replace

`use Spryker\Client\Catalog\Plugin\Elasticsearch\ResultFormatter\RawCatalogSearchResultFormatterPlugin;`

with

`use FondOfImpala\Client\ProductImageGroupingProductPageSearch\Plugin\Search\RawCatalogSearchResultFormatterPlugin`


In src/Pyz/Zed/ProductPageSearch/ProductPageSearchDependencyProvider.php

add `$dataExpanderPlugins[ProductImageGroupingProductPageSearchConfig::PLUGIN_PRODUCT_IMAGE_GROUPED_PAGE_DATA] = new ProductImageGroupedPageDataLoaderExpanderPlugin();`

after

`$dataExpanderPlugins[ProductPageSearchConfig::PLUGIN_PRODUCT_IMAGE_PAGE_DATA] = new ProductImagePageDataLoaderExpanderPlugin();`
```
        /**
        * @return array<\Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageDataExpanderInterface>
        */
        protected function getDataExpanderPlugins(): array
        {
            $dataExpanderPlugins = [];
            ...
            $dataExpanderPlugins[ProductPageSearchConfig::PLUGIN_PRODUCT_IMAGE_PAGE_DATA] = new ProductImagePageDataLoaderExpanderPlugin();
            $dataExpanderPlugins[ProductImageGroupingProductPageSearchConfig::PLUGIN_PRODUCT_IMAGE_GROUPED_PAGE_DATA] = new ProductImageGroupedPageDataLoaderExpanderPlugin();
            ...
            return $dataExpanderPlugins;
        }
```

add

`new ProductImageGroupMapExpanderPlugin(),`

after

`new ProductImageMapExpanderPlugin(),`

```
      /**
      * @return array<\Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductAbstractMapExpanderPluginInterface>
      */
      protected function getProductAbstractMapExpanderPlugins(): array
      {
          return [
              ...
              new ProductImageMapExpanderPlugin(),
              new ProductImageGroupMapExpanderPlugin(),
              ...
          ];
      }
```
