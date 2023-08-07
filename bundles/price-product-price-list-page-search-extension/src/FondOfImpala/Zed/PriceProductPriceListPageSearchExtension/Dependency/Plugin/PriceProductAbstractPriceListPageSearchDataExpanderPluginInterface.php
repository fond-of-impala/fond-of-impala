<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin;

interface PriceProductAbstractPriceListPageSearchDataExpanderPluginInterface
{
    /**
     * Specification:
     * - Expands the mapped search data.
     *
     * @api
     *
     * @param array $data
     * @param array $searchData
     *
     * @return array
     */
    public function expand(array $data, array $searchData): array;
}
