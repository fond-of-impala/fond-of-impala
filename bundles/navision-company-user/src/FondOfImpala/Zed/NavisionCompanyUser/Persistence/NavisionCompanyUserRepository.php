<?php

namespace FondOfImpala\Zed\NavisionCompanyUser\Persistence;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\NavisionCompanyUser\Persistence\NavisionCompanyUserPersistenceFactory getFactory()
 */
class NavisionCompanyUserRepository extends AbstractRepository implements NavisionCompanyUserRepositoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $externalReference
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserByExternalReference(string $externalReference): ?CompanyUserTransfer
    {
        $companyUserEntity = $this->getFactory()
            ->getCompanyUserQuery()
            ->filterByExternalReference($externalReference)
            ->findOne();

        if (!$companyUserEntity) {
            return null;
        }

        return (new CompanyUserTransfer())->fromArray(
            $companyUserEntity->toArray(),
            true,
        );
    }
}
