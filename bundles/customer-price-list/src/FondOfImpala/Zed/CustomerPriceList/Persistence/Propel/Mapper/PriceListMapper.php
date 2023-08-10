<?php

namespace FondOfImpala\Zed\CustomerPriceList\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\PriceListCollectionTransfer;
use Generated\Shared\Transfer\PriceListTransfer;
use Orm\Zed\PriceList\Persistence\Base\FoiPriceList;
use Propel\Runtime\Collection\ObjectCollection;

class PriceListMapper implements PriceListMapperInterface
{
    /**
     * @param \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\PriceList\Persistence\Base\FoiPriceList> $entityCollection
     *
     * @return \Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    public function mapEntityCollectionToTransfer(ObjectCollection $entityCollection): PriceListCollectionTransfer
    {
        $transfer = new PriceListCollectionTransfer();

        foreach ($entityCollection as $object) {
            $transfer->addPriceList($this->mapEntityToTransfer($object));
        }

        return $transfer;
    }

    /**
     * @param \Orm\Zed\PriceList\Persistence\Base\FoiPriceList $entity
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function mapEntityToTransfer(FoiPriceList $entity): PriceListTransfer
    {
        return (new PriceListTransfer())->fromArray($entity->toArray(), true);
    }
}
