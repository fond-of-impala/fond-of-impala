<?php

namespace FondOfImpala\Client\EnhancedCatalogExtension\Dependency\Plugin;

use Elastica\Result;

interface ProductExpanderPluginInterface
{
    /**
     * @param array $product
     * @param \Elastica\Result $document
     *
     * @return array
     */
    public function expand(array $product, Result $document): array;
}
