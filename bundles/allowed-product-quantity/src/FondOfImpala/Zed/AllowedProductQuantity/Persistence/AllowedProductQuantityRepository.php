<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Persistence;

use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityPersistenceFactory getFactory()
 */
class AllowedProductQuantityRepository extends AbstractRepository implements AllowedProductQuantityRepositoryInterface
{
    /**
     * @var string
     */
    public const VIRTUAL_COLUMN_SKU = 'sku';

    /**
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\AllowedProductQuantityTransfer|null
     */
    public function findAllowedProductQuantityByIdProductAbstract(int $idProductAbstract): ?AllowedProductQuantityTransfer
    {
        $query = $this->getFactory()
            ->createAllowedProductQuantityQuery()
            ->clear();

        $entity = $query->filterByFkProductAbstract($idProductAbstract)
            ->findOne();

        if ($entity === null) {
            return null;
        }

        return $this->getFactory()
            ->createAllowedProductQuantityMapper()
            ->mapEntityToTransfer($entity);
    }

    /**
     * @param array<string> $abstractSkus
     *
     * @return array<string, \Generated\Shared\Transfer\AllowedProductQuantityTransfer>
     */
    public function findGroupedAllowedProductQuantitiesByAbstractSkus(array $abstractSkus): array
    {
        $query = $this->getFactory()
            ->createAllowedProductQuantityQuery()
            ->clear();

        $entities = $query->useProductQuery()
                ->filterBySku_In($abstractSkus)
            ->endUse()
            ->withColumn(
                SpyProductAbstractTableMap::COL_SKU,
                static::VIRTUAL_COLUMN_SKU,
            )->find();

        return $this->getFactory()
            ->createAllowedProductQuantityMapper()
            ->mapEntityCollectionToGroupedTransfers($entities);
    }
}
