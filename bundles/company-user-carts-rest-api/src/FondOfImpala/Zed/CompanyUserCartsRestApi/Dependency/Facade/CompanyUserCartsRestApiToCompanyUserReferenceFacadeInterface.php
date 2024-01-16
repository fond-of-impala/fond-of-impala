<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyUserCartsRestApiToCompanyUserReferenceFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByCompanyUserReference(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer;

    /**
     * @param string $companyUserReference
     * @param int $idCustomer
     *
     * @return int|null
     */
    public function getIdCompanyUserByCompanyUserReferenceAndIdCustomer(
        string $companyUserReference,
        int $idCustomer
    ): ?int;
}
