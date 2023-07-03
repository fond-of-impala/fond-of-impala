<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business;

use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerAnonymizerCompanyUserConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function deleteCompanyUsersForCustomer(CustomerTransfer $customerTransfer): void;
}
