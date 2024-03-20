<?php

namespace FondOfImpala\Client\EnhancedCatalog\Formatter;

use Elastica\ResultSet;
use Generated\Shared\Search\PageIndexMap;

class RawCatalogSearchResultFormatter implements RawCatalogSearchResultFormatterInterface
{
    /**
     * @var array<\FondOfImpala\Client\EnhancedCatalogExtension\Dependency\Plugin\ProductExpanderPluginInterface>
     */
    protected array $productExpanderPlugins;

    /**
     * @param array<\FondOfImpala\Client\EnhancedCatalogExtension\Dependency\Plugin\ProductExpanderPluginInterface> $productExpanderPlugins
     */
    public function __construct(array $productExpanderPlugins = [])
    {
        $this->productExpanderPlugins = $productExpanderPlugins;
    }

    /**
     * @param \Elastica\ResultSet $searchResult
     * @param array<string, mixed> $requestParameters
     *
     * @return mixed
     */
    public function format(ResultSet $searchResult, array $requestParameters)
    {
        $products = [];

        foreach ($searchResult->getResults() as $document) {
            $product = $document->getSource()[PageIndexMap::SEARCH_RESULT_DATA];

            foreach ($this->productExpanderPlugins as $productExpanderPlugin) {
                $product = $productExpanderPlugin->expand($product, $document);
            }

            $products[] = $product;
        }

        return $products;
    }
}
