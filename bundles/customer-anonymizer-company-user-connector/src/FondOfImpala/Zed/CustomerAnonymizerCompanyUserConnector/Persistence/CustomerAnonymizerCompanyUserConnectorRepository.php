<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorPersistenceFactory getFactory()
 */
class CustomerAnonymizerCompanyUserConnectorRepository extends AbstractRepository implements CustomerAnonymizerCompanyUserConnectorRepositoryInterface
{
    /**
     * @param int $fkCustomer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findCompanyUsersByFkCustomer(int $fkCustomer): CompanyUserCollectionTransfer
    {
        $collection = new CompanyUserCollectionTransfer();
        $query = $this->getFactory()->getCompanyUserQuery();

        $result = $query->filterByFkCustomer($fkCustomer)->find();

        /** @var \Orm\Zed\CompanyUser\Persistence\SpyCompanyUser $companyUserEntity */
        foreach ($result->getData() as $companyUserEntity) {
            $companyUserTransfer = (new CompanyUserTransfer())->fromArray($companyUserEntity->toArray(), true);
            $collection->addCompanyUser($companyUserTransfer);
        }

        return $collection;
    }
}
