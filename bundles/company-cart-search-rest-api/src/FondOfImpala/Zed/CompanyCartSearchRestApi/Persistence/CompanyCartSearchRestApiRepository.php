<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence;

use FondOfImpala\Zed\CompanyCartSearchRestApi\Communication\Plugin\PermissionExtension\SeeAllCompanyQuotesPermissionPlugin;
use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Orm\Zed\Permission\Persistence\Map\SpyPermissionTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence\CompanyCartSearchRestApiPersistenceFactory getFactory()
 */
class CompanyCartSearchRestApiRepository extends AbstractRepository implements CompanyCartSearchRestApiRepositoryInterface
{
    /**
     * @param int $idCustomer
     * @param string $companyUuid
     *
     * @return int|null
     */
    public function getIdCompanyByIdCustomerAndCompanyUuid(
        int $idCustomer,
        string $companyUuid
    ): ?int {
        $idPermission = $this->getIdPermissionByKey(SeeAllCompanyQuotesPermissionPlugin::KEY);

        if ($idPermission === null) {
            return null;
        }

        /** @var int|null $idCompany */
        $idCompany = $this->getFactory()
            ->getCompanyQuery()
            ->clear()
            ->useCompanyUserQuery()
                ->useCustomerQuery()
                    ->filterByIdCustomer($idCustomer)
                ->endUse()
                ->useSpyCompanyRoleToCompanyUserQuery()
                    ->useCompanyRoleQuery()
                        ->useSpyCompanyRoleToPermissionQuery()
                            ->usePermissionQuery()
                                ->filterByIdPermission($idPermission)
                            ->endUse()
                        ->endUse()
                    ->endUse()
                ->endUse()
            ->endUse()
            ->select([SpyCompanyTableMap::COL_ID_COMPANY])
            ->findOneByUuid($companyUuid);

        return $idCompany;
    }

    /**
     * @param string $key
     *
     * @return int|null
     */
    public function getIdPermissionByKey(string $key): ?int
    {
        /** @var int|null $idPermission */
        $idPermission = $this->getFactory()
            ->getPermissionQuery()
            ->clear()
            ->filterByKey($key)
            ->select([SpyPermissionTableMap::COL_ID_PERMISSION])
            ->findOne();

        return $idPermission;
    }
}
