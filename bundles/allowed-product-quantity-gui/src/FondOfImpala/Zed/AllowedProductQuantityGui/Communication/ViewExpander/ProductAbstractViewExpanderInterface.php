<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\ViewExpander;

interface ProductAbstractViewExpanderInterface
{
    /**
     * @param array $viewData
     *
     * @return array
     */
    public function expand(array $viewData): array;
}
