<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Persistence;

use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRolePersistenceFactory getFactory()
 */
class CompanyTypeRoleRepository extends AbstractRepository implements CompanyTypeRoleRepositoryInterface
{
    /**
     * @param int $idCustomer
     *
     * @return array<int>
     */
    public function findActiveCompanyUserIdsByIdCustomer(int $idCustomer): array
    {
        /** @phpstan-ignore-next-line */
        return $this->getFactory()->getCompanyUserQuery()
            ->clear()
            ->filterByIsActive(true)
            ->filterByFkCustomer($idCustomer)
            ->select([SpyCompanyUserTableMap::COL_ID_COMPANY_USER])
            ->find()
            ->toArray();
    }
}
