<?php

namespace FondOfImpala\Zed\PriceList\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\PriceListTransfer;
use Orm\Zed\PriceList\Persistence\FosPriceList;
use Propel\Runtime\Collection\ObjectCollection;

/**
 * @codeCoverageIgnore
 */
class PriceListMapper implements PriceListMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Orm\Zed\PriceList\Persistence\FosPriceList
     */
    public function mapTransferToEntity(PriceListTransfer $priceListTransfer): FosPriceList
    {
        $fosPriceList = new FosPriceList();

        $fosPriceList->fromArray(
            $priceListTransfer->modifiedToArray(false),
        );

        return $fosPriceList;
    }

    /**
     * @param \Orm\Zed\PriceList\Persistence\FosPriceList $entity
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function mapEntityToTransfer(FosPriceList $entity): PriceListTransfer
    {
        return (new PriceListTransfer())
            ->fromArray($entity->toArray(), true);
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\PriceList\Persistence\FosPriceList> $entityCollection
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
