<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper;

use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Orm\Zed\Company\Persistence\SpyCompany;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRole;
use Propel\Runtime\Collection\Collection;

interface CompanyMapperInterface
{
    /**
     * @param \Orm\Zed\CompanyRole\Persistence\SpyCompanyRole $spyCompanyRole
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function fromSpyCompanyRole(SpyCompanyRole $spyCompanyRole): ?CompanyTransfer;

    /**
     * @param \Orm\Zed\Company\Persistence\SpyCompany $spyCompany
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function mapEntityToCompanyTransfer(
        SpyCompany $spyCompany,
        CompanyTransfer $companyTransfer
    ): CompanyTransfer;

    /**
     * @param \Propel\Runtime\Collection\Collection $companyEntities
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    public function mapCompanyEntityCollectionToCompanyCollectionTransfer(
        Collection $companyEntities
    ): CompanyCollectionTransfer;
}
