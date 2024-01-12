<?php

namespace FondOfImpala\Zed\CompanyUserReference\Persistence;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferencePersistenceFactory getFactory()
 */
class CompanyUserReferenceRepository extends AbstractRepository implements CompanyUserReferenceRepositoryInterface
{
    /**
     * @param string $companyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserByCompanyUserReference(string $companyUserReference): ?CompanyUserTransfer
    {
        $query = $this->getFactory()
            ->getCompanyUserPropelQuery()
            ->clear()
            ->filterByCompanyUserReference($companyUserReference);

        $companyUserEntityTransfer = $this->buildQueryFromCriteria($query)->findOne();

        if ($companyUserEntityTransfer === null) {
            return null;
        }

        return (new CompanyUserTransfer())->fromArray(
            $companyUserEntityTransfer->toArray(),
            true,
        );
    }

    /**
     * @param string $companyUserReference
     *
     * @return int|null
     */
    public function findIdCompanyByCompanyUserReference(string $companyUserReference): ?int
    {
        $entity = $this->getFactory()
            ->getCompanyUserPropelQuery()
            ->clear()
            ->filterByCompanyUserReference($companyUserReference)
            ->findOne();

        if ($entity === null) {
            return null;
        }

        return $entity->getFkCompany();
    }

    /**
     * @param string $companyUserReference
     *
     * @return int|null
     */
    public function findIdCompanyBusinessUnitByCompanyUserReference(string $companyUserReference): ?int
    {
        $entity = $this->getFactory()
            ->getCompanyUserPropelQuery()
            ->clear()
            ->filterByCompanyUserReference($companyUserReference)
            ->findOne();

        if ($entity === null) {
            return null;
        }

        return $entity->getFkCompanyBusinessUnit();
    }

    /**
     * @param string $companyUserReference
     * @param int $fkCustomer
     *
     * @return int|null
     */
    public function findIdCompanyUserByCompanyUserReferenceAndFkCustomer(
        string $companyUserReference,
        int $fkCustomer
    ): ?int {
        /** @var int|null $idCompanyUser */
        $idCompanyUser = $this->getFactory()
            ->getCompanyUserPropelQuery()
            ->clear()
            ->filterByCompanyUserReference($companyUserReference)
            ->filterByFkCustomer($fkCustomer)
            ->select([SpyCompanyUserTableMap::COL_ID_COMPANY_USER])
            ->findOne();

        return $idCompanyUser;
    }
}
