<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Persistence\Propel\Mapper;

use FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityRepository;
use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Orm\Zed\AllowedProductQuantity\Persistence\FoiAllowedProductQuantity;
use Propel\Runtime\Collection\Collection;

class AllowedProductQuantityMapper implements AllowedProductQuantityMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\AllowedProductQuantityTransfer $transfer
     *
     * @return \Orm\Zed\AllowedProductQuantity\Persistence\FoiAllowedProductQuantity
     */
    public function mapTransferToEntity(AllowedProductQuantityTransfer $transfer): FoiAllowedProductQuantity
    {
        $entity = new FoiAllowedProductQuantity();

        $entity->fromArray($transfer->toArray(false));

        return $entity->setFkProductAbstract($transfer->getIdProductAbstract());
    }

    /**
     * @param \Orm\Zed\AllowedProductQuantity\Persistence\FoiAllowedProductQuantity $entity
     *
     * @return \Generated\Shared\Transfer\AllowedProductQuantityTransfer
     */
    public function mapEntityToTransfer(FoiAllowedProductQuantity $entity): AllowedProductQuantityTransfer
    {
        return (new AllowedProductQuantityTransfer())
            ->fromArray($entity->toArray(), true)
            ->setIdProductAbstract($entity->getFkProductAbstract());
    }

    /**
     * @param \Propel\Runtime\Collection\Collection $entityCollection
     *
     * @return array<string, \Generated\Shared\Transfer\AllowedProductQuantityTransfer>
     */
    public function mapEntityCollectionToGroupedTransfers(Collection $entityCollection): array
    {
        $groupedTransfers = [];

        foreach ($entityCollection as $entity) {
            $sku = $entity->getVirtualColumn(AllowedProductQuantityRepository::VIRTUAL_COLUMN_SKU);

            if (isset($groupedTransfers[$sku])) {
                continue;
            }

            $groupedTransfers[$sku] = $this->mapEntityToTransfer($entity);
        }

        return $groupedTransfers;
    }
}
