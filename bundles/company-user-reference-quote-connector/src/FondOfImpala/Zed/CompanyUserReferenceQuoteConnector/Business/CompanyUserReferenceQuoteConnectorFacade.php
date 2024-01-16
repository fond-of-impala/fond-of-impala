<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business;

use Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Persistence\CompanyUserReferenceQuoteConnectorRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\CompanyUserReferenceQuoteConnectorBusinessFactory getFactory()
 */
class CompanyUserReferenceQuoteConnectorFacade extends AbstractFacade implements CompanyUserReferenceQuoteConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer $companyUserReferenceCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function findQuotesByCompanyUserReferences(
        CompanyUserReferenceCollectionTransfer $companyUserReferenceCollectionTransfer
    ): QuoteCollectionTransfer {
        return $this->getFactory()
            ->createQuoteReader()
            ->findQuotesByCompanyUserReferences($companyUserReferenceCollectionTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return void
     */
    public function deleteQuotesByCompanyUser(CompanyUserTransfer $companyUserTransfer): void
    {
        $this->getFactory()->createQuoteDeleter()->deleteByCompanyUser($companyUserTransfer);
    }
}
