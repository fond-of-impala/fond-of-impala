<?php

namespace FondOfImpala\Zed\PriceListApi\Business\Hydrator;

interface PriceProductsHydratorInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     *
     * @return array<\Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function hydrate(array $priceProductTransfers): array;
}
