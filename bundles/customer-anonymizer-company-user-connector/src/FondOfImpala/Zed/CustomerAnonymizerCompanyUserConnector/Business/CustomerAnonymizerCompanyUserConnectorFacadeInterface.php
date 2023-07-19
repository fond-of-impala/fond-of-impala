<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business;

use Generated\Shared\Transfer\CompanyUserIdCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerAnonymizerCompanyUserConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function deleteCompanyUsersByCustomer(CustomerTransfer $customerTransfer): void;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserIdCollectionTransfer $idCollectionTransfer
     *
     * @return void
     */
    public function deleteCompanyUsersByCompanyUserIdCollection(CompanyUserIdCollectionTransfer $idCollectionTransfer): void;
}
