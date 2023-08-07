<?php

namespace FondOfImpala\Zed\PriceList\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\PriceListTransfer;
use Orm\Zed\PriceList\Persistence\FoiPriceList;
use Propel\Runtime\Collection\ObjectCollection;

/**
 * @codeCoverageIgnore
 */
class PriceListMapper implements PriceListMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Orm\Zed\PriceList\Persistence\FoiPriceList
     */
    public function mapTransferToEntity(PriceListTransfer $priceListTransfer): FoiPriceList
    {
        $foiPriceList = new FoiPriceList();

        $foiPriceList->fromArray(
            $priceListTransfer->modifiedToArray(false),
        );

        return $foiPriceList;
    }

    /**
     * @param \Orm\Zed\PriceList\Persistence\FoiPriceList $entity
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function mapEntityToTransfer(FoiPriceList $entity): PriceListTransfer
    {
        return (new PriceListTransfer())
            ->fromArray($entity->toArray(), true);
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\PriceList\Persistence\FoiPriceList> $entityCollection
     *
     * @return array<\Generated\Shared\Transfer\PriceListTransfer>
     */
    public function mapEntityCollectionToTransfers(ObjectCollection $entityCollection): array
    {
        $transfers = [];

        foreach ($entityCollection as $entity) {
            $transfers[] = $this->mapEntityToTransfer($entity);
        }

        return $transfers;
    }
}
