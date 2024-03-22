<?php

namespace FondOfImpala\Client\ProductGroupHash\Plugin\EnhancedCatalogExtension;

use Elastica\Result;
use FondOfImpala\Client\EnhancedCatalogExtension\Dependency\Plugin\ProductExpanderPluginInterface;
use FondOfImpala\Shared\ProductGroupHash\ProductGroupHashConstants;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class GroupCountProductExpanderPlugin extends AbstractPlugin implements ProductExpanderPluginInterface
{
    /**
     * @param array $product
     * @param \Elastica\Result $document
     *
     * @return array
     */
    public function expand(array $product, Result $document): array
    {
        $innerHits = $document->getInnerHits();

        if (!isset($innerHits[ProductGroupHashConstants::INNER_HITS_NAME]['hits']['total']['value'])) {
            return $product;
        }

        $product['group_count'] = $innerHits[ProductGroupHashConstants::INNER_HITS_NAME]['hits']['total']['value'];

        return $product;
    }
}
