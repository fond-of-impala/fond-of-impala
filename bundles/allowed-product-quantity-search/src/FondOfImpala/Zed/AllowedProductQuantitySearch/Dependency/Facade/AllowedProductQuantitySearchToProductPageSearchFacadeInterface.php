<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade;

interface AllowedProductQuantitySearchToProductPageSearchFacadeInterface
{
    /**
     * @param array $productAbstractIds
     *
     * @return void
     */
    public function publish(array $productAbstractIds): void;

    /**
     * @param array $productAbstractIds
     * @param array $pageDataExpanderPluginNames
     *
     * @return void
     */
    public function refresh(array $productAbstractIds, $pageDataExpanderPluginNames = []): void;

    /**
     * @param array $productAbstractIds
     *
     * @return void
     */
    public function unpublish(array $productAbstractIds): void;
}
