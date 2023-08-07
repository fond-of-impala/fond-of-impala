<?php

namespace FondOfImpala\Zed\PriceList\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\PriceListTransfer;
use Orm\Zed\PriceList\Persistence\FoiPriceList;
use Propel\Runtime\Collection\ObjectCollection;

interface PriceListMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Orm\Zed\PriceList\Persistence\FoiPriceList
     */
    public function mapTransferToEntity(PriceListTransfer $priceListTransfer): FoiPriceList;

    /**
     * @param \Orm\Zed\PriceList\Persistence\FoiPriceList $entity
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function mapEntityToTransfer(FoiPriceList $entity): PriceListTransfer;

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\PriceList\Persistence\FoiPriceList> $entityCollection
     *
     * @return array<\Generated\Shared\Transfer\PriceListTransfer>
     */
    public function mapEntityCollectionToTransfers(ObjectCollection $entityCollection): array;
}
