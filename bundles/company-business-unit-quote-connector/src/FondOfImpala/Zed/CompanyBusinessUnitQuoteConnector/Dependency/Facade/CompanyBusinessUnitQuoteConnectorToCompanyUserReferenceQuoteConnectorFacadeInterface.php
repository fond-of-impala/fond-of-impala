<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade;

use Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer;
use Generated\Shared\Transfer\QuoteCollectionTransfer;

interface CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer $companyUserReferenceCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function findQuotesByCompanyUserReferences(
        CompanyUserReferenceCollectionTransfer $companyUserReferenceCollectionTransfer
    ): QuoteCollectionTransfer;
}
