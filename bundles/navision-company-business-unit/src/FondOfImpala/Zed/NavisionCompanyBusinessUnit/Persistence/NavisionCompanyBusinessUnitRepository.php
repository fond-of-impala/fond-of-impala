<?php

namespace FondOfImpala\Zed\NavisionCompanyBusinessUnit\Persistence;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\NavisionCompanyBusinessUnit\Persistence\NavisionCompanyBusinessUnitPersistenceFactory getFactory()
 */
class NavisionCompanyBusinessUnitRepository extends AbstractRepository implements NavisionCompanyBusinessUnitRepositoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $externalReference
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|null
     */
    public function findCompanyBusinessUnitByExternalReference(string $externalReference): ?CompanyBusinessUnitTransfer
    {
        $companyBusinessUnitEntity = $this->getFactory()
            ->getCompanyBusinessUnitQuery()
            ->filterByExternalReference($externalReference)
            ->findOne();

        if (!$companyBusinessUnitEntity) {
            return null;
        }

        return (new CompanyBusinessUnitTransfer())->fromArray(
            $companyBusinessUnitEntity->toArray(),
            true,
        );
    }
}
