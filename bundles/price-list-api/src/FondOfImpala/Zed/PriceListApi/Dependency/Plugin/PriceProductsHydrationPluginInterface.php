<?php

namespace FondOfImpala\Zed\PriceListApi\Dependency\Plugin;

interface PriceProductsHydrationPluginInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     *
     * @return array<\Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function hydrate(array $priceProductTransfers): array;
}
