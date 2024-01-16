<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Deleter;

use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model\QuoteReaderInterface;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;

class QuoteDeleter implements QuoteDeleterInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model\QuoteReaderInterface
     */
    protected $quoteReader;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface
     */
    protected $quoteFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model\QuoteReaderInterface $quoteReader
     * @param \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface $quoteFacade
     */
    public function __construct(
        QuoteReaderInterface $quoteReader,
        CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface $quoteFacade
    ) {
        $this->quoteReader = $quoteReader;
        $this->quoteFacade = $quoteFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return void
     */
    public function deleteByCompanyUser(CompanyUserTransfer $companyUserTransfer): void
    {
        $quoteCollectionTransfer = $this->quoteReader->findByCompanyUser($companyUserTransfer);

        foreach ($quoteCollectionTransfer->getQuotes() as $quoteTransfer) {
            $this->quoteFacade->deleteQuote($quoteTransfer);
        }
    }
}
