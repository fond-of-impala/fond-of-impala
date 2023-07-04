<?php

declare (strict_types=1);

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Model;

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
     * @param \Generated\Shared\Transfer\CompanyUserIdCollectionTransfer $idCollectionTransfer
     *
     * @return void
     */
    public function deleteCompanyUserByIds(CompanyUserIdCollectionTransfer $idCollectionTransfer): void;
}
