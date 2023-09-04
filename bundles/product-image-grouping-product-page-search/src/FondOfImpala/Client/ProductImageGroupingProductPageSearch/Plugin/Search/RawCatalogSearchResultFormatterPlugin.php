<?php

namespace FondOfImpala\Client\ProductImageGroupingProductPageSearch\Plugin\Search;

use Elastica\ResultSet;
use FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Communication\Plugin\ProductPageSearch\ProductImageGroupMapExpanderPlugin;
use Generated\Shared\Transfer\RestCatalogSearchProductImageTransfer;
use Spryker\Client\Catalog\Plugin\Elasticsearch\ResultFormatter\RawCatalogSearchResultFormatterPlugin as SprykerRawCatalogSearchResultFormatterPlugin;

class RawCatalogSearchResultFormatterPlugin extends SprykerRawCatalogSearchResultFormatterPlugin
{
    /**
     * @param \Elastica\ResultSet $searchResult
     * @param array $requestParameters
     *
     * @return mixed
     */
    public function formatSearchResult(ResultSet $searchResult, array $requestParameters = [])
    {
        $rawData = parent::formatSearchResult($searchResult, $requestParameters);
        foreach ($rawData as $index => $rawProduct) {
            $rawData[$index] = $this->prepareImageData($rawProduct);
        }

        return $rawData;
    }

    /**
     * @param array $product
     *
     * @return array
     */
    protected function prepareImageData(array $product): array
    {
        if (!array_key_exists(ProductImageGroupMapExpanderPlugin::KEY, $product)) {
            return $product;
        }

        $groupedImages = [];
        foreach ($product[ProductImageGroupMapExpanderPlugin::KEY] as $key => $images) {
            $key = lcfirst(str_replace('_', '', ucwords($key, '_')));

            foreach ($images as $image) {
                $groupedImages[$key][] = (new RestCatalogSearchProductImageTransfer())->fromArray($image, true)->toArray(true, true);
            }
        }

        $product[ProductImageGroupMapExpanderPlugin::KEY] = $groupedImages;

        return $product;
    }
}
