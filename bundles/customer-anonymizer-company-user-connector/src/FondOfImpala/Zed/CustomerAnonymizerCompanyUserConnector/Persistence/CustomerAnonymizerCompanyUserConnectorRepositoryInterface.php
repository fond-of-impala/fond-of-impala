<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence;

use Generated\Shared\Transfer\CompanyUserIdCollectionTransfer;

interface CustomerAnonymizerCompanyUserConnectorRepositoryInterface
{
    /**
     * @param int $fkCustomer
     *
     * @return \Generated\Shared\Transfer\CompanyUserIdCollectionTransfer
     */
    public function findCompanyUserIdsByFkCustomer(int $fkCustomer): CompanyUserIdCollectionTransfer;
}
