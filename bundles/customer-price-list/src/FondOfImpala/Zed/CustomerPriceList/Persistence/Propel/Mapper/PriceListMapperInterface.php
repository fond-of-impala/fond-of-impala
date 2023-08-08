<?php

namespace FondOfImpala\Zed\CustomerPriceList\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\PriceListCollectionTransfer;
use Generated\Shared\Transfer\PriceListTransfer;
use Orm\Zed\PriceList\Persistence\Base\FoiPriceList;
use Propel\Runtime\Collection\ObjectCollection;

interface PriceListMapperInterface
{
    /**
     * @param \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\PriceList\Persistence\Base\FoiPriceList> $entityCollection
     *
     * @return \Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    public function mapEntityCollectionToTransfer(ObjectCollection $entityCollection): PriceListCollectionTransfer;

    /**
     * @param \Orm\Zed\PriceList\Persistence\Base\FoiPriceList $entity
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function mapEntityToTransfer(FoiPriceList $entity): PriceListTransfer;
}
