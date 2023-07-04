<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence;

use Generated\Shared\Transfer\CompanyUserIdCollectionTransfer;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorPersistenceFactory getFactory()
 */
class CustomerAnonymizerCompanyUserConnectorRepository extends AbstractRepository implements CustomerAnonymizerCompanyUserConnectorRepositoryInterface
{
    /**
     * @param int $fkCustomer
     *
     * @return \Generated\Shared\Transfer\CompanyUserIdCollectionTransfer
     */
    public function findCompanyUserIdsByFkCustomer(int $fkCustomer): CompanyUserIdCollectionTransfer
    {
        $query = $this->getFactory()->getCompanyUserQuery();

        $data = $query->filterByFkCustomer($fkCustomer)->select([SpyCompanyUserTableMap::COL_ID_COMPANY_USER])->find()->getData();

        return (new CompanyUserIdCollectionTransfer())->setIds($data);
    }
}
