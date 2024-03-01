<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Persistence;

use Orm\Zed\ProductList\Persistence\Map\SpyProductListTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ProductListsBulkRestApi\Persistence\ProductListsBulkRestApiPersistenceFactory getFactory()
 */
class ProductListsBulkRestApiRepository extends AbstractRepository implements ProductListsBulkRestApiRepositoryInterface
{
 /**
  * @param array<string> $keys
  *
  * @return array<string, int>
  */
    public function getProductListIdsByKeys(array $keys): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $collection */
        $collection = $this->getFactory()
            ->getProductListQuery()
            ->clear()
            ->filterByKey_In($keys)
            ->select([SpyProductListTableMap::COL_ID_PRODUCT_LIST, SpyProductListTableMap::COL_KEY])
            ->find();

        return $collection->toKeyValue(
            SpyProductListTableMap::COL_KEY,
            SpyProductListTableMap::COL_ID_PRODUCT_LIST,
        );
    }

    /**
     * @param array<string> $uuids
     *
     * @return array<string, int>
     */
    public function getProductListIdsByUuids(array $uuids): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $collection */
        $collection = $this->getFactory()
            ->getProductListQuery()
            ->clear()
            ->filterByUuid_In($uuids)
            ->select([SpyProductListTableMap::COL_ID_PRODUCT_LIST, SpyProductListTableMap::COL_UUID])
            ->find();

        return $collection->toKeyValue(
            SpyProductListTableMap::COL_UUID,
            SpyProductListTableMap::COL_ID_PRODUCT_LIST,
        );
    }
}
