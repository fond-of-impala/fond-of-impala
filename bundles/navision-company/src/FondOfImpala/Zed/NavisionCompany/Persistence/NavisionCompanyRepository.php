<?php

namespace FondOfImpala\Zed\NavisionCompany\Persistence;

use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\NavisionCompany\Persistence\NavisionCompanyPersistenceFactory getFactory()
 */
class NavisionCompanyRepository extends AbstractRepository implements NavisionCompanyRepositoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $externalReference
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function findCompanyByExternalReference(string $externalReference): ?CompanyTransfer
    {
        $companyEntity = $this->getFactory()
            ->getCompanyQuery()
            ->filterByExternalReference($externalReference)
            ->findOne();

        if (!$companyEntity) {
            return null;
        }

        return (new CompanyTransfer())->fromArray(
            $companyEntity->toArray(),
            true,
        );
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $debtorNumber
     *
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function findCompanyByDebtorNumber(string $debtorNumber): ?CompanyTransfer
    {
        $companyEntity = $this->getFactory()
            ->getCompanyQuery()
            ->filterByDebtorNumber($debtorNumber)
            ->findOne();

        if (!$companyEntity) {
            return null;
        }

        return (new CompanyTransfer())->fromArray(
            $companyEntity->toArray(),
            true,
        );
    }
}
