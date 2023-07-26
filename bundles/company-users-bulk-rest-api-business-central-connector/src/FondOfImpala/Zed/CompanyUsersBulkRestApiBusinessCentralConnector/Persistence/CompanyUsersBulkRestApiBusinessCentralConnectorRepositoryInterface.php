<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Persistence;

use Generated\Shared\Transfer\CompanyUsersBulkCompanyCollectionTransfer;

interface CompanyUsersBulkRestApiBusinessCentralConnectorRepositoryInterface
{
    /**
     * @param array $debtorNumbers
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkCompanyCollectionTransfer
     */
    public function findCompaniesByDebtorNumbers(array $debtorNumbers): CompanyUsersBulkCompanyCollectionTransfer;
}
