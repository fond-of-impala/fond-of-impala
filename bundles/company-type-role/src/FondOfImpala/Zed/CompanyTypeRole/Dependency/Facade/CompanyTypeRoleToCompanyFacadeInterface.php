<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade;

use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyCriteriaFilterTransfer;

interface CompanyTypeRoleToCompanyFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    public function getCompanies(): CompanyCollectionTransfer;

    /**
     * Specification:
     * - Finds companies according to criteria from CompanyCriteriaFilterTransfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyCriteriaFilterTransfer $companyCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    public function getCompanyCollection(CompanyCriteriaFilterTransfer $companyCriteriaFilterTransfer): CompanyCollectionTransfer;
}
