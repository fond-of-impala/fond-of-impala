<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CustomerCompanyUserConnector\Business;

use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerCompanyUserConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function deleteCompanyUserForCustomer(CustomerTransfer $customerTransfer): void;
}
