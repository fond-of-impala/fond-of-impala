<?php

declare (strict_types=1);

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Deleter;

use Generated\Shared\Transfer\CompanyUserIdCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

interface CompanyUserDeleterInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function deleteByCustomer(CustomerTransfer $customerTransfer): void;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserIdCollectionTransfer $companyUserIdCollectionTransfer
     *
     * @return void
     */
    public function deleteCompanyUserByCompanyUserIdCollection(
        CompanyUserIdCollectionTransfer $companyUserIdCollectionTransfer
    ): void;
}
