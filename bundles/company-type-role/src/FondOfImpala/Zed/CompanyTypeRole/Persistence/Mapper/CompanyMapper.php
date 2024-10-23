<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper;

use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Orm\Zed\Company\Persistence\SpyCompany;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRole;
use Propel\Runtime\Collection\Collection;

/**
 * @codeCoverageIgnore
 */
class CompanyMapper implements CompanyMapperInterface
{
    /**
     * @param \Orm\Zed\CompanyRole\Persistence\SpyCompanyRole $spyCompanyRole
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function fromSpyCompanyRole(SpyCompanyRole $spyCompanyRole): ?CompanyTransfer
    {
        $spyCompany = $spyCompanyRole->getCompany();

        return (new CompanyTransfer())
            ->fromArray($spyCompany->toArray(), true);
    }

    /**
     * @param \Orm\Zed\Company\Persistence\SpyCompany $spyCompany
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function mapEntityToCompanyTransfer(
        SpyCompany $spyCompany,
        CompanyTransfer $companyTransfer
    ): CompanyTransfer {
        return $companyTransfer->fromArray(
            $spyCompany->toArray(),
            true,
        );
    }

    /**
     * @param \Propel\Runtime\Collection\Collection<\Orm\Zed\Company\Persistence\SpyCompany> $companyEntities
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    public function mapCompanyEntityCollectionToCompanyCollectionTransfer(
        Collection $companyEntities
    ): CompanyCollectionTransfer {
        $companyCollectionTransfer = new CompanyCollectionTransfer();

        foreach ($companyEntities as $companyEntity) {
            $companyTransfer = $this->mapEntityToCompanyTransfer(
                $companyEntity,
                new CompanyTransfer(),
            );

            $companyCollectionTransfer->addCompany($companyTransfer);
        }

        return $companyCollectionTransfer;
    }
}
