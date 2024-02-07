<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Persistence;

use Orm\Zed\ProductList\Persistence\Map\SpyProductListTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
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
        $query = $this->getFactory()
            ->getProductListQuery()
            ->clear()
            ->filterByKey_In($keys);

        return $query->find()->toKeyValue(
            SpyProductListTableMap::COL_KEY,
            SpyProductListTableMap::COL_ID_PRODUCT_LIST
        );
    }

    /**
     * @param array<string> $uuids
     *
     * @return array<string, int>
     */
    public function getProductListIdsByUuids(array $uuids): array
    {
        $query = $this->getFactory()
            ->getProductListQuery()
            ->clear()
            ->filterByUuid_In($uuids);

        return $query->find()->toKeyValue(
            SpyProductListTableMap::COL_UUID,
            SpyProductListTableMap::COL_ID_PRODUCT_LIST
        );
    }
}
