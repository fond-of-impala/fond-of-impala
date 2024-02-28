<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Persistence;

use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\ProductList\Persistence\Map\SpyProductListTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Persistence\CustomerProductListsBulkRestApiPersistenceFactory getFactory()
 */
class CustomerProductListsBulkRestApiRepository extends AbstractRepository implements CustomerProductListsBulkRestApiRepositoryInterface
{
 /**
  * @param array<string> $customerReferences
  *
  * @return array<string, int>
  */
    public function getCustomerIdsByCustomerReferences(array $customerReferences): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $collection */
        $collection = $this->getFactory()
            ->getCustomerQuery()
            ->clear()
            ->filterByCustomerReference_In($customerReferences)
            ->select([SpyCustomerTableMap::COL_ID_CUSTOMER, SpyCustomerTableMap::COL_CUSTOMER_REFERENCE])
            ->find();

        return $collection->toKeyValue(
            SpyCustomerTableMap::COL_CUSTOMER_REFERENCE,
            SpyCustomerTableMap::COL_ID_CUSTOMER,
        );
    }

    /**
     * @param array<string> $emails
     *
     * @return array<string, int>
     */
    public function getCustomerIdsByEmails(array $emails): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $collection */
        $collection = $this->getFactory()
            ->getCustomerQuery()
            ->clear()
            ->filterByEmail_In($emails)
            ->select([SpyCustomerTableMap::COL_ID_CUSTOMER, SpyCustomerTableMap::COL_EMAIL])
            ->find();

        return $collection->toKeyValue(
            SpyCustomerTableMap::COL_EMAIL,
            SpyCustomerTableMap::COL_ID_CUSTOMER,
        );
    }

    /**
     * @param string $customerReference
     *
     * @return array<int>
     */
    public function getProductListIdsByCustomerReference(string $customerReference): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $collection */
        $collection = $this->getFactory()
            ->getCustomerQuery()
            ->filterByCustomerReference($customerReference)
            ->useSpyProductListCustomerQuery()
                ->useSpyProductListQuery()
                    ->select([SpyProductListTableMap::COL_ID_PRODUCT_LIST])
                ->endUse()
            ->endUse()
            ->find();

        return $collection->getData();
    }
}
