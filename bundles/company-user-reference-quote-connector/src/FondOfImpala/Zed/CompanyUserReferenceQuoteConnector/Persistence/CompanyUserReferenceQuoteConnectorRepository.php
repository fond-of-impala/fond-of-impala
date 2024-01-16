<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Persistence;

use Orm\Zed\Quote\Persistence\Map\SpyQuoteTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Persistence\CompanyUserReferenceQuoteConnectorPersistenceFactory getFactory()
 */
class CompanyUserReferenceQuoteConnectorRepository extends AbstractRepository implements CompanyUserReferenceQuoteConnectorRepositoryInterface
{
    /**
     * @param array<string> $companyUserReferences
     *
     * @return array<int>
     */
    public function findQuoteIdsByCompanyUserReferences(array $companyUserReferences): array
    {
        if (count($companyUserReferences) === 0) {
            return [];
        }

        /** @var \Propel\Runtime\Collection\ArrayCollection $collection */
        $collection = $this->getFactory()->getQuoteQuery()
            ->clear()
            ->filterByCompanyUserReference_In($companyUserReferences)
            ->select([SpyQuoteTableMap::COL_ID_QUOTE])
            ->find();

        return $collection->toArray();
    }

    /**
     * @param string $companyUserReference
     *
     * @return array<int>
     */
    public function findQuoteIdsByCompanyUserReference(string $companyUserReference): array
    {
        /** @var \Propel\Runtime\Collection\ArrayCollection $collection */
        $collection = $this->getFactory()->getQuoteQuery()
            ->clear()
            ->filterByCompanyUserReference($companyUserReference)
            ->select([SpyQuoteTableMap::COL_ID_QUOTE])
            ->find();

        return $collection->toArray();
    }
}
