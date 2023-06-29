<?php

declare (strict_types=1);

namespace FondOfImpala\Zed\CustomerCompanyUserConnector\Business\Model;

use Generated\Shared\Transfer\CustomerTransfer;

interface CompanyUserDeleterInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function deleteCompanyUserForCustomer(CustomerTransfer $customerTransfer): void;
}
