<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\ViewExpander;

class ProductAbstractViewExpander implements ProductAbstractViewExpanderInterface
{
    /**
     * @param array $viewData
     *
     * @return array
     */
    public function expand(array $viewData): array
    {
        return $viewData;
    }
}
